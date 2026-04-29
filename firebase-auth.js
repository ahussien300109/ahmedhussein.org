/* ─────────────────────────────────────────────
   firebase-auth.js
   Drop-in auth replacements that mirror the
   existing function signatures in app.js.
   Loaded after firebase-config.js and firebase-db.js.
   ───────────────────────────────────────────── */

// ── onAuthStateChanged listener ─────────────────────────────
// Runs on every page load and replaces restoreSession()
window.FB.auth.onAuthStateChanged(async (fbUser) => {
  if (!fbUser) {
    S.user = null;
    S.enrolled = [];
    S.isAdmin = false;
    updateNav(false);
    return;
  }

  // User is signed in — load profile from Firestore
  try {
    const profile = await DB.getUser(fbUser.uid);
    const adminFlag = await DB.isAdmin(fbUser.uid);

    S.user = {
      uid: fbUser.uid,
      email: fbUser.email,
      fname: profile?.fname || '',
      lname: profile?.lname || '',
      phone: profile?.phone || '',
      tier:  profile?.tier  || 'free',
      isAdmin: adminFlag
    };
    S.enrolled = profile?.enrolled || [];
    S.isAdmin  = adminFlag;

    updateNav(true);
    // If dashboard is the current route, refresh it
    if (Router.current === 'dashboard') updateDash();
  } catch (e) {
    console.error('[Auth] profile load failed', e);
    toast('Could not load your profile. Please refresh.', 'err');
  }
});

// ── doLogin (replaces existing function in app.js) ───────────
async function doLogin() {
  const email = document.getElementById('l-email').value.trim();
  const pass  = document.getElementById('l-pass').value;
  const err   = document.getElementById('login-err');
  if (!email || !pass) {
    err.textContent = 'Please fill in all fields.';
    err.classList.add('show');
    return;
  }
  err.classList.remove('show');
  try {
    await window.FB.auth.signInWithEmailAndPassword(email, pass);
    document.getElementById('login-ok').classList.add('show');
    setTimeout(() => {
      closeModal();
      toast('Welcome back!', 'suc');
    }, 900);
  } catch (e) {
    const msg = e.code === 'auth/user-not-found' || e.code === 'auth/wrong-password'
      ? 'Invalid email or password.'
      : 'Login failed. Please try again.';
    err.textContent = msg;
    err.classList.add('show');
  }
}

// ── doRegister (replaces existing function in app.js) ────────
async function doRegister() {
  const fname = document.getElementById('r-fname').value.trim();
  const lname = document.getElementById('r-lname').value.trim();
  const email = document.getElementById('r-email').value.trim();
  const phone = document.getElementById('r-phone').value.trim();
  const pass  = document.getElementById('r-pass').value;
  const err   = document.getElementById('reg-err');

  if (!fname || !email || !pass) {
    err.textContent = 'First name, email and password are required.';
    err.classList.add('show'); return;
  }
  if (!email.includes('@')) {
    err.textContent = 'Please enter a valid email.';
    err.classList.add('show'); return;
  }
  if (pass.length < 8) {
    err.textContent = 'Password must be at least 8 characters.';
    err.classList.add('show'); return;
  }
  err.classList.remove('show');

  try {
    const cred = await window.FB.auth.createUserWithEmailAndPassword(email, pass);
    await DB.createUserProfile(cred.user.uid, {
      fname, lname, email, phone,
      joined: new Date().toLocaleDateString()
    });
    document.getElementById('reg-ok').classList.add('show');
    setTimeout(() => {
      document.getElementById('reg-ok').classList.remove('show');
      switchTab('login');
    }, 1600);
  } catch (e) {
    const msg = e.code === 'auth/email-already-in-use'
      ? 'This email is already registered.'
      : 'Registration failed: ' + e.message;
    err.textContent = msg;
    err.classList.add('show');
  }
}

// ── doLogout (replaces existing function in app.js) ──────────
async function doLogout() {
  await window.FB.auth.signOut();
  S.user = null; S.enrolled = []; S.isAdmin = false;
  updateNav(false);
  showPage('home');
  toast('Logged out successfully.', 'inf');
}

// ── ensureDefaultAdmin (replaces no-op shim) ─────────────────
// Admin is set manually in Firebase Console + Firestore /admins/{uid}
// This function becomes a no-op; kept for compatibility.
function ensureDefaultAdmin() { /* handled by Firebase Console */ }

// ── restoreSession (replaces sessionStorage approach) ─────────
// onAuthStateChanged handles this automatically. Keep as no-op shim.
function restoreSession() { /* handled by onAuthStateChanged above */ }

// ── saveSession (replaces localStorage approach) ──────────────
// No-op: Firestore is the source of truth; profile saved via DB.updateUserProfile()
function saveSession() { /* no-op — Firestore is source of truth */ }
