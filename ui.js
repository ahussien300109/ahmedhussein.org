/* ─────────────────────────────────────────────
   ui.js — Visual Effects, Navigation & UI
   ───────────────────────────────────────────── */

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

/* ── NAVBAR SCROLL ── */
function initScroll() {
  const nav = document.getElementById('nav');
  window.addEventListener('scroll', () => nav.classList.toggle('stuck', window.scrollY > 20), { passive: true });
}

/* ── INTERSECTION OBSERVER (reveal animations) ── */
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

/* ── COUNTER ANIMATIONS ── */
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

/* ── SKILL BARS ── */
function animSkills() {
  document.querySelectorAll('.sr-fill').forEach(b => b.style.width = b.dataset.w || '0%');
}

/* ── SCROLL SPY — highlight active nav link + trigger section effects ── */
function initScrollSpy() {
  const links = document.querySelectorAll('.nav-links a[data-pg]');
  let skillsDone = false;
  const obs = new IntersectionObserver(entries => {
    entries.forEach(e => {
      if (!e.isIntersecting) return;
      const id = e.target.id;
      links.forEach(a => a.classList.toggle('act', a.dataset.pg === id));
      if (id === 'about' && !skillsDone) { skillsDone = true; setTimeout(animSkills, 400); }
    });
  }, { rootMargin: '-15% 0px -75% 0px', threshold: 0 });
  ['hero', 'courses', 'about', 'contact', 'dashboard'].forEach(id => {
    const el = document.getElementById(id);
    if (el) obs.observe(el);
  });
}

/* ── SECTION NAVIGATION ── */
function scrollToSection(id) {
  const el = document.getElementById(id);
  if (!el) return;
  const top = el.getBoundingClientRect().top + window.scrollY - 72;
  window.scrollTo({ top: Math.max(0, top), behavior: 'smooth' });
}

/* ── MOBILE NAV ── */
function toggleMob() {
  document.getElementById('mob-nav').classList.toggle('open');
  document.getElementById('ham').classList.toggle('open');
}

/* ── THEME TOGGLE ── */
function toggleTheme() {
  const html = document.documentElement;
  const isLight = html.getAttribute('data-theme') === 'light';
  html.setAttribute('data-theme', isLight ? 'dark' : 'light');
  localStorage.setItem('theme', isLight ? 'dark' : 'light');
  document.getElementById('theme-icon').className = isLight ? 'fas fa-sun' : 'fas fa-moon';
}

/* ── TOAST NOTIFICATIONS ── */
function toast(msg, type = 'inf') {
  const box = document.getElementById('toast-box');
  const icons = { suc: 'fa-check-circle', err: 'fa-exclamation-circle', inf: 'fa-info-circle' };
  const t = document.createElement('div');
  t.className = `toast ${type}`;
  t.innerHTML = `<i class="fas ${icons[type] || icons.inf}"></i><span>${msg}</span>`;
  box.appendChild(t);
  setTimeout(() => { t.classList.add('rm'); setTimeout(() => t.remove(), 300); }, 4200);
}
