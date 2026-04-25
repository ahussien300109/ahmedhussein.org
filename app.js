/* ─────────────────────────────────────────────
   app.js — Main entry point: UI, data, routing
   ───────────────────────────────────────────── */

/* ── COURSE PERSISTENCE ── */
function loadCourses() {
  try {
    const s = localStorage.getItem('ah_courses');
    if (s) {
      const saved = JSON.parse(s);
      const ids = new Set(saved.map(c => c.id));
      // Merge: any course added to DEFAULT_COURSES since last save is appended
      return [...saved, ...DEFAULT_COURSES.filter(c => !ids.has(c.id))];
    }
  } catch(e) {}
  return DEFAULT_COURSES.map(c => Object.assign({}, c));
}
function saveCourses() { localStorage.setItem('ah_courses', JSON.stringify(COURSES)); }

/* ── COURSE DATA ── */
const DEFAULT_COURSES = [
  { id: 1, cat: 'CCNA', icon: '🌐', th: 'th1', badge: 'hot',
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


  { id: 5, cat: 'CCNP', icon: '⚙️', th: 'th5',
    title: 'SD-WAN & Network Automation (Python)',
    desc: 'Cisco Viptela SD-WAN, Python scripting, Ansible playbooks, NETCONF/RESTCONF APIs, and DNA Center automation.',
    level: 'Advanced', duration: '60 hrs', students: '95', price: '$199', rating: '4.7', reviews: '38',
    prereqs: 'CCNP ENCOR or solid enterprise networking experience.',
    curriculum: ['SD-WAN: Control & Data Plane','vManage, vBond & vSmart','OMP Routing & Policy','Python for Network Engineers','Netmiko & NAPALM Libraries','Ansible for Cisco IOS','NETCONF & RESTCONF','DNA Center REST API','DevOps Capstone Project'] },

  { id: 6, cat: 'CCNA', icon: '📝', th: 'th6', badge: 'free',
    title: 'CCNA Exam Bootcamp: 10-Day Intensive',
    desc: 'Rapid exam prep with 5 full-length practice tests, time management strategies, and domain-by-domain review sessions.',
    level: 'Intermediate', duration: '30 hrs', students: '340', price: 'Free', rating: '4.8', reviews: '156',
    prereqs: 'Completed CCNA training or equivalent knowledge.',
    link: 'ccna-domain1.html',
    curriculum: ['Exam Structure & Scoring','Domain 1: Network Fundamentals','Domain 2: Network Access','Domain 3: IP Connectivity','Domain 4: IP Services','Domain 5: Security Fundamentals','Domain 6: Automation','Practice Test 1 + Review','Practice Test 2 + Final Sim'] },

  { id: 7, cat: 'CCNA', icon: '🔬', th: 'th1', badge: 'new',
    title: 'CCNA Exam Labs',
    desc: '13 hands-on Packet Tracer labs across Layer 2, Routing, and Security. Each lab includes tasks, configuration commands, and a downloadable .zip file.',
    level: 'Intermediate', duration: '15 hrs', students: '280', price: 'Free', rating: '4.9', reviews: '74',
    prereqs: 'CCNA training or equivalent knowledge recommended.',
    type: 'course', pageLink: 'labs', btnLabel: '▶ Start Lab',
    curriculum: ['Layer 2: 802.1Q Trunking & LACP (Labs 1–2)','Layer 2: Voice VLAN & LLDP (Lab 3)','Layer 2: VLAN & Neighbor Discovery (Labs 8–10)','Layer 2: EtherChannel Series (Labs 13–18)','Routing: Dual-Stack Addressing (Lab 4)','Routing: Static Routing & Failover (Lab 5)','Routing: OSPF Single-Area (Labs 6–7)','Routing: IPv6 Static (Lab 19)','Security: ACLs & DHCP Snooping (Lab 11)','Security: NAT, DHCP, NTP & SSH (Lab 14)','Security: Port Security (Labs 16–17)'] }
];
let COURSES = loadCourses();
console.log('[COURSES]', COURSES.map(c => c.id + ' ' + c.title + ' cat:' + c.cat + ' price:' + c.price));

/* ── INJECT LAB CONTENT INTO CCNA EXAM LABS COURSE ──────────────
   Labs are defined here and written directly onto the course object
   in both COURSES and DEFAULT_COURSES, so they survive cache merges.
   ─────────────────────────────────────────────────────────────── */
(function() {
  const labs = [
    { category:'Layer 2 Switching', icon:'fa-layer-group', color:'var(--c)', items:[
      { num:'01', title:'802.1Q Trunking & LACP', file:'lab01-trunking-lacp.zip',
        tasks:['Configure 802.1Q trunk encapsulation on SW1–SW2 links','Set up EtherChannel using LACP — channel-group 10 mode active','Verify trunk: show interfaces trunk','Verify bundle: show etherchannel summary'],
        config:['interface range Fa0/1-2',' switchport trunk encapsulation dot1q',' switchport mode trunk',' channel-group 10 mode active','!','interface Port-channel 10',' switchport trunk encapsulation dot1q',' switchport mode trunk'] },
      { num:'02', title:'802.1Q Trunking & LACP (Advanced)', file:'lab02-native-vlan-lacp.zip',
        tasks:['Set native VLAN 45 on all trunk interfaces','Create LACP EtherChannel — channel-group 15 mode passive','Verify native VLAN: show interfaces trunk','Test untagged frame forwarding across the bundle'],
        config:['interface range Fa0/3-4',' switchport trunk encapsulation dot1q',' switchport trunk native vlan 45',' switchport mode trunk',' channel-group 15 mode passive'] },
      { num:'03', title:'Voice VLAN & LLDP', file:'lab03-voice-vlan-lldp.zip',
        tasks:['Create VLAN 77 (data) and VLAN 177 (voice)','Configure access port: data + voice VLAN assignment','Enable LLDP globally and on specific interfaces','Verify: show lldp neighbors detail'],
        config:['vlan 77',' name DATA','vlan 177',' name VOICE','!','interface Fa0/5',' switchport mode access',' switchport access vlan 77',' switchport voice vlan 177','!','lldp run'] },
      { num:'08–10', title:'VLAN & Neighbor Discovery', file:'lab08-10-vlan-cdp-lldp.zip',
        tasks:['Create VLANs 10, 20, 30 and assign access ports','Enable CDP on SW1, LLDP on SW2','Verify: show cdp neighbors / show lldp neighbors','Compare CDP and LLDP output fields'],
        config:['vlan 10',' name SALES','vlan 20',' name IT','!','interface Fa0/10',' switchport mode access',' switchport access vlan 10','!','cdp run','lldp run'] },
      { num:'13–18', title:'Trunking & EtherChannel Series', file:'lab13-18-etherchannel.zip',
        tasks:['Lab 13: LACP active/active — channel-group 1','Lab 15: PAgP desirable/auto — channel-group 2','Lab 17: Static EtherChannel (mode on) — channel-group 3','Lab 18: Trunk + EtherChannel with allowed VLANs'],
        config:['! LACP — Lab 13','channel-group 1 mode active','! PAgP — Lab 15','channel-group 2 mode desirable','! Static — Lab 17','channel-group 3 mode on','! Allowed VLANs — Lab 18','switchport trunk allowed vlan 10,20,30'] },
    ]},
    { category:'Routing', icon:'fa-route', color:'var(--o)', items:[
      { num:'04', title:'IPv4 & IPv6 Address Assignment', file:'lab04-dual-stack.zip',
        tasks:['Assign first usable IPv4 host address per subnet','Configure IPv6 global unicast + link-local addresses','Enable ipv6 unicast-routing','Verify: ping, show interfaces, show ipv6 interface brief'],
        config:['ipv6 unicast-routing','!','interface GigabitEthernet0/0',' ip address 192.168.1.1 255.255.255.0',' ipv6 address 2001:DB8:A::/64 eui-64',' ipv6 address FE80::1 link-local',' no shutdown'] },
      { num:'05', title:'Static Routing & Failover', file:'lab05-static-failover.zip',
        tasks:['Configure host route to /32 destination','Add default route via primary ISP link','Floating static route AD 225 via backup ISP','Verify failover: shut primary, check routing table'],
        config:['ip route 10.10.10.0 255.255.255.0 192.168.1.254','ip route 0.0.0.0 0.0.0.0 203.0.113.1','ip route 0.0.0.0 0.0.0.0 198.51.100.1 225'] },
      { num:'06–07', title:'OSPF Single-Area Routing', file:'lab06-07-ospf.zip',
        tasks:['Assign router-IDs 1.1.1.1 / 2.2.2.2 / 3.3.3.3','Enable OSPF on interfaces: ip ospf 1 area 0 (no network stmt)','Set OSPF priority 200 on R1 to force DR election','Verify: show ip ospf neighbor, show ip route ospf'],
        config:['router ospf 1',' router-id 1.1.1.1','!','interface GigabitEthernet0/0',' ip ospf 1 area 0',' ip ospf priority 200'] },
      { num:'19', title:'IPv6 Static Routing', file:'lab19-ipv6-static.zip',
        tasks:['Configure IPv6 static routes to all remote networks','Add floating IPv6 route AD 5 for redundancy','Verify: ping ipv6, traceroute ipv6','Failover test: disable primary interface'],
        config:['ipv6 route 2001:DB8:B::/64 GigabitEthernet0/1 FE80::2','ipv6 route 2001:DB8:B::/64 GigabitEthernet0/2 FE80::3 5'] },
      { num:'20', title:'IPv4 Static & Default Routing', file:'lab20-static-default.zip',
        tasks:['Configure static routes for all internal subnets','Add default route pointing to ISP','Extended ping end-to-end test','Failover test: shut primary uplink, verify backup path'],
        config:['ip route 10.1.0.0 255.255.0.0 192.168.100.2','ip route 10.2.0.0 255.255.0.0 192.168.100.2','ip route 0.0.0.0 0.0.0.0 203.0.113.254'] },
    ]},
    { category:'Security & Services', icon:'fa-shield-alt', color:'var(--g)', items:[
      { num:'11', title:'ACLs & DHCP Snooping', file:'lab11-acl-dhcp-snooping.zip',
        tasks:['Create named extended ACL blocking RFC 1918 sources','Apply ACL inbound on WAN-facing interface','Enable DHCP snooping on VLANs 10, 20','Mark uplink to DHCP server as trusted','Enable DAI (Dynamic ARP Inspection) on both VLANs'],
        config:['ip access-list extended BLOCK-RFC1918',' deny ip 10.0.0.0 0.255.255.255 any',' deny ip 172.16.0.0 0.15.255.255 any',' deny ip 192.168.0.0 0.0.255.255 any',' permit ip any any','!','ip dhcp snooping','ip dhcp snooping vlan 10,20','!','interface Fa0/1',' ip dhcp snooping trust','!','ip arp inspection vlan 10,20'] },
      { num:'14', title:'NAT, DHCP, NTP & SSH', file:'lab14-services.zip',
        tasks:['DHCP pool with exclusions .1–.10 for servers','Configure PAT (NAT overload) for internet access','Set NTP server and verify synchronisation','Enable SSH v2 with RSA 2048-bit key','Restrict VTY lines to SSH-only with local auth'],
        config:['ip dhcp excluded-address 192.168.1.1 192.168.1.10','ip dhcp pool LAN',' network 192.168.1.0 255.255.255.0',' default-router 192.168.1.1',' dns-server 8.8.8.8','!','ip nat inside source list ACL-NAT interface Gi0/1 overload','!','ntp server 216.239.35.0','!','crypto key generate rsa modulus 2048','ip ssh version 2','line vty 0 4',' transport input ssh',' login local'] },
      { num:'16–17', title:'ACLs & Port Security', file:'lab16-17-port-security.zip',
        tasks:['Extended ACL: permit VLAN10 → VLAN20 HTTP traffic only','Apply ACL inbound on VLAN 10 SVI','Port security: maximum 2 MAC addresses per port','Enable sticky MAC address learning','Set violation mode restrict; verify syslog'],
        config:['ip access-list extended VLAN-FILTER',' permit tcp 192.168.10.0 0.0.0.255 192.168.20.0 0.0.0.255 eq 80',' deny ip any any','!','interface Vlan10',' ip access-group VLAN-FILTER in','!','interface Fa0/2',' switchport port-security maximum 2',' switchport port-security mac-address sticky',' switchport port-security violation restrict',' switchport port-security'] },
    ]},
  ];
  // Attach to both arrays so it survives cache merges and admin reloads
  [COURSES, DEFAULT_COURSES].forEach(arr => {
    const c = arr.find(x => x.id === 7);
    if (c) c.labs = labs;
  });
})();

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
  document.querySelectorAll('.sr-fill').forEach((b, i) => {
    const target = parseInt(b.dataset.w);
    const pct = b.closest('.skill-row')?.querySelector('.sr-pct');
    if (pct) pct.textContent = '0%';
    setTimeout(() => {
      b.style.width = b.dataset.w || '0%';
      if (!pct) return;
      const dur = 1400, t0 = performance.now();
      (function tick(now) {
        const p = Math.min((now - t0) / dur, 1), e = 1 - Math.pow(1 - p, 3);
        pct.textContent = Math.round(target * e) + '%';
        if (p < 1) requestAnimationFrame(tick);
      })(t0);
    }, i * 60);
  });
}

function initSkillBars() {
  document.querySelectorAll('.sr-fill').forEach(b => b.style.width = '0'); // reset on each visit
  const rows = document.querySelector('.skill-rows');
  if (!rows) return;
  const obs = new IntersectionObserver(([e]) => {
    if (!e.isIntersecting) return;
    animSkills();
    obs.disconnect();
  }, { threshold: 0.2 });
  obs.observe(rows);
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

/* ── CLI DEMO ANIMATION ── */
function initCliDemo() {
  const el = document.getElementById('cli-demo');
  if (!el || el.dataset.started) return;
  const lines = [
    {t:'cmd', v:'SW1# configure terminal'},
    {t:'cmd', v:'SW1(config)# interface range Fa0/1-2'},
    {t:'cmd', v:'SW1(config-if)# switchport trunk encapsulation dot1q'},
    {t:'cmd', v:'SW1(config-if)# switchport mode trunk'},
    {t:'cmd', v:'SW1(config-if)# channel-group 10 mode active'},
    {t:'out', v:'% Creating a channel-group...'},
    {t:'cmd', v:'SW1(config-if)# end'},
    {t:'cmd', v:'SW1# show etherchannel summary'},
    {t:'out', v:'Group  Port-channel  Protocol   Ports'},
    {t:'out', v:'  10   Po10(SU)      LACP       Fa0/1(P) Fa0/2(P)'},
    {t:'ok',  v:'✓ EtherChannel verified — Lab 01 complete!'},
  ];
  const obs = new IntersectionObserver(([e]) => {
    if (!e.isIntersecting) return;
    obs.disconnect();
    el.dataset.started = '1';
    let i = 0;
    function next() {
      if (i >= lines.length) { setTimeout(() => { el.innerHTML = ''; i = 0; next(); }, 4000); return; }
      const {t, v} = lines[i++];
      const d = document.createElement('div');
      d.style.cssText = `color:${t==='cmd'?'#7ec8e3':t==='ok'?'#00ff88':'#667788'}`;
      d.textContent = v;
      el.appendChild(d);
      el.scrollTop = el.scrollHeight;
      setTimeout(next, t==='cmd' ? 140 + Math.random()*80 : 55);
    }
    next();
  }, {threshold: 0.4});
  obs.observe(el);
}

/* ── URGENCY SEATS COUNTER ── */
function initUrgency() {
  const el = document.getElementById('seats-count');
  if (!el) return;
  // Pseudo-random but stable seats count based on day of month
  const seats = Math.max(2, 7 - (new Date().getDate() % 5));
  el.textContent = seats;
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
  initUrgency();
  initCliDemo();
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
  if (pg === 'about') setTimeout(initSkillBars, 50);
  if (pg === 'labs') renderLabs();
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
      <div class="cc-thumb ${c.th}"><span class="cc-thumb-icon">${c.icon}</span><div class="cc-level-tag lvl-${c.level === 'Beginner' ? 'beg' : c.level === 'Advanced' ? 'adv' : 'int'}">${c.level}</div>${c.badge ? `<div class="cc-badge ccb-${c.badge}">${{hot:'🔥 Popular',free:'✓ Free',new:'New'}[c.badge]}</div>` : ''}</div>
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
          <button class="cc-enroll" onclick="event.stopPropagation();enrollCourse(${c.id})">${(c.link||c.pageLink) ? (c.btnLabel||'▶ Start Course') : S.enrolled.includes(c.id) ? '✓ Enrolled' : 'Enroll Now'}</button>
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
  const enrollBtn = c.pageLink
    ? `<button class="btn btn-c" onclick="closeCourseModal();showPage('${c.pageLink}')"><i class="fas fa-play"></i> ${c.btnLabel||'Start'}</button>`
    : c.link
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
  if (course?.pageLink) { closeCourseModal(); showPage(course.pageLink); return; }
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
  const users    = JSON.parse(localStorage.getItem('ah_users') || '[]');
  const students = users.filter(u => !u.isAdmin);
  const totalEnr = students.reduce((a, u) => a + (u.enrolled ? u.enrolled.length : 0), 0);
  const premium  = students.filter(u => u.tier === 'premium').length;
  const free     = COURSES.filter(c => c.price === 'Free').length;

  // Top courses by enrollment count
  const enrMap = {};
  students.forEach(u => (u.enrolled || []).forEach(id => { enrMap[id] = (enrMap[id] || 0) + 1; }));
  const topCourses = COURSES.map(c => ({...c, n: enrMap[c.id] || 0}))
    .sort((a, b) => b.n - a.n).slice(0, 5);
  const maxN = Math.max(...topCourses.map(c => c.n), 1);

  // Recent registrations (last 5 — stored newest-last)
  const recent = [...students].reverse().slice(0, 5);

  const statCards = [
    { ico:'fa-book',          cls:'ico-c', val:COURSES.length,  lbl:'Courses',     up:true,  trend:`+${COURSES.length}` },
    { ico:'fa-users',         cls:'ico-g', val:students.length, lbl:'Students',    up:true,  trend:students.length ? `+${Math.max(1,Math.round(students.length*.12))} mo` : '0' },
    { ico:'fa-graduation-cap',cls:'ico-o', val:totalEnr,        lbl:'Enrollments', up:true,  trend:totalEnr ? `+${Math.max(1,Math.round(totalEnr*.08))} mo` : '0' },
    { ico:'fa-crown',         cls:'ico-p', val:premium,         lbl:'Premium',     up:premium>0, trend:premium>0?`${premium} active`:'0 yet' },
  ];

  el.innerHTML = `
    <div class="dash-toprow">
      <div>
        <div class="dash-hello">ADMIN <span>DASHBOARD</span></div>
        <div class="dash-sub">${new Date().toLocaleDateString('en-GB',{weekday:'long',day:'numeric',month:'long',year:'numeric'})}</div>
      </div>
      <button class="btn btn-c btn-sm" onclick="openEditCourse(null)"><i class="fas fa-plus"></i> Add Course</button>
    </div>

    <div class="dash-stats" style="margin-bottom:1.5rem">
      ${statCards.map(s=>`
      <div class="dstat">
        <div class="dstat-ico ${s.cls}"><i class="fas ${s.ico}"></i></div>
        <div class="dstat-num">${s.val}</div>
        <div class="dstat-lbl">${s.lbl}</div>
        <div class="adm-stat-trend ${s.up?'trend-up':'trend-dn'}">
          <i class="fas fa-arrow-${s.up?'up':'down'}" style="font-size:.48rem"></i> ${s.trend}
        </div>
      </div>`).join('')}
    </div>

    <div class="adm-tw-grid">
      <div>
        <div class="dash-sec-title" style="margin-bottom:.8rem">
          <i class="fas fa-user-plus" style="color:var(--c);margin-right:6px;font-size:.75rem"></i>Recent Registrations
        </div>
        <div style="background:var(--card);border:1px solid var(--bdr);border-radius:var(--r);padding:.8rem 1rem">
          ${recent.length ? recent.map(u=>`
          <div class="adm-activity-item">
            <div class="adm-av">${(u.fname?.[0]||'?').toUpperCase()}</div>
            <div style="flex:1;min-width:0">
              <div style="font-size:.82rem;font-weight:600;color:var(--tw);white-space:nowrap;overflow:hidden;text-overflow:ellipsis">${u.fname||''} ${u.lname||''}</div>
              <div style="font-size:.67rem;color:var(--tm);white-space:nowrap;overflow:hidden;text-overflow:ellipsis">${u.email}</div>
            </div>
            <span class="lvl-tag ${u.tier==='premium'?'premium-tag':''}" style="font-size:.54rem;flex-shrink:0">${u.tier==='premium'?'Pro':'Free'}</span>
          </div>`).join('') : `<div style="text-align:center;padding:1.5rem;color:var(--tm);font-size:.82rem">No students yet</div>`}
        </div>
      </div>

      <div>
        <div class="dash-sec-title" style="margin-bottom:.8rem">
          <i class="fas fa-chart-bar" style="color:var(--o);margin-right:6px;font-size:.75rem"></i>Top Courses by Enrollment
        </div>
        <div style="background:var(--card);border:1px solid var(--bdr);border-radius:var(--r);padding:.8rem 1rem;margin-bottom:1rem">
          ${topCourses.map(c=>`
          <div style="margin-bottom:.85rem">
            <div style="display:flex;justify-content:space-between;font-size:.77rem;margin-bottom:3px">
              <span style="font-weight:600;color:var(--t);overflow:hidden;text-overflow:ellipsis;white-space:nowrap;max-width:155px">${c.title}</span>
              <span style="font-family:'Orbitron',monospace;font-size:.68rem;color:var(--c);flex-shrink:0;margin-left:6px">${c.n}</span>
            </div>
            <div style="height:5px;background:var(--bg4);border-radius:3px;overflow:hidden">
              <div class="adm-chart-bar" data-w="${maxN?Math.round(c.n/maxN*100):0}"></div>
            </div>
          </div>`).join('')}
        </div>

        <div class="dash-sec-title" style="margin-bottom:.8rem">
          <i class="fas fa-bell" style="color:var(--g);margin-right:6px;font-size:.75rem"></i>Notifications
        </div>
        ${free>0?`<div class="adm-notif"><div class="adm-notif-dot" style="background:var(--g)"></div><span><strong>${free}</strong> free course${free>1?'s':''} active — consider a premium upsell.</span></div>`:''}
        ${students.length===0?`<div class="adm-notif"><div class="adm-notif-dot" style="background:var(--o)"></div><span>No students yet — share your course link to get started.</span></div>`:
        `<div class="adm-notif"><div class="adm-notif-dot" style="background:var(--c)"></div><span><strong>${students.length}</strong> student${students.length>1?'s':''} · <strong>${totalEnr}</strong> total enrollment${totalEnr!==1?'s':''}.</span></div>`}
        ${premium>0?`<div class="adm-notif"><div class="adm-notif-dot" style="background:var(--o)"></div><span><strong>${premium}</strong> premium subscriber${premium>1?'s':''} — ${Math.round(premium/students.length*100)||0}% conversion rate.</span></div>`:''}
      </div>
    </div>

    <div class="dash-sec-title" style="margin-bottom:.8rem">
      <i class="fas fa-bolt" style="color:var(--c);margin-right:6px;font-size:.75rem"></i>Quick Actions
    </div>
    <div style="display:flex;gap:.75rem;flex-wrap:wrap">
      <button class="btn btn-c" onclick="openEditCourse(null)"><i class="fas fa-plus"></i> Add Course</button>
      <button class="btn btn-ghost" onclick="activatePanel('admin-courses');renderAdminCourses()"><i class="fas fa-book"></i> Manage Courses</button>
      <button class="btn btn-ghost" onclick="activatePanel('admin-students');renderAdminStudents()"><i class="fas fa-users"></i> View Students</button>
    </div>`;

  // Animate chart bars after render
  requestAnimationFrame(() => {
    document.querySelectorAll('.adm-chart-bar[data-w]').forEach(b => {
      b.style.width = b.dataset.w + '%';
    });
  });
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
  const all = JSON.parse(localStorage.getItem('ah_users')||'[]').filter(u=>!u.isAdmin);
  el.innerHTML = `
    <div class="adm-search-wrap">
      <i class="fas fa-search adm-search-ico"></i>
      <input class="adm-search" id="adm-stu-q" type="text" placeholder="Search by name or email…" oninput="_admStudentFilter(this.value)">
    </div>
    <div id="adm-stu-tbl"></div>`;
  _admRenderStudentTbl(all);
}

function _admStudentFilter(q) {
  const all = JSON.parse(localStorage.getItem('ah_users')||'[]').filter(u=>!u.isAdmin);
  const ql = q.toLowerCase();
  _admRenderStudentTbl(q ? all.filter(u=>`${u.fname} ${u.lname} ${u.email}`.toLowerCase().includes(ql)) : all, q);
}

function _admRenderStudentTbl(users, q='') {
  const el = document.getElementById('adm-stu-tbl');
  if (!el) return;
  if (!users.length) {
    el.innerHTML = `<div class="empty-state"><div class="es-ico">${q?'🔍':'👥'}</div><div class="es-title">${q?'NO RESULTS':'NO STUDENTS YET'}</div><div class="es-desc">${q?'Try a different search term.':'Students appear here after registering.'}</div></div>`;
    return;
  }
  const cols = '1.8fr 2fr 1fr 0.7fr 1fr';
  el.innerHTML = `
    <div style="font-size:.7rem;color:var(--tm);margin-bottom:.6rem">${users.length} student${users.length!==1?'s':''} found</div>
    <div class="adm-tbl">
      <div class="adm-tbl-hdr" style="grid-template-columns:${cols}">
        <span>Student</span><span>Email</span><span>Plan</span><span>Courses</span><span>Joined</span>
      </div>
      ${users.map(u=>`
      <div class="adm-tbl-row" style="grid-template-columns:${cols}">
        <div style="display:flex;align-items:center;gap:.55rem">
          <div class="adm-av" style="width:28px;height:28px;font-size:.55rem;flex-shrink:0">${(u.fname?.[0]||'?').toUpperCase()}</div>
          <span style="font-weight:600;color:var(--tw);font-size:.82rem;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">${u.fname||''} ${u.lname||''}</span>
        </div>
        <span style="font-size:.74rem;color:var(--tm);overflow:hidden;text-overflow:ellipsis;white-space:nowrap">${u.email}</span>
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
const BOT_REPLIES = [
  [/\b(hi|hello|hey|salaam)\b/i,  'Hello! 👋 How can I help you today?'],
  [/ccna/i,                        'Our CCNA 200-301 course takes you from zero to certified — 80 hrs, 5 practice exams, and real Packet Tracer labs!'],
  [/ccnp/i,                        'CCNP Enterprise (ENCOR 350-401) covers BGP, SD-WAN, wireless and automation. Recommended after CCNA.'],
  [/secur|cyberops|scor/i,         'CyberOps & Security covers ASA, Firepower NGFW, VPNs and incident response — great for security roles.'],
  [/free|price|cost|\$/i,          'The CCNA Bootcamp is 100% free! Premium courses start at $79. Register for free to get started.'],
  [/lab|packet.?tracer/i,          'All courses include Packet Tracer labs. The dedicated Lab course has 50+ hands-on exercises.'],
  [/certif/i,                      'Premium members get a signed certificate per course — great for LinkedIn and job applications!'],
  [/contact|email|reach/i,         'Reach Ahmed at ahmed@ahmedhussein.org or via the Contact page. He responds within 24 hours.'],
  [/register|sign.?up|account/i,   'Click "Register Free" in the nav — 30 seconds and you get instant access to free courses!'],
  [/thank/i,                       "You're welcome! 😊 Let me know if you have any other questions."],
  [/.*/,                           'Thanks for your message! Ahmed will reply soon. Feel free to browse the Courses section. 🚀'],
];

let chatOpen = false;

function initChat() {
  setTimeout(() => _chatAppend('Hi there! 👋 Ask me about courses, pricing, or certifications.', 'bot'), 600);
  setTimeout(() => {
    const badge = document.getElementById('chat-badge');
    if (badge && !chatOpen) badge.style.display = 'flex';
  }, 700);
}

function toggleChat() {
  chatOpen = !chatOpen;
  document.getElementById('chat-box').classList.toggle('open', chatOpen);
  document.getElementById('chat-icon').className = chatOpen ? 'fas fa-times' : 'fas fa-comment-dots';
  document.getElementById('chat-badge').style.display = 'none';
  if (chatOpen) setTimeout(() => document.getElementById('chat-input').focus(), 80);
}

function sendChat() {
  const inp  = document.getElementById('chat-input');
  const text = inp.value.trim();
  if (!text) return;                               // prevent empty send

  inp.value = '';                                  // clear input immediately
  _chatAppend(text, 'user');                       // show user message

  // show typing indicator — hold direct reference to avoid ID clash
  const msgs   = document.getElementById('chat-msgs');
  const typing = document.createElement('div');
  typing.className = 'chat-typing';
  typing.innerHTML = '<div class="tydot"></div><div class="tydot"></div><div class="tydot"></div>';
  msgs.appendChild(typing);
  msgs.scrollTop = msgs.scrollHeight;

  // bot reply after 1s
  setTimeout(() => {
    typing.remove();
    const match = BOT_REPLIES.find(([rx]) => rx.test(text));
    _chatAppend((match || BOT_REPLIES.at(-1))[1], 'bot');
  }, 1000);
}

function _chatAppend(text, side) {
  const msgs = document.getElementById('chat-msgs');
  if (!msgs) return;
  const d = document.createElement('div');
  d.className = 'cmsg ' + side;
  d.textContent = text;
  msgs.appendChild(d);
  msgs.scrollTop = msgs.scrollHeight;              // auto-scroll to latest
}

/* ── LABS PAGE DATA ── */

function renderLabs() {
  const pg = document.getElementById('page-labs');
  if (!pg) return;
  if (pg.dataset.built) { reObserve(); return; }
  pg.dataset.built = '1';
  // Source labs from the course object — data lives in the course, not a separate const
  const labCourse = COURSES.find(c => c.id === 7) || DEFAULT_COURSES.find(c => c.id === 7);
  const LABS_DATA = labCourse?.labs || [];

  pg.innerHTML = `
    <div class="pg-header">
      <div class="pg-header-bg"></div><div class="pg-header-glow"></div>
      <div class="pg-header-inner">
        <div class="breadcrumb">
          <a href="#" onclick="showPage('courses');return false">Courses</a>
          <i class="fas fa-chevron-right"></i>CCNA Exam Labs
        </div>
        <div class="sec-eyebrow" style="margin-bottom:.8rem"><i class="fas fa-flask"></i> CCNA 200-301 Hands-On Labs</div>
        <div class="pg-title">CCNA EXAM <span style="color:var(--c)">LABS</span></div>
        <div class="pg-subtitle">Packet Tracer labs for every CCNA domain. Each lab includes tasks, exact configuration commands, and a downloadable .zip file.</div>
        <div style="display:flex;gap:2rem;flex-wrap:wrap;padding-top:1.5rem;border-top:1px solid var(--bdr);margin-top:1.2rem">
          ${[['13','Lab Exercises'],['3','Categories'],['Free','All Downloads']].map(([n,l])=>`
          <div>
            <div style="font-family:'Orbitron',monospace;font-size:1.4rem;font-weight:900;color:var(--tw)">${n}</div>
            <div style="font-size:.63rem;color:var(--c);text-transform:uppercase;letter-spacing:2px;margin-top:2px">${l}</div>
          </div>`).join('')}
        </div>
      </div>
    </div>

    ${LABS_DATA.map((cat, ci) => `
    <section style="padding:3.5rem 2.5rem;background:var(${ci % 2 ? '--bg1' : '--bg'})">
      <div class="sec-wrap">
        <div class="sec-eyebrow" style="color:${cat.color}"><i class="fas ${cat.icon}"></i> ${cat.category}</div>
        <h2 class="sec-h2" style="margin-bottom:1.8rem">${cat.category} <span style="color:${cat.color}">Labs</span></h2>
        <div class="faq-list">
          ${cat.labs.map(lab => `
          <div class="faq-item">
            <div class="faq-q" onclick="toggleFAQ(this)">
              <span><span style="font-family:'Orbitron',monospace;font-weight:700;color:${cat.color};margin-right:.6rem">LAB ${lab.num}</span>${lab.title}</span>
              <div class="faq-icon"><i class="fas fa-plus"></i></div>
            </div>
            <div class="faq-body"><div class="faq-body-inner" style="padding-top:.2rem">

              <p style="font-family:'Orbitron',monospace;font-size:.6rem;font-weight:700;color:${cat.color};letter-spacing:2px;text-transform:uppercase;margin-bottom:.6rem">Tasks</p>
              <div class="curr-list" style="margin-bottom:1.2rem">
                ${lab.tasks.map((t,i)=>`<div class="curr-li"><div class="curr-num">${i+1}</div>${t}</div>`).join('')}
              </div>

              <p style="font-family:'Orbitron',monospace;font-size:.6rem;font-weight:700;color:${cat.color};letter-spacing:2px;text-transform:uppercase;margin-bottom:.6rem">Configuration</p>
              <div style="background:var(--bg3);border:1px solid var(--bdr);border-radius:var(--r);padding:.9rem 1.1rem;overflow-x:auto;margin-bottom:1.2rem">
                ${lab.config.map(l=>`<div style="font-family:monospace;font-size:.79rem;color:var(--t);white-space:pre;line-height:1.7">${l.replace(/</g,'&lt;')}</div>`).join('')}
              </div>

              <a href="labs/${lab.file}" download
                 class="btn btn-ghost btn-sm"
                 onclick="toast('Preparing download: ${lab.file}','suc')">
                <i class="fas fa-download"></i> ${lab.file}
              </a>

            </div></div>
          </div>`).join('')}
        </div>
      </div>
    </section>`).join('')}

    <section class="sec-cta">
      <div class="cta-top-line"></div>
      <div class="sec-wrap" style="text-align:center;position:relative;z-index:1">
        <div class="sec-eyebrow" style="justify-content:center"><i class="fas fa-graduation-cap"></i> Need Theory Too?</div>
        <h2 class="cta-h">Pair Labs with the<br><span class="hl">Free CCNA Bootcamp</span></h2>
        <p class="cta-sub">The free bootcamp covers all 6 exam domains with lessons and quizzes. Use it alongside these labs for maximum retention.</p>
        <div class="cta-btns">
          <button class="hbtn hbtn-primary" onclick="enrollCourse(6)"><i class="fas fa-play"></i> Start Free Bootcamp</button>
          <button class="hbtn hbtn-outline" onclick="showPage('courses')"><i class="fas fa-compass"></i> All Courses</button>
        </div>
      </div>
    </section>`;

  reObserve();
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
