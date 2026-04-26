/* ─────────────────────────────────────────────
   router.js — Hash-based SPA router
   Supports static routes ("home", "courses")
   and dynamic routes ("course-:id", "lab-:slug")
   ───────────────────────────────────────────── */

const Router = (() => {
  /* Routes stored as ordered array so dynamic patterns
     are matched after exact strings */
  const _routes  = [];   // [{ pattern, rx, keys, handler }]
  const _guards  = [];
  let   _current = null;

  /* ── META ── */
  const META = {
    home:      { title: 'Ahmed Hussein | Cisco Certified Instructor',  desc: 'Expert CCNA, CCNP & Network Security training — 96% exam pass rate.' },
    courses:   { title: 'Courses | Ahmed Hussein',                     desc: 'CCNA, CCNP and Security courses with lab-first teaching.' },
    about:     { title: 'About | Ahmed Hussein',                       desc: 'Cisco Certified Instructor with 10+ years enterprise networking experience.' },
    contact:   { title: 'Contact | Ahmed Hussein',                     desc: 'Get in touch for course inquiries or corporate training.' },
    dashboard: { title: 'Dashboard | Ahmed Hussein',                   desc: 'Your student learning dashboard.' },
    labs:      { title: 'Exam Labs | Ahmed Hussein',                   desc: 'Hands-on CCNA 200-301 Packet Tracer labs.' },
  };

  const _applyMeta = (path) => {
    /* Dynamic pages: derive title from pattern prefix */
    let m = META[path];
    if (!m && path.startsWith('course-')) {
      m = { title: 'Course | Ahmed Hussein', desc: 'CCNA, CCNP & Security course details.' };
    }
    m = m || META.home;
    document.title = m.title;
    const el = document.querySelector('meta[name="description"]');
    if (el) el.setAttribute('content', m.desc);
    const og = (prop, val) => {
      let e = document.querySelector(`meta[property="${prop}"]`);
      if (!e) { e = document.createElement('meta'); e.setAttribute('property', prop); document.head.appendChild(e); }
      e.setAttribute('content', val);
    };
    og('og:title', m.title);
    og('og:description', m.desc);
    og('og:url', location.href);
  };

  /* Compile a route pattern into a RegExp + param key list.
     ":id"  → named capture group  (/([^/]+)/)
     "*"    → greedy wildcard
     All other regex-special chars (including "/") are escaped.  */
  const _compile = (pattern) => {
    const keys = [];
    /* Use unique sentinel strings so replacements don't collide */
    const src = pattern
      .replace(/:([A-Za-z_][A-Za-z0-9_]*)/g, (_, k) => { keys.push(k); return '\x00P\x00'; })
      .replace(/\*/g, '\x00W\x00')
      /* Escape all remaining regex-special characters including "/" */
      .replace(/[/\\^$.|?*+()[\]{}]/g, c => '\\' + c)
      /* Restore capture groups */
      .replace(/\x00P\x00/g, '([^/]+)')
      .replace(/\x00W\x00/g, '(.*)');
    return { rx: new RegExp('^' + src + '$'), keys };
  };

  /* Get clean path from current hash */
  const _pathFromHash = () =>
    (location.hash.replace(/^#\/?/, '').split('?')[0].trim()) || 'home';

  /* Core dispatch */
  const _dispatch = (rawPath) => {
    /* Run guards */
    for (const guard of _guards) {
      const redirect = guard(rawPath);
      if (redirect && redirect !== rawPath) { Router.go(redirect); return; }
    }

    /* Find first matching route */
    let matched = false;
    for (const route of _routes) {
      const m = rawPath.match(route.rx);
      if (!m) continue;

      /* Build params object from named captures */
      const params = {};
      route.keys.forEach((k, i) => { params[k] = m[i + 1]; });

      route.handler(params, rawPath);
      matched = true;
      break;
    }

    if (!matched) {
      /* Fall back to home */
      const home = _routes.find(r => r.pattern === 'home');
      if (home) home.handler({}, 'home');
    }

    _current = rawPath;
    _applyMeta(rawPath);
    window.scrollTo({ top: 0, behavior: 'smooth' });

    /* Sync nav active state — highlight parent section */
    const section = rawPath.startsWith('course-') ? 'courses' : rawPath;
    document.querySelectorAll('.nav-links a[data-pg]').forEach(a => {
      a.classList.toggle('act', a.dataset.pg === section);
    });
  };

  /* ── PUBLIC API ── */
  return {
    /**
     * Register a route.
     * Pattern may contain ":param" segments.
     * Handler receives (params, rawPath).
     */
    on(pattern, handler) {
      const { rx, keys } = _compile(pattern);
      _routes.push({ pattern, rx, keys, handler });
      return this;
    },

    /** Register multiple static paths with the same handler. */
    many(paths, handler) {
      paths.forEach(p => this.on(p, handler));
      return this;
    },

    /** Register a navigation guard. Return redirect path to abort, falsy to continue. */
    guard(fn) {
      _guards.push(fn);
      return this;
    },

    /** Navigate programmatically. */
    go(path) {
      const old = location.hash;
      location.hash = path;
      if (old === `#${path}`) _dispatch(path);
    },

    /**
     * navigate(path) — same as go() but accepts leading slashes.
     * router.navigate('/courses/1') === Router.go('courses/1')
     */
    navigate(path) {
      this.go(String(path).replace(/^\/+/, ''));
    },

    /** Current route key. */
    get current() { return _current || _pathFromHash(); },

    /** Start the router. */
    init() {
      window.addEventListener('load',       () => _dispatch(_pathFromHash()));
      window.addEventListener('hashchange', () => _dispatch(_pathFromHash()));
      _dispatch(_pathFromHash());
    },
  };
})();
