/* ═════════════════════════════════════════════════════════════════
   api.js — Supabase REST backend (no SDK, pure fetch)
   ─────────────────────────────────────────────────────────────────
   SUPABASE SETUP (run once in SQL Editor):
   ──────────────────────────────────────────
   create table courses (
     id          uuid primary key default gen_random_uuid(),
     title       text not null,
     description text,
     price       text default 'Free',
     level       text default 'Beginner',
     category    text default 'CCNA',
     duration    text default '0 hrs',
     icon        text default '🌐',
     students    integer default 0,
     rating      numeric default 5.0,
     created_at  timestamptz default now()
   );

   create table lessons (
     id          uuid primary key default gen_random_uuid(),
     course_id   uuid references courses(id) on delete cascade,
     title       text not null,
     content     text,
     order_index integer default 0,
     duration    text default '5 min',
     created_at  timestamptz default now()
   );

   -- Public read
   alter table courses enable row level security;
   alter table lessons  enable row level security;
   create policy "public_read_courses" on courses for select using (true);
   create policy "public_read_lessons" on lessons  for select using (true);

   -- Authenticated write (admin only)
   create policy "auth_write_courses" on courses for all
     using (auth.role() = 'authenticated');
   create policy "auth_write_lessons" on lessons for all
     using (auth.role() = 'authenticated');
   ───────────────────────────────────────────────────────────────── */

const SUPABASE_URL      = '';  // Leave empty to use local-only mode
const SUPABASE_ANON_KEY = '';  // Leave empty to use local-only mode

/* ── Internal HTTP layer ──────────────────────────────────────── */
const _http = (() => {
  let _session = null;
  
  // If no Supabase credentials, return mock responses
  if (!SUPABASE_URL || !SUPABASE_ANON_KEY || SUPABASE_URL.includes('YOUR_PROJECT')) {
    console.log('[API] Running in local-only mode (no Supabase credentials)');
    return {
      get:  async () => [],
      post: async () => null,
      patch:async () => null,
      del:  async () => null,
      setSession: () => {},
      getSession: () => null,
    };
  }
  
  const request = async (path, opts = {}) => {
    const headers = {
      apikey: SUPABASE_ANON_KEY,
      'Content-Type': 'application/json',
      ...opts.headers,
    };
    if (_session?.access_token) {
      headers.Authorization = `Bearer ${_session.access_token}`;
    }
    const res = await fetch(SUPABASE_URL + path, { ...opts, headers });
    if (res.status === 204) return null;
    const body = await res.json();
    if (!res.ok) {
      throw new Error(body.message || body.error_description || `HTTP ${res.status}`);
    }
    return body;
  };

  return {
    get:  (path, h = {}) => request(path, { headers: { Accept: 'application/json', ...h } }),
    post: (path, data, h = {}) => request(path, { method: 'POST', body: JSON.stringify(data), headers: h }),
    patch:(path, data, h = {}) => request(path, { method: 'PATCH', body: JSON.stringify(data), headers: h }),
    del:  (path) => request(path, { method: 'DELETE' }),
    setSession: (s) => { _session = s; },
    getSession: () => _session,
  };
})();

/* ══════════════════════════════════════════════════════════════════
   AUTH
   ══════════════════════════════════════════════════════════════════ */
const Auth = {
  /** Sign in with email + password. */
  async signIn(email, password) {
    const data = await _http.post(
      '/auth/v1/token?grant_type=password',
      { email, password }
    );
    _http.setSession(data);
    sessionStorage.setItem('_sb_sess', JSON.stringify(data));
    return data.user;
  },

  /** Sign out and clear session. */
  async signOut() {
    try { await _http.post('/auth/v1/logout', {}); } catch (_) {}
    _http.setSession(null);
    sessionStorage.removeItem('_sb_sess');
  },

  /** Restore session from sessionStorage on page load. */
  restore() {
    try {
      const raw = sessionStorage.getItem('_sb_sess');
      if (!raw) return null;
      const sess = JSON.parse(raw);
      /* Reject expired tokens */
      if (sess?.expires_at && Date.now() / 1000 > sess.expires_at) {
        sessionStorage.removeItem('_sb_sess');
        return null;
      }
      _http.setSession(sess);
      return sess.user;
    } catch (_) { return null; }
  },

  get user() { return _http.getSession()?.user || null; },
  get isAdmin() { return !!_http.getSession()?.user; },
};

/* ══════════════════════════════════════════════════════════════════
   COURSES
   ══════════════════════════════════════════════════════════════════ */
const Courses = {
  /** Fetch all courses ordered by creation date. */
  list() {
    return _http.get('/rest/v1/courses?order=created_at.desc');
  },

  /** Fetch one course with its lessons. */
  async get(id) {
    const rows = await _http.get(
      `/rest/v1/courses?id=eq.${id}&select=*,lessons(*)&lessons.order=order_index.asc`
    );
    return rows?.[0] ?? null;
  },

  /** Create a course. Returns the new row. */
  create(data) {
    return _http.post('/rest/v1/courses', data, {
      Prefer: 'return=representation',
    }).then(r => r?.[0]);
  },

  /** Update a course by id. Returns the updated row. */
  update(id, data) {
    return _http.patch(`/rest/v1/courses?id=eq.${id}`, data, {
      Prefer: 'return=representation',
    }).then(r => r?.[0]);
  },

  /** Delete a course (cascades to lessons via FK). */
  delete(id) {
    return _http.del(`/rest/v1/courses?id=eq.${id}`);
  },
};

/* ══════════════════════════════════════════════════════════════════
   LESSONS
   ══════════════════════════════════════════════════════════════════ */
const Lessons = {
  /** List lessons for a course, ordered. */
  list(courseId) {
    return _http.get(
      `/rest/v1/lessons?course_id=eq.${courseId}&order=order_index.asc`
    );
  },

  /** Create a lesson. Returns the new row. */
  create(data) {
    return _http.post('/rest/v1/lessons', data, {
      Prefer: 'return=representation',
    }).then(r => r?.[0]);
  },

  /** Update a lesson. Returns the updated row. */
  update(id, data) {
    return _http.patch(`/rest/v1/lessons?id=eq.${id}`, data, {
      Prefer: 'return=representation',
    }).then(r => r?.[0]);
  },

  /** Delete a lesson. */
  delete(id) {
    return _http.del(`/rest/v1/lessons?id=eq.${id}`);
  },

  /**
   * Reorder lessons by updating each order_index.
   * @param {string[]} orderedIds  — lesson ids in desired order
   */
  reorder(orderedIds) {
    return Promise.all(
      orderedIds.map((id, idx) =>
        _http.patch(`/rest/v1/lessons?id=eq.${id}`, { order_index: idx }, {
          Prefer: 'return=minimal',
        })
      )
    );
  },
};

/* ── Public API ─────────────────────────────────────────────────── */
const Api = { Auth, Courses, Lessons };
