<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

    <!-- Theme preference -->
    <script>
        (function(){
            var t = localStorage.getItem('theme') || (window.matchMedia('(prefers-color-scheme:light)').matches ? 'light' : 'dark');
            if(t === 'light') document.documentElement.setAttribute('data-theme','light');
        })();
    </script>

    @stack('styles')
</head>
<body>
    <!-- CUSTOM CURSOR -->
    <div id="cursor"></div>
    <div id="cursor-ring"></div>

    <!-- CIRCUIT CANVAS -->
    <canvas id="circuit-canvas"></canvas>

    <!-- SCROLL PROGRESS -->
    <div id="scroll-progress"></div>

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
                <li><a href="#about" data-pg="about">About</a></li>
                <li><a href="#contact" data-pg="contact">Contact</a></li>
                @auth
                    <li><a href="{{ route('student.my-learning') }}" data-pg="dashboard">My Learning</a></li>
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
                    <button class="nbtn" onclick="openLoginModal()">Sign In</button>
                    <button class="nbtn solid" onclick="openRegisterModal()">Register</button>
                @endauth
            </div>
            <button class="nbtn" id="theme-toggle-btn" onclick="toggleTheme()" title="Toggle theme" style="padding:7px 11px;font-size:.95rem"><i class="fas fa-sun" id="theme-icon"></i></button>
            <button class="ham" id="ham" onclick="toggleMobileNav()"><span></span><span></span><span></span></button>
        </div>
    </nav>

    <!-- MOBILE NAV -->
    <div class="mob-nav" id="mob-nav">
        <a href="/">Home</a>
        <a href="{{ route('courses.index') }}">Courses</a>
        <a href="#about">About</a>
        <a href="#contact">Contact</a>
        @auth
            <a href="{{ route('student.my-learning') }}">My Learning</a>
            @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}">Admin Dashboard</a>
            @endif
        @else
            <a href="#" onclick="openLoginModal()">Sign In</a>
            <a href="#" onclick="openRegisterModal()">Register Free</a>
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
                        <a href="#about">About</a>
                        <a href="#contact">Contact</a>
                        <a href="#" onclick="openRegisterModal()">Register</a>
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

    <!-- AUTH MODAL (for non-authenticated users) -->
    @if(!auth()->check())
    <div class="modal-ov" id="auth-modal" style="display:none">
        <div class="modal-box">
            <button class="mclose" onclick="closeLoginModal()"><i class="fas fa-times"></i></button>
            <div class="m-title">SIGN IN</div>
            <div class="m-sub">Enter your credentials to access your learning portal</div>
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="fgrp"><label class="flbl">Email</label><input name="email" class="finp" type="email" placeholder="you@example.com" required></div>
                <div class="fgrp"><label class="flbl">Password</label><input name="password" class="finp" type="password" placeholder="••••••••" required></div>
                <button class="btn btn-c btn-full" type="submit"><i class="fas fa-sign-in-alt"></i> Sign In</button>
                <p style="text-align:center;font-size:0.78rem;color:var(--tm);margin-top:1rem">Don't have an account? <a href="/register" style="color:var(--c)">Register free</a></p>
            </form>
        </div>
    </div>
    @endif

    <!-- TOAST CONTAINER -->
    <div id="toast-box"></div>

    <!-- SCRIPTS -->
    <script>
        // Theme toggle
        function toggleTheme() {
            const html = document.documentElement;
            const currentTheme = html.getAttribute('data-theme');
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            html.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            updateThemeIcon();
        }

        function updateThemeIcon() {
            const icon = document.getElementById('theme-icon');
            const isDark = !document.documentElement.hasAttribute('data-theme') ||
                          document.documentElement.getAttribute('data-theme') === 'dark';
            icon.className = isDark ? 'fas fa-moon' : 'fas fa-sun';
        }

        // Mobile nav
        function toggleMobileNav() {
            document.getElementById('mob-nav').classList.toggle('open');
        }

        // Modal functions
        function openLoginModal() {
            document.getElementById('auth-modal').style.display = 'flex';
        }

        function closeLoginModal() {
            document.getElementById('auth-modal').style.display = 'none';
        }

        function openRegisterModal() {
            window.location.href = '/register';
        }

        // Circuit canvas animation
        function initCircuitCanvas() {
            const canvas = document.getElementById('circuit-canvas');
            if (!canvas) return;

            const ctx = canvas.getContext('2d');
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;

            let animationFrame;
            function drawCircuit() {
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                ctx.strokeStyle = 'rgba(0,212,255,0.03)';
                ctx.lineWidth = 1;

                const gridSize = 50;
                for (let x = 0; x < canvas.width; x += gridSize) {
                    ctx.beginPath();
                    ctx.moveTo(x, 0);
                    ctx.lineTo(x, canvas.height);
                    ctx.stroke();
                }

                for (let y = 0; y < canvas.height; y += gridSize) {
                    ctx.beginPath();
                    ctx.moveTo(0, y);
                    ctx.lineTo(canvas.width, y);
                    ctx.stroke();
                }

                animationFrame = requestAnimationFrame(drawCircuit);
            }

            drawCircuit();
        }

        // Custom cursor
        function initCursor() {
            const cursor = document.getElementById('cursor');
            const cursorRing = document.getElementById('cursor-ring');

            document.addEventListener('mousemove', (e) => {
                cursor.style.left = e.clientX + 'px';
                cursor.style.top = e.clientY + 'px';
                cursorRing.style.left = e.clientX + 'px';
                cursorRing.style.top = e.clientY + 'px';
            });

            document.addEventListener('mousedown', () => {
                cursor.classList.add('active');
                cursorRing.classList.add('active');
            });

            document.addEventListener('mouseup', () => {
                cursor.classList.remove('active');
                cursorRing.classList.remove('active');
            });
        }

        // Scroll progress
        function initScrollProgress() {
            window.addEventListener('scroll', () => {
                const scrollProgress = document.getElementById('scroll-progress');
                const scrollHeight = document.documentElement.scrollHeight - window.innerHeight;
                const scrolled = (window.scrollY / scrollHeight) * 100;
                scrollProgress.style.width = scrolled + '%';
            });
        }

        // Initialize on load
        document.addEventListener('DOMContentLoaded', () => {
            initCircuitCanvas();
            initCursor();
            initScrollProgress();
            updateThemeIcon();

            // Close mobile nav on link click
            document.querySelectorAll('.mob-nav a').forEach(link => {
                link.addEventListener('click', () => {
                    document.getElementById('mob-nav').classList.remove('open');
                });
            });
        });

        // Handle window resize
        window.addEventListener('resize', () => {
            const canvas = document.getElementById('circuit-canvas');
            if (canvas) {
                canvas.width = window.innerWidth;
                canvas.height = window.innerHeight;
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
