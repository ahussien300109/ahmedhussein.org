<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('description', 'Expert Cisco certification training with LMS platform. Learn from Ahmed Hussein - Cisco Certified Instructor.')">
    <title>@yield('title', 'Ahmed Hussein LMS') - Cisco Training</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;600;700;900&family=Exo+2:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/hero.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pages.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animations.css') }}">
    <link rel="stylesheet" href="{{ asset('css/premium-animations.css') }}">

    <!-- Theme preference -->
    <script>
        (function(){
            var t = localStorage.getItem('theme') || (window.matchMedia('(prefers-color-scheme:light)').matches ? 'light' : 'dark');
            if(t === 'light') document.documentElement.setAttribute('data-theme','light');
        })();
    </script>

    @stack('styles')

    <style>
        #main-content {
            margin-top: 80px;
            position: relative;
            z-index: 1;
        }

        @media (max-width: 768px) {
            #main-content {
                margin-top: 70px;
            }
        }
    </style>
</head>
<body>
    <!-- CUSTOM CURSOR -->
    <div id="cursor"></div>
    <div id="cursor-ring"></div>

    <!-- SCROLL PROGRESS BAR -->
    <div id="scroll-progress"></div>

    <!-- CIRCUIT CANVAS -->
    <canvas id="circuit-canvas"></canvas>

    <!-- NAVIGATION -->
    <nav id="nav">
        <div class="nav-inner">
            <a href="/" class="nav-logo">
                <svg class="logo-hex" viewBox="0 0 40 40">
                    <circle cx="20" cy="20" r="18" fill="none" stroke="rgba(0,212,255,.45)" stroke-width=".8" stroke-dasharray="5 3" class="lr1"/>
                    <circle cx="20" cy="20" r="13.5" fill="none" stroke="rgba(0,212,255,.2)" stroke-width=".6" stroke-dasharray="2 4" class="lr2"/>
                    <polygon points="20,4 34,12 34,28 20,36 6,28 6,12" fill="rgba(0,212,255,.06)" stroke="#00d4ff" stroke-width="1.5"/>
                    <text x="20" y="24.5" text-anchor="middle" font-family="Orbitron,monospace" font-size="9" fill="#00d4ff" font-weight="700">AH</text>
                </svg>
                <div><div class="logo-text"><span>AHMED</span> HUSSEIN</div><div class="logo-sub">Cisco Certified Instructor</div></div>
            </a>
            <ul class="nav-links">
                <li><a href="/" data-pg="home" class="@if(request()->path() == '/') act @endif">Home</a></li>
                <li><a href="{{ route('courses.index') }}" data-pg="courses" class="@if(str_contains(request()->path(), 'courses')) act @endif">Courses</a></li>
                <li><a href="{{ route('about') }}" data-pg="about" class="@if(str_contains(request()->path(), 'about')) act @endif">About</a></li>
                <li><a href="{{ route('contact') }}" data-pg="contact" class="@if(str_contains(request()->path(), 'contact')) act @endif">Contact</a></li>
                @auth
                    <li><a href="{{ route('student.my-learning') }}" data-pg="dashboard" class="@if(str_contains(request()->path(), 'my-learning')) act @endif">My Learning</a></li>
                @endauth
            </ul>
            <div class="nav-right">
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="nbtn" style="text-decoration:none"><i class="fas fa-cog"></i> Admin</a>
                    @endif
                    <button class="nbtn" onclick="document.getElementById('logout-form').submit()" style="cursor:pointer">
                        <i class="fas fa-power-off"></i> Logout
                    </button>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none">
                        @csrf
                    </form>
                @else
                    <button class="nbtn" onclick="openModal('login')">Sign In</button>
                    <button class="nbtn solid" onclick="openModal('register')">Register</button>
                @endauth
            </div>
            <button class="nbtn" id="theme-toggle-btn" onclick="toggleTheme()" title="Toggle theme" style="padding:7px 11px;font-size:.95rem"><i class="fas fa-sun" id="theme-icon"></i></button>
            <button class="ham" id="ham" onclick="toggleMob()"><span></span><span></span><span></span></button>
        </div>
    </nav>

    <!-- MOBILE NAV -->
    <div class="mob-nav" id="mob-nav">
        <a href="/">Home</a>
        <a href="{{ route('courses.index') }}">Courses</a>
        <a href="{{ route('about') }}">About</a>
        <a href="{{ route('contact') }}">Contact</a>
        @auth
            <a href="{{ route('student.my-learning') }}">My Learning</a>
            @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}">Admin Dashboard</a>
            @endif
        @else
            <a href="#" onclick="openModal('login')">Sign In</a>
            <a href="#" onclick="openModal('register')">Register Free</a>
        @endauth
    </div>

    <!-- MAIN CONTENT -->
    <main id="main-content">
        @if ($errors->any())
            <div class="alert-box alert-error" style="margin:1rem auto;max-width:900px">
                <strong>Error:</strong>
                <ul style="margin:0.5rem 0 0 1.5rem">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert-box alert-success" style="margin:1rem auto;max-width:900px">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert-box alert-error" style="margin:1rem auto;max-width:900px">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer id="site-footer">
        <div class="footer-inner">
            <div class="footer-grid">
                <div>
                    <div class="f-brand"><span>AHMED</span> HUSSEIN</div>
                    <p class="f-desc">Cisco Certified Instructor offering expert CCNA, CCNP, and Network Security training across the GCC and Middle East.</p>
                    <div class="social-links">
                        <a href="#" class="soc-btn"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="soc-btn"><i class="fab fa-youtube"></i></a>
                        <a href="#" class="soc-btn"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="soc-btn"><i class="fab fa-telegram"></i></a>
                    </div>
                </div>
                <div>
                    <div class="f-col-title">Courses</div>
                    <div class="f-links">
                        <a href="{{ route('courses.index') }}">CCNA 200-301</a>
                        <a href="{{ route('courses.index') }}">CCNP Enterprise</a>
                        <a href="{{ route('courses.index') }}">Network Security</a>
                        <a href="{{ route('courses.index') }}">Exam Bootcamp</a>
                    </div>
                </div>
                <div>
                    <div class="f-col-title">Navigate</div>
                    <div class="f-links">
                        <a href="/">Home</a>
                        <a href="{{ route('about') }}">About</a>
                        <a href="{{ route('contact') }}">Contact</a>
                        <a href="/register">Register</a>
                    </div>
                </div>
                <div>
                    <div class="f-col-title">Contact</div>
                    <div class="f-links">
                        <span style="color:var(--tm);font-size:0.78rem">info@ahmedhussein.org</span>
                        <span style="color:var(--tm);font-size:0.78rem">+973 3219 8505</span>
                        <span style="color:var(--tm);font-size:0.78rem">Manama, Bahrain</span>
                        <span style="color:var(--tm);font-size:0.78rem">Sat–Thu: 9AM–9PM</span>
                    </div>
                </div>
            </div>
            <div class="footer-bot">
                <span>© 2025 Ahmed Hussein. All rights reserved.</span>
                <div style="display:flex;gap:1rem">
                    <a href="#privacy">Privacy</a>
                    <a href="#terms">Terms</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- AUTH MODAL (for non-authenticated users) - MATCHES WEBSITE EXACTLY -->
    @if(!auth()->check())
    <div class="modal-ov" id="auth-modal" style="display:none">
        <div class="modal-box">
            <button class="mclose" onclick="closeModal()"><i class="fas fa-times"></i></button>
            <div class="m-title">ACCESS PORTAL</div>
            <div class="m-sub">Sign in or create your free account</div>
            <div class="m-tabs">
                <button class="m-tab on" data-tab="login" onclick="switchTab('login')">Sign In</button>
                <button class="m-tab" data-tab="register" onclick="switchTab('register')">Register</button>
            </div>

            <!-- LOGIN PANEL -->
            <div class="m-panel on" id="mp-login">
                <div class="form-msg" id="login-ok"><i class="fas fa-check-circle"></i> Logged in!</div>
                <div class="fgrp"><label class="flbl">Email</label><input id="l-email" class="finp" type="email" placeholder="you@example.com"></div>
                <div class="fgrp"><label class="flbl">Password <a href="#" class="forgot">Forgot?</a></label><input id="l-pass" class="finp" type="password" placeholder="••••••••" onkeydown="if(event.key==='Enter')doLogin()"></div>
                <div class="form-err" id="login-err"></div>
                <button class="btn btn-c btn-full" onclick="doLogin()"><i class="fas fa-sign-in-alt"></i> Sign In</button>
                <p style="text-align:center;font-size:0.78rem;color:var(--tm);margin-top:1rem">No account? <a href="#" onclick="switchTab('register')" style="color:var(--c)">Register free</a></p>
            </div>

            <!-- REGISTER PANEL -->
            <div class="m-panel" id="mp-register">
                <div class="form-msg" id="reg-ok"><i class="fas fa-check-circle"></i> Account created! Sign in now.</div>
                <p style="font-size:0.68rem;font-weight:700;color:var(--tm);text-transform:uppercase;letter-spacing:1px;margin-bottom:0.6rem">Choose Plan</p>
                <div class="tier-row">
                    <div class="tier-opt on" data-tier="free" onclick="pickTier('free')"><div class="tier-name">FREE</div><div class="tier-price">$0</div><div class="tier-feat">Course previews & free courses</div></div>
                    <div class="tier-opt" data-tier="premium" onclick="pickTier('premium')"><div class="tier-name">PREMIUM ⚡</div><div class="tier-price">$29/mo</div><div class="tier-feat">Full access + labs + certificates</div></div>
                </div>
                <div class="form-row2">
                    <div class="fgrp"><label class="flbl">First Name *</label><input id="r-fname" class="finp" placeholder="Ahmed"></div>
                    <div class="fgrp"><label class="flbl">Last Name</label><input id="r-lname" class="finp" placeholder="Hassan"></div>
                </div>
                <div class="fgrp"><label class="flbl">Email *</label><input id="r-email" class="finp" type="email" placeholder="you@example.com"></div>
                <div class="fgrp"><label class="flbl">Phone</label><input id="r-phone" class="finp" placeholder="+973..."></div>
                <div class="fgrp"><label class="flbl">Password * (min 8 chars)</label><input id="r-pass" class="finp" type="password" placeholder="Min 8 characters" onkeydown="if(event.key==='Enter')doRegister()"></div>
                <div class="form-err" id="reg-err"></div>
                <button class="btn btn-c btn-full" onclick="doRegister()"><i class="fas fa-user-plus"></i> Create Account</button>
            </div>
        </div>
    </div>
    @endif

    <!-- TOAST CONTAINER -->
    <div id="toast-box"></div>

    <!-- LIVE CHAT - WHATSAPP -->
    <a href="https://wa.me/97332198505?text=Hello%20Ahmed%20Hussein%2C%20I%20would%20like%20to%20inquire%20about%20your%20courses"
       target="_blank"
       rel="noopener noreferrer"
       class="whatsapp-btn"
       title="Chat with us on WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>

    <!-- SCRIPTS -->
    <script src="{{ asset('js/animations.js') }}" defer></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/premium-interactions.js') }}" defer></script>

    @stack('scripts')
</body>
</html>
