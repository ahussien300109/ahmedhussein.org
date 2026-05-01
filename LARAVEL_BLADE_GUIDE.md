# Laravel Blade LMS UI Architecture Guide

## Overview
Your LMS is built with **Laravel 11**, **Blade templating**, and a **custom dark theme** matching your static website design. This guide explains the complete architecture and how to reuse/extend components.

---

## 📁 Project Structure

```
resources/views/
├── layouts/
│   └── app.blade.php              # Master layout (navbar, footer, auth)
├── welcome.blade.php              # Home page (hero, features, testimonials, faq, pricing)
├── courses/
│   ├── index.blade.php            # Course listing page
│   ├── show.blade.php             # Course detail + lessons + labs
│   ├── create.blade.php           # Create course form (admin)
│   └── edit.blade.php             # Edit course form (admin)
├── lessons/
│   ├── create.blade.php           # Create lesson form
│   └── edit.blade.php             # Edit lesson form
├── about.blade.php                # About instructor page
├── contact.blade.php              # Contact form page
├── auth/
│   └── login.blade.php            # Login form
├── admin/
│   └── dashboard.blade.php        # Admin dashboard
└── student/
    └── my-learning.blade.php      # Student progress page

public/css/
├── style.css                      # Color scheme & theme variables
├── hero.css                       # Animations & hero effects
├── pages.css                      # Page-specific styles
└── dashboard.css                  # Admin dashboard styles
```

---

## 🎨 Design System

### Color Variables (CSS)
Defined in `public/css/style.css` as CSS custom properties:

```css
:root {
  /* Primary Colors */
  --c: #00d4ff;          /* Electric cyan (primary) */
  --c2: #0099cc;         /* Cyan mid-tone */
  --c3: #005577;         /* Cyan deep */
  --o: #ff6a00;          /* Neon orange (accent) */
  --o2: #ff9a40;         /* Orange light */
  --g: #00ff88;          /* Green (success) */
  
  /* Backgrounds */
  --bg: #030d1a;         /* Deepest navy (main) */
  --bg1: #060f20;        /* Navy L1 */
  --bg2: #080e1c;        /* Navy L2 */
  --bg3: #0c1628;        /* Navy L3 */
  --bg4: #101e38;        /* Navy L4 */
  --bg5: #142240;        /* Navy L5 */
  --card: #0a1525;       /* Card background */
  
  /* Text */
  --t: #c8ddf0;          /* Body text (light) */
  --tm: #7a9ab5;         /* Text muted */
  --tw: #ffffff;         /* Text white */
  
  /* Borders & Radius */
  --bdr: rgba(0,212,255,0.15);    /* Border color */
  --bdr2: rgba(0,212,255,0.3);    /* Border hover */
  --r: 10px;             /* Border radius S */
  --r2: 16px;            /* Border radius M */
  --r3: 22px;            /* Border radius L */
}

/* Light mode variant */
[data-theme="light"] {
  --bg: #f5f7fa;
  --t: #1e293b;
  --c: #0062cc;
  /* ... light mode overrides */
}
```

### Typography
```css
/* Headings */
font-family: 'Orbitron', monospace;
font-weight: 700;

/* Body Text */
font-family: 'Exo 2', sans-serif;
font-weight: 400-600;
```

---

## 🏗️ Master Layout: `app.blade.php`

The master layout provides:
- **Navbar** with logo, navigation, auth buttons
- **Auth Modal** for login/register
- **Toast notifications**
- **Footer** with social links and site info
- **Circuit background animation**
- **Custom cursor**
- **Scroll progress indicator**
- **Theme toggle (dark/light mode)**

### Key Sections:

#### 1. **Navigation Bar**
```blade
<nav id="nav">
  <div class="nav-inner">
    <a href="/" class="nav-logo">
      <!-- Hexagon logo with "AH" initials -->
    </a>
    <ul class="nav-links">
      <li><a href="/" data-pg="home">Home</a></li>
      <li><a href="{{ route('courses.index') }}" data-pg="courses">Courses</a></li>
      <li><a href="{{ route('about') }}" data-pg="about">About</a></li>
      <li><a href="{{ route('contact') }}" data-pg="contact">Contact</a></li>
    </ul>
    <!-- Auth buttons (Login/Register or Admin/Logout) -->
  </div>
</nav>
```

**Styling Features:**
- Sticky on scroll
- Glassmorphism effect (semi-transparent with blur)
- Active link detection using `request()->path()`
- Responsive hamburger menu on mobile

#### 2. **Authentication Modal**
```blade
<div class="modal-ov" id="auth-modal" style="display:none">
  <div class="modal-box">
    <!-- Login form: email + password -->
  </div>
</div>
```

**JavaScript Controls:**
```javascript
function openLoginModal()  { /* show modal */ }
function closeLoginModal() { /* hide modal */ }
function toggleTheme()     { /* switch dark/light */ }
```

#### 3. **Footer**
```blade
<footer id="site-footer">
  <div class="footer-grid">
    <!-- Brand section with social links -->
    <!-- Courses links -->
    <!-- Navigation links -->
    <!-- Contact info -->
  </div>
</footer>
```

#### 4. **Animations**
- **Circuit grid background**: Animated grid lines that drift
- **Particles**: Floating circles with fade animation
- **Cursor**: Custom cursor with ring effect
- **Scroll progress**: Top progress bar

---

## 📄 Page Templates

### 1. **Home Page** (`welcome.blade.php`)

**Sections:**
- **Hero**: Title, subtitle, CTA buttons, stats
- **Features**: 4 key benefits (Labs, Curriculum, Progress, Certs)
- **Testimonials**: 3 student reviews with ratings
- **Pricing**: Free vs Premium tier comparison
- **FAQ**: 6 expandable questions with answers
- **Final CTA**: "Ready to Master Cisco Networking?"

**Component Example - Hero:**
```blade
<section class="hero">
  <div class="hero-inner">
    <div>
      <h1 class="hero-h1">
        <span>Master</span><br>
        <span class="line2">Cisco Network</span><br>
        <span class="line3">Certifications</span>
      </h1>
      <p class="hero-sub">Expert-led courses built for real-world engineering...</p>
      <div class="hero-btns">
        <a href="{{ route('courses.index') }}" class="hbtn hbtn-primary">
          <i class="fas fa-book"></i> Explore Courses
        </a>
      </div>
    </div>
    <!-- Certificate showcase on right -->
  </div>
</section>
```

**Styling:**
```css
.hero {
  min-height: 100vh;
  background: radial-gradient(circle, rgba(0,212,255,0.1) 0%, transparent 70%);
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 4rem;
}

.hero-h1 {
  font-size: clamp(2.5rem, 5vw, 3.5rem);
  color: var(--tw);
}

.hero-h1 .line2 { color: var(--c); text-shadow: 0 0 30px rgba(0,212,255,0.5); }
.hero-h1 .line3 { color: var(--o); text-shadow: 0 0 30px rgba(255,106,0,0.4); }
```

### 2. **Courses Index** (`courses/index.blade.php`)

**Features:**
- Grid of course cards (4 columns on desktop)
- Badge system (Free/Premium, Hot/New)
- Rating display with star icons
- Price, duration, level, student count
- Action buttons (View, Edit, Delete)

**Card Component:**
```blade
<div class="course-card">
  <div class="course-image">
    @if($course->image)
      <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}">
    @else
      <div>{{ $course->title }}</div>
    @endif
  </div>
  <div class="course-body">
    <div class="course-badge-row">
      <span class="course-badge {{ $course->is_free ? 'free' : 'premium' }}">
        {{ $course->is_free ? 'FREE' : 'PREMIUM' }}
      </span>
      @if($course->badge)
        <span class="course-badge {{ $course->badge }}">{{ ucfirst($course->badge) }}</span>
      @endif
    </div>
    
    <h3 class="course-title">{{ $course->title }}</h3>
    <p class="course-desc">{{ Str::limit($course->description, 100) }}</p>
    
    @if($course->rating)
      <div class="course-rating">
        <span class="stars">★ {{ number_format($course->rating, 1) }}</span>
        ({{ $course->review_count }} reviews)
      </div>
    @endif
    
    @if($course->price > 0)
      <div class="course-price">${{ number_format($course->price, 0) }}</div>
    @endif
    
    <div class="course-meta-row">
      <span><i class="fas fa-clock"></i> {{ $course->duration }}</span>
      <span><i class="fas fa-graduation-cap"></i> {{ $course->level }}</span>
      <span><i class="fas fa-users"></i> {{ $course->student_count }} students</span>
    </div>
    
    <div class="course-actions">
      <a href="{{ route('courses.show', $course) }}" class="course-btn solid">View</a>
    </div>
  </div>
</div>
```

**CSS:**
```css
.course-card {
  border: 1px solid var(--c);
  border-radius: 10px;
  background: var(--card);
  transition: all 0.3s ease;
  overflow: hidden;
}

.course-card:hover {
  transform: translateY(-10px);
  box-shadow: 0 0 30px rgba(0,212,255,0.2);
  border-color: var(--c);
}

.course-image {
  height: 200px;
  background: linear-gradient(135deg, var(--c) 0%, #00ff88 100%);
}

.course-badge {
  display: inline-block;
  padding: 0.35rem 0.7rem;
  border-radius: 4px;
  font-size: 0.7rem;
  font-weight: 700;
  text-transform: uppercase;
}

.course-badge.free {
  background: rgba(0, 255, 136, 0.15);
  color: #00ff88;
  border: 1px solid rgba(0, 255, 136, 0.3);
}

.course-badge.premium {
  background: rgba(255, 106, 0, 0.15);
  color: #ff6a00;
  border: 1px solid rgba(255, 106, 0, 0.3);
}
```

### 3. **Course Detail** (`courses/show.blade.php`)

**Features:**
- Course header with title, rating, duration, level
- Course image/placeholder
- Description & prerequisites
- Curriculum (topics list)
- Lessons section with expand/collapse
- **Hands-on Labs** with expandable tasks and configs
- Enrollment CTA button
- Sidebar with course stats

**Lab Component:**
```blade
<!-- LABS SECTION -->
@if($course->labs && $course->labs->count() > 0)
  <h3 class="section-title">Hands-On Labs</h3>
  
  @php
    $labsByCategory = $course->labs->groupBy('category');
  @endphp
  
  @foreach($labsByCategory as $category => $labs)
    <div class="lab-category">
      <div class="lab-category-title">
        <i class="lab-category-icon fas fa-network-wired"></i>
        {{ $category }}
      </div>
      
      @foreach($labs as $lab)
        <div class="lab-item" onclick="toggleLab(this)">
          <div class="lab-header">
            <div class="lab-number">{{ $lab->number }}</div>
            <div class="lab-title-section">
              <h4 class="lab-title">{{ $lab->title }}</h4>
              <p class="lab-desc">{{ $lab->description }}</p>
            </div>
            <i class="lab-expand-icon fas fa-chevron-down"></i>
          </div>
          
          <div class="lab-content">
            @if($lab->tasks)
              <div class="lab-tasks">
                <div class="lab-tasks-title">Lab Tasks:</div>
                <ul class="lab-task-list">
                  @php $tasks = json_decode($lab->tasks, true) ?? []; @endphp
                  @foreach($tasks as $task)
                    <li>{{ $task }}</li>
                  @endforeach
                </ul>
              </div>
            @endif
            
            @if($lab->config_examples)
              <div>
                <div class="lab-config-title">Configuration Examples:</div>
                @php $configs = json_decode($lab->config_examples, true) ?? []; @endphp
                @foreach($configs as $config)
                  <div class="lab-config">{{ $config }}</div>
                @endforeach
              </div>
            @endif
          </div>
        </div>
      @endforeach
    </div>
  @endforeach
@endif
```

**Lab Styling:**
```css
.lab-item {
  border: 1px solid var(--bdr);
  border-radius: 10px;
  padding: 1.5rem;
  background: var(--card);
  transition: all 0.3s;
  cursor: pointer;
}

.lab-item:hover {
  border-color: var(--c);
  box-shadow: 0 0 20px rgba(0,212,255,0.1);
}

.lab-header {
  display: flex;
  align-items: flex-start;
  gap: 1rem;
}

.lab-number {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  background: linear-gradient(135deg, #00ff88, var(--c));
  color: var(--bg);
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
  flex-shrink: 0;
}

.lab-config {
  background: rgba(0,212,255,0.05);
  border: 1px solid rgba(0,212,255,0.2);
  border-radius: 8px;
  padding: 1rem;
  font-family: 'Courier New', monospace;
  font-size: 0.8rem;
  color: #00ff88;
  overflow-x: auto;
  margin-top: 0.75rem;
}
```

### 4. **About Page** (`about.blade.php`)

**Sections:**
- Page header with gradient text
- Instructor bio with stats (10+ years, 1200+ students, 96% pass rate)
- Credentials grid (6 certifications)
- Technical expertise section (6 skills)
- CTA to courses

**Structure:**
```blade
<!-- CREDENTIALS -->
<div class="creds-grid">
  <div class="cred-card">
    <div class="cred-icon"><i class="fas fa-certificate"></i></div>
    <div class="cred-name">CCNA 200-301</div>
    <div class="cred-desc">Complete networking fundamentals and routing/switching</div>
  </div>
  <!-- More credential cards -->
</div>

<!-- EXPERTISE -->
<div class="skills-grid">
  <div class="skill-item">
    <div class="skill-icon"><i class="fas fa-network-wired"></i></div>
    <div class="skill-info">
      <div class="skill-name">Routing & Switching</div>
      <div class="skill-desc">OSPF, BGP, EIGRP, VLANs, Spanning Tree</div>
    </div>
  </div>
  <!-- More skill items -->
</div>
```

### 5. **Contact Page** (`contact.blade.php`)

**Features:**
- Contact form (name, email, subject, message)
- Info cards (email, phone, location, WhatsApp)
- WhatsApp direct link integration
- "Why Choose Us" section with 4 benefits

**Form Component:**
```blade
<form action="#" method="POST">
  <div class="form-group">
    <label for="name">Your Name *</label>
    <input type="text" id="name" name="name" required>
  </div>
  
  <div class="form-group">
    <label for="email">Your Email *</label>
    <input type="email" id="email" name="email" required>
  </div>
  
  <button type="submit" class="form-submit">
    <i class="fas fa-paper-plane"></i> Send Message
  </button>
</form>

<!-- Info Cards -->
<div class="info-card">
  <div class="info-icon"><i class="fas fa-envelope"></i></div>
  <div class="info-title">Email</div>
  <div class="info-content">
    <a href="mailto:info@ahmedhussein.org">info@ahmedhussein.org</a>
  </div>
</div>

<!-- WhatsApp Link -->
<a href="https://wa.me/97332198505?text=Hello%20Ahmed" target="_blank" class="whatsapp-btn">
  <i class="fab fa-whatsapp"></i> WhatsApp
</a>
```

---

## 🔧 Admin Dashboard (`admin/dashboard.blade.php`)

**Features:**
- Stats overview (courses, students, enrollments)
- Recent activity log
- Course management table
- Student list
- Responsive layout

**Admin Table Component:**
```blade
<div class="adm-tbl">
  <div class="adm-tbl-hdr">
    <span>Course</span>
    <span>Students</span>
    <span>Status</span>
  </div>
  
  @foreach($courses as $course)
    <div class="adm-tbl-row">
      <span class="adm-course-name">
        <i class="fas fa-book"></i>
        <span>{{ $course->title }}</span>
      </span>
      <span>{{ $course->enrollments->count() }}</span>
      <span class="lvl-tag">{{ $course->is_free ? 'Free' : 'Premium' }}</span>
    </div>
  @endforeach
</div>
```

---

## 🔄 How to Reuse HTML/CSS in New Pages

### Step 1: Create a New Blade Template
```blade
@extends('layouts.app')

@section('title', 'Page Title')

@section('content')
<style>
  /* Page-specific styles */
  .my-section {
    padding: 3rem 2rem;
    background: var(--bg2);
  }
</style>

<!-- Page content here -->
@endsection
```

### Step 2: Use CSS Variables
Always use CSS variables from `:root` for consistency:
```css
/* ✓ GOOD - Uses variables */
background: var(--card);
border: 1px solid var(--bdr);
color: var(--t);

/* ✗ BAD - Hardcoded colors */
background: #0a1525;
border: 1px solid rgba(0,212,255,0.15);
```

### Step 3: Apply Standard Patterns
**Button Pattern:**
```css
.btn {
  padding: 0.75rem 1.5rem;
  border-radius: 8px;
  border: 2px solid var(--bdr);
  background: transparent;
  color: var(--c);
  font-weight: 600;
  transition: all 0.3s;
  cursor: pointer;
}

.btn:hover {
  background: var(--c);
  color: var(--bg);
}

.btn.primary {
  background: linear-gradient(135deg, var(--c), var(--c2));
  color: var(--bg);
  border-color: var(--c);
}
```

**Card Pattern:**
```css
.card {
  border: 1px solid var(--bdr);
  border-radius: 10px;
  padding: 1.5rem;
  background: var(--card);
  transition: all 0.3s;
}

.card:hover {
  border-color: var(--c);
  box-shadow: 0 0 20px rgba(0,212,255,0.1);
  transform: translateY(-4px);
}
```

**Grid Layout:**
```css
.grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 2rem;
}

@media (max-width: 768px) {
  .grid {
    grid-template-columns: 1fr;
  }
}
```

### Step 4: Component Pattern
Create reusable Blade components in `resources/views/components/`:

```bash
# Example: Card component
resources/views/components/card.blade.php
```

```blade
<!-- card.blade.php -->
<div class="card">
  <h3>{{ $title }}</h3>
  <p>{{ $slot }}</p>
  @if($action)
    <a href="{{ $action['url'] }}" class="btn primary">{{ $action['text'] }}</a>
  @endif
</div>
```

**Usage:**
```blade
<x-card title="Learn Networking">
  Comprehensive CCNA courses with hands-on labs
  :action="['url' => route('courses.show', $course), 'text' => 'Enroll Now']"
</x-card>
```

---

## 📱 Responsive Design

### Breakpoints
```css
/* Desktop: 1200px+ */
@media (max-width: 1024px) {
  /* Tablet adjustments */
}

@media (max-width: 768px) {
  /* Mobile adjustments */
  .grid { grid-template-columns: 1fr; }
  .hero-inner { grid-template-columns: 1fr; }
}

@media (max-width: 640px) {
  /* Small mobile adjustments */
  .hero { padding: 1rem; }
  .btn { width: 100%; }
}
```

---

## 🎬 Animations

### Keyframe Animations
```css
@keyframes shimmer {
  from { background-position: 0% 0%; }
  to { background-position: 200% 0%; }
}

@keyframes floatUpDown {
  0%, 100% { transform: translateY(0px); }
  50% { transform: translateY(-15px); }
}

@keyframes pulse {
  0%, 100% { opacity: 1; transform: scale(1); }
  50% { opacity: 0.8; transform: scale(1.1); }
}
```

### Hover Effects
```css
/* Glow effect on hover */
.card:hover {
  box-shadow: 0 0 20px rgba(0,212,255,0.2);
}

/* Lift effect */
.card:hover {
  transform: translateY(-8px);
}

/* Color transition */
.btn {
  transition: all 0.3s;
}
```

---

## 🚀 JavaScript Interactions

### Authentication Modal
```javascript
function openLoginModal() {
  document.getElementById('auth-modal').style.display = 'flex';
}

function closeLoginModal() {
  document.getElementById('auth-modal').style.display = 'none';
}

function openRegisterModal() {
  window.location.href = '/register';
}
```

### Theme Toggle
```javascript
function toggleTheme() {
  const html = document.documentElement;
  const currentTheme = html.getAttribute('data-theme');
  const newTheme = currentTheme === 'light' ? 'dark' : 'light';
  html.setAttribute('data-theme', newTheme);
  localStorage.setItem('theme', newTheme);
  updateThemeIcon();
}
```

### Lab Expand/Collapse
```javascript
function toggleLab(element) {
  element.classList.toggle('expanded');
}
```

### FAQ Toggle
```javascript
function toggleFaq(element) {
  element.parentElement.classList.toggle('open');
}
```

---

## 📊 Database Models

### Course Model
```php
class Course extends Model {
  protected $fillable = [
    'title', 'description', 'image',
    'is_free', 'price', 'rating', 'review_count',
    'duration', 'level', 'badge', 'category',
    'prerequisites', 'curriculum', 'created_by'
  ];
  
  public function lessons() {
    return $this->hasMany(Lesson::class)->orderBy('order');
  }
  
  public function labs() {
    return $this->hasMany(Lab::class)->orderBy('order');
  }
  
  public function enrollments() {
    return $this->hasMany(Enrollment::class);
  }
}
```

### Lab Model
```php
class Lab extends Model {
  protected $fillable = [
    'course_id', 'number', 'category', 'title',
    'description', 'tasks', 'config_examples',
    'file_path', 'icon', 'order'
  ];
  
  protected $casts = [
    'tasks' => 'array',
    'config_examples' => 'array',
  ];
  
  public function course() {
    return $this->belongsTo(Course::class);
  }
}
```

---

## 🎯 Key Features Summary

| Feature | Implementation | Status |
|---------|----------------|--------|
| **Dark Theme** | CSS variables + data-theme attribute | ✅ |
| **Responsive** | CSS Grid + Flexbox + Media queries | ✅ |
| **Authentication** | Laravel auth + Modal UI | ✅ |
| **Course Management** | CRUD operations + admin panel | ✅ |
| **Lessons & Labs** | Database relationships + expandable UI | ✅ |
| **Animations** | CSS keyframes + JavaScript transitions | ✅ |
| **Performance** | Asset caching + optimized queries | ✅ |
| **Accessibility** | Semantic HTML + ARIA attributes | ✅ |

---

## 📖 Usage Examples

### Adding a New Page
1. Create `resources/views/my-page.blade.php`
2. Extend `layouts.app`
3. Add styles in `<style>` block
4. Use CSS variables for colors
5. Make responsive with media queries

### Adding a New Course Card
```blade
<div class="course-card">
  <div class="course-image">
    <img src="{{ $image }}" alt="{{ $title }}">
  </div>
  <div class="course-body">
    <h3 class="course-title">{{ $title }}</h3>
    <p class="course-desc">{{ $description }}</p>
    <a href="{{ route('courses.show', $course) }}" class="course-btn solid">View</a>
  </div>
</div>
```

### Styling a Form
```blade
<form method="POST">
  @csrf
  <div class="form-group">
    <label for="title">Title</label>
    <input type="text" id="title" name="title" class="form-control">
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
```

---

## 🔗 Useful Resources

- **Routes**: `routes/web.php`
- **Controllers**: `app/Http/Controllers/`
- **Models**: `app/Models/`
- **Migrations**: `database/migrations/`
- **CSS Files**: `public/css/`

---

## 💡 Best Practices

1. **Always use CSS variables** for colors
2. **Test responsive** on mobile, tablet, desktop
3. **Use Blade escaping** `{{ }}` to prevent XSS
4. **Leverage relationships** (hasMany, belongsTo)
5. **Add error messages** in forms with `@error`
6. **Use route helpers** instead of hardcoded URLs
7. **Optimize images** before upload
8. **Test dark/light mode** toggling

---

## 🚀 Next Steps

1. **Deploy to Varpix**: Push to production
2. **Add Premium Tier**: Implement payment system
3. **Email Notifications**: Course enrollment confirmations
4. **Progress Tracking**: Detailed student analytics
5. **Certificate Generation**: PDF certificates on completion

---

Generated: 2026-05-01 | Laravel 11 LMS | Blade Templating
