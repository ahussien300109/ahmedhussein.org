/* ─────────────────────────────────────────────
   firebase-config.js
   Initialize Firebase app once. All other
   firebase-*.js files import from window.FB.
   ───────────────────────────────────────────── */

// Replace all values below with your actual Firebase project config
// (Firebase Console → Project Settings → Your apps → SDK setup)
const firebaseConfig = {
  apiKey:            "AIzaSyDreEDEhUGyaq3mXvLJXy5YbceGCNYuDB4",
  authDomain:        "ahmedhussein-org.firebaseapp.com",
  projectId:         "ahmedhussein-org",
  storageBucket:     "ahmedhussein-org.firebasestorage.app",
  messagingSenderId: "23169433242",
  appId:             "1:23169433242:web:c93d263637522f82ba2923"
};

// Initialise the app — guard against double-init (HMR / dev reload)
const _fbApp = firebase.apps?.length
  ? firebase.app()
  : firebase.initializeApp(firebaseConfig);

// Expose SDK handles on a single global so all files share one instance
window.FB = {
  app:     _fbApp,
  auth:    firebase.auth(),
  db:      firebase.firestore(),
  storage: firebase.storage(),
};

console.log('[Firebase] initialised project:', firebaseConfig.projectId);
