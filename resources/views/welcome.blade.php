@extends('layouts.app')

@section('title', 'Home - Ahmed Hussein LMS')
@section('description', 'Expert Cisco CCNA, CCNP and Network Security training with 96% exam pass rate.')

@section('content')
<style>
    .hero {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
        z-index: 1;
        position: relative;
    }

    .hero-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 3rem;
        align-items: center;
        max-width: 1200px;
        width: 100%;
    }

    .hero-content h1 {
        font-family: 'Orbitron', monospace;
        font-size: clamp(2.5rem, 5vw, 4rem);
        font-weight: 800;
        margin: 0 0 1rem 0;
        line-height: 1.2;
        background: linear-gradient(135deg, var(--c) 0%, #00ff88 50%, var(--c) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .hero-content p {
        font-family: 'Exo 2', sans-serif;
        font-size: clamp(1rem, 2vw, 1.25rem);
        color: var(--tm);
        margin: 1.5rem 0 2rem 0;
        line-height: 1.75;
        max-width: 500px;
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1.25rem;
        border: 1px solid var(--c);
        border-radius: 50px;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: var(--c);
        margin-bottom: 1.5rem;
        font-weight: 600;
    }

    .hero-badge-dot {
        width: 8px;
        height: 8px;
        background: #00ff88;
        border-radius: 50%;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% { opacity: 1; }
        50% { opacity: 0.5; }
    }

    .hero-buttons {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        margin-top: 2rem;
    }

    .hero-btn {
        padding: 0.75rem 2rem;
        border: 2px solid var(--c);
        background: transparent;
        color: var(--c);
        border-radius: 50px;
        font-family: 'Exo 2', sans-serif;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .hero-btn:hover {
        background: var(--c);
        color: var(--bg);
        box-shadow: 0 0 20px rgba(0,212,255,0.3);
    }

    .hero-btn.solid {
        background: var(--c);
        color: var(--bg);
    }

    .hero-btn.solid:hover {
        box-shadow: 0 0 30px rgba(0,212,255,0.5);
    }

    .hero-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
        margin-top: 3rem;
        max-width: 500px;
    }

    .stat {
        text-align: center;
    }

    .stat-num {
        font-family: 'Orbitron', monospace;
        font-size: 2rem;
        font-weight: 700;
        color: var(--c);
    }

    .stat-label {
        font-size: 0.85rem;
        color: var(--tm);
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-top: 0.5rem;
    }

    .hero-visual {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 400px;
    }

    .hero-card {
        width: 100%;
        max-width: 400px;
        padding: 2rem;
        border: 1px solid var(--c);
        border-radius: 10px;
        background: rgba(0,212,255,0.05);
        backdrop-filter: blur(10px);
        position: relative;
        overflow: hidden;
    }

    .hero-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 2px;
        background: linear-gradient(90deg, transparent, var(--c), transparent);
        animation: shimmer 2s infinite;
    }

    @keyframes shimmer {
        0%, 100% { opacity: 0; }
        50% { opacity: 1; }
    }

    .cert-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
        margin-top: 1rem;
    }

    .cert-badge {
        padding: 1rem;
        text-align: center;
        border: 1px solid rgba(0,212,255,0.3);
        border-radius: 8px;
        background: rgba(0,212,255,0.02);
    }

    .cert-icon {
        font-size: 1.5rem;
        color: var(--c);
        margin-bottom: 0.5rem;
    }

    .cert-name {
        font-size: 0.8rem;
        color: var(--tm);
        font-weight: 600;
    }

    @media (max-width: 768px) {
        .hero-grid {
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        .hero-visual {
            min-height: 300px;
        }

        .hero-stats {
            grid-template-columns: 1fr;
        }
    }
</style>

<section class="hero">
    <div class="hero-grid">
        <div class="hero-content">
            <div class="hero-badge">
                <span class="hero-badge-dot"></span>
                <span>Welcome Back</span>
            </div>
            <h1>Learn from <span style="color:#00ff88">Expert</span> Instructors</h1>
            <p>Master Cisco certifications (CCNA, CCNP, Network Security) with comprehensive courses, hands-on labs, and a 96% exam pass rate. Join thousands of successful students today.</p>

            <div class="hero-buttons">
                <a href="{{ route('courses.index') }}" class="hero-btn solid"><i class="fas fa-book"></i> Explore Courses</a>
                @if(!auth()->check())
                    <a href="/register" class="hero-btn" style="border:none;background:transparent"><i class="fas fa-user-plus"></i> Sign Up Free</a>
                @else
                    <a href="{{ route('student.my-learning') }}" class="hero-btn"><i class="fas fa-chart-line"></i> My Learning</a>
                @endif
            </div>

            <div class="hero-stats">
                <div class="stat">
                    <div class="stat-num">500+</div>
                    <div class="stat-label">Students</div>
                </div>
                <div class="stat">
                    <div class="stat-num">96%</div>
                    <div class="stat-label">Pass Rate</div>
                </div>
                <div class="stat">
                    <div class="stat-num">4.9★</div>
                    <div class="stat-label">Rating</div>
                </div>
            </div>
        </div>

        <div class="hero-visual">
            <div class="hero-card">
                <div style="font-family:'Orbitron',monospace;color:var(--c);font-weight:700;margin-bottom:1.5rem">Certifications</div>
                <div class="cert-grid">
                    <div class="cert-badge">
                        <div class="cert-icon"><i class="fas fa-certificate"></i></div>
                        <div class="cert-name">CCNA 200-301</div>
                    </div>
                    <div class="cert-badge">
                        <div class="cert-icon"><i class="fas fa-certificate"></i></div>
                        <div class="cert-name">CCNP Enterprise</div>
                    </div>
                    <div class="cert-badge">
                        <div class="cert-icon"><i class="fas fa-lock"></i></div>
                        <div class="cert-name">Network Security</div>
                    </div>
                    <div class="cert-badge">
                        <div class="cert-icon"><i class="fas fa-zap"></i></div>
                        <div class="cert-name">Exam Bootcamp</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Courses Section -->
<section style="padding:4rem 2rem;background:var(--bg2);position:relative;z-index:1">
    <div style="max-width:1200px;margin:0 auto">
        <h2 style="font-family:'Orbitron',monospace;text-align:center;margin-bottom:3rem;font-size:clamp(1.5rem,4vw,2.5rem)">
            <span style="background:linear-gradient(135deg,var(--c),#00ff88);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text">Featured Courses</span>
        </h2>

        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:2rem">
            @forelse(\App\Models\Course::take(3)->get() as $course)
                <div style="border:1px solid var(--c);border-radius:10px;overflow:hidden;background:var(--bg);transition:all 0.3s;cursor:pointer" onmouseover="this.style.transform='translateY(-10px)';this.style.boxShadow='0 0 30px rgba(0,212,255,0.2)'" onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='none'">
                    <div style="height:200px;background:linear-gradient(135deg,var(--c),#00ff88);display:flex;align-items:center;justify-content:center;font-family:'Orbitron',monospace;color:white;font-weight:700">
                        {{ $course->title }}
                    </div>
                    <div style="padding:1.5rem">
                        <h3 style="font-family:'Orbitron',monospace;margin:0 0 0.5rem 0">{{ $course->title }}</h3>
                        <p style="color:var(--tm);font-size:0.9rem;margin:0 0 1rem 0">{{ Str::limit($course->description, 100) }}</p>
                        <div style="display:flex;justify-content:space-between;align-items:center">
                            <span style="color:var(--c);font-weight:600">{{ $course->is_free ? 'FREE' : 'PREMIUM' }}</span>
                            <a href="{{ route('courses.show', $course) }}" style="color:var(--c);text-decoration:none;font-weight:600">View Course →</a>
                        </div>
                    </div>
                </div>
            @empty
                <div style="grid-column:1/-1;text-align:center;padding:2rem;color:var(--tm)">
                    <p>Courses coming soon...</p>
                </div>
            @endforelse
        </div>

        <div style="text-align:center;margin-top:3rem">
            <a href="{{ route('courses.index') }}" style="display:inline-flex;align-items:center;gap:0.5rem;padding:0.75rem 2rem;border:2px solid var(--c);border-radius:50px;color:var(--c);text-decoration:none;font-weight:600;transition:all 0.3s" onmouseover="this.style.background='var(--c)';this.style.color='var(--bg)'" onmouseout="this.style.background='transparent';this.style.color='var(--c)'">
                <i class="fas fa-arrow-right"></i> Explore All Courses
            </a>
        </div>
    </div>
</section>
@endsection
