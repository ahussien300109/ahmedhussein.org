/* ============================================
   AHMED HUSSEIN CISCO INSTRUCTOR — MAIN JS
   ============================================ */

'use strict';

/* ── COURSE DATA ── */
const COURSES = [
  {
    id: 1, cat: 'CCNA', icon: '🌐',
    thumb: 'thumb-1', thumbClass: 'thumb-1',
    title: 'CCNA 200-301: Complete Network Associate',
    desc: 'Master the fundamentals of routing, switching, and network administration. Covers IPv4/IPv6, VLANs, STP, OSPF, and everything you need to pass the CCNA exam.',
    level: 'Beginner', duration: '80 hrs', students: '420', price: '$149',
    rating: '4.9', reviews: '128',
    prereqs: 'Basic computer skills. No prior networking knowledge required.',
    objectives: ['Understand OSI and TCP/IP models', 'Configure routers and switches', 'Implement OSPF and EIGRP', 'Configure VLANs and inter-VLAN routing', 'Secure network devices'],
    curriculum: [
      'Networking Fundamentals & OSI Model',
      'IP Addressing & Subnetting (IPv4/IPv6)',
      'Routing Protocols: OSPF, EIGRP, Static',
      'VLANs, Trunking, and Spanning Tree',
      'WAN Technologies: MPLS, PPPoE, VPNs',
      'Network Services: DHCP, DNS, NAT',
      'Security Fundamentals & ACLs',
      'Network Automation & Programmability',
      'Wireless Networking Basics',
      'Exam Strategy & 5 Practice Tests'
    ]
  },
  {
    id: 2, cat: 'CCNP', icon: '🔷',
    thumb: 'thumb-2', thumbClass: 'thumb-2',
    title: 'CCNP Enterprise: ENCOR 350-401',
    desc: 'Advanced enterprise networking covering dual-stack architecture, wireless, SD-WAN, security, and automation. The complete ENCOR preparation course.',
    level: 'Advanced', duration: '120 hrs', students: '180', price: '$249',
    rating: '4.8', reviews: '64',
    prereqs: 'CCNA certification or equivalent knowledge required.',
    objectives: ['Design enterprise campus networks', 'Deploy advanced routing protocols', 'Configure SD-WAN solutions', 'Automate with Python and Ansible', 'Implement network security policies'],
    curriculum: [
      'Advanced OSPF & BGP Configuration',
      'MPLS L3VPN Architecture',
      'Campus Switching: STP, RSTP, MSTP',
      'Wireless Design: 802.11 & Cisco WLC',
      'SD-WAN Architecture & Deployment',
      'Network Automation with Python',
      'Ansible for Network Engineers',
      'Infrastructure Security & TrustSec',
      'Network Assurance & DNA Center',
      'ENCOR Practice Exams & Labs'
    ]
  },
  {
    id: 3, cat: 'Security', icon: '🔐',
    thumb: 'thumb-3', thumbClass: 'thumb-3',
    title: 'Cisco CyberOps & Network Security',
    desc: 'Comprehensive Cisco security training covering threat defense, ASA/Firepower firewalls, IDS/IPS, VPNs, and incident response for security professionals.',
    level: 'Intermediate', duration: '90 hrs', students: '210', price: '$199',
    rating: '4.9', reviews: '89',
    prereqs: 'CCNA or basic networking knowledge recommended.',
    objectives: ['Configure Cisco ASA Firewall', 'Deploy Firepower NGFW', 'Implement site-to-site and remote VPNs', 'Analyze security logs', 'Respond to network incidents'],
    curriculum: [
      'Security Concepts & Cryptography',
      'Cisco ASA Firewall & NAT Policies',
      'Firepower NGFW & IDS/IPS',
      'VPN Technologies: IPsec & SSL',
      'Identity Management with AAA & ISE',
      'Security Monitoring & SIEM',
      'Threat Detection & Incident Response',
      'Compliance & Risk Management',
      'CyberOps Associate Exam Prep',
      'SCOR 350-701 Practice Labs'
    ]
  },
  {
    id: 4, cat: 'Labs', icon: '🖧',
    thumb: 'thumb-4', thumbClass: 'thumb-4',
    title: 'Packet Tracer Masterclass: 50+ Labs',
    desc: 'Hands-on Cisco Packet Tracer labs covering every major networking scenario. Build complete enterprise network topologies from scratch with step-by-step guidance.',
    level: 'Beginner', duration: '40 hrs', students: '560', price: '$79',
    rating: '4.9', reviews: '207',
    prereqs: 'No prerequisites. Packet Tracer is free to download.',
    objectives: ['Navigate Packet Tracer confidently', 'Build LAN and WAN topologies', 'Configure routing and switching', 'Troubleshoot real network issues', 'Create complex multi-site scenarios'],
    curriculum: [
      'Packet Tracer Interface & Device Setup',
      'Building Small Office LAN Topology',
      'Router CLI Configuration from Scratch',
      'VLAN & Inter-VLAN Routing Labs',
      'OSPF Multi-Area Design Lab',
      'EIGRP & Redistribution Lab',
      'ACL & Extended ACL Security Labs',
      'DHCP Server & Relay Configuration',
      'IPv6 Dual-Stack Network Lab',
      'Final Project: Enterprise Campus Network'
    ]
  },
  {
    id: 5, cat: 'CCNP', icon: '⚙️',
    thumb: 'thumb-5', thumbClass: 'thumb-5',
    title: 'SD-WAN & Network Automation with Python',
    desc: 'Master Cisco Viptela SD-WAN, Python scripting for network engineers, Ansible playbooks, NETCONF/RESTCONF APIs, and Cisco DNA Center automation.',
    level: 'Advanced', duration: '60 hrs', students: '95', price: '$199',
    rating: '4.7', reviews: '38',
    prereqs: 'CCNP ENCOR or solid enterprise networking experience required.',
    objectives: ['Deploy Cisco SD-WAN fabric', 'Write Python scripts for network automation', 'Use Ansible for device configuration', 'Consume NETCONF/RESTCONF APIs', 'Automate with DNA Center'],
    curriculum: [
      'SD-WAN Architecture: Control & Data Plane',
      'Cisco vManage, vBond & vSmart Setup',
      'OMP Routing & Policy Configuration',
      'Python for Network Engineers (beginner→advanced)',
      'Netmiko & NAPALM Libraries',
      'Ansible Playbooks for Cisco IOS/NX-OS',
      'NETCONF, RESTCONF & YANG Models',
      'Cisco DNA Center REST API',
      'Network DevOps & CI/CD Pipelines',
      'Automation Capstone Project'
    ]
  },
  {
    id: 6, cat: 'CCNA', icon: '📝',
    thumb: 'thumb-6', thumbClass: 'thumb-6',
    title: 'CCNA Exam Bootcamp: 10-Day Intensive',
    desc: 'Rapid exam preparation with 5 full-length practice tests, proven test-taking strategies, and domain-by-domain review. Pass your CCNA on the first attempt.',
    level: 'Intermediate', duration: '30 hrs', students: '340', price: 'Free',
    rating: '4.8', reviews: '156',
    prereqs: 'Have completed CCNA training or have equivalent networking knowledge.',
    objectives: ['Master all 6 CCNA exam domains', 'Score 90%+ on practice tests', 'Develop time management strategies', 'Identify and fix knowledge gaps', 'Book and pass CCNA exam'],
    curriculum: [
      'CCNA Exam Structure & Scoring Breakdown',
      'Domain 1: Network Fundamentals (Deep Dive)',
      'Domain 2: Network Access (VLANs, EtherChannel)',
      'Domain 3: IP Connectivity (Routing & OSPF)',
      'Domain 4: IP Services (DHCP, DNS, NAT, NTP)',
      'Domain 5: Security Fundamentals (ACLs, AAA)',
      'Domain 6: Automation & Programmability',
      'Practice Test 1 + Full Review Session',
      'Practice Test 2 + Weak Area Drilling',
      'Final Exam Simulation + Booking Guide'
    ]
  }
];

/* ── APP STATE ── */
const App = {
  currentUser: null,
  enrolledCourses: [],
  selectedTier: 'free',
  currentFilter: 'all',
  currentPage: 'home',

  init() {
    this.createParticles();
    this.setupScrollEffects();
    this.setupCursorGlow();
    this.setupIntersectionObserver();
    this.setupCounters();
    this.renderFeaturedCourses();
    this.tryRestoreSession();
    window.addEventListener('popstate', () => this.handleRoute());
    setTimeout(() => this.hideLoader(), 1500);
  },

  hideLoader() {
    const loader = document.getElementById('page-loader');
    if (loader) loader.classList.add('hidden');
    setTimeout(() => { if (loader) loader.remove(); }, 600);
  },

  tryRestoreSession() {
    const saved = sessionStorage.getItem('ah_user');
    if (saved) {
      this.currentUser = JSON.parse(saved);
      this.enrolledCourses = this.currentUser.enrolled || [];
      this.updateNavForAuth(true);
    }
  },

  /* ── PARTICLES ── */
  createParticles() {
    const container = document.querySelector('.hero-particles');
    if (!container) return;
    const count = window.innerWidth < 768 ? 8 : 18;
    for (let i = 0; i < count; i++) {
      const p = document.createElement('div');
      p.className = 'particle';
      const size = Math.random() * 4 + 2;
      p.style.cssText = `
        width:${size}px; height:${size}px;
        left:${Math.random()*100}%;
        animation-duration:${Math.random()*15+10}s;
        animation-delay:${Math.random()*10}s;
        opacity:${Math.random()*0.4+0.1};
      `;
      container.appendChild(p);
    }
  },

  /* ── CURSOR GLOW ── */
  setupCursorGlow() {
    if (window.innerWidth < 1024) return;
    const glow = document.querySelector('.cursor-glow');
    if (!glow) return;
    document.addEventListener('mousemove', e => {
      glow.style.left = e.clientX + 'px';
      glow.style.top = e.clientY + 'px';
    });
  },

  /* ── SCROLL EFFECTS ── */
  setupScrollEffects() {
    const navbar = document.getElementById('navbar');
    let lastY = 0;
    window.addEventListener('scroll', () => {
      const y = window.scrollY;
      if (navbar) {
        navbar.classList.toggle('scrolled', y > 20);
      }
      lastY = y;
    }, { passive: true });
  },

  /* ── INTERSECTION OBSERVER ── */
  setupIntersectionObserver() {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.12 });
    document.querySelectorAll('.fade-up, .fade-left, .fade-right').forEach(el => observer.observe(el));
  },

  reObserve() {
    setTimeout(() => {
      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add('visible');
          }
        });
      }, { threshold: 0.1 });
      document.querySelectorAll('.fade-up:not(.visible), .fade-left:not(.visible), .fade-right:not(.visible)').forEach(el => observer.observe(el));
    }, 100);
  },

  /* ── COUNTERS ── */
  setupCounters() {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          this.animateCounter(entry.target);
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.5 });
    document.querySelectorAll('[data-count]').forEach(el => observer.observe(el));
  },

  animateCounter(el) {
    const target = parseInt(el.dataset.count);
    const suffix = el.dataset.suffix || '';
    const duration = 1800;
    const start = performance.now();
    const update = (now) => {
      const elapsed = now - start;
      const progress = Math.min(elapsed / duration, 1);
      const eased = 1 - Math.pow(1 - progress, 3);
      el.textContent = Math.round(target * eased) + suffix;
      if (progress < 1) requestAnimationFrame(update);
    };
    requestAnimationFrame(update);
  },

  /* ── RENDER COURSES ── */
  renderFeaturedCourses() {
    const grid = document.getElementById('featured-courses-grid');
    if (grid) grid.innerHTML = COURSES.slice(0, 3).map(c => this.courseCardHTML(c)).join('');
  },

  renderAllCourses(filter = 'all', query = '') {
    const grid = document.getElementById('all-courses-grid');
    if (!grid) return;
    let filtered = filter === 'all' ? COURSES : COURSES.filter(c => c.cat === filter);
    if (query) {
      const q = query.toLowerCase();
      filtered = filtered.filter(c => c.title.toLowerCase().includes(q) || c.desc.toLowerCase().includes(q) || c.cat.toLowerCase().includes(q));
    }
    const count = document.getElementById('results-count');
    if (count) count.innerHTML = `<span>${filtered.length}</span> courses found`;
    grid.innerHTML = filtered.length
      ? filtered.map(c => this.courseCardHTML(c)).join('')
      : `<div class="empty-state"><div class="empty-state-icon">🔍</div><div class="empty-state-title">No courses found</div><div class="empty-state-desc">Try a different search term or filter.</div></div>`;
  },

  courseCardHTML(c) {
    const levelClass = c.level.toLowerCase();
    const isFree = c.price === 'Free';
    return `
    <div class="course-card card-glow fade-up" onclick="App.openCourseDetail(${c.id})">
      <div class="course-thumb ${c.thumbClass}">
        <span class="course-thumb-icon">${c.icon}</span>
        <div class="course-level-badge level-${levelClass}">${c.level}</div>
      </div>
      <div class="course-body">
        <div class="course-cat">${c.cat}</div>
        <div class="course-title">${c.title}</div>
        <div class="course-desc">${c.desc}</div>
        <div class="course-meta">
          <span><i class="fas fa-clock"></i>${c.duration}</span>
          <span><i class="fas fa-users"></i>${c.students}+ students</span>
          <span><i class="fas fa-star"></i>${c.rating}</span>
        </div>
        <div class="course-footer">
          <span class="course-price ${isFree ? 'free' : ''}">${c.price}</span>
          <button class="btn btn-primary btn-sm" onclick="event.stopPropagation(); App.enrollCourse(${c.id})">
            ${this.enrolledCourses.includes(c.id) ? '<i class="fas fa-check"></i> Enrolled' : 'Enroll Now'}
          </button>
        </div>
      </div>
    </div>`;
  },

  openCourseDetail(id) {
    const c = COURSES.find(x => x.id === id);
    if (!c) return;
    const isEnrolled = this.enrolledCourses.includes(id);
    const isFree = c.price === 'Free';
    document.getElementById('course-detail-content').innerHTML = `
      <div class="cdm-header">
        <div class="cdm-thumb ${c.thumbClass}">${c.icon}</div>
        <div>
          <div class="section-tag" style="margin-bottom:0.4rem">${c.cat}</div>
          <div style="font-family:'Syne',sans-serif;font-size:1.25rem;font-weight:800;color:var(--white);line-height:1.3">${c.title}</div>
          <div class="course-rating" style="margin-top:6px">
            <span class="stars">★★★★★</span>
            <span>${c.rating} (${c.reviews} reviews)</span>
          </div>
        </div>
      </div>
      <div class="cdm-meta-row">
        <div class="cdm-meta-item"><i class="fas fa-signal"></i><strong>${c.level}</strong></div>
        <div class="cdm-meta-item"><i class="fas fa-clock"></i><strong>${c.duration}</strong></div>
        <div class="cdm-meta-item"><i class="fas fa-users"></i><strong>${c.students}+ enrolled</strong></div>
        <div class="cdm-meta-item"><i class="fas fa-tag"></i><strong style="color:var(--white)">${c.price}</strong></div>
      </div>
      <p style="color:var(--muted);font-size:0.88rem;line-height:1.75;margin-bottom:1.5rem">${c.desc}</p>
      <div class="instructor-strip">
        <div class="is-avatar">AH</div>
        <div><div class="is-label">Instructor</div><div class="is-name">Ahmed Hussein</div><div class="is-cert">Cisco Certified Professional</div></div>
      </div>
      <div style="background:var(--bg4);border-radius:var(--radius);padding:1rem;margin-bottom:1.5rem">
        <div class="curriculum-title" style="margin-bottom:0.5rem"><i class="fas fa-info-circle" style="color:var(--cisco-blue);margin-right:6px"></i>Prerequisites</div>
        <p style="font-size:0.84rem;color:var(--muted)">${c.prereqs}</p>
      </div>
      <div class="curriculum-title">Course Curriculum (${c.curriculum.length} modules)</div>
      <div class="curriculum-list">
        ${c.curriculum.map((item, i) => `
          <div class="curriculum-item">
            <div class="ci-num">${i + 1}</div>
            <span>${item}</span>
          </div>`).join('')}
      </div>
      <div class="enroll-bar">
        <div>
          <div class="enroll-price ${isFree ? 'free' : ''}">${c.price}</div>
          <div style="font-size:0.72rem;color:var(--muted);margin-top:3px">Full lifetime access</div>
        </div>
        <button class="btn ${isEnrolled ? 'btn-ghost' : 'btn-primary'} btn-lg" onclick="App.enrollCourse(${c.id}); App.closeCourseModal()">
          ${isEnrolled ? '<i class="fas fa-check"></i> Already Enrolled' : '<i class="fas fa-graduation-cap"></i> Enroll Now'}
        </button>
      </div>`;
    document.getElementById('course-modal').classList.add('open');
    document.body.style.overflow = 'hidden';
  },

  closeCourseModal() {
    document.getElementById('course-modal').classList.remove('open');
    document.body.style.overflow = '';
  },

  enrollCourse(id) {
    if (!this.currentUser) {
      this.openModal('login');
      Toast.show('Please sign in to enroll in a course', 'info');
      return;
    }
    if (this.enrolledCourses.includes(id)) {
      Toast.show('You are already enrolled in this course', 'info');
      return;
    }
    this.enrolledCourses.push(id);
    this.currentUser.enrolled = this.enrolledCourses;
    this.saveSession();
    this.updateDashboard();
    Toast.show('Successfully enrolled! Check your dashboard.', 'success');
    this.refreshCourseGrids();
  },

  refreshCourseGrids() {
    const fg = document.getElementById('featured-courses-grid');
    if (fg) fg.innerHTML = COURSES.slice(0, 3).map(c => this.courseCardHTML(c)).join('');
    this.renderAllCourses(this.currentFilter, document.getElementById('course-search-input')?.value || '');
  },

  /* ── PAGE ROUTING ── */
  showPage(page) {
    document.querySelectorAll('.page-section').forEach(s => s.style.display = 'none');
    const target = document.getElementById('page-' + page);
    if (target) {
      target.style.display = 'block';
      window.scrollTo({ top: 0, behavior: 'smooth' });
    }
    // Update active nav link
    document.querySelectorAll('.nav-link').forEach(l => {
      l.classList.toggle('active', l.dataset.page === page);
    });
    // Post-show actions
    if (page === 'courses') this.renderAllCourses(this.currentFilter);
    if (page === 'about') this.animateSkillBars();
    if (page === 'dashboard') { if (!this.currentUser) { this.showPage('home'); this.openModal('login'); return; } this.updateDashboard(); }
    this.reObserve();
    this.currentPage = page;
  },

  /* ── COURSE FILTERS ── */
  filterCourses(cat, btn) {
    document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
    if (btn) btn.classList.add('active');
    this.currentFilter = cat;
    this.renderAllCourses(cat, document.getElementById('course-search-input')?.value || '');
  },

  searchCourses() {
    const q = document.getElementById('course-search-input')?.value || '';
    this.renderAllCourses(this.currentFilter, q);
  },

  /* ── AUTH ── */
  openModal(tab = 'login') {
    const overlay = document.getElementById('auth-modal');
    overlay.classList.add('open');
    document.body.style.overflow = 'hidden';
    this.switchAuthTab(tab);
    ['login-error', 'reg-error'].forEach(id => {
      const el = document.getElementById(id);
      if (el) el.classList.remove('show');
    });
    ['login-success', 'reg-success'].forEach(id => {
      const el = document.getElementById(id);
      if (el) el.classList.remove('show');
    });
  },

  closeModal() {
    document.getElementById('auth-modal').classList.remove('open');
    document.body.style.overflow = '';
  },

  switchAuthTab(tab) {
    document.querySelectorAll('.modal-tab').forEach(t => t.classList.toggle('active', t.dataset.tab === tab));
    document.querySelectorAll('.auth-panel').forEach(p => p.classList.toggle('active', p.dataset.panel === tab));
  },

  selectTier(tier) {
    this.selectedTier = tier;
    document.querySelectorAll('.tier-opt').forEach(o => o.classList.toggle('selected', o.dataset.tier === tier));
  },

  doLogin() {
    const email = document.getElementById('l-email').value.trim();
    const pass = document.getElementById('l-pass').value;
    const errEl = document.getElementById('login-error');
    if (!email || !pass) { errEl.textContent = 'Please fill all fields.'; errEl.classList.add('show'); return; }
    const users = JSON.parse(localStorage.getItem('ah_users') || '[]');
    const user = users.find(u => u.email === email && u.pass === btoa(pass));
    if (!user) { errEl.textContent = 'Invalid email or password.'; errEl.classList.add('show'); return; }
    errEl.classList.remove('show');
    const successEl = document.getElementById('login-success');
    successEl.classList.add('show');
    this.currentUser = user;
    this.enrolledCourses = user.enrolled || [];
    this.saveSession();
    setTimeout(() => {
      this.closeModal();
      this.updateNavForAuth(true);
      this.updateDashboard();
      Toast.show(`Welcome back, ${user.fname}!`, 'success');
      successEl.classList.remove('show');
    }, 900);
  },

  doRegister() {
    const fname = document.getElementById('r-fname').value.trim();
    const lname = document.getElementById('r-lname').value.trim();
    const email = document.getElementById('r-email').value.trim();
    const phone = document.getElementById('r-phone').value.trim();
    const pass = document.getElementById('r-pass').value;
    const errEl = document.getElementById('reg-error');
    if (!fname || !email || !pass) { errEl.textContent = 'First name, email, and password are required.'; errEl.classList.add('show'); return; }
    if (!email.includes('@')) { errEl.textContent = 'Please enter a valid email address.'; errEl.classList.add('show'); return; }
    if (pass.length < 8) { errEl.textContent = 'Password must be at least 8 characters.'; errEl.classList.add('show'); return; }
    const users = JSON.parse(localStorage.getItem('ah_users') || '[]');
    if (users.find(u => u.email === email)) { errEl.textContent = 'This email is already registered.'; errEl.classList.add('show'); return; }
    errEl.classList.remove('show');
    const newUser = { fname, lname, email, phone, pass: btoa(pass), tier: this.selectedTier, enrolled: [], joinDate: new Date().toLocaleDateString() };
    users.push(newUser);
    localStorage.setItem('ah_users', JSON.stringify(users));
    const successEl = document.getElementById('reg-success');
    successEl.classList.add('show');
    setTimeout(() => { successEl.classList.remove('show'); this.switchAuthTab('login'); }, 1600);
  },

  logout() {
    this.currentUser = null;
    this.enrolledCourses = [];
    sessionStorage.removeItem('ah_user');
    this.updateNavForAuth(false);
    this.showPage('home');
    Toast.show('Logged out successfully.', 'info');
  },

  saveSession() {
    const u = { ...this.currentUser, enrolled: this.enrolledCourses };
    sessionStorage.setItem('ah_user', JSON.stringify(u));
    // Persist to localStorage
    const users = JSON.parse(localStorage.getItem('ah_users') || '[]');
    const idx = users.findIndex(x => x.email === this.currentUser.email);
    if (idx > -1) { users[idx] = u; localStorage.setItem('ah_users', JSON.stringify(users)); }
  },

  updateNavForAuth(loggedIn) {
    document.getElementById('nav-signin').style.display = loggedIn ? 'none' : '';
    document.getElementById('nav-register').style.display = loggedIn ? 'none' : '';
    document.getElementById('nav-dashboard-link').style.display = loggedIn ? '' : 'none';
    document.getElementById('nav-logout-btn').style.display = loggedIn ? '' : 'none';
  },

  /* ── DASHBOARD ── */
  showDashPanel(panel) {
    document.querySelectorAll('.dash-panel').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.dash-nav-item').forEach(i => i.classList.remove('active'));
    document.getElementById('dash-' + panel)?.classList.add('active');
    document.querySelector(`.dash-nav-item[data-panel="${panel}"]`)?.classList.add('active');
  },

  updateDashboard() {
    if (!this.currentUser) return;
    document.getElementById('dash-username').textContent = this.currentUser.fname || 'Student';
    document.getElementById('dash-plan-name').textContent = this.currentUser.tier === 'premium' ? 'Premium ⭐' : 'Free Plan';
    document.getElementById('dash-enrolled-count').textContent = this.enrolledCourses.length;

    const enrolled = COURSES.filter(c => this.enrolledCourses.includes(c.id));
    const listEl = document.getElementById('dash-enrolled-list');
    const myCoursesEl = document.getElementById('dash-my-courses-list');
    const html = enrolled.length
      ? enrolled.map(c => `
        <div class="enrolled-item">
          <div class="ei-thumb ${c.thumbClass}">${c.icon}</div>
          <div style="flex:1">
            <div class="ei-name">${c.title}</div>
            <div class="ei-prog-label">Progress · 0% complete</div>
          </div>
          <div class="ei-prog-wrap" style="max-width:160px">
            <div class="ei-prog-bar"><div class="ei-prog-fill" style="width:0%"></div></div>
            <div class="ei-pct">0%</div>
          </div>
        </div>`).join('')
      : `<div class="empty-state"><div class="empty-state-icon">📚</div><div class="empty-state-title">No courses yet</div><div class="empty-state-desc">Browse and enroll in a course to get started.</div><button class="btn btn-primary" onclick="App.showPage('courses')"><i class="fas fa-search"></i> Browse Courses</button></div>`;

    if (listEl) listEl.innerHTML = html;
    if (myCoursesEl) myCoursesEl.innerHTML = html;

    // Profile form
    const pf = s => document.getElementById('profile-' + s);
    if (pf('fname')) pf('fname').value = this.currentUser.fname || '';
    if (pf('lname')) pf('lname').value = this.currentUser.lname || '';
    if (pf('email')) pf('email').value = this.currentUser.email || '';
    if (pf('phone')) pf('phone').value = this.currentUser.phone || '';
  },

  saveProfile() {
    if (!this.currentUser) return;
    this.currentUser.fname = document.getElementById('profile-fname')?.value || this.currentUser.fname;
    this.currentUser.lname = document.getElementById('profile-lname')?.value || this.currentUser.lname;
    this.currentUser.phone = document.getElementById('profile-phone')?.value || this.currentUser.phone;
    this.saveSession();
    document.getElementById('dash-username').textContent = this.currentUser.fname;
    Toast.show('Profile updated successfully!', 'success');
  },

  /* ── CONTACT ── */
  sendContact() {
    const email = document.getElementById('contact-email')?.value;
    if (!email) { Toast.show('Please enter your email address.', 'error'); return; }
    const successEl = document.getElementById('contact-success');
    if (successEl) { successEl.classList.add('show'); setTimeout(() => successEl.classList.remove('show'), 4000); }
    Toast.show('Message sent! I\'ll respond within 24 hours.', 'success');
    ['contact-fname','contact-lname','contact-email','contact-msg'].forEach(id => {
      const el = document.getElementById(id);
      if (el) el.value = '';
    });
  },

  /* ── NEWSLETTER ── */
  subscribe() {
    const input = document.getElementById('newsletter-email');
    if (!input || !input.value.includes('@')) { Toast.show('Please enter a valid email.', 'error'); return; }
    Toast.show('Subscribed! Check your inbox for resources.', 'success');
    input.value = '';
  },

  /* ── SKILL BARS ── */
  animateSkillBars() {
    setTimeout(() => {
      document.querySelectorAll('.skill-bar-fill').forEach(bar => {
        bar.style.width = bar.dataset.width || '0%';
      });
    }, 200);
  },
};

/* ── TOAST SYSTEM ── */
const Toast = {
  show(message, type = 'info') {
    const container = document.getElementById('toast-container');
    const icons = { success: 'fa-check-circle', error: 'fa-exclamation-circle', info: 'fa-info-circle' };
    const toast = document.createElement('div');
    toast.className = `toast ${type}`;
    toast.innerHTML = `
      <i class="fas ${icons[type] || icons.info} toast-icon"></i>
      <span class="toast-message">${message}</span>
      <button class="toast-close" onclick="this.parentElement.remove()">
        <i class="fas fa-times"></i>
      </button>`;
    container.appendChild(toast);
    setTimeout(() => {
      toast.classList.add('removing');
      setTimeout(() => toast.remove(), 300);
    }, 4000);
  }
};

/* ── DOM READY ── */
document.addEventListener('DOMContentLoaded', () => {
  App.init();

  // Modal close on overlay click
  document.getElementById('auth-modal')?.addEventListener('click', e => {
    if (e.target === e.currentTarget) App.closeModal();
  });
  document.getElementById('course-modal')?.addEventListener('click', e => {
    if (e.target === e.currentTarget) App.closeCourseModal();
  });

  // Hamburger
  document.getElementById('hamburger-btn')?.addEventListener('click', () => {
    const menu = document.getElementById('mobile-menu');
    const btn = document.getElementById('hamburger-btn');
    menu.classList.toggle('open');
    btn.classList.toggle('open');
  });

  // ESC key
  document.addEventListener('keydown', e => {
    if (e.key === 'Escape') { App.closeModal(); App.closeCourseModal(); }
  });

  // Smooth nav link scroll
  document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', e => {
      const id = a.getAttribute('href').slice(1);
      const el = document.getElementById(id);
      if (el) { e.preventDefault(); el.scrollIntoView({ behavior: 'smooth' }); }
    });
  });
});
