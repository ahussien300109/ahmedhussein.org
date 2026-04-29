# Ahmed Hussein — Cisco Instructor Website
## Complete Deployment Guide

---

## 📁 FILE STRUCTURE

```
ahmedhussein/
├── index.html          ← Main website (all pages)
├── 404.html            ← Error page
├── css/
│   ├── style.css       ← Base styles, variables, components
│   ├── hero.css        ← Hero section & homepage sections
│   └── pages.css       ← Courses, About, Contact, Dashboard
└── js/
    └── app.js          ← All JavaScript logic & course data
```

---

## 🚀 DEPLOYMENT — STEP BY STEP

### Option A: cPanel / Shared Hosting (Recommended)
1. Open your cPanel → File Manager
2. Navigate to `public_html/`
3. Upload ALL files maintaining the folder structure:
   - `index.html` → `public_html/index.html`
   - `404.html` → `public_html/404.html`
   - `css/` folder → `public_html/css/`
   - `js/` folder → `public_html/js/`
4. Your site is live at `http://yourdomain.com`

### Option B: FTP Upload
1. Connect with FileZilla or similar FTP client
2. Host: your domain or IP
3. Username/Password: from your hosting panel
4. Navigate to `public_html/` or `www/`
5. Upload all files maintaining folder structure

### Option C: Netlify (Free, Fast)
1. Go to https://netlify.com → Sign up free
2. Drag and drop the `ahmedhussein/` folder onto Netlify
3. Your site is instantly live on a Netlify URL
4. Add custom domain: Site settings → Domain management

### Option D: GitHub Pages (Free)
1. Create a GitHub account
2. New repository: `ahmedhussein.github.io`
3. Upload all files to the repo
4. Settings → Pages → Branch: main
5. Live at `https://ahmedhussein.github.io`

---

## ⚙️ CUSTOMIZATION GUIDE

### 1. Update Contact Details
Edit `index.html` — search for and replace:
- `ahmed@ahmedhussein.org` → your email
- `+973 XXXX XXXX` → your phone number
- `Manama, Kingdom of Bahrain` → your location

### 2. Add Your Photo
Replace the emoji `👨‍💻` in the About section with:
```html
<img src="images/ahmed-hussein.jpg" alt="Ahmed Hussein" style="width:100%;height:100%;object-fit:cover">
```
Upload your photo to the `images/` folder.

### 3. Update Social Media Links
In `index.html`, find all `href="#"` on social buttons and replace with real URLs:
```html
<a href="https://linkedin.com/in/your-profile" class="social-btn">
```

### 4. Add / Edit Courses
Open `js/app.js` and edit the `COURSES` array at the top:
```javascript
{
  id: 7,                          // Unique ID
  cat: 'CCNA',                    // Category: CCNA, CCNP, Security, Labs
  icon: '🌐',                     // Emoji icon
  thumb: 'thumb-1',               // CSS class for card background
  title: 'Your Course Title',
  desc: 'Short description...',
  level: 'Beginner',              // Beginner | Intermediate | Advanced
  duration: '40 hrs',
  students: '0',
  price: '$99',                   // or 'Free'
  rating: '4.8',
  reviews: '0',
  prereqs: 'Prerequisites here',
  objectives: ['What students will learn...'],
  curriculum: ['Module 1', 'Module 2', ...]
}
```

### 5. Customize Colors
Open `css/style.css` and modify CSS variables at the top:
```css
:root {
  --cisco-blue: #049fd9;    /* Primary blue */
  --accent: #ff6b35;        /* Orange accent */
  --bg: #070d1a;            /* Main background */
}
```

---

## 🔐 AUTHENTICATION SYSTEM

The site uses browser localStorage for user data storage — perfect for a static hosting site.

**How it works:**
- Users register → data stored in browser localStorage
- Login checks stored credentials
- Session persists via sessionStorage during the visit
- Enrolled courses are saved per user

**For production (real backend):**
Replace the `doLogin()` and `doRegister()` functions in `app.js` with API calls:
```javascript
// Replace localStorage logic with:
const response = await fetch('/api/login', {
  method: 'POST',
  body: JSON.stringify({ email, password }),
  headers: { 'Content-Type': 'application/json' }
});
```

---

## 📧 CONTACT FORM — REAL EMAILS

To make the contact form actually send emails, use one of:

### Formspree (Free, no backend needed)
1. Go to https://formspree.io → Create account
2. Create a new form → Get your form ID (e.g., `xyzabcde`)
3. In `app.js`, update `sendContact()`:
```javascript
async sendContact() {
  const data = {
    fname: document.getElementById('contact-fname').value,
    email: document.getElementById('contact-email').value,
    message: document.getElementById('contact-msg').value,
  };
  await fetch('https://formspree.io/f/YOUR_FORM_ID', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
  });
  // show success...
}
```

### EmailJS (Free, no backend)
1. https://emailjs.com → Create account & connect your Gmail
2. Add their SDK: `<script src="https://cdn.jsdelivr.net/npm/@emailjs/browser@3/dist/email.min.js"></script>`
3. Call `emailjs.send()` in your contact function

---

## 📊 GOOGLE ANALYTICS

Add before `</head>` in `index.html`:
```html
<script async src="https://www.googletagmanager.com/gtag/js?id=G-XXXXXXXXXX"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'G-XXXXXXXXXX'); // Replace with your GA4 ID
</script>
```

---

## 💬 LIVE CHAT (Tawk.to — Free)

1. Go to https://tawk.to → Create account
2. Add your website → Get your embed code
3. Paste before `</body>` in `index.html`

---

## 🎨 ADDING YOUR REAL PHOTO

1. Create an `images/` folder
2. Name your photo `ahmed.jpg` (800×1000px recommended)
3. In `index.html`, find `👨‍💻` emoji in About section and replace with:
```html
<img src="images/ahmed.jpg" alt="Ahmed Hussein" style="width:100%;height:100%;object-fit:cover;border-radius:20px">
```

---

## ✅ PRE-LAUNCH CHECKLIST

- [ ] Replace placeholder phone/email
- [ ] Add real social media links
- [ ] Upload your professional photo
- [ ] Update instructor certifications if needed
- [ ] Connect contact form to real email (Formspree)
- [ ] Add Google Analytics
- [ ] Set up SSL certificate (most hosts provide free via Let's Encrypt)
- [ ] Test on mobile devices
- [ ] Test all navigation links
- [ ] Add favicon: `<link rel="icon" href="images/favicon.ico">`

---

## 📞 SUPPORT

For questions about deployment or customization, contact:
ahmed@ahmedhussein.org
