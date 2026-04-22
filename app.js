/* ─────────────────────────────────────────────
   app.js — Course Data, Routing & Application Logic
   ───────────────────────────────────────────── */

/* ── COURSE DATA ── */
const COURSES = [
  { id: 1, cat: 'CCNA', icon: '🌐', th: 'th1',
    title: 'CCNA 200-301: Complete Network Associate',
    desc: 'Master routing, switching, IPv4/IPv6, VLANs, OSPF, and everything you need to pass the CCNA exam first time.',
    level: 'Beginner', duration: '80 hrs', students: '420', price: '$149', rating: '4.9', reviews: '128',
    prereqs: 'No prior networking knowledge required.',
    curriculum: ['Networking Fundamentals & OSI Model','IP Addressing & Subnetting','Routing: OSPF, EIGRP, Static Routes','VLANs, Trunking & Spanning Tree','WAN Technologies & VPNs','Network Services: DHCP, DNS, NAT','Security Fundamentals & ACLs','Automation & Programmability','5 Full-Length Practice Exams'] },

  { id: 2, cat: 'CCNP', icon: '🔷', th: 'th2',
    title: 'CCNP Enterprise: ENCOR 350-401',
    desc: 'Advanced enterprise networking — BGP, MPLS, SD-WAN, wireless, automation, and security. Full ENCOR exam preparation.',
    level: 'Advanced', duration: '120 hrs', students: '180', price: '$249', rating: '4.8', reviews: '64',
    prereqs: 'CCNA certification or equivalent knowledge.',
    curriculum: ['Advanced OSPF, BGP & IS-IS','MPLS L3VPN Architecture','Campus Switching: STP/RSTP/MSTP','Wireless: 802.11 & Cisco WLC','SD-WAN Architecture & Deployment','Python & Ansible Automation','NETCONF/RESTCONF & YANG','Network Assurance & DNA Center','ENCOR Practice Exams'] },

  { id: 3, cat: 'Security', icon: '🔐', th: 'th3',
    title: 'CyberOps & Network Security (SCOR)',
    desc: 'Comprehensive Cisco security training: ASA firewalls, Firepower NGFW, VPNs, IDS/IPS, and incident response.',
    level: 'Intermediate', duration: '90 hrs', students: '210', price: '$199', rating: '4.9', reviews: '89',
    prereqs: 'CCNA or basic networking knowledge.',
    curriculum: ['Security Concepts & Cryptography','Cisco ASA Firewall & NAT','Firepower NGFW & IPS','VPN: IPsec & SSL/TLS','Identity Management: AAA & ISE','Security Monitoring & SIEM','Threat Detection & Response','CyberOps & SCOR Practice Exams'] },

  { id: 4, cat: 'Labs', icon: '🖧', th: 'th4',
    title: 'Packet Tracer Masterclass: 50+ Labs',
    desc: '50+ practical Cisco Packet Tracer labs. Build complete enterprise networks from scratch with expert guidance.',
    level: 'Beginner', duration: '40 hrs', students: '560', price: '$79', rating: '4.9', reviews: '207',
    prereqs: 'No prerequisites. Packet Tracer is free to download.',
    curriculum: ['Interface & Device Setup','LAN Topology Design','Router CLI from Scratch','VLAN & Inter-VLAN Routing','OSPF Multi-Area Labs','EIGRP & Redistribution','ACL Security Labs','IPv6 Dual-Stack Lab','Final Project: Enterprise Campus'] },

  { id: 5, cat: 'CCNP', icon: '⚙️', th: 'th5',
    title: 'SD-WAN & Network Automation (Python)',
    desc: 'Cisco Viptela SD-WAN, Python scripting, Ansible playbooks, NETCONF/RESTCONF APIs, and DNA Center automation.',
    level: 'Advanced', duration: '60 hrs', students: '95', price: '$199', rating: '4.7', reviews: '38',
    prereqs: 'CCNP ENCOR or solid enterprise networking experience.',
    curriculum: ['SD-WAN: Control & Data Plane','vManage, vBond & vSmart','OMP Routing & Policy','Python for Network Engineers','Netmiko & NAPALM Libraries','Ansible for Cisco IOS','NETCONF & RESTCONF','DNA Center REST API','DevOps Capstone Project'] },

  { id: 6, cat: 'CCNA', icon: '📝', th: 'th6',
    title: 'CCNA Exam Bootcamp: 10-Day Intensive',
    desc: 'Rapid exam prep with 5 full-length practice tests, time management strategies, and domain-by-domain review sessions.',
    level: 'Intermediate', duration: '30 hrs', students: '340', price: 'Free', rating: '4.8', reviews: '156',
    prereqs: 'Completed CCNA training or equivalent knowledge.',
    curriculum: ['Exam Structure & Scoring','Domain 1: Network Fundamentals','Domain 2: Network Access','Domain 3: IP Connectivity','Domain 4: IP Services','Domain 5: Security Fundamentals','Domain 6: Automation','Practice Test 1 + Review','Practice Test 2 + Final Sim'] }
];

/* ── APP STATE ── */
const S = { user: null, enrolled: [], tier: 'free', filter: 'all' };

/* ── INITIALISATION ── */
document.addEventListener('DOMContentLoaded', () => {
  initCircuit();
  initCursor();
  initScroll();
  initObserver();
  initCounters();
  renderCourses('home-courses-grid', COURSES.slice(0, 3));
  restoreSession();
  setTimeout(() => document.getElementById('loader').classList.add('gone'), 1700);
  document.getElementById('auth-modal').addEventListener('click', e => { if (e.target === e.currentTarget) closeModal(); });
  document.getElementById('course-modal').addEventListener('click', e => { if (e.target === e.currentTarget) closeCourseModal(); });
  document.addEventListener('keydown', e => { if (e.key === 'Escape') { closeModal(); closeCourseModal(); } });
});

/* ── PAGE ROUTING ── */
function showPage(pg) {
  document.querySelectorAll('.page').forEach(p => p.classList.remove('show'));
  const target = document.getElementById('page-' + pg);
  if (target) target.classList.add('show');
  document.querySelectorAll('.nav-links a').forEach(a => a.classList.toggle('act', a.dataset.pg === pg));
  window.scrollTo({ top: 0, behavior: 'smooth' });
  const footer = document.getElementById('site-footer');
  if (footer) footer.style.display = pg === 'dashboard' ? 'none' : '';
  if (pg === 'courses') renderCourses('all-courses-grid', COURSES);
  if (pg === 'about') setTimeout(animSkills, 300);
  if (pg === 'dashboard') {
    if (!S.user) { openModal('login'); showPage('home'); return; }
    updateDash();
  }
  reObserve();
}

/* ── COURSE RENDERING ── */
function renderCourses(gridId, data) {
  const g = document.getElementById(gridId);
  if (!g) return;
  g.innerHTML = data.map(c => `
    <div class="ccard reveal" onclick="openCourseDetail(${c.id})">
      <div class="cc-thumb ${c.th}"><span class="cc-thumb-icon">${c.icon}</span><div class="cc-level-tag lvl-${c.level === 'Beginner' ? 'beg' : c.level === 'Advanced' ? 'adv' : 'int'}">${c.level}</div></div>
      <div class="cc-body">
        <div class="cc-cat">${c.cat}</div>
        <div class="cc-title">${c.title}</div>
        <div class="cc-desc">${c.desc}</div>
        <div class="cc-meta">
          <span><i class="fas fa-clock"></i>${c.duration}</span>
          <span><i class="fas fa-users"></i>${c.students}+ students</span>
          <span><i class="fas fa-star"></i>${c.rating}</span>
        </div>
        <div class="cc-footer">
          <span class="cc-price ${c.price === 'Free' ? 'free' : ''}">${c.price}</span>
          <button class="cc-enroll" onclick="event.stopPropagation();enrollCourse(${c.id})">${c.id === 6 ? '▶ Start Course' : S.enrolled.includes(c.id) ? '✓ Enrolled' : 'Enroll Now'}</button>
        </div>
      </div>
    </div>`).join('');
  reObserve();
}

function filterCourses(cat, btn) {
  document.querySelectorAll('.f-btn').forEach(b => b.classList.remove('on'));
  btn.classList.add('on');
  S.filter = cat;
  applyFilter();
}

function searchCourses() { applyFilter(); }

function applyFilter() {
  const q = (document.getElementById('course-search')?.value || '').toLowerCase();
  let d = S.filter === 'all' ? COURSES : COURSES.filter(c => c.cat === S.filter);
  if (q) d = d.filter(c => c.title.toLowerCase().includes(q) || c.desc.toLowerCase().includes(q));
  const info = document.getElementById('results-info');
  if (info) info.innerHTML = `<span>${d.length}</span> courses`;
  renderCourses('all-courses-grid', d);
}

function openCourseDetail(id) {
  const c = COURSES.find(x => x.id === id);
  if (!c) return;
  const isEnrolled = S.enrolled.includes(id);
  document.getElementById('course-detail-inner').innerHTML = `
    <div class="cdm-header">
      <div class="cdm-thumb ${c.th}">${c.icon}</div>
      <div>
        <div style="font-size:0.62rem;font-weight:700;color:var(--c);letter-spacing:2px;text-transform:uppercase;margin-bottom:3px">${c.cat}</div>
        <div style="font-family:'Orbitron',monospace;font-size:1.05rem;font-weight:900;color:var(--tw);line-height:1.3">${c.title}</div>
        <div style="color:#ffd700;font-size:0.8rem;margin-top:4px">★★★★★ ${c.rating} (${c.reviews} reviews)</div>
      </div>
    </div>
    <div class="cdm-meta">
      <span class="cdm-mi"><i class="fas fa-signal"></i><strong>${c.level}</strong></span>
      <span class="cdm-mi"><i class="fas fa-clock"></i><strong>${c.duration}</strong></span>
      <span class="cdm-mi"><i class="fas fa-users"></i><strong>${c.students}+ enrolled</strong></span>
      <span class="cdm-mi"><i class="fas fa-tag"></i><strong style="color:var(--tw)">${c.price}</strong></span>
    </div>
    <p style="color:var(--tm);font-size:0.85rem;line-height:1.75;margin-bottom:1.2rem">${c.desc}</p>
    <div style="background:var(--bg3);border:1px solid var(--bdr);border-radius:var(--r);padding:0.9rem;margin-bottom:1.2rem">
      <span style="font-size:0.65rem;font-weight:700;color:var(--c);letter-spacing:2px;text-transform:uppercase">Prerequisites: </span>
      <span style="font-size:0.82rem;color:var(--tm)">${c.prereqs}</span>
    </div>
    <div class="curr-wrap">
      <div class="curr-title-txt">Curriculum — ${c.curriculum.length} modules</div>
      <div class="curr-list">${c.curriculum.map((m, i) => `<div class="curr-li"><div class="curr-num">${i + 1}</div>${m}</div>`).join('')}</div>
    </div>
    <div style="background:var(--bg3);border:1px solid var(--bdr);border-radius:var(--r);padding:0.9rem;display:flex;align-items:center;gap:10px;margin-bottom:1.2rem">
      <div style="width:38px;height:38px;border-radius:50%;background:linear-gradient(135deg,var(--c),var(--c3));display:flex;align-items:center;justify-content:center;font-family:'Orbitron',monospace;font-weight:700;font-size:0.75rem;color:var(--bg)">AH</div>
      <div>
        <div style="font-size:0.65rem;color:var(--tm)">Instructor</div>
        <div style="font-size:0.88rem;font-weight:700;color:var(--tw)">Ahmed Hussein</div>
        <div style="font-size:0.65rem;color:var(--c)">Cisco Certified Professional</div>
      </div>
    </div>
    <div class="enroll-foot">
      <div>
        <div class="ef-price ${c.price === 'Free' ? 'free' : ''}">${c.price}</div>
        <div style="font-size:0.65rem;color:var(--tm);margin-top:3px">Full lifetime access</div>
      </div>
      <button class="btn ${isEnrolled ? 'btn-ghost' : 'btn-c'}" onclick="enrollCourse(${c.id});closeCourseModal()">
        ${isEnrolled ? '<i class="fas fa-check"></i> Already Enrolled' : '<i class="fas fa-graduation-cap"></i> Enroll Now'}
      </button>
    </div>`;
  document.getElementById('course-modal').classList.add('open');
  document.body.style.overflow = 'hidden';
}

function closeCourseModal() {
  document.getElementById('course-modal').classList.remove('open');
  document.body.style.overflow = '';
}

function enrollCourse(id) {
  if (id === 6) { window.location.href = 'ccna-domain1.html'; return; }
  if (!S.user) { openModal('login'); toast('Sign in to enroll in a course', 'inf'); return; }
  if (S.enrolled.includes(id)) { toast('Already enrolled in this course', 'inf'); return; }
  S.enrolled.push(id);
  S.user.enrolled = S.enrolled;
  saveSession();
  updateDash();
  toast('Enrolled successfully! Check your dashboard.', 'suc');
  renderCourses('home-courses-grid', COURSES.slice(0, 3));
  renderCourses('all-courses-grid', COURSES);
}

/* ── AUTHENTICATION ── */
function openModal(tab = 'login') {
  document.getElementById('auth-modal').classList.add('open');
  document.body.style.overflow = 'hidden';
  switchTab(tab);
  ['login-err', 'reg-err'].forEach(id => { const e = document.getElementById(id); if (e) e.classList.remove('show'); });
  ['login-ok', 'reg-ok'].forEach(id => { const e = document.getElementById(id); if (e) e.classList.remove('show'); });
}

function closeModal() {
  document.getElementById('auth-modal').classList.remove('open');
  document.body.style.overflow = '';
}

function switchTab(tab) {
  document.querySelectorAll('.m-tab').forEach(t => t.classList.toggle('on', t.dataset.tab === tab));
  document.querySelectorAll('.m-panel').forEach(p => p.classList.toggle('on', p.id === 'mp-' + tab));
}

function pickTier(t) {
  S.tier = t;
  document.querySelectorAll('.tier-opt').forEach(o => o.classList.toggle('on', o.dataset.tier === t));
}

function doLogin() {
  const email = document.getElementById('l-email').value.trim();
  const pass = document.getElementById('l-pass').value;
  const err = document.getElementById('login-err');
  if (!email || !pass) { err.textContent = 'Please fill in all fields.'; err.classList.add('show'); return; }
  const users = JSON.parse(localStorage.getItem('ah_users') || '[]');
  const u = users.find(x => x.email === email && x.pass === btoa(pass));
  if (!u) { err.textContent = 'Invalid email or password.'; err.classList.add('show'); return; }
  err.classList.remove('show');
  document.getElementById('login-ok').classList.add('show');
  S.user = u; S.enrolled = u.enrolled || [];
  saveSession();
  setTimeout(() => {
    closeModal(); updateNav(true); updateDash();
    toast('Welcome back, ' + u.fname + '!', 'suc');
  }, 900);
}

function doRegister() {
  const fname = document.getElementById('r-fname').value.trim();
  const lname = document.getElementById('r-lname').value.trim();
  const email = document.getElementById('r-email').value.trim();
  const phone = document.getElementById('r-phone').value.trim();
  const pass = document.getElementById('r-pass').value;
  const err = document.getElementById('reg-err');
  if (!fname || !email || !pass) { err.textContent = 'First name, email and password are required.'; err.classList.add('show'); return; }
  if (!email.includes('@')) { err.textContent = 'Please enter a valid email.'; err.classList.add('show'); return; }
  if (pass.length < 8) { err.textContent = 'Password must be at least 8 characters.'; err.classList.add('show'); return; }
  const users = JSON.parse(localStorage.getItem('ah_users') || '[]');
  if (users.find(x => x.email === email)) { err.textContent = 'This email is already registered.'; err.classList.add('show'); return; }
  err.classList.remove('show');
  const nu = { fname, lname, email, phone, pass: btoa(pass), tier: S.tier, enrolled: [], joined: new Date().toLocaleDateString() };
  users.push(nu); localStorage.setItem('ah_users', JSON.stringify(users));
  document.getElementById('reg-ok').classList.add('show');
  setTimeout(() => { document.getElementById('reg-ok').classList.remove('show'); switchTab('login'); }, 1600);
}

function doLogout() {
  S.user = null; S.enrolled = [];
  sessionStorage.removeItem('ah_user');
  updateNav(false);
  showPage('home');
  toast('Logged out successfully.', 'inf');
}

function saveSession() {
  const u = { ...S.user, enrolled: S.enrolled };
  sessionStorage.setItem('ah_user', JSON.stringify(u));
  const users = JSON.parse(localStorage.getItem('ah_users') || '[]');
  const i = users.findIndex(x => x.email === S.user.email);
  if (i > -1) { users[i] = u; localStorage.setItem('ah_users', JSON.stringify(users)); }
}

function restoreSession() {
  const s = sessionStorage.getItem('ah_user');
  if (s) {
    S.user = JSON.parse(s); S.enrolled = S.user.enrolled || [];
    updateNav(true);
  }
}

function updateNav(loggedIn) {
  document.getElementById('nav-login-btn').style.display = loggedIn ? 'none' : '';
  document.getElementById('nav-reg-btn').style.display = loggedIn ? 'none' : '';
  document.getElementById('nav-logout-btn').style.display = loggedIn ? '' : 'none';
  document.getElementById('nav-dash-lnk').style.display = loggedIn ? '' : 'none';
}

/* ── DASHBOARD ── */
function showDashPanel(id, el) {
  document.querySelectorAll('.dash-panel').forEach(p => p.classList.remove('act'));
  document.querySelectorAll('.ds-item').forEach(i => i.classList.remove('act'));
  document.getElementById('dash-' + id)?.classList.add('act');
  if (el) el.classList.add('act');
}

function updateDash() {
  if (!S.user) return;
  document.getElementById('dash-name').textContent = S.user.fname?.toUpperCase() || 'STUDENT';
  document.getElementById('dash-plan').textContent = S.user.tier === 'premium' ? 'PREMIUM ⚡' : 'FREE';
  document.getElementById('dash-enrolled-n').textContent = S.enrolled.length;
  const enr = COURSES.filter(c => S.enrolled.includes(c.id));
  const html = enr.length
    ? enr.map(c => `
        <div class="enr-item">
          <div class="enr-thumb ${c.th}">${c.icon}</div>
          <div style="flex:1"><div class="enr-name">${c.title}</div><div class="enr-prog-lbl">Progress</div></div>
          <div class="enr-prog-wrap" style="max-width:160px">
            <div class="enr-bar"><div class="enr-fill" style="width:0%"></div></div>
            <div class="enr-pct">0%</div>
          </div>
        </div>`).join('')
    : `<div class="empty-state">
        <div class="es-ico">📡</div>
        <div class="es-title">NO COURSES YET</div>
        <div class="es-desc">Enroll in a course to get started.</div>
        <button class="btn btn-c" onclick="showPage('courses')"><i class="fas fa-search"></i> Browse Courses</button>
      </div>`;
  ['dash-enr-list', 'dash-mc-list'].forEach(id => { const el = document.getElementById(id); if (el) el.innerHTML = html; });
  if (document.getElementById('pf-fname')) document.getElementById('pf-fname').value = S.user.fname || '';
  if (document.getElementById('pf-lname')) document.getElementById('pf-lname').value = S.user.lname || '';
  if (document.getElementById('pf-email')) document.getElementById('pf-email').value = S.user.email || '';
  if (document.getElementById('pf-phone')) document.getElementById('pf-phone').value = S.user.phone || '';
}

function saveProfile() {
  if (!S.user) return;
  S.user.fname = document.getElementById('pf-fname').value || S.user.fname;
  S.user.lname = document.getElementById('pf-lname').value || S.user.lname;
  S.user.phone = document.getElementById('pf-phone').value || S.user.phone;
  saveSession();
  document.getElementById('dash-name').textContent = S.user.fname.toUpperCase();
  toast('Profile updated!', 'suc');
}

/* ── CONTACT & NEWSLETTER ── */
function sendContact() {
  if (!document.getElementById('cf-email').value) { toast('Please enter your email address.', 'err'); return; }
  const ok = document.getElementById('contact-ok');
  ok.classList.add('show');
  toast("Message sent! I'll respond within 24 hours.", 'suc');
  ['cf-fname', 'cf-lname', 'cf-email', 'cf-phone', 'cf-msg'].forEach(id => { const el = document.getElementById(id); if (el) el.value = ''; });
  setTimeout(() => ok.classList.remove('show'), 5000);
}

function doSubscribe() {
  const v = document.getElementById('nl-email').value;
  if (!v.includes('@')) { toast('Please enter a valid email.', 'err'); return; }
  toast('Subscribed! Weekly resources coming your way.', 'suc');
  document.getElementById('nl-email').value = '';
}
