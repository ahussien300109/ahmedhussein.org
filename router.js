/* ─────────────────────────────────────────────
   router.js — Hash-based SPA router
   ───────────────────────────────────────────── */

const Router = (() => {
  const _routes  = {};
  const _guards  = [];
  let   _current = null;

  /* Page-level meta config */
  const META = {
    home:      { title: 'Ahmed Hussein | Cisco Certified Instructor',    desc: 'Expert CCNA, CCNP & Network Security training — 96% exam pass rate.' },
    courses:   { title: 'Courses | Ahmed Hussein',                       desc: 'CCNA, CCNP and Security courses with lab-first teaching.' },
    about:     { title: 'About | Ahmed Hussein',                         desc: 'Cisco Certified Instructor with 10+ years enterprise networking experience.' },
    contact:   { title: 'Contact | Ahmed Hussein',                       desc: 'Get in touch for course inquiries or corporate training.' },
    dashboard: { title: 'Dashboard | Ahmed Hussein',                     desc: 'Your student learning dashboard.' },
    labs:      { title: 'Exam Labs | Ahmed Hussein',                     desc: 'Hands-on CCNA 200-301 Packet Tracer labs.' },
    freecourse:{ title: 'Free CCNA Bootcamp | Ahmed Hussein',            desc: 'Free 10-day CCNA exam bootcamp — no signup needed.' },
  };

  /* Derive route key from current hash */
  const _pathFromHash = () => {
    const h = location.hash.replace(/^#\/?/, '').split('?')[0].trim();
    return h || 'home';
  };

  /* Apply meta for current route */
  const _applyMeta = (path) => {
    const m = META[path] || META.home;
    document.title = m.title;
    const descEl = document.querySelector('meta[name="description"]');
    if (descEl) descEl.setAttribute('content', m.desc);
    // og tags
    const og = (prop, val) => {
      let el = document.querySelector(`meta[property="${prop}"]`);
      if (!el) { el = document.createElement('meta'); el.setAttribute('property', prop); document.head.appendChild(el); }
      el.setAttribute('content', val);
    };
    og('og:title',       m.title);
    og('og:description', m.desc);
    og('og:url',         location.href);
  };

  /* Run the matched handler */
  const _dispatch = (path) => {
    // Run guards first (e.g. auth check)
    for (const guard of _guards) {
      const redirect = guard(path);
      if (redirect && redirect !== path) { Router.go(redirect); return; }
    }

    const handler = _routes[path] || _routes['home'];
    _current = path;

    if (handler) {
      handler(path);
    } else {
      console.warn(`[Router] No handler for "${path}"`);
    }

    _applyMeta(path);
    window.scrollTo({ top: 0, behavior: 'smooth' });

    // Sync nav active state
    document.querySelectorAll('.nav-links a[data-pg]').forEach(a => {
      a.classList.toggle('act', a.dataset.pg === path);
    });
  };

  return {
    /**
     * Register a route handler.
     * @param {string}   path     — route key (matches hash value)
     * @param {Function} handler  — called with (path) on match
     */
    on(path, handler) {
      _routes[path] = handler;
      return this;
    },

    /**
     * Register an array of paths with the same handler.
     */
    many(paths, handler) {
      paths.forEach(p => this.on(p, handler));
      return this;
    },

    /**
     * Register a navigation guard. Return a redirect path to redirect, or falsy to continue.
     */
    guard(fn) {
      _guards.push(fn);
      return this;
    },

    /**
     * Navigate to a route programmatically.
     */
    go(path) {
      const old = location.hash;
      location.hash = path;
      // Force dispatch if hash didn't change (same path clicked again)
      if (old === `#${path}`) _dispatch(path);
    },

    /** Current route key */
    get current() { return _current || _pathFromHash(); },

    /** Start the router — call once on DOMContentLoaded */
    init() {
      window.addEventListener('hashchange', () => _dispatch(_pathFromHash()));
      _dispatch(_pathFromHash());
    },
  };
})();