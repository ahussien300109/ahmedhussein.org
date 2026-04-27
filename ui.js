/* ─────────────────────────────────────────────
   ui.js — Section renderers & shared components
   Each exported function injects HTML into the
   #root container or returns an HTML string.
   ───────────────────────────────────────────── */

/* ── ROOT REFERENCE ── */
const root = () => document.getElementById('root');

/* ══════════════════════════════════════════════
   SHARED COMPONENTS
   ══════════════════════════════════════════════ */

/** Inner-page header (Courses, About, Contact…) */
const PageHeader = ({ eyebrow, title, subtitle, breadcrumb }) => /* html */`
  <div class="pg-header">
    <div class="pg-header-bg"></div><div class="pg-header-glow"></div>
    <div class="pg-header-inner">
      ${breadcrumb ? `<div class="breadcrumb"><a href="#" onclick="Router.go('home');return false">Home</a><i class="fas fa-chevron-right"></i>${breadcrumb}</div>` : ''}
      ${eyebrow ? `<div class="sec-eyebrow"><i class="${eyebrow.icon}"></i> ${eyebrow.text}</div>` : ''}
      <div class="pg-title">${title}</div>
      ${subtitle ? `<div class="pg-subtitle">${subtitle}</div>` : ''}
    </div>
  </div>`;

/* ══════════════════════════════════════════════
   HOME SECTION
   ══════════════════════════════════════════════ */
const renderHome = () => {
  root().innerHTML = /* html */`

  <section class="hero">
    <div class="hero-glow"></div><div class="hero-mesh"></div><div class="hero-scanline"></div>
    <div class="hero-inner">
      <div class="hero-left">
        <div class="urgency-pill reveal"><span class="up-dot"></span>Next cohort — Only <strong id="seats-count">4</strong> seats left</div>
        <div class="hero-eyebrow reveal"><span class="eyebrow-line"></span><span class="eyebrow-text">Cisco Certified Instructor · Bahrain</span></div>
        <h1 class="hero-h1 reveal d1"><div>MASTER THE</div><div class="line2">NETWORK.</div><div class="line3">OWN YOUR CAREER.</div></h1>
        <p class="hero-sub reveal d2">Expert-led <strong>CCNA, CCNP, and Network Security</strong> courses built for real-world engineering. Hands-on labs, live mentorship, and a proven 96% exam pass rate.</p>
        <div class="hero-btns reveal d3">
          <button class="hbtn hbtn-primary" onclick="Router.go('courses')"><i class="fas fa-satellite-dish"></i> Explore Courses</button>
          <button class="hbtn hbtn-outline" onclick="openModal('register')"><i class="fas fa-user-astronaut"></i> Register Free</button>
        </div>
        <div class="hero-trust reveal d4">
          <span class="trust-item"><i class="fas fa-check-circle"></i> Packet Tracer Labs</span>
          <span class="trust-item"><i class="fas fa-check-circle"></i> Cisco NetAcad Aligned</span>
          <span class="trust-item"><i class="fas fa-check-circle"></i> Certificate on Completion</span>
        </div>
        <div class="hero-stats-bar reveal d5">
          <div class="hstat"><div class="hstat-num" data-count="1200" data-sfx="+">0+</div><div class="hstat-label">Students Trained</div></div>
          <div class="hstat"><div class="hstat-num" data-count="96" data-sfx="%">0%</div><div class="hstat-label">Pass Rate</div></div>
          <div class="hstat"><div class="hstat-num" data-count="10" data-sfx="+">0+</div><div class="hstat-label">Years Experience</div></div>
        </div>
      </div>
      <div class="hero-right reveal d2">
        <div class="floating-badge fb1"><div class="fb-icon fbi-c"><i class="fas fa-trophy"></i></div><div><div class="fb-title">96% Pass Rate</div><div class="fb-sub">First attempt</div></div></div>
        <div class="floating-badge fb2"><div class="fb-icon fbi-o"><i class="fas fa-star"></i></div><div><div class="fb-title">4.9 Rating</div><div class="fb-sub">500+ reviews</div></div></div>
        <div class="hero-device">
          <div class="device-header"><div class="dh-title">CERT TRACKS</div><div class="dh-dots"><div class="dot dot1"></div><div class="dot dot2"></div><div class="dot dot3"></div></div></div>
          <div class="device-body">
            <div class="cert-tiles">
              <div class="cert-tile" onclick="Router.go('courses')"><div class="ct-icon">🌐</div><div class="ct-name">CCNA</div><div class="ct-code">EXAM 200-301</div></div>
              <div class="cert-tile" onclick="Router.go('courses')"><div class="ct-icon">🔷</div><div class="ct-name">CCNP</div><div class="ct-code">ENCOR 350-401</div></div>
              <div class="cert-tile" onclick="Router.go('courses')"><div class="ct-icon">🔐</div><div class="ct-name">SECURITY</div><div class="ct-code">SCOR 350-701</div></div>
              <div class="cert-tile" onclick="Router.go('courses')"><div class="ct-icon">⚙️</div><div class="ct-name">AUTOMATION</div><div class="ct-code">SD-WAN + PYTHON</div></div>
            </div>
            <div class="device-instructor">
              <div class="di-avatar">AH</div>
              <div><div class="di-name">AHMED HUSSEIN</div><div class="di-role">Cisco Certified Professional</div></div>
              <div class="di-live"><div class="live-dot"></div> LIVE</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="hero-scroll-hint" onclick="document.querySelector('.feat-row')?.scrollIntoView({behavior:'smooth'})">
      <div class="scroll-mouse"><div class="scroll-wheel"></div></div>
      <span class="scroll-hint-lbl">Scroll</span>
    </div>
  </section>

  <div class="feat-row"><div class="feat-row-inner">
    <div class="feat-item reveal"><div class="feat-icon-wrap"><i class="fas fa-laptop-code"></i></div><div><div class="feat-title">50+ Hands-On Labs</div><div class="feat-desc">Real Cisco Packet Tracer exercises covering every exam domain</div></div></div>
    <div class="feat-item reveal d2"><div class="feat-icon-wrap"><i class="fas fa-certificate"></i></div><div><div class="feat-title">Official Cisco Curriculum</div><div class="feat-desc">NetAcad-aligned content matching current exam blueprints</div></div></div>
    <div class="feat-item reveal d3"><div class="feat-icon-wrap"><i class="fas fa-headset"></i></div><div><div class="feat-title">Live Mentorship</div><div class="feat-desc">Direct Q&amp;A access with the instructor throughout your course</div></div></div>
    <div class="feat-item reveal d4"><div class="feat-icon-wrap"><i class="fas fa-medal"></i></div><div><div class="feat-title">96% Pass Rate</div><div class="feat-desc">Proven track record across CCNA, CCNP, and Security exams</div></div></div>
  </div></div>

  <section class="sec-path"><div class="sec-wrap">
    <div class="sec-hdr reveal" style="text-align:center;max-width:600px;margin:0 auto 3rem">
      <div class="sec-eyebrow" style="justify-content:center"><i class="fas fa-road"></i> Your Certification Journey</div>
      <h2 class="sec-h2">From Zero to <span class="accent">Cisco Professional</span></h2>
    </div>
    <div class="path-track">
      <div class="path-step ps1 reveal" style="--ps-c:var(--g)"><div class="ps-num">STEP 01</div><div class="ps-ico">🎯</div><div class="ps-title">Start Free</div><div class="ps-sub">CCNA Bootcamp &amp; Exam Labs</div><div class="ps-tag pst-g">Free · Start Now</div></div>
      <div class="path-arr reveal">›</div>
      <div class="path-step ps2 reveal d1" style="--ps-c:var(--c)"><div class="ps-num">STEP 02</div><div class="ps-ico">🌐</div><div class="ps-title">CCNA 200-301</div><div class="ps-sub">Full Exam Preparation</div><div class="ps-tag pst-c">80 hrs · $149</div></div>
      <div class="path-arr reveal d1">›</div>
      <div class="path-step ps3 reveal d2" style="--ps-c:var(--o)"><div class="ps-num">STEP 03</div><div class="ps-ico">🔷</div><div class="ps-title">CCNP / Security</div><div class="ps-sub">Enterprise &amp; Security Track</div><div class="ps-tag pst-o">Advanced · $199+</div></div>
      <div class="path-arr reveal d2">›</div>
      <div class="path-step ps4 reveal d3" style="--ps-c:var(--c2)"><div class="ps-num">RESULT</div><div class="ps-ico">💼</div><div class="ps-title">Network Engineer</div><div class="ps-sub">Career Ready · GCC Market</div><div class="ps-tag pst-b">$60k–$120k avg</div></div>
    </div>
  </div></section>

  <section class="sec-courses"><div class="sec-wrap">
    <div class="sec-hdr-row">
      <div class="reveal"><div class="sec-eyebrow"><i class="fas fa-signal"></i> Featured Courses</div><h2 class="sec-h2">Start Your <span class="accent">Certification</span> Path</h2></div>
      <button class="pill-btn reveal" onclick="Router.go('courses')">All Courses <i class="fas fa-arrow-right"></i></button>
    </div>
    <div class="courses-grid" id="home-courses-grid"></div>
  </div></section>

  <section class="sec-stats"><div class="sec-wrap"><div class="stats-grid">
    <div class="stat-card reveal"><div class="stat-ico"><i class="fas fa-users"></i></div><div class="stat-num" data-count="1200" data-sfx="+">0+</div><div class="stat-lbl">Students Trained</div></div>
    <div class="stat-card reveal d2"><div class="stat-ico"><i class="fas fa-award"></i></div><div class="stat-num" data-count="96" data-sfx="%">0%</div><div class="stat-lbl">Exam Pass Rate</div></div>
    <div class="stat-card reveal d3"><div class="stat-ico"><i class="fas fa-book-open"></i></div><div class="stat-num" data-count="6" data-sfx="">0</div><div class="stat-lbl">Active Courses</div></div>
    <div class="stat-card reveal d4"><div class="stat-ico"><i class="fas fa-clock"></i></div><div class="stat-num" data-count="10" data-sfx="+">0+</div><div class="stat-lbl">Years Experience</div></div>
  </div></div></section>

  <section class="sec-demo"><div class="demo-inner">
    <div class="reveal">
      <div class="sec-eyebrow"><i class="fas fa-terminal"></i> Try Before You Enroll</div>
      <h2 class="sec-h2" style="margin-bottom:1rem">Run a Real Lab <span class="accent">Right Now</span></h2>
      <p style="color:var(--tm);font-size:.92rem;line-height:1.8;margin-bottom:1.5rem">Configure 802.1Q trunking and LACP on actual Cisco topology. Free Packet Tracer file included.</p>
      <div class="demo-checks">
        <div class="demo-check"><i class="fas fa-check-circle"></i>Real Cisco IOS commands</div>
        <div class="demo-check"><i class="fas fa-check-circle"></i>Step-by-step task guide</div>
        <div class="demo-check"><i class="fas fa-check-circle"></i>Free Packet Tracer software</div>
      </div>
      <div style="display:flex;gap:1rem;flex-wrap:wrap;margin-top:1.5rem">
        <button class="hbtn hbtn-primary" onclick="enrollCourse(7)"><i class="fas fa-flask"></i> Start Free Lab</button>
        <button class="hbtn hbtn-outline" onclick="openCourseDetail(7)"><i class="fas fa-eye"></i> Preview Labs</button>
      </div>
    </div>
    <div class="demo-cli-wrap reveal d2">
      <div class="demo-cli-bar">
        <span class="dcb-dot" style="background:#ff5f57"></span><span class="dcb-dot" style="background:#febc2e"></span><span class="dcb-dot" style="background:#28c840"></span>
        <span style="font-family:'Orbitron',monospace;font-size:.58rem;color:var(--tm);margin-left:auto">CISCO IOS · LAB 01</span>
      </div>
      <div class="demo-cli-body" id="cli-demo"></div>
    </div>
  </div></section>

  <section class="sec-testi"><div class="sec-wrap">
    <div class="sec-hdr reveal"><div class="sec-eyebrow"><i class="fas fa-comments"></i> Student Success</div><h2 class="sec-h2">What Our <span class="accent">Students</span> Say</h2></div>
    <div class="testi-grid">
      <div class="tcard reveal"><div class="tcard-accent ta1"></div><div class="t-stars">★★★★★</div><p class="t-text">"Ahmed's CCNA course got me 920/1000 on my first attempt!"</p><div class="t-author"><div class="t-av" style="background:linear-gradient(135deg,var(--c),var(--c3))">KA</div><div><div class="t-name">Khalid Al-Rashidi</div><div class="t-cert">CCNA Certified · Saudi Arabia</div></div></div></div>
      <div class="tcard reveal d2"><div class="tcard-accent ta2"></div><div class="t-stars">★★★★★</div><p class="t-text">"From junior to senior network engineer in 6 months. Unbelievable ROI."</p><div class="t-author"><div class="t-av" style="background:linear-gradient(135deg,var(--o),#b03a10)">SM</div><div><div class="t-name">Sara Mohammed</div><div class="t-cert">CCNP Enterprise · Bahrain</div></div></div></div>
      <div class="tcard reveal d3"><div class="tcard-accent ta3"></div><div class="t-stars">★★★★★</div><p class="t-text">"Landed a security engineer role immediately after certification."</p><div class="t-author"><div class="t-av" style="background:linear-gradient(135deg,var(--g),#047a35)">FH</div><div><div class="t-name">Faris Hassan</div><div class="t-cert">CyberOps + SCOR · UAE</div></div></div></div>
    </div>
  </div></section>

  <section class="sec-faq"><div class="sec-wrap">
    <div class="sec-hdr reveal" style="text-align:center;max-width:600px;margin:0 auto 3rem">
      <div class="sec-eyebrow" style="justify-content:center"><i class="fas fa-question-circle"></i> Common Questions</div>
      <h2 class="sec-h2">Frequently <span class="accent">Asked</span></h2>
    </div>
    <div class="faq-list">
      ${[['What do I need to start?','No prior networking knowledge required. A computer, internet, and free Cisco Packet Tracer software.'],
         ['How long to pass CCNA?','Most students complete and pass within 3–6 months with consistent study.'],
         ['Is content aligned with Cisco exams?','Yes. All courses follow Cisco NetAcad blueprints updated to current exam objectives.'],
         ['Is there live support?','Yes. Direct access to Ahmed Hussein for Q&A throughout your course.'],
         ['Do I get a certificate?','Premium members receive a signed completion certificate for every finished course.']
      ].map(([q,a]) => `<div class="faq-item"><div class="faq-q" onclick="toggleFAQ(this)"><span>${q}</span><div class="faq-icon"><i class="fas fa-plus"></i></div></div><div class="faq-body"><div class="faq-body-inner">${a}</div></div></div>`).join('')}
    </div>
  </div></section>

  <section class="sec-about-prev"><div class="sec-wrap"><div class="about-grid">
    <div class="about-img-side reveal">
      <div class="about-frame"><span style="font-size:7rem">👨‍💻</span>
        <div class="about-overlay">
          <div style="font-family:'Orbitron',monospace;font-size:.95rem;font-weight:900;color:var(--tw)">Ahmed Hussein</div>
          <div style="font-size:.72rem;color:var(--c);margin-top:2px">Cisco Certified Professional</div>
          <div class="cert-pills"><span class="cert-pill">CCNP</span><span class="cert-pill">CCNA</span><span class="cert-pill">CyberOps</span></div>
        </div>
      </div>
      <div class="about-float"><div class="af-num">4.9★</div><div class="af-lbl">Average Rating</div></div>
    </div>
    <div class="reveal d2">
      <div class="sec-eyebrow"><i class="fas fa-id-badge"></i> Instructor Profile</div>
      <h2 class="sec-h2" style="margin-bottom:1rem">A Decade of <span class="accent">Cisco</span> Mastery</h2>
      <p style="color:var(--tm);line-height:1.8;margin-bottom:2rem;font-size:.92rem">With 10+ years of enterprise networking experience, I've guided 1,200+ students across the Middle East through their certification journeys.</p>
      <button class="btn btn-c" onclick="Router.go('about')"><i class="fas fa-user-circle"></i> View Full Profile</button>
    </div>
  </div></div></section>

  <section class="sec-final-cta"><div class="cta-top-line"></div><div class="fct-inner">
    <div class="reveal">
      <div class="fct-proof">★★★★★ &nbsp;4.9/5 from 500+ students</div>
      <h2 class="fct-h">Join 1,200+ Engineers Who Passed<br>Their CCNA on the <span>First Attempt</span></h2>
      <p class="fct-p">No experience needed. Start the free bootcamp today.</p>
    </div>
    <div class="reveal d2"><div class="fct-actions">
      <button class="hbtn hbtn-primary" onclick="openModal('register')" style="width:100%;justify-content:center"><i class="fas fa-rocket"></i> Start Free — No Card Needed</button>
      <button class="hbtn hbtn-outline" onclick="Router.go('courses')" style="width:100%;justify-content:center"><i class="fas fa-compass"></i> View All Courses</button>
      <div class="fct-micro"><i class="fas fa-lock"></i>Free forever · <i class="fas fa-certificate"></i>Certificate on completion</div>
    </div></div>
  </div></section>`;

  renderCourses('home-courses-grid', COURSES.slice(0, 3));
  reObserve(); initCounters(); initUrgency(); initCliDemo();
};

/* ══════════════════════════════════════════════
   COURSES SECTION
   ══════════════════════════════════════════════ */
const renderCoursesPage = () => {
  root().innerHTML = /* html */`
    ${PageHeader({ breadcrumb:'Courses', title:'CISCO COURSES', subtitle:'From CCNA fundamentals to advanced CCNP and Security. Expert-led, lab-first, exam-focused.' })}
    <div class="filter-toolbar">
      <div class="filter-toolbar-inner">
        <button class="f-btn on" onclick="filterCourses('all',this)">All</button>
        <button class="f-btn" onclick="filterCourses('CCNA',this)">CCNA</button>
        <button class="f-btn" onclick="filterCourses('CCNP',this)">CCNP</button>
        <button class="f-btn" onclick="filterCourses('Security',this)">Security</button>
        <div class="f-sep"></div>
        <div class="f-search"><i class="fas fa-search"></i><input id="course-search" type="text" placeholder="Search courses..." oninput="searchCourses()"></div>
        <div class="f-count" id="results-info"><span>${COURSES.length}</span> courses</div>
      </div>
    </div>
    <section style="padding:3rem 2.5rem;background:var(--bg1)">
      <div style="max-width:1300px;margin:0 auto"><div class="courses-grid" id="all-courses-grid"></div></div>
    </section>`;
  renderCourses('all-courses-grid', COURSES);
  reObserve();
};

/* ══════════════════════════════════════════════
   ABOUT SECTION
   ══════════════════════════════════════════════ */
const renderAbout = () => {
  const skills = [['Routing &amp; Switching (CCNP)','97%'],['Network Security &amp; Firewalls','90%'],['Cyber Security','88%'],['Wireless Networking','87%'],['SD-WAN &amp; Cloud Networking','85%'],['Azure Cloud','83%'],['Network Automation (Python)','82%'],['Cloud Systems','80%'],['VoIP','78%'],['Linux OS','75%']];
  root().innerHTML = /* html */`
    ${PageHeader({ breadcrumb:'About', title:'AHMED HUSSEIN', subtitle:'Cisco Certified Professional with 10+ years of enterprise networking experience.' })}
    <div class="about-full"><div class="about-full-grid">
      <div class="about-sidebar">
        <div class="about-photo-card">
          <div class="apc-img"><span style="font-size:7rem">👨‍💻</span></div>
          <div class="apc-plate"><div class="apc-name">AHMED HUSSEIN</div><div class="apc-role">Cisco Certified Instructor</div></div>
        </div>
        <div class="cert-list-card" style="overflow-y:auto;max-height:420px">
          <div class="clc-title">Certifications</div>
          ${[['Cisco','var(--c)',['🔷 CCNP Enterprise|350-401 ENCOR','🔐 CCNP Security Core|350-701 SCOR','🌐 CCNA Enterprise|200-301','🛡️ CCNA Cyber Security|CyberOps Associate','💡 CCST IT|Cisco Certified Support Tech','🔒 CCST CyberSecurity|Cisco Certified Support Tech']],
             ['Huawei','var(--o)',['⚡ HCIA Routing &amp; Switching|Huawei ICT Associate','⚡ HCIP Routing &amp; Switching|Huawei ICT Professional','📡 HCIA Wireless|Huawei ICT Associate','🔐 HCIA Security|Huawei ICT Associate']],
             ['Microsoft &amp; Other','var(--c2)',['🎓 MCT Trainer|Microsoft Certified Trainer','💻 MCITP|IT Professional','🛡️ Fortinet NSE|Network Security Expert','☁️ VMware Associate|Virtualization']]
          ].map(([vendor, color, certs]) => `
            <div style="font-size:.55rem;font-weight:700;color:${color};text-transform:uppercase;letter-spacing:2px;padding:.5rem 0 .3rem;border-bottom:1px solid var(--bdr);margin:.4rem 0 .2rem">${vendor}</div>
            ${certs.map(c => { const [name,code]=c.split('|'); return `<div class="clc-item"><div class="clc-ico">${name.slice(0,2)}</div><div><div class="clc-name">${name.slice(2).trim()}</div><div class="clc-code">${code}</div></div><div class="clc-badge">Active</div></div>`; }).join('')}
          `).join('')}
        </div>
        <div style="display:flex;gap:.5rem;flex-wrap:wrap">
          <a href="#" class="soc-btn"><i class="fab fa-linkedin-in"></i></a>
          <a href="#" class="soc-btn"><i class="fab fa-youtube"></i></a>
          <a href="#" class="soc-btn"><i class="fab fa-twitter"></i></a>
          <a href="#" class="soc-btn"><i class="fab fa-telegram"></i></a>
        </div>
      </div>
      <div class="about-main">
        <div class="abt-section"><div class="abt-sec-title">Professional Bio</div>
          <p class="bio-text">With over a decade of hands-on enterprise networking experience, I've dedicated my career to empowering IT professionals across the Middle East and beyond to achieve their certification goals.</p>
          <p class="bio-text">Every course combines comprehensive curriculum with practical labs that mirror actual enterprise network environments.</p>
        </div>
        <div class="achieve-cards">
          <div class="ach-card"><div class="ach-num" data-count="1200" data-sfx="+">0+</div><div class="ach-lbl">Students Trained</div></div>
          <div class="ach-card"><div class="ach-num" data-count="96" data-sfx="%">0%</div><div class="ach-lbl">Pass Rate</div></div>
          <div class="ach-card"><div class="ach-num" data-count="10" data-sfx="+">0+</div><div class="ach-lbl">Years Exp.</div></div>
        </div>
        <div class="abt-section"><div class="abt-sec-title">Technical Expertise</div>
          <div class="skill-rows">
            ${skills.map(([n,p]) => `<div class="skill-row"><div class="sr-head"><span class="sr-name">${n}</span><span class="sr-pct">${p}</span></div><div class="sr-bg"><div class="sr-fill" data-w="${p}"></div></div></div>`).join('')}
          </div>
        </div>
        <div class="abt-section"><div class="abt-sec-title">Career Timeline</div>
          <div class="timeline">
            <div class="tl-item"><div class="tl-yr">2024 – Present</div><div class="tl-title">Senior Cisco Instructor &amp; Course Developer</div><div class="tl-desc">Delivering CCNA, CCNP, and Security courses online and on-site across the GCC</div></div>
            <div class="tl-item"><div class="tl-yr">2020 – 2024</div><div class="tl-title">Network Engineering Consultant</div><div class="tl-desc">Designed enterprise Cisco networks for banking and telecoms clients</div></div>
            <div class="tl-item"><div class="tl-yr">2016 – 2020</div><div class="tl-title">Cisco NetAcad Instructor</div><div class="tl-desc">Delivered official Cisco curriculum at a regional NetAcad</div></div>
            <div class="tl-item"><div class="tl-yr">2013 – 2016</div><div class="tl-title">Network Administrator</div><div class="tl-desc">Managed multi-site Cisco campus networks and data center infrastructure</div></div>
          </div>
        </div>
      </div>
    </div></div>`;
  initCounters(); setTimeout(initSkillBars, 50); reObserve();
};

/* ══════════════════════════════════════════════
   CONTACT SECTION
   ══════════════════════════════════════════════ */
const renderContact = () => {
  root().innerHTML = /* html */`
    ${PageHeader({ breadcrumb:'Contact', title:'GET IN TOUCH', subtitle:"Questions about courses? I respond within 24 hours." })}
    <div class="contact-layout">
      <div class="contact-left">
        <div class="ci-card"><div class="ci-row"><div class="ci-ico"><i class="fas fa-envelope"></i></div><div><div class="ci-lbl">Email</div><div class="ci-val">info@ahmedhussein.org</div></div></div></div>
        <div class="ci-card"><div class="ci-row"><div class="ci-ico"><i class="fab fa-whatsapp"></i></div><div><div class="ci-lbl">WhatsApp / Phone</div><div class="ci-val">+973 3219 8505</div></div></div></div>
        <div class="ci-card"><div class="ci-row"><div class="ci-ico"><i class="fas fa-map-marker-alt"></i></div><div><div class="ci-lbl">Location</div><div class="ci-val">Manama, Kingdom of Bahrain</div></div></div></div>
        <div class="oh-card">
          <div class="oh-title"><i class="fas fa-clock" style="color:var(--c);margin-right:6px"></i>Office Hours</div>
          <div class="oh-row"><span>Saturday – Thursday</span><span>9:00 AM – 9:00 PM</span></div>
          <div class="oh-row"><span>Friday</span><span style="color:var(--tm)">Closed</span></div>
          <div class="oh-row"><span>Time Zone</span><span>AST (UTC +3)</span></div>
        </div>
        <div class="ci-card">
          <div class="ci-lbl" style="margin-bottom:.6rem">Follow &amp; Connect</div>
          <div class="social-links">
            <a href="#" class="soc-btn"><i class="fab fa-linkedin-in"></i></a>
            <a href="#" class="soc-btn"><i class="fab fa-youtube"></i></a>
            <a href="#" class="soc-btn"><i class="fab fa-telegram"></i></a>
            <a href="#" class="soc-btn"><i class="fab fa-twitter"></i></a>
            <a href="#" class="soc-btn"><i class="fab fa-instagram"></i></a>
          </div>
        </div>
      </div>
      <div class="contact-form-card">
        <div class="form-msg" id="contact-ok"><i class="fas fa-check-circle"></i> Message sent! I'll respond within 24 hours.</div>
        <div class="form-row2">
          <div class="fgrp"><label class="flbl">First Name</label><input id="cf-fname" class="finp" placeholder="Ahmed"></div>
          <div class="fgrp"><label class="flbl">Last Name</label><input id="cf-lname" class="finp" placeholder="Hassan"></div>
        </div>
        <div class="fgrp"><label class="flbl">Email Address</label><input id="cf-email" class="finp" type="email" placeholder="you@example.com"></div>
        <div class="fgrp"><label class="flbl">Phone / WhatsApp</label><input id="cf-phone" class="finp" placeholder="+973..."></div>
        <div class="fgrp"><label class="flbl">Subject</label>
          <select id="cf-subject" class="finp">
            <option>Course Inquiry — CCNA</option><option>Course Inquiry — CCNP</option>
            <option>Course Inquiry — Security</option><option>Corporate / Group Training</option><option>General Question</option>
          </select>
        </div>
        <div class="fgrp"><label class="flbl">Message</label><textarea id="cf-msg" class="finp" placeholder="Tell me about your goals..."></textarea></div>
        <button class="btn btn-c btn-full" onclick="sendContact()"><i class="fas fa-paper-plane"></i> Send Message</button>
      </div>
    </div>`;
};

/* ══════════════════════════════════════════════
   PUBLIC API — imported by app.js
   ══════════════════════════════════════════════ */
const UI = { renderHome, renderCoursesPage, renderAbout, renderContact, PageHeader };
