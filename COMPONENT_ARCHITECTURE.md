# Laravel Blade LMS - Component Architecture

## 🏗️ Layout Hierarchy

```
┌─────────────────────────────────────────────────────────┐
│                    app.blade.php                        │
│  (Master Layout: navbar, footer, modals, scripts)       │
└─────────────────────────────────────────────────────────┘
                            │
        ┌───────────────────┼───────────────────┐
        │                   │                   │
        ▼                   ▼                   ▼
   ┌──────────┐      ┌──────────┐      ┌──────────┐
   │ welcome  │      │ courses  │      │  about   │
   │          │      │   show   │      │ contact  │
   │ Features │      │  Details │      │ lessons  │
   │ Testimonials      Lessons  │      │ admin    │
   │ FAQ      │      │  Labs    │      │          │
   │ Pricing  │      │ Enrollment     │          │
   └──────────┘      └──────────┘      └──────────┘
```

## 🎨 Reusable Components

### 1. Card Component Pattern
```
┌─────────────────────────────────────┐
│ .card / .course-card                │
│ border: 1px solid var(--bdr)        │
│ border-radius: 10px                 │
│ padding: 1.5rem                     │
│ background: var(--card)             │
│ ┌─────────────────────────────────┐ │
│ │ Card Header / Image             │ │
│ ├─────────────────────────────────┤ │
│ │ Card Body                       │ │
│ │ - Title                         │ │
│ │ - Description                   │ │
│ │ - Metadata                      │ │
│ │ - Badges                        │ │
│ ├─────────────────────────────────┤ │
│ │ Card Footer / Actions           │ │
│ └─────────────────────────────────┘ │
└─────────────────────────────────────┘
```

**Used In:**
- Course cards (courses/index.blade.php)
- Testimonial cards (welcome.blade.php)
- Info cards (contact.blade.php)
- Credential cards (about.blade.php)
- Admin stat cards (admin/dashboard.blade.php)

---

### 2. Section Component Pattern
```
┌──────────────────────────────────────┐
│ .section / .features-section          │
│ padding: 4rem 2rem                   │
│ background: var(--bg2)               │
│ ┌────────────────────────────────┐  │
│ │ Section Header                 │  │
│ │ - Title with accent gradient   │  │
│ │ - Subtitle/description         │  │
│ ├────────────────────────────────┤  │
│ │ Section Content (Grid/Flex)    │  │
│ │ ┌──────────┐ ┌──────────┐      │  │
│ │ │ Item 1   │ │ Item 2   │ ...  │  │
│ │ └──────────┘ └──────────┘      │  │
│ └────────────────────────────────┘  │
└──────────────────────────────────────┘
```

**Used In:**
- Features (4 columns, 2 on tablet)
- Testimonials (3 cards, 1 on mobile)
- Courses (auto-fill grid, min-width 320px)
- FAQ (single column, expandable)
- Pricing (2 columns, 1 on mobile)

---

### 3. Button Component Pattern
```
┌────────────────────────────┐
│ .btn / .hbtn               │
│ padding: 0.75rem 1.5rem    │
│ border-radius: 8px         │
│ border: 2px solid          │
│ font-weight: 600           │
│ text-transform: uppercase  │
│ transition: all 0.3s       │
└────────────────────────────┘

States:
├─ .btn              (outline, transparent bg)
├─ .btn.primary      (solid bg, gradient)
├─ .btn:hover        (color invert, shadow)
├─ .hbtn-primary     (hero button)
├─ .hbtn-outline     (hero outline)
└─ .course-btn       (small action button)
```

**Color Variants:**
```
Primary (Cyan):
  background: linear-gradient(135deg, var(--c), var(--c2))
  color: var(--bg)
  border: 2px solid var(--c)

Outline:
  background: transparent
  color: var(--c)
  border: 2px solid var(--c)

Hover:
  box-shadow: 0 0 30px rgba(0,212,255,0.5)
  transform: translateY(-2px)
```

---

### 4. Form Component Pattern
```
┌────────────────────────────────────────┐
│ .form / form element                   │
│ ┌────────────────────────────────────┐ │
│ │ .form-group                        │ │
│ │ ┌──────────────────────────────┐  │ │
│ │ │ label.form-label             │  │ │
│ │ │ "Your Name *"                │  │ │
│ │ └──────────────────────────────┘  │ │
│ │ ┌──────────────────────────────┐  │ │
│ │ │ input.form-control           │  │ │
│ │ │ border: 1px solid var(--bdr) │  │ │
│ │ │ background: transparent      │  │ │
│ │ │ color: var(--t)              │  │ │
│ │ └──────────────────────────────┘  │ │
│ │ Focus State:                       │ │
│ │ ├─ border-color: var(--c)          │ │
│ │ └─ box-shadow: 0 0 20px rgba...    │ │
│ └────────────────────────────────────┘ │
│ ┌────────────────────────────────────┐ │
│ │ button.btn.btn-primary             │ │
│ └────────────────────────────────────┘ │
└────────────────────────────────────────┘
```

**Used In:**
- Course create/edit (courses/create.blade.php)
- Lesson create/edit (lessons/create.blade.php)
- Contact form (contact.blade.php)
- Admin filters (admin/dashboard.blade.php)

---

### 5. Badge Component Pattern
```
┌─────────────────────────┐
│ .course-badge           │
│ padding: 0.35rem 0.7rem │
│ border-radius: 4px      │
│ font-size: 0.7rem       │
│ font-weight: 700        │
│ text-transform: uppercase│
│ display: inline-block   │
└─────────────────────────┘

Variants:
├─ .free     → green bg, green text
├─ .premium  → orange bg, orange text
├─ .hot      → orange bg, orange text
├─ .new      → cyan bg, cyan text
└─ .lvl-tag  → level badge

Example Usage:
<span class="course-badge premium">PREMIUM</span>
<span class="course-badge hot">HOT</span>
<span class="lvl-tag">Intermediate</span>
```

---

## 📐 Grid System

### Desktop (1200px+)
```
Courses Grid:       4 columns
Features Grid:      4 columns
Testimonials Grid:  3 columns
About Grid:         2 columns
Pricing Grid:       2 columns
```

### Tablet (768px - 1024px)
```
Courses Grid:       2-3 columns
Features Grid:      2 columns
Testimonials Grid:  2 columns
About Grid:         1 column
Pricing Grid:       1 column
```

### Mobile (< 768px)
```
All Grids:          1 column
Nav:                Hamburger menu
Buttons:            Full width
```

---

## 🎨 Color Scheme

### Primary Color (Cyan)
```css
--c:    #00d4ff  /* Primary - buttons, links, highlights */
--c2:   #0099cc  /* Mid-tone - gradients, hover states */
--c3:   #005577  /* Deep - borders, subtle backgrounds */

Usage:
├─ Navigation hover
├─ Button backgrounds
├─ Card borders (on hover)
├─ Text highlights
└─ Glow effects
```

### Accent Color (Orange)
```css
--o:    #ff6a00  /* Primary accent - premium badges, features */
--o2:   #ff9a40  /* Light - hover states */

Usage:
├─ Premium badges
├─ "Hot" course badges
├─ Secondary buttons
└─ Hero title "line3"
```

### Success Color (Green)
```css
--g:    #00ff88  /* Success, confirms, progress */

Usage:
├─ Checkmarks in pricing
├─ "Free" badges
├─ Trust items
├─ Lab expand icons
└─ Live indicator pulse
```

### Backgrounds
```css
--bg:   #030d1a  /* Main background */
--bg1:  #060f20  /* Overlay 1 */
--bg2:  #080e1c  /* Overlay 2 - section bg */
--bg3:  #0c1628  /* Overlay 3 - darker elements */
--bg4:  #101e38  /* Overlay 4 */
--bg5:  #142240  /* Overlay 5 - darkest */
--card: #0a1525  /* Card background */

Hierarchy:
Main bg < bg1 < bg2 < bg3 < bg4 < bg5
         Light                      Dark
```

### Text Colors
```css
--t:    #c8ddf0  /* Body text (default) */
--tm:   #7a9ab5  /* Muted text (secondary) */
--tw:   #ffffff  /* White text (headings) */

Contrast Ratios:
├─ --tw on --bg  ✓ 20:1 (AAA)
├─ --t  on --bg  ✓ 12:1 (AAA)
└─ --tm on --bg  ✓ 7:1 (AA)
```

---

## 🔤 Typography Hierarchy

### Font Families
```css
Headings:  'Orbitron', monospace
           font-weight: 700-900
           letter-spacing: 1-3px
           text-transform: uppercase (sometimes)

Body:      'Exo 2', sans-serif
           font-weight: 400-600
           letter-spacing: 0.5px
```

### Font Sizes
```
h1: clamp(2.5rem, 5vw, 3.5rem)   /* Responsive hero */
h2: clamp(1.8rem, 4vw, 2.5rem)   /* Section titles */
h3: 1.1rem - 1.3rem              /* Card titles */
h4: 0.9rem - 1rem                /* Subtitles */

p:  0.85rem - 1rem               /* Body text */
.muted: 0.75rem - 0.85rem        /* Secondary text */
.small: 0.65rem - 0.75rem        /* Captions */
```

---

## 🎬 Animation Patterns

### Hover Effects (Cards)
```css
.card:hover {
  transform: translateY(-8px);              /* Lift */
  border-color: var(--c);                   /* Highlight border */
  box-shadow: 0 0 20px rgba(0,212,255,0.15); /* Glow */
}
```

### Hover Effects (Buttons)
```css
.btn:hover {
  background: var(--c);                     /* Fill background */
  color: var(--bg);                         /* Invert text */
  transform: translateY(-2px);              /* Slight lift */
  box-shadow: 0 0 30px rgba(0,212,255,0.5); /* Glow */
}
```

### Focus States (Inputs)
```css
input:focus {
  outline: none;
  border-color: var(--c);
  box-shadow: 0 0 0 3px rgba(0,212,255,0.1);
}
```

### Keyframe Animations
```css
@keyframes shimmer {
  from { background-position: 0% 0%; }
  to   { background-position: 200% 0%; }
}

@keyframes floatUpDown {
  0%, 100% { transform: translateY(0px); }
  50%      { transform: translateY(-15px); }
}

@keyframes pulse {
  0%, 100% { opacity: 1; transform: scale(1); }
  50%      { opacity: 0.8; transform: scale(1.1); }
}

@keyframes gridDrift {
  from { transform: translateY(0); }
  to   { transform: translateY(70px); }
}
```

---

## 📦 CSS Files Organization

### style.css
```
├─ CSS Variables (--c, --bg, --t, etc.)
├─ Light mode overrides [data-theme="light"]
├─ Global styles (body, html, etc.)
├─ Utility classes (.btn, .card, etc.)
└─ Admin dashboard styles
```

### hero.css
```
├─ Background animations (gridDrift, particles)
├─ Hero section layout
├─ Certificate showcase
├─ Feature strip
└─ Course cards
```

### pages.css
```
├─ About page styles
├─ Contact page styles
├─ Lesson details
└─ Admin specific
```

### dashboard.css
```
├─ Admin layout
├─ Tables and charts
├─ Stat cards
└─ Activity logs
```

---

## 🔗 Data Flow

### Page Rendering Flow
```
routes/web.php
    ↓
Controller (e.g., CourseController@show)
    ↓
Load Model + Relationships (Course + Labs + Lessons)
    ↓
Pass to View (e.g., courses/show.blade.php)
    ↓
Blade extends layouts/app.blade.php
    ↓
Render HTML with CSS from public/css/
    ↓
JavaScript interactions (modals, toggles)
    ↓
Display in Browser
```

### Component Rendering
```
@extends('layouts.app')
    ↓
<nav> from app.blade.php
<main> @yield('content')
    ↓
Course cards loop through $courses
    ↓
Each card applies .course-card CSS classes
    ↓
Styling applied from public/css/style.css
    ↓
Render on screen
```

---

## 📊 CSS Class Naming

### Pattern
```
.[component]-[variant]
.[component]-[state]
```

### Examples
```
.course-card           (main component)
.course-card:hover     (state)
.course-badge          (sub-component)
.course-badge.premium  (variant)
.course-badge.free     (variant)

.btn                   (main component)
.btn.primary           (variant)
.btn:hover             (state)
.btn:active            (state)

.form-group            (container)
.form-control          (input)
.form-label            (label)
```

---

## ✅ Component Checklist

Use this when adding new components:

- [ ] Uses CSS variables for colors
- [ ] Includes responsive media queries
- [ ] Has hover/active states
- [ ] Follows naming convention
- [ ] Tested on mobile/tablet/desktop
- [ ] Accessible (contrast, spacing)
- [ ] Uses existing utilities where possible
- [ ] Documentation in comments

---

## 🚀 Quick Copy-Paste Templates

### New Page
```blade
@extends('layouts.app')

@section('title', 'My Page Title')

@section('content')
<style>
  .my-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 2rem;
  }
  
  .my-section {
    padding: 3rem 2rem;
    background: var(--bg2);
  }
</style>

<div class="my-container">
  <!-- Content here -->
</div>
@endsection
```

### New Card Grid
```blade
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:2rem">
  @foreach($items as $item)
    <div class="card">
      <h3>{{ $item->title }}</h3>
      <p>{{ $item->description }}</p>
      <a href="#" class="btn btn-primary">Action</a>
    </div>
  @endforeach
</div>
```

### New Button
```blade
<button class="btn btn-primary" onclick="doSomething()">
  <i class="fas fa-icon"></i> Button Text
</button>
```

---

## 📈 Performance Tips

1. **Minimize Blade Loops**: Use `@forelse` to handle empty states
2. **Eager Load**: Use `->with('relations')` in controllers
3. **Cache CSS**: Let browser cache public/css files
4. **Lazy Load Images**: Add `loading="lazy"` to img tags
5. **Minify Production CSS**: Use `npm run prod`

---

Generated: 2026-05-01 | Laravel 11 LMS Architecture
