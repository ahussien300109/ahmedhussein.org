# Firebase Dynamic Course Platform Setup

## Files Created (7 new files)

✅ **firebase-config.js** — Firebase SDK initialization  
✅ **firebase-db.js** — Firestore CRUD operations (courses, lessons, users)  
✅ **firebase-auth.js** — Firebase Auth replacements for login/register/logout  
✅ **firebase-storage.js** — File upload utilities for lesson assets  
✅ **lesson-viewer.js** — Lesson player with video/image/text/file rendering  
✅ **lesson-viewer.css** — Responsive styles for lesson player  
✅ **migrate.js** — One-time migration script (removes after use)  

## Files Modified (2 existing files)

✅ **index.html** — Added Firebase SDK scripts + lesson-viewer.css link  
✅ **app.js** — Replaced localStorage auth + course management with Firebase calls  

---

## Next Steps: Firebase Console Setup

### Step 1: Create Firebase Project
1. Go to **https://console.firebase.google.com**
2. Click "Add project"
3. Project name: `ahmedhussein-org`
4. Skip Google Analytics (optional)
5. Click "Create project"

### Step 2: Enable Services

**Authentication:**
- Click "Authentication" → "Get Started"
- Select "Email/Password"
- Click "Enable"

**Firestore Database:**
- Click "Firestore Database" → "Create Database"
- Start in "Production mode"
- Region: **europe-west1** (Bahrain closest)
- Click "Create"

**Cloud Storage:**
- Click "Storage" → "Get started"
- Accept default rules
- Region: **europe-west1**

### Step 3: Add Security Rules

**Firestore → Rules tab:**
```javascript
rules_version = '2';
service cloud.firestore {
  match /databases/{database}/documents {
    function isSignedIn() {
      return request.auth != null;
    }
    function isAdmin() {
      return isSignedIn() &&
        exists(/databases/$(database)/documents/admins/$(request.auth.uid));
    }
    match /courses/{courseId} {
      allow read: if resource.data.published == true || isAdmin();
      allow create, update, delete: if isAdmin();
      match /lessons/{lessonId} {
        allow read: if isAdmin()
          || resource.data.freePreview == true
          || (isSignedIn() &&
              get(/databases/$(database)/documents/users/$(request.auth.uid))
                .data.enrolled.hasAny([courseId]));
        allow create, update, delete: if isAdmin();
      }
    }
    match /users/{uid} {
      allow read, update: if request.auth.uid == uid || isAdmin();
      allow create: if isSignedIn() && request.auth.uid == uid;
    }
    match /admins/{uid} {
      allow read, write: if isAdmin();
    }
  }
}
```
Click "Publish"

**Storage → Rules tab:**
```javascript
rules_version = '2';
service firebase.storage {
  match /b/{bucket}/o {
    match /lessons/{courseId}/{lessonId}/{fileName} {
      allow read: if true;
      allow write: if request.auth != null
        && exists(/databases/(default)/documents/admins/$(request.auth.uid));
    }
  }
}
```
Click "Publish"

### Step 4: Get Firebase Config

1. Click "Project settings" (⚙ gear icon)
2. Scroll to "Your apps"
3. Click "Web" app (or add if missing)
4. Copy the config object
5. Paste into **firebase-config.js** (replace placeholder):

```javascript
const firebaseConfig = {
  apiKey:            "YOUR_API_KEY",
  authDomain:        "YOUR_PROJECT.firebaseapp.com",
  projectId:         "YOUR_PROJECT",
  storageBucket:     "YOUR_PROJECT.appspot.com",
  messagingSenderId: "YOUR_ID",
  appId:             "1:YOUR_ID:web:YOUR_ID"
};
```

### Step 5: Create Admin Account

1. **Authentication** → "Users" tab
2. Click "Add user"
3. Email: `admin@ahmedhussein.org`
4. Password: **Strong password (save it!)**
5. Click "Add user"
6. **Copy the User UID** (long string)

Now create admin document in Firestore:
1. **Firestore** → Click "+" to start collection
2. Collection ID: `admins`
3. Document ID: **Paste the UID**
4. Field: `email` (string) = `admin@ahmedhussein.org`
5. Click "Save"

### Step 6: Authorize GitHub Pages Domain

1. **Authentication** → "Settings" tab
2. Scroll to "Authorized domains"
3. Click "Add domain"
4. Enter: `ahussien300109.github.io`
5. (If using custom domain `ahmedhussein.org`, add that too)

---

## Step 7: Deploy to GitHub

```bash
# Stage all changes
git add firebase-config.js firebase-db.js firebase-auth.js \
        firebase-storage.js lesson-viewer.js lesson-viewer.css \
        migrate.js index.html app.js FIREBASE_SETUP.md

# Commit
git commit -m "Add Firebase dynamic course platform

- Firebase Auth for secure authentication
- Firestore for course/lesson storage
- Firebase Storage for media uploads
- Admin dashboard with CRUD
- Lesson viewer with video/image/text/file support
- One-time migration script for existing courses"

# Push
git push origin main
```

GitHub Pages will automatically deploy to `https://ahussien300109.github.io/ahmedhussein.org/`

---

## Step 8: Run One-Time Migration

1. **Visit the live site**
2. **Login as admin** (admin@ahmedhussein.org + password)
3. **Open browser DevTools** (F12)
4. **Go to Console tab**
5. **Run:**
   ```javascript
   migrateCoursesToFirestore()
   ```
6. **Watch console** for completion messages
7. **Verify** in Firebase Console → Firestore that 6 courses appear

### After Migration:
- Remove `<script src="migrate.js"></script>` from `index.html`
- `git add index.html`
- `git commit -m "Remove migration script after one-time use"`
- `git push origin main`

---

## Verification Checklist

- [ ] Firebase project created
- [ ] Authentication enabled
- [ ] Firestore database created
- [ ] Storage bucket created
- [ ] Security rules published (Firestore + Storage)
- [ ] Firebase config copied to firebase-config.js
- [ ] Admin account created in Firebase
- [ ] Admin UID added to /admins/{uid} document
- [ ] GitHub Pages domain authorized
- [ ] Code pushed to main branch
- [ ] Live site accessible at GitHub Pages URL
- [ ] Login works (test with admin credentials)
- [ ] Migration script runs successfully
- [ ] 6 courses appear in Firestore console
- [ ] Course grid renders on homepage
- [ ] Enrolled courses appear in dashboard
- [ ] Lesson viewer loads for free-preview lessons
- [ ] File upload works in admin dashboard (after enhancement)

---

## Troubleshooting

**"Cannot find DB" error:**
- Ensure firebase-config.js is loaded before firebase-db.js
- Check script load order in index.html

**Firebase config shows as placeholder:**
- Copy exact config from Firebase Console
- No need to add quotes around values

**Courses not loading:**
- Check browser console for errors
- Verify Firestore collection exists
- Confirm published = true on courses

**Login fails with "Invalid domain":**
- Add your domain to Firebase Auth → Authorized domains
- Wait 5 minutes for changes to propagate

**Migration script not found:**
- Confirm migrate.js loaded in index.html
- Reload page after ensuring admin is logged in

---

## Firestore Schema Reference

### /courses/{slug}
```
id: "ccna-200-301"
cat: "CCNA"
icon: "🌐"
title: "CCNA 200-301: Complete Network Associate"
desc: "..."
level: "Beginner"
duration: "80 hrs"
price: "$149"
rating: "4.9"
reviews: 128
students: 420
published: true
lessonCount: 9
createdAt: Timestamp
updatedAt: Timestamp
```

### /courses/{slug}/lessons/{id}
```
order: 1
title: "Networking Fundamentals"
type: "text" | "video" | "image" | "file"
content: "..." (for text type)
videoUrl: "..." (for video type)
imageUrl: "..." (for image type)
fileUrl: "..." (for file type)
fileName: "..." (for file type)
freePreview: true | false
createdAt: Timestamp
updatedAt: Timestamp
```

### /users/{uid}
```
fname: "John"
lname: "Doe"
email: "john@example.com"
phone: "+1234567890"
tier: "free" | "premium"
enrolled: ["ccna-200-301", "ccnp-encor"]
progress: {
  "ccna-200-301": {
    "lesson-id-1": true,
    "lesson-id-2": true
  }
}
joined: Timestamp
updatedAt: Timestamp
```

### /admins/{uid}
```
email: "admin@ahmedhussein.org"
addedAt: Timestamp
```

---

## Next: Enhanced Admin Dashboard

The lesson editor in the admin dashboard is a TODO. Current implementation supports basic course CRUD. To add lesson management:

1. **In renderDashboard():** Update the lesson list rendering to show rich form fields per type
2. **In firebase-db.js:** saveLesson() and deleteLesson() already exist
3. **In firebase-storage.js:** uploadLessonFile() ready for file uploads
4. **Event handlers:** Add onchange handlers for lesson type selector to show/hide content fields

The [lesson-viewer.js](lesson-viewer.js) is fully implemented and ready to render all lesson types.

---

**Questions?** Check the [plan file](../plans/serialized-beaming-fox.md) for architecture details.
