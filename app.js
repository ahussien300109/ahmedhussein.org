/* ─────────────────────────────────────────────
   app.js — Main entry point: UI, data, routing
   ───────────────────────────────────────────── */

/* ── COURSE PERSISTENCE ── */
function loadCourses() {
  try { const s = localStorage.getItem('ah_courses'); if (s) return JSON.parse(s); } catch(e) {}
  return DEFAULT_COURSES.map(c => Object.assign({}, c));
}
function saveCourses() { localStorage.setItem('ah_courses', JSON.stringify(COURSES)); }

/* ── COURSE DATA ── */
const DEFAULT_COURSES = [
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
    link: 'ccna-domain1.html',
    curriculum: ['Exam Structure & Scoring','Domain 1: Network Fundamentals','Domain 2: Network Access','Domain 3: IP Connectivity','Domain 4: IP Services','Domain 5: Security Fundamentals','Domain 6: Automation','Practice Test 1 + Review','Practice Test 2 + Final Sim'] }
];
let COURSES = loadCourses();

/* ── APP STATE ── */
const S = { user: null, enrolled: [], tier: 'free', filter: 'all', isAdmin: false };

/* ── CIRCUIT CANVAS ── */
function initCircuit() {
  const c = document.getElementById('circuit-canvas');
  const ctx = c.getContext('2d');
  let W, H, nodes = [];
  function resize() {
    W = c.width = window.innerWidth;
    H = c.height = window.innerHeight;
    nodes = [];
    const n = Math.floor((W * H) / 22000);
    for (let i = 0; i < n; i++)
      nodes.push({ x: Math.random() * W, y: Math.random() * H, vx: (Math.random() - .5) * 0.3, vy: (Math.random() - .5) * 0.3 });
  }
  resize();
  window.addEventListener('resize', resize);
  function draw() {
    ctx.clearRect(0, 0, W, H);
    nodes.forEach(n => {
      n.x += n.vx; n.y += n.vy;
      if (n.x < 0 || n.x > W) n.vx *= -1;
      if (n.y < 0 || n.y > H) n.vy *= -1;
      ctx.beginPath(); ctx.arc(n.x, n.y, 1.5, 0, Math.PI * 2);
      ctx.fillStyle = '#00d4ff'; ctx.fill();
    });
    for (let i = 0; i < nodes.length; i++)
      for (let j = i + 1; j < nodes.length; j++) {
        const dx = nodes[i].x - nodes[j].x, dy = nodes[i].y - nodes[j].y;
        const d = Math.sqrt(dx * dx + dy * dy);
        if (d < 130) {
          ctx.beginPath(); ctx.moveTo(nodes[i].x, nodes[i].y); ctx.lineTo(nodes[j].x, nodes[j].y);
          ctx.strokeStyle = `rgba(0,212,255,${(1 - d / 130) * 0.5})`; ctx.lineWidth = 0.4; ctx.stroke();
        }
      }
    requestAnimationFrame(draw);
  }
  draw();
}

/* ── CUSTOM CURSOR ── */
function initCursor() {
  if (window.innerWidth < 1024) return;
  const cur = document.getElementById('cursor'), ring = document.getElementById('cursor-ring');
  document.addEventListener('mousemove', e => {
    cur.style.left = e.clientX + 'px'; cur.style.top = e.clientY + 'px';
    ring.style.left = e.clientX + 'px'; ring.style.top = e.clientY + 'px';
  });
  document.querySelectorAll('button,a,.ccard,.cert-tile,.feat-item').forEach(el => {
    el.addEventListener('mouseenter', () => { cur.classList.add('cursor-hover'); ring.classList.add('cursor-ring-hover'); });
    el.addEventListener('mouseleave', () => { cur.classList.remove('cursor-hover'); ring.classList.remove('cursor-ring-hover'); });
  });
}

/* ── SCROLL & OBSERVER ── */
function initScroll() {
  const nav = document.getElementById('nav');
  window.addEventListener('scroll', () => nav.classList.toggle('stuck', window.scrollY > 20), { passive: true });
}

function initObserver() {
  const obs = new IntersectionObserver(entries =>
    entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('vis'); obs.unobserve(e.target); } }),
    { threshold: 0.12 });
  document.querySelectorAll('.reveal').forEach(el => obs.observe(el));
}

function reObserve() {
  setTimeout(() => {
    const obs = new IntersectionObserver(entries =>
      entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('vis'); }),
      { threshold: 0.1 });
    document.querySelectorAll('.reveal:not(.vis)').forEach(el => obs.observe(el));
  }, 120);
}

/* ── COUNTERS & SKILLS ── */
function initCounters() {
  const obs = new IntersectionObserver(entries =>
    entries.forEach(e => { if (e.isIntersecting) { animCount(e.target); obs.unobserve(e.target); } }),
    { threshold: 0.5 });
  document.querySelectorAll('[data-count]').forEach(el => obs.observe(el));
}

function animCount(el) {
  const target = +el.dataset.count, sfx = el.dataset.sfx || '', dur = 1800, start = performance.now();
  (function tick(now) {
    const p = Math.min((now - start) / dur, 1), e = 1 - Math.pow(1 - p, 3);
    el.textContent = Math.round(target * e) + sfx;
    if (p < 1) requestAnimationFrame(tick);
  })(start);
}

function animSkills() {
  document.querySelectorAll('.sr-fill').forEach(b => b.style.width = b.dataset.w || '0%');
}

/* ── THEME & TOAST ── */
function toggleTheme() {
  const html = document.documentElement;
  const isLight = html.getAttribute('data-theme') === 'light';
  html.setAttribute('data-theme', isLight ? 'dark' : 'light');
  localStorage.setItem('theme', isLight ? 'dark' : 'light');
  document.getElementById('theme-icon').className = isLight ? 'fas fa-sun' : 'fas fa-moon';
}

function toast(msg, type = 'inf') {
  const box = document.getElementById('toast-box');
  const icons = { suc: 'fa-check-circle', err: 'fa-exclamation-circle', inf: 'fa-info-circle' };
  const t = document.createElement('div');
  t.className = `toast ${type}`;
  t.innerHTML = `<i class="fas ${icons[type] || icons.inf}"></i><span>${msg}</span>`;
  box.appendChild(t);
  setTimeout(() => { t.classList.add('rm'); setTimeout(() => t.remove(), 300); }, 4200);
}

/* ── SCROLL PROGRESS ── */
function initScrollProgress() {
  const bar = document.getElementById('scroll-progress');
  if (!bar) return;
  window.addEventListener('scroll', () => {
    const pct = window.scrollY / (document.documentElement.scrollHeight - window.innerHeight) * 100;
    bar.style.width = Math.min(pct, 100) + '%';
  }, { passive: true });
}

/* ── FAQ ACCORDION ── */
function toggleFAQ(qEl) {
  const item = qEl.closest('.faq-item');
  const wasOpen = item.classList.contains('open');
  document.querySelectorAll('.faq-item.open').forEach(i => i.classList.remove('open'));
  if (!wasOpen) item.classList.add('open');
}

/* ── MOBILE NAV ── */
function toggleMob() {
  document.getElementById('mob-nav').classList.toggle('open');
  document.getElementById('ham').classList.toggle('open');
}

/* ── INIT ── */
document.addEventListener('DOMContentLoaded', () => {
  if (document.documentElement.getAttribute('data-theme') === 'light') {
    const ic = document.getElementById('theme-icon');
    if (ic) ic.className = 'fas fa-moon';
  }
  initScrollProgress();
  initCircuit();
  initCursor();
  initScroll();
  initObserver();
  initCounters();
  renderCourses('home-courses-grid', COURSES.slice(0, 3));
  restoreSession();
  initChat();
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
          <button class="cc-enroll" onclick="event.stopPropagation();enrollCourse(${c.id})">${c.link ? '▶ Start Course' : S.enrolled.includes(c.id) ? '✓ Enrolled' : 'Enroll Now'}</button>
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
  const enrollBtn = c.link
    ? `<a href="${c.link}" class="btn btn-g"><i class="fas fa-play"></i> Start Free Course</a>`
    : `<button class="btn ${isEnrolled ? 'btn-ghost' : 'btn-c'}" onclick="enrollCourse(${c.id});closeCourseModal()">${isEnrolled ? '<i class="fas fa-check"></i> Already Enrolled' : '<i class="fas fa-graduation-cap"></i> Enroll Now'}</button>`;
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
      ${enrollBtn}
    </div>`;
  document.getElementById('course-modal').classList.add('open');
  document.body.style.overflow = 'hidden';
}

function closeCourseModal() {
  document.getElementById('course-modal').classList.remove('open');
  document.body.style.overflow = '';
}

function enrollCourse(id) {
  const course = COURSES.find(x => x.id === id);
  if (course?.link) { window.location.href = course.link; return; }
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
  S.user = u; S.enrolled = u.enrolled || []; S.isAdmin = !!u.isAdmin;
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
  const nu = { fname, lname, email, phone, pass: btoa(pass), tier: S.tier, enrolled: [], joined: new Date().toLocaleDateString(), isAdmin: email === 'admin@ahmedhussein.org' };
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
    S.user = JSON.parse(s); S.enrolled = S.user.enrolled || []; S.isAdmin = !!S.user.isAdmin;
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
function activatePanel(id) {
  document.querySelectorAll('.dash-panel').forEach(p => p.classList.remove('act'));
  document.querySelectorAll('.ds-item[data-pnl]').forEach(i => i.classList.remove('act'));
  const panel = document.getElementById('dash-' + id);
  if (panel) panel.classList.add('act');
  const nav = document.querySelector('.ds-item[data-pnl="' + id + '"]');
  if (nav) nav.classList.add('act');
}
function showDashPanel(id) { activatePanel(id); }

function updateDash() {
  if (!S.user) return;
  renderDashNav();
  if (S.isAdmin) { activatePanel('admin-overview'); renderAdminOverview(); }
  else { activatePanel('overview'); renderStudentDash(); }
}

function renderDashNav() {
  const nav = document.getElementById('ds-nav');
  const logo = document.getElementById('ds-logo-txt');
  const role = document.getElementById('ds-role-txt');
  if (!nav) return;
  if (S.isAdmin) {
    if (logo) logo.textContent = 'ADMIN';
    if (role) role.textContent = 'Control Panel';
    nav.innerHTML = `
      <div class="ds-item act" data-pnl="admin-overview" onclick="activatePanel('admin-overview');renderAdminOverview()"><i class="fas fa-chart-bar"></i> Dashboard</div>
      <div class="ds-item" data-pnl="admin-courses" onclick="activatePanel('admin-courses');renderAdminCourses()"><i class="fas fa-book"></i> Courses</div>
      <div class="ds-item" data-pnl="admin-edit" onclick="openEditCourse(null)"><i class="fas fa-plus-circle"></i> Add Course</div>
      <div class="ds-item" data-pnl="admin-students" onclick="activatePanel('admin-students');renderAdminStudents()"><i class="fas fa-users"></i> Students</div>
      <div class="ds-sep"></div>
      <div class="ds-item" onclick="showPage('courses')"><i class="fas fa-compass"></i> View Site</div>
      <div class="ds-item ds-logout" onclick="doLogout()"><i class="fas fa-power-off"></i> Logout</div>`;
  } else {
    if (logo) logo.textContent = 'DASHBOARD';
    if (role) role.textContent = 'Student Portal';
    nav.innerHTML = `
      <div class="ds-item act" data-pnl="overview" onclick="activatePanel('overview');renderStudentDash()"><i class="fas fa-th-large"></i> Overview</div>
      <div class="ds-item" data-pnl="my-courses" onclick="activatePanel('my-courses');renderMyCourses()"><i class="fas fa-graduation-cap"></i> My Courses</div>
      <div class="ds-item" data-pnl="profile" onclick="activatePanel('profile')"><i class="fas fa-user-circle"></i> Profile</div>
      <div class="ds-sep"></div>
      <div class="ds-item" onclick="showPage('courses')"><i class="fas fa-compass"></i> Browse Courses</div>
      <div class="ds-item" onclick="showPage('contact')"><i class="fas fa-headset"></i> Support</div>
      <div class="ds-sep"></div>
      <div class="ds-item ds-logout" onclick="doLogout()"><i class="fas fa-power-off"></i> Logout</div>`;
  }
}

/* ── STUDENT DASHBOARD ── */
function renderStudentDash() {
  if (!S.user) return;
  const nm = document.getElementById('dash-name');
  const pl = document.getElementById('dash-plan');
  const en = document.getElementById('dash-enrolled-n');
  if (nm) nm.textContent = (S.user.fname || 'STUDENT').toUpperCase();
  if (pl) pl.textContent = S.user.tier === 'premium' ? 'PREMIUM ⚡' : 'FREE';
  if (en) en.textContent = S.enrolled.length;
  const el = document.getElementById('dash-enr-list');
  if (el) el.innerHTML = buildEnrolledHTML(S.enrolled.slice(0, 4));
  ['pf-fname','pf-lname','pf-email','pf-phone'].forEach(id => {
    const field = document.getElementById(id);
    const key = id.replace('pf-', '');
    if (field) field.value = S.user[key] || '';
  });
}

function renderMyCourses() {
  const el = document.getElementById('dash-mc-list');
  if (el) el.innerHTML = buildEnrolledHTML(S.enrolled);
}

function buildEnrolledHTML(ids) {
  if (!ids || !ids.length) return `<div class="empty-state"><div class="es-ico">&#128225;</div><div class="es-title">NO COURSES YET</div><div class="es-desc">Enroll in a course to get started.</div><button class="btn btn-c" onclick="showPage('courses')"><i class="fas fa-search"></i> Browse Courses</button></div>`;
  return ids.map(id => {
    const c = COURSES.find(x => x.id === id);
    if (!c) return '';
    const continueBtn = c.link
      ? `<a href="${c.link}" class="btn btn-c btn-sm"><i class="fas fa-play"></i> Continue</a>`
      : `<button class="btn btn-ghost btn-sm" onclick="openCourseDetail(${c.id})"><i class="fas fa-info-circle"></i> Info</button>`;
    return `<div class="enr-item">
      <div class="enr-thumb ${c.th}">${c.icon}</div>
      <div class="enr-info">
        <div class="enr-name">${c.title}</div>
        <div style="font-size:.65rem;color:var(--tm);margin-top:2px">${c.cat} · ${c.level} · ${c.duration}</div>
        <div class="enr-prog-row">
          <div class="enr-bar"><div class="enr-fill" style="width:0%"></div></div>
          <div class="enr-pct">0%</div>
        </div>
      </div>
      <div class="enr-actions">${continueBtn}</div>
    </div>`;
  }).join('');
}

/* ── ADMIN: OVERVIEW ── */
function renderAdminOverview() {
  const el = document.getElementById('dash-admin-overview');
  if (!el) return;
  const users = JSON.parse(localStorage.getItem('ah_users') || '[]');
  const totalEnr = users.reduce((a, u) => a + (u.enrolled ? u.enrolled.length : 0), 0);
  el.innerHTML = `
    <div class="dash-toprow">
      <div><div class="dash-hello">ADMIN <span>DASHBOARD</span></div><div class="dash-sub">Site overview and quick actions</div></div>
    </div>
    <div class="dash-stats">
      <div class="dstat"><div class="dstat-ico ico-c"><i class="fas fa-book"></i></div><div class="dstat-num">${COURSES.length}</div><div class="dstat-lbl">Courses</div></div>
      <div class="dstat"><div class="dstat-ico ico-g"><i class="fas fa-users"></i></div><div class="dstat-num">${users.filter(u=>!u.isAdmin).length}</div><div class="dstat-lbl">Students</div></div>
      <div class="dstat"><div class="dstat-ico ico-o"><i class="fas fa-graduation-cap"></i></div><div class="dstat-num">${totalEnr}</div><div class="dstat-lbl">Enrollments</div></div>
      <div class="dstat"><div class="dstat-ico ico-p"><i class="fas fa-star"></i></div><div class="dstat-num">${COURSES.filter(c=>c.price==='Free').length}</div><div class="dstat-lbl">Free</div></div>
    </div>
    <div class="dash-sec-title">Quick Actions</div>
    <div style="display:flex;gap:1rem;flex-wrap:wrap">
      <button class="btn btn-c" onclick="openEditCourse(null)"><i class="fas fa-plus"></i> Add Course</button>
      <button class="btn btn-ghost" onclick="activatePanel('admin-courses');renderAdminCourses()"><i class="fas fa-book"></i> Manage Courses</button>
      <button class="btn btn-ghost" onclick="activatePanel('admin-students');renderAdminStudents()"><i class="fas fa-users"></i> View Students</button>
    </div>`;
}

/* ── ADMIN: COURSE TABLE ── */
let editingId = null;
function renderAdminCourses() {
  const el = document.getElementById('dash-admin-courses-inner');
  if (!el) return;
  if (!COURSES.length) {
    el.innerHTML = `<div class="empty-state"><div class="es-ico">&#128218;</div><div class="es-title">NO COURSES</div><div class="es-desc">Click "Add Course" above to create your first course.</div></div>`;
    return;
  }
  const cols = '2fr 1fr 1fr 1fr 1.4fr';
  el.innerHTML = `<div class="adm-tbl">
    <div class="adm-tbl-hdr" style="grid-template-columns:${cols}">
      <span>Course</span><span>Category</span><span>Level</span><span>Price</span><span>Actions</span>
    </div>
    ${COURSES.map(c => `<div class="adm-tbl-row" style="grid-template-columns:${cols}">
      <div class="adm-course-name"><span style="font-size:1.3rem">${c.icon}</span><span>${c.title}</span></div>
      <span><span class="lvl-tag">${c.cat}</span></span>
      <span style="font-size:.74rem;color:var(--tm)">${c.level}</span>
      <span class="${c.price==='Free'?'free-tag':'price-tag'}">${c.price}</span>
      <div style="display:flex;gap:.45rem;flex-wrap:wrap">
        <button class="btn btn-ghost btn-sm" onclick="openEditCourse(${c.id})"><i class="fas fa-edit"></i> Edit</button>
        <button class="btn btn-sm" style="background:rgba(255,68,85,.1);color:var(--red);border:1px solid rgba(255,68,85,.2)" onclick="adminDeleteCourse(${c.id})"><i class="fas fa-trash"></i></button>
      </div>
    </div>`).join('')}
  </div>`;
}

/* ── ADMIN: EDIT FORM ── */
function openEditCourse(id) {
  editingId = id;
  const heading = document.getElementById('ace-heading');
  if (id === null) {
    if (heading) heading.textContent = 'ADD COURSE';
    ['cf-title','cf-icon','cf-dur','cf-price','cf-desc','cf-prereqs','cf-link','cf-curr'].forEach(fid => { const el=document.getElementById(fid); if(el) el.value=''; });
    const cat = document.getElementById('cf-cat'); if (cat) cat.value='CCNA';
    const lvl = document.getElementById('cf-level'); if (lvl) lvl.value='Beginner';
    const pri = document.getElementById('cf-price'); if (pri) pri.value='$149';
    const ico = document.getElementById('cf-icon'); if (ico) ico.value='🌐';
  } else {
    const c = COURSES.find(x => x.id === id);
    if (!c) return;
    if (heading) heading.textContent = 'EDIT COURSE';
    const set = (fid, val) => { const el=document.getElementById(fid); if(el) el.value=val||''; };
    set('cf-title', c.title); set('cf-icon', c.icon); set('cf-cat', c.cat);
    set('cf-level', c.level); set('cf-dur', c.duration); set('cf-price', c.price);
    set('cf-desc', c.desc); set('cf-prereqs', c.prereqs); set('cf-link', c.link||'');
    set('cf-curr', (c.curriculum||[]).join('\n'));
  }
  activatePanel('admin-edit');
}

/* ── ADMIN: SAVE COURSE ── */
function adminSaveCourse() {
  const title = (document.getElementById('cf-title').value||'').trim();
  if (!title) { toast('Course title is required.', 'err'); return; }
  const g = id => (document.getElementById(id)||{}).value || '';
  const cat    = g('cf-cat') || 'CCNA';
  const level  = g('cf-level') || 'Beginner';
  const dur    = g('cf-dur').trim() || '0 hrs';
  const price  = g('cf-price').trim() || 'Free';
  const icon   = g('cf-icon').trim() || '📚';
  const desc   = g('cf-desc').trim();
  const prereqs= g('cf-prereqs').trim();
  const link   = g('cf-link').trim();
  const curr   = g('cf-curr').split('\n').map(s=>s.trim()).filter(Boolean);
  const thMap  = {CCNA:'th1',CCNP:'th2',Security:'th3',Labs:'th4'};
  const th     = thMap[cat] || 'th5';
  if (editingId === null) {
    const newId = COURSES.length ? Math.max(...COURSES.map(c=>c.id))+1 : 1;
    COURSES.push({id:newId,cat,icon,th,title,desc,level,duration:dur,students:'0',price,rating:'5.0',reviews:'0',prereqs,link:link||undefined,curriculum:curr});
    toast('Course added!', 'suc');
  } else {
    const idx = COURSES.findIndex(x=>x.id===editingId);
    if (idx>-1) {
      COURSES[idx] = Object.assign({}, COURSES[idx], {cat,icon,th,title,desc,level,duration:dur,price,prereqs,link:link||undefined,curriculum:curr});
      toast('Course updated!', 'suc');
    }
  }
  saveCourses();
  renderCourses('home-courses-grid', COURSES.slice(0,3));
  renderCourses('all-courses-grid', COURSES);
  activatePanel('admin-courses');
  renderAdminCourses();
}

/* ── ADMIN: DELETE COURSE ── */
function adminDeleteCourse(id) {
  const c = COURSES.find(x=>x.id===id);
  if (!c) return;
  if (!confirm('Delete "' + c.title + '"? This cannot be undone.')) return;
  COURSES.splice(COURSES.findIndex(x=>x.id===id), 1);
  saveCourses();
  renderCourses('home-courses-grid', COURSES.slice(0,3));
  renderCourses('all-courses-grid', COURSES);
  renderAdminCourses();
  toast('Course deleted.', 'inf');
}

/* ── ADMIN: STUDENTS ── */
function renderAdminStudents() {
  const el = document.getElementById('dash-admin-students-inner');
  if (!el) return;
  const users = JSON.parse(localStorage.getItem('ah_users')||'[]').filter(u=>!u.isAdmin);
  if (!users.length) {
    el.innerHTML = `<div class="empty-state"><div class="es-ico">&#128100;</div><div class="es-title">NO STUDENTS YET</div><div class="es-desc">Students appear here after registering on the site.</div></div>`;
    return;
  }
  const cols = '1.4fr 2fr 1fr 0.7fr 1fr';
  el.innerHTML = `<div class="adm-tbl">
    <div class="adm-tbl-hdr" style="grid-template-columns:${cols}">
      <span>Name</span><span>Email</span><span>Plan</span><span>Courses</span><span>Joined</span>
    </div>
    ${users.map(u=>`<div class="adm-tbl-row" style="grid-template-columns:${cols}">
      <span style="font-weight:600;color:var(--tw)">${u.fname||''} ${u.lname||''}</span>
      <span style="font-size:.74rem;color:var(--tm)">${u.email}</span>
      <span><span class="lvl-tag ${u.tier==='premium'?'premium-tag':''}">${u.tier==='premium'?'Premium':'Free'}</span></span>
      <span style="font-family:'Orbitron',monospace;font-size:.8rem;color:var(--c)">${(u.enrolled||[]).length}</span>
      <span style="font-size:.72rem;color:var(--tm)">${u.joined||'&mdash;'}</span>
    </div>`).join('')}
  </div>`;
}

/* ── PROFILE ── */
function saveProfile() {
  if (!S.user) return;
  S.user.fname = document.getElementById('pf-fname').value || S.user.fname;
  S.user.lname = document.getElementById('pf-lname').value || S.user.lname;
  S.user.phone = document.getElementById('pf-phone').value || S.user.phone;
  saveSession();
  document.getElementById('dash-name').textContent = S.user.fname.toUpperCase();
  toast('Profile updated!', 'suc');
}

/* ── CHAT WIDGET ── */
const CHAT_REPLIES = [
  [/\b(hi|hello|hey|salaam|marhaba)\b/i,    'Hello! 👋 How can I help you today?'],
  [/ccna/i,                                  'Our CCNA 200-301 course takes you from zero to certified with 80 hrs of labs and 5 practice exams. Check Courses above!'],
  [/ccnp/i,                                  'The CCNP Enterprise (ENCOR 350-401) covers BGP, SD-WAN, automation and more. Recommended after CCNA.'],
  [/securit|cyberops|scor/i,                 'The CyberOps & Security course covers ASA firewalls, Firepower NGFW, VPNs and incident response. Great for security roles!'],
  [/free|price|cost|paid|\$/i,               'The CCNA Exam Bootcamp is completely free! Premium courses start at $79. Register for a free account to get started.'],
  [/lab|packet tracer/i,                     'All courses include Cisco Packet Tracer labs. The dedicated Lab course has 50+ hands-on exercises.'],
  [/certif/i,                                'Premium members receive a completion certificate for every course — perfect for LinkedIn and job applications!'],
  [/contact|email|whatsapp|reach/i,          'You can reach Ahmed at ahmed@ahmedhussein.org or via the Contact page. He responds within 24 hours.'],
  [/register|sign.?up|account/i,             'Click "Register Free" in the top nav — takes 30 seconds and gives you instant access to free courses!'],
  [/thank/i,                                 "You're welcome! 😊 Let me know if you have any other questions."],
  [/./,                                      "Thanks for your message! Ahmed will get back to you shortly. Meanwhile feel free to browse the Courses section. 🚀"],
];

let chatOpen = false;

function initChat() {
  setTimeout(() => addChatMsg("Hi there! 👋 Ask me about courses, pricing, or anything else.", 'bot'), 600);
  setTimeout(() => {
    if (!chatOpen) document.getElementById('chat-badge').style.display = 'flex';
  }, 700);
}

function toggleChat() {
  const box = document.getElementById('chat-box');
  chatOpen = !chatOpen;
  box.classList.toggle('open', chatOpen);
  document.getElementById('chat-icon').className = chatOpen ? 'fas fa-times' : 'fas fa-comment-dots';
  document.getElementById('chat-badge').style.display = 'none';
  if (chatOpen) setTimeout(() => document.getElementById('chat-input').focus(), 80);
}

function sendChat() {
  const inp = document.getElementById('chat-input');
  const text = inp.value.trim();
  if (!text) return;
  addChatMsg(text, 'user');
  inp.value = '';
  const msgs = document.getElementById('chat-msgs');
  const t = document.createElement('div');
  t.className = 'chat-typing'; t.id = 'chat-typing';
  t.innerHTML = '<div class="tydot"></div><div class="tydot"></div><div class="tydot"></div>';
  msgs.appendChild(t); msgs.scrollTop = msgs.scrollHeight;
  setTimeout(() => {
    const ty = document.getElementById('chat-typing');
    if (ty) ty.remove();
    const match = CHAT_REPLIES.find(([rx]) => rx.test(text));
    addChatMsg(match[1], 'bot');
  }, 700 + Math.random() * 500);
}

function addChatMsg(text, from) {
  const msgs = document.getElementById('chat-msgs');
  if (!msgs) return;
  const d = document.createElement('div');
  d.className = `cmsg ${from}`;
  d.textContent = text;
  msgs.appendChild(d);
  msgs.scrollTop = msgs.scrollHeight;
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
