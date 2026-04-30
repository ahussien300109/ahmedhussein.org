@extends('layouts.app')

@section('title', 'Home - Ahmed Hussein LMS')
@section('description', 'Expert Cisco CCNA, CCNP and Network Security training with 96% exam pass rate.')

@section('content')
<style>
    /* HERO SECTION */
    .hero {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem 2rem 2rem;
        z-index: 1;
        position: relative;
        overflow: hidden;
        margin-top: -80px;
        padding-top: 100px;
    }

    .hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 50%;
        width: 1000px;
        height: 1000px;
        background: radial-gradient(circle, rgba(0,212,255,0.1) 0%, transparent 70%);
        transform: translateX(-50%);
        pointer-events: none;
    }

    .hero-inner {
        max-width: 1300px;
        width: 100%;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 4rem;
        align-items: center;
        position: relative;
        z-index: 1;
    }

    .hero-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 1.5rem;
    }

    .eyebrow-line {
        width: 30px;
        height: 2px;
        background: var(--c);
    }

    .eyebrow-text {
        font-family: 'Orbitron', monospace;
        font-size: 0.7rem;
        font-weight: 700;
        color: var(--c);
        letter-spacing: 3px;
        text-transform: uppercase;
    }

    .hero-h1 {
        font-family: 'Orbitron', monospace;
        font-size: clamp(2.5rem, 5vw, 3.5rem);
        font-weight: 900;
        line-height: 1.1;
        color: var(--tw);
        margin: 0 0 1rem 0;
    }

    .hero-h1 .line2 {
        color: var(--c);
        text-shadow: 0 0 30px rgba(0,212,255,0.5);
    }

    .hero-h1 .line3 {
        color: var(--o);
        text-shadow: 0 0 30px rgba(255,106,0,0.4);
    }

    .hero-sub {
        font-size: 1.05rem;
        color: var(--tm);
        line-height: 1.8;
        margin: 1.5rem 0 2rem 0;
        max-width: 550px;
    }

    .hero-sub strong {
        color: var(--t);
        font-weight: 600;
    }

    .hero-btns {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        margin: 2.5rem 0 3rem 0;
    }

    .hbtn {
        padding: 0.9rem 2rem;
        border-radius: 8px;
        font-family: 'Exo 2', sans-serif;
        font-size: 0.9rem;
        font-weight: 700;
        letter-spacing: 1px;
        text-transform: uppercase;
        cursor: pointer;
        transition: all 0.3s;
        border: none;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
    }

    .hbtn-primary {
        background: linear-gradient(135deg, var(--c), var(--c2));
        color: var(--bg);
        box-shadow: 0 0 20px rgba(0,212,255,0.3);
    }

    .hbtn-primary:hover {
        box-shadow: 0 0 40px rgba(0,212,255,0.6);
        transform: translateY(-3px);
    }

    .hbtn-outline {
        background: transparent;
        color: var(--c);
        border: 1.5px solid var(--c);
    }

    .hbtn-outline:hover {
        background: rgba(0,212,255,0.1);
        transform: translateY(-3px);
    }

    .hero-trust {
        display: flex;
        gap: 2rem;
        flex-wrap: wrap;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid var(--bdr);
    }

    .trust-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 0.85rem;
        color: var(--tm);
    }

    .trust-item i {
        color: var(--g);
        font-size: 0.9rem;
    }

    .hero-stats {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid var(--bdr);
    }

    .stat {
        text-align: center;
    }

    .stat-num {
        font-family: 'Orbitron', monospace;
        font-size: 2.2rem;
        font-weight: 900;
        color: var(--c);
    }

    .stat-label {
        font-size: 0.75rem;
        color: var(--tm);
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-top: 0.5rem;
    }

    /* HERO RIGHT - CERTIFICATIONS */
    .hero-right {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .cert-showcase {
        position: relative;
        width: 100%;
        max-width: 450px;
    }

    .cert-card {
        border: 1px solid var(--bdr);
        border-radius: 12px;
        padding: 2rem;
        background: var(--card);
        position: relative;
        overflow: hidden;
    }

    .cert-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 2px;
        background: linear-gradient(90deg, transparent, var(--c), transparent);
    }

    .cert-title {
        font-family: 'Orbitron', monospace;
        font-size: 0.85rem;
        color: var(--c);
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 1.5rem;
        font-weight: 700;
    }

    .cert-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .cert-tile {
        border: 1px solid rgba(0,212,255,0.2);
        border-radius: 10px;
        padding: 1.25rem;
        text-align: center;
        background: rgba(0,212,255,0.02);
        transition: all 0.3s;
        cursor: pointer;
    }

    .cert-tile:hover {
        border-color: var(--c);
        background: rgba(0,212,255,0.08);
        transform: translateY(-4px);
    }

    .cert-icon {
        font-size: 2rem;
        color: var(--c);
        margin-bottom: 0.75rem;
    }

    .cert-name {
        font-family: 'Orbitron', monospace;
        font-size: 0.8rem;
        color: var(--tw);
        font-weight: 700;
        margin-bottom: 0.25rem;
    }

    .cert-code {
        font-size: 0.65rem;
        color: var(--tm);
        letter-spacing: 1px;
    }

    .cert-instructor {
        border-top: 1px solid var(--bdr);
        padding-top: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .cert-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--c), var(--c2));
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--bg);
        font-family: 'Orbitron', monospace;
        font-weight: 700;
    }

    .cert-instructor-info {
        flex: 1;
    }

    .cert-instructor-name {
        font-family: 'Orbitron', monospace;
        font-size: 0.9rem;
        color: var(--tw);
        font-weight: 700;
    }

    .cert-instructor-role {
        font-size: 0.7rem;
        color: var(--c);
        margin-top: 0.25rem;
    }

    /* COURSES SECTION */
    .courses-section {
        padding: 4rem 2rem;
        background: var(--bg2);
        position: relative;
        z-index: 1;
    }

    .section-container {
        max-width: 1300px;
        margin: 0 auto;
    }

    .section-header {
        text-align: center;
        margin-bottom: 3rem;
    }

    .section-title {
        font-family: 'Orbitron', monospace;
        font-size: clamp(1.8rem, 4vw, 2.5rem);
        font-weight: 700;
        margin: 0;
    }

    .section-title .accent {
        background: linear-gradient(135deg, var(--c) 0%, #00ff88 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .courses-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 2rem;
        margin-bottom: 3rem;
    }

    .course-card {
        border: 1px solid var(--bdr);
        border-radius: 12px;
        overflow: hidden;
        background: var(--card);
        transition: all 0.3s;
        display: flex;
        flex-direction: column;
    }

    .course-card:hover {
        border-color: var(--c);
        transform: translateY(-8px);
        box-shadow: 0 12px 40px rgba(0,212,255,0.15);
    }

    .course-thumb {
        height: 180px;
        background: linear-gradient(135deg, var(--c), var(--c2));
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Orbitron', monospace;
        color: var(--bg);
        font-weight: 700;
        font-size: 1.1rem;
    }

    .course-body {
        padding: 1.75rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .course-title {
        font-family: 'Orbitron', monospace;
        font-size: 1.1rem;
        color: var(--tw);
        margin: 0 0 0.75rem 0;
        font-weight: 700;
    }

    .course-desc {
        color: var(--tm);
        font-size: 0.9rem;
        margin: 0 0 1rem 0;
        line-height: 1.6;
        flex: 1;
    }

    .course-footer {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 1rem;
        border-top: 1px solid var(--bdr);
    }

    .course-badge {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        padding: 0.4rem 0.8rem;
        border-radius: 4px;
        background: rgba(0,212,255,0.1);
        color: var(--c);
    }

    .course-link {
        color: var(--c);
        text-decoration: none;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s;
    }

    .course-link:hover {
        color: #00ff88;
        gap: 0.75rem;
    }

    .cta-center {
        text-align: center;
        margin-top: 3rem;
    }

    .btn-large {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem 2.5rem;
        border: 2px solid var(--c);
        background: transparent;
        color: var(--c);
        border-radius: 8px;
        text-decoration: none;
        font-weight: 700;
        font-family: 'Exo 2', sans-serif;
        transition: all 0.3s;
        font-size: 0.95rem;
        letter-spacing: 1px;
    }

    .btn-large:hover {
        background: var(--c);
        color: var(--bg);
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(0,212,255,0.3);
    }

    @media (max-width: 1024px) {
        .hero-inner {
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        .hero-stats {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    /* FEATURES SECTION */
    .features-section {
        padding: 4rem 2rem;
        background: linear-gradient(180deg, var(--bg2) 0%, var(--bg) 100%);
        border-top: 1px solid var(--bdr);
        position: relative;
        z-index: 1;
    }

    .features-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 2rem;
        max-width: 1300px;
        margin: 0 auto;
    }

    .feature-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        gap: 1rem;
    }

    .feature-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        background: rgba(0,212,255,0.1);
        border: 1px solid rgba(0,212,255,0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: var(--c);
    }

    .feature-title {
        font-family: 'Orbitron', monospace;
        font-size: 1rem;
        font-weight: 700;
        color: var(--tw);
    }

    .feature-desc {
        font-size: 0.85rem;
        color: var(--tm);
        line-height: 1.6;
    }

    /* TESTIMONIALS SECTION */
    .testimonials-section {
        padding: 4rem 2rem;
        background: var(--bg);
        position: relative;
        z-index: 1;
    }

    .section-header-center {
        text-align: center;
        margin-bottom: 3rem;
    }

    .section-header-center h2 {
        font-family: 'Orbitron', monospace;
        font-size: clamp(1.8rem, 4vw, 2.5rem);
        font-weight: 700;
        color: var(--tw);
        margin: 0;
    }

    .section-header-center p {
        color: var(--tm);
        margin-top: 0.75rem;
        font-size: 0.95rem;
    }

    .testimonials-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
        max-width: 1300px;
        margin: 0 auto;
    }

    .testimonial-card {
        border: 1px solid var(--bdr);
        border-radius: 12px;
        padding: 2rem;
        background: var(--card);
        transition: all 0.3s;
    }

    .testimonial-card:hover {
        border-color: var(--c);
        transform: translateY(-8px);
        box-shadow: 0 12px 40px rgba(0,212,255,0.15);
    }

    .testimonial-stars {
        display: flex;
        gap: 0.25rem;
        margin-bottom: 1rem;
        color: #ffd700;
        font-size: 0.9rem;
    }

    .testimonial-text {
        color: var(--t);
        font-size: 0.95rem;
        line-height: 1.7;
        margin-bottom: 1.5rem;
        font-style: italic;
    }

    .testimonial-author {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding-top: 1rem;
        border-top: 1px solid var(--bdr);
    }

    .author-avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--c), var(--c2));
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Orbitron', monospace;
        font-weight: 700;
        color: var(--bg);
        flex-shrink: 0;
    }

    .author-info h4 {
        margin: 0;
        font-size: 0.9rem;
        color: var(--tw);
        font-weight: 600;
    }

    .author-info p {
        margin: 0.25rem 0 0 0;
        font-size: 0.75rem;
        color: var(--tm);
    }

    /* FAQ SECTION */
    .faq-section {
        padding: 4rem 2rem;
        background: linear-gradient(180deg, var(--bg) 0%, var(--bg2) 100%);
        position: relative;
        z-index: 1;
    }

    .faq-container {
        max-width: 900px;
        margin: 0 auto;
    }

    .faq-item {
        border: 1px solid var(--bdr);
        border-radius: 10px;
        margin-bottom: 1rem;
        background: var(--card);
        overflow: hidden;
        transition: all 0.3s;
    }

    .faq-item:hover {
        border-color: var(--c);
    }

    .faq-question {
        padding: 1.5rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: all 0.2s;
    }

    .faq-question:hover {
        background: rgba(0,212,255,0.02);
    }

    .faq-question h3 {
        margin: 0;
        font-family: 'Orbitron', monospace;
        font-size: 1rem;
        color: var(--tw);
        font-weight: 600;
        flex: 1;
    }

    .faq-toggle {
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--c);
        transition: transform 0.3s;
        flex-shrink: 0;
    }

    .faq-item.open .faq-toggle {
        transform: rotate(180deg);
    }

    .faq-answer {
        display: none;
        padding: 0 1.5rem 1.5rem 1.5rem;
        color: var(--t);
        line-height: 1.7;
        font-size: 0.9rem;
    }

    .faq-item.open .faq-answer {
        display: block;
    }

    /* PRICING SECTION */
    .pricing-section {
        padding: 4rem 2rem;
        background: var(--bg);
        position: relative;
        z-index: 1;
    }

    .pricing-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 2rem;
        max-width: 1000px;
        margin: 0 auto;
    }

    .pricing-card {
        border: 1px solid var(--bdr);
        border-radius: 12px;
        padding: 2.5rem;
        background: var(--card);
        transition: all 0.3s;
        position: relative;
    }

    .pricing-card:hover {
        border-color: var(--c);
        transform: translateY(-8px);
        box-shadow: 0 12px 40px rgba(0,212,255,0.15);
    }

    .pricing-card.featured {
        border-color: var(--c);
        background: rgba(0,212,255,0.02);
        transform: scale(1.05);
    }

    .pricing-badge {
        position: absolute;
        top: -12px;
        right: 20px;
        background: linear-gradient(135deg, var(--c), var(--c2));
        color: var(--bg);
        padding: 0.4rem 1rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
    }

    .pricing-title {
        font-family: 'Orbitron', monospace;
        font-size: 1.3rem;
        color: var(--tw);
        margin: 0 0 0.75rem 0;
        font-weight: 700;
    }

    .pricing-desc {
        color: var(--tm);
        font-size: 0.9rem;
        margin: 0 0 1.5rem 0;
    }

    .pricing-amount {
        font-family: 'Orbitron', monospace;
        font-size: 2.5rem;
        color: var(--c);
        font-weight: 700;
        margin-bottom: 0.25rem;
    }

    .pricing-period {
        color: var(--tm);
        font-size: 0.85rem;
        margin-bottom: 2rem;
        padding-bottom: 2rem;
        border-bottom: 1px solid var(--bdr);
    }

    .pricing-features {
        list-style: none;
        padding: 0;
        margin: 0 0 2rem 0;
    }

    .pricing-features li {
        padding: 0.75rem 0;
        color: var(--t);
        font-size: 0.9rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .pricing-features li:before {
        content: '✓';
        color: var(--g);
        font-weight: 700;
        font-size: 1rem;
    }

    .pricing-features li.disabled {
        color: var(--tm);
        opacity: 0.5;
    }

    .pricing-features li.disabled:before {
        content: '✕';
        color: var(--tm);
    }

    .pricing-btn {
        display: block;
        width: 100%;
        padding: 0.85rem;
        border: 2px solid var(--bdr);
        background: transparent;
        color: var(--c);
        border-radius: 8px;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 1px;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
    }

    .pricing-card:hover .pricing-btn {
        border-color: var(--c);
        background: rgba(0,212,255,0.1);
    }

    .pricing-card.featured .pricing-btn {
        background: var(--c);
        color: var(--bg);
        border-color: var(--c);
    }

    .pricing-card.featured .pricing-btn:hover {
        box-shadow: 0 0 30px rgba(0,212,255,0.5);
    }

    /* ANIMATIONS */
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

    .cert-card::before {
        animation: shimmer 3s linear infinite;
        background-size: 200%;
    }

    @media (max-width: 1024px) {
        .features-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .features-grid {
            grid-template-columns: 1fr;
        }

        .testimonials-grid {
            grid-template-columns: 1fr;
        }

        .pricing-grid {
            grid-template-columns: 1fr;
        }

        .pricing-card.featured {
            transform: scale(1);
        }
    }

    @media (max-width: 640px) {
        .hero {
            padding: 2rem 1rem;
            min-height: auto;
        }

        .hero-h1 {
            font-size: clamp(1.8rem, 4vw, 2.5rem);
        }

        .hero-btns {
            flex-direction: column;
        }

        .hbtn {
            width: 100%;
            justify-content: center;
        }

        .hero-trust {
            flex-direction: column;
            gap: 1rem;
        }

        .hero-stats {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .courses-section {
            padding: 2rem 1rem;
        }

        .features-section,
        .testimonials-section,
        .faq-section {
            padding: 2rem 1rem;
        }

        .features-grid,
        .testimonials-grid {
            gap: 1rem;
        }
    }
</style>

<!-- HERO SECTION -->
<section class="hero">
    <div class="hero-inner">
        <!-- LEFT SIDE -->
        <div>
            <div class="hero-eyebrow">
                <span class="eyebrow-line"></span>
                <span class="eyebrow-text">Welcome to Your Learning Journey</span>
            </div>

            <h1 class="hero-h1">
                <span>Master</span><br>
                <span class="line2">Cisco Network</span><br>
                <span class="line3">Certifications</span>
            </h1>

            <p class="hero-sub">
                Expert-led <strong>CCNA, CCNP, and Network Security</strong> courses built for real-world engineering. Hands-on labs, live mentorship, and a proven <strong>96% exam pass rate</strong>.
            </p>

            <div class="hero-btns">
                <a href="{{ route('courses.index') }}" class="hbtn hbtn-primary">
                    <i class="fas fa-book"></i> Explore Courses
                </a>
                @if(!auth()->check())
                    <a href="/register" class="hbtn hbtn-outline">
                        <i class="fas fa-user-plus"></i> Register Free
                    </a>
                @else
                    <a href="{{ route('student.my-learning') }}" class="hbtn hbtn-outline">
                        <i class="fas fa-chart-line"></i> My Learning
                    </a>
                @endif
            </div>

            <div class="hero-trust">
                <div class="trust-item"><i class="fas fa-check"></i> Packet Tracer Labs</div>
                <div class="trust-item"><i class="fas fa-check"></i> Cisco NetAcad Aligned</div>
                <div class="trust-item"><i class="fas fa-check"></i> Certificate of Completion</div>
            </div>

            <div class="hero-stats">
                <div class="stat">
                    <div class="stat-num">1200+</div>
                    <div class="stat-label">Students Trained</div>
                </div>
                <div class="stat">
                    <div class="stat-num">96%</div>
                    <div class="stat-label">Pass Rate</div>
                </div>
                <div class="stat">
                    <div class="stat-num">10+</div>
                    <div class="stat-label">Years Experience</div>
                </div>
            </div>
        </div>

        <!-- RIGHT SIDE - CERTIFICATIONS -->
        <div class="hero-right">
            <div class="cert-showcase">
                <div class="cert-card">
                    <div class="cert-title">Available Certifications</div>
                    <div class="cert-grid">
                        <div class="cert-tile">
                            <div class="cert-icon"><i class="fas fa-globe"></i></div>
                            <div class="cert-name">CCNA</div>
                            <div class="cert-code">200-301</div>
                        </div>
                        <div class="cert-tile">
                            <div class="cert-icon"><i class="fas fa-shield"></i></div>
                            <div class="cert-name">CCNP</div>
                            <div class="cert-code">350-401</div>
                        </div>
                        <div class="cert-tile">
                            <div class="cert-icon"><i class="fas fa-lock"></i></div>
                            <div class="cert-name">Security+</div>
                            <div class="cert-code">SY0-601</div>
                        </div>
                        <div class="cert-tile">
                            <div class="cert-icon"><i class="fas fa-bolt"></i></div>
                            <div class="cert-name">Automation</div>
                            <div class="cert-code">SD-WAN</div>
                        </div>
                    </div>

                    <div class="cert-instructor">
                        <div class="cert-avatar">AH</div>
                        <div class="cert-instructor-info">
                            <div class="cert-instructor-name">Ahmed Hussein</div>
                            <div class="cert-instructor-role">Cisco Certified Professional</div>
                        </div>
                        <div style="color:var(--g);font-size:0.75rem;font-weight:700;text-transform:uppercase">● LIVE</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FEATURED COURSES SECTION -->
<section class="courses-section">
    <div class="section-container">
        <div class="section-header">
            <h2 class="section-title">
                Featured <span class="accent">Courses</span>
            </h2>
        </div>

        <div class="courses-grid">
            @forelse(\App\Models\Course::latest()->take(3)->get() as $course)
                <div class="course-card">
                    <div class="course-thumb">{{ Str::limit($course->title, 20) }}</div>
                    <div class="course-body">
                        <h3 class="course-title">{{ $course->title }}</h3>
                        <p class="course-desc">{{ Str::limit($course->description, 100) }}</p>
                        <div class="course-footer">
                            <span class="course-badge">{{ $course->is_free ? 'FREE' : 'PREMIUM' }}</span>
                            <a href="{{ route('courses.show', $course) }}" class="course-link">
                                Learn More <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div style="grid-column:1/-1;text-align:center;padding:3rem;color:var(--tm)">
                    <p>Courses coming soon...</p>
                </div>
            @endforelse
        </div>

        <div class="cta-center">
            <a href="{{ route('courses.index') }}" class="btn-large">
                <i class="fas fa-arrow-right"></i> Explore All Courses
            </a>
        </div>
    </div>
</section>

<!-- FEATURES SECTION -->
<section class="features-section">
    <div class="features-grid">
        <div class="feature-item">
            <div class="feature-icon"><i class="fas fa-laptop"></i></div>
            <div class="feature-title">Hands-On Labs</div>
            <p class="feature-desc">20+ practical Packet Tracer labs with real-world configuration scenarios</p>
        </div>
        <div class="feature-item">
            <div class="feature-icon"><i class="fas fa-book"></i></div>
            <div class="feature-title">Structured Curriculum</div>
            <p class="feature-desc">Comprehensive lessons aligned with official Cisco certification exams</p>
        </div>
        <div class="feature-item">
            <div class="feature-icon"><i class="fas fa-chart-line"></i></div>
            <div class="feature-title">Progress Tracking</div>
            <p class="feature-desc">Monitor your learning journey with detailed progress analytics</p>
        </div>
        <div class="feature-item">
            <div class="feature-icon"><i class="fas fa-award"></i></div>
            <div class="feature-title">Certifications</div>
            <p class="feature-desc">Earn recognized certificates upon course completion</p>
        </div>
    </div>
</section>

<!-- TESTIMONIALS SECTION -->
<section class="testimonials-section">
    <div class="section-container">
        <div class="section-header-center">
            <h2>Student <span class="accent">Success Stories</span></h2>
            <p>See what our students have accomplished</p>
        </div>

        <div class="testimonials-grid">
            <div class="testimonial-card">
                <div class="testimonial-stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="testimonial-text">"Ahmed's teaching style is exceptional. The hands-on labs made complex networking concepts clear and practical. I passed my CCNA on the first attempt!"</p>
                <div class="testimonial-author">
                    <div class="author-avatar">MA</div>
                    <div class="author-info">
                        <h4>Muhammad Ali</h4>
                        <p>CCNA Certified • Kuwait</p>
                    </div>
                </div>
            </div>

            <div class="testimonial-card">
                <div class="testimonial-stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="testimonial-text">"The course structure is perfect for working professionals. I was able to balance work and studies, and the mentorship support was outstanding throughout."</p>
                <div class="testimonial-author">
                    <div class="author-avatar">FH</div>
                    <div class="author-info">
                        <h4>Fatima Hassan</h4>
                        <p>CCNP Enterprise • UAE</p>
                    </div>
                </div>
            </div>

            <div class="testimonial-card">
                <div class="testimonial-stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                </div>
                <p class="testimonial-text">"Beyond just passing the exam, Ahmed's course taught me practical networking skills I use daily in my job. Highly recommended for anyone serious about networking!"</p>
                <div class="testimonial-author">
                    <div class="author-avatar">SA</div>
                    <div class="author-info">
                        <h4>Salem Ahmed</h4>
                        <p>Network Engineer • Saudi Arabia</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- PRICING SECTION -->
<section class="pricing-section">
    <div class="section-container">
        <div class="section-header-center">
            <h2>Simple, Transparent <span class="accent">Pricing</span></h2>
            <p>Choose the plan that fits your learning goals</p>
        </div>

        <div class="pricing-grid">
            <!-- FREE TIER -->
            <div class="pricing-card">
                <h3 class="pricing-title">Free Access</h3>
                <p class="pricing-desc">Start your learning journey</p>
                <div class="pricing-amount">Free</div>
                <div class="pricing-period">Forever</div>

                <ul class="pricing-features">
                    <li>Course previews & highlights</li>
                    <li>Free sample lessons</li>
                    <li>Community support</li>
                    <li class="disabled">Hands-on labs access</li>
                    <li class="disabled">Full course access</li>
                    <li class="disabled">Direct mentorship</li>
                    <li class="disabled">Certificates</li>
                </ul>

                <button class="pricing-btn" onclick="openRegisterModal()">
                    <i class="fas fa-rocket"></i> Get Started
                </button>
            </div>

            <!-- PREMIUM TIER -->
            <div class="pricing-card featured">
                <div class="pricing-badge">POPULAR</div>
                <h3 class="pricing-title">Premium</h3>
                <p class="pricing-desc">Complete learning experience</p>
                <div class="pricing-amount">$29<span style="font-size:0.5em;color:var(--tm)">/mo</span></div>
                <div class="pricing-period">Billed monthly</div>

                <ul class="pricing-features">
                    <li>All free features</li>
                    <li>Full course access</li>
                    <li>20+ hands-on labs</li>
                    <li>Direct mentorship</li>
                    <li>Certificate of completion</li>
                    <li>Lifetime course updates</li>
                    <li>Exclusive live Q&A sessions</li>
                </ul>

                <a href="/register" class="pricing-btn">
                    <i class="fas fa-star"></i> Upgrade Now
                </a>
            </div>
        </div>
    </div>
</section>

<!-- FAQ SECTION -->
<section class="faq-section">
    <div class="section-container">
        <div class="section-header-center">
            <h2>Frequently Asked <span class="accent">Questions</span></h2>
            <p>Find answers to common questions about our courses</p>
        </div>

        <div class="faq-container">
            <div class="faq-item open">
                <div class="faq-question" onclick="toggleFaq(this)">
                    <h3>What are the prerequisites for CCNA course?</h3>
                    <div class="faq-toggle"><i class="fas fa-chevron-down"></i></div>
                </div>
                <div class="faq-answer">
                    While no formal prerequisites are required, a basic understanding of computer networking concepts is recommended. The course covers everything from fundamentals to advanced topics, making it suitable for beginners with IT background. We provide review materials for those new to networking.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question" onclick="toggleFaq(this)">
                    <h3>How long does it take to complete a course?</h3>
                    <div class="faq-toggle"><i class="fas fa-chevron-down"></i></div>
                </div>
                <div class="faq-answer">
                    CCNA course typically takes 4-6 weeks with consistent 10-12 hours per week of study. However, you have lifetime access to course materials, allowing you to learn at your own pace. Most students complete within 8-12 weeks including hands-on labs and practice exams.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question" onclick="toggleFaq(this)">
                    <h3>Are the labs Cisco NetAcad aligned?</h3>
                    <div class="faq-toggle"><i class="fas fa-chevron-down"></i></div>
                </div>
                <div class="faq-answer">
                    Yes, all our labs are designed to align with Cisco NetAcad curriculum standards and real exam scenarios. We use Packet Tracer for network simulation labs, which is the official Cisco simulation software used in certification preparation.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question" onclick="toggleFaq(this)">
                    <h3>What's included in the Premium membership?</h3>
                    <div class="faq-toggle"><i class="fas fa-chevron-down"></i></div>
                </div>
                <div class="faq-answer">
                    Premium membership ($29/month) includes: Full access to all courses, all hands-on labs, direct mentorship with Ahmed Hussein, certificate of completion, downloadable resources, lifetime course access, and exclusive live Q&A sessions every week.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question" onclick="toggleFaq(this)">
                    <h3>What is the exam pass rate guarantee?</h3>
                    <div class="faq-toggle"><i class="fas fa-chevron-down"></i></div>
                </div>
                <div class="faq-answer">
                    Our students have achieved a 96% pass rate on Cisco certification exams. While we can't guarantee individual success, our comprehensive curriculum, hands-on labs, and dedicated mentorship significantly improve pass rates. We provide money-back guarantee if unsatisfied with the course content.
                </div>
            </div>

            <div class="faq-item">
                <div class="faq-question" onclick="toggleFaq(this)">
                    <h3>Do you offer payment plans?</h3>
                    <div class="faq-toggle"><i class="fas fa-chevron-down"></i></div>
                </div>
                <div class="faq-answer">
                    Yes, we offer flexible payment options. Premium membership can be paid monthly ($29/month), quarterly, or annually with discounts. We also offer interest-free payment plans through our partner payment processors for larger commitments.
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FINAL CTA SECTION -->
<section style="padding:4rem 2rem;background:linear-gradient(135deg,rgba(0,212,255,0.08),rgba(255,106,0,0.04));border-top:1px solid var(--bdr);position:relative;z-index:1;text-align:center">
    <div style="max-width:800px;margin:0 auto">
        <h2 style="font-family:'Orbitron',monospace;font-size:clamp(1.8rem,4vw,2.5rem);font-weight:700;color:var(--tw);margin:0 0 1rem 0">
            Ready to Master Cisco Networking?
        </h2>
        <p style="color:var(--tm);font-size:1rem;line-height:1.8;margin:0 0 2rem 0">
            Start your learning journey today with our comprehensive courses, hands-on labs, and expert mentorship. Join 1200+ students who've achieved their networking certifications.
        </p>
        <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap">
            <a href="{{ route('courses.index') }}" style="padding:0.9rem 2rem;background:linear-gradient(135deg,var(--c),var(--c2));color:var(--bg);border-radius:8px;text-decoration:none;font-weight:700;text-transform:uppercase;letter-spacing:1px;transition:all 0.3s;display:inline-flex;align-items:center;gap:0.75rem">
                <i class="fas fa-book"></i> Explore Courses
            </a>
            @if(!auth()->check())
                <a href="/register" style="padding:0.9rem 2rem;border:2px solid var(--c);background:transparent;color:var(--c);border-radius:8px;text-decoration:none;font-weight:700;text-transform:uppercase;letter-spacing:1px;transition:all 0.3s;display:inline-flex;align-items:center;gap:0.75rem">
                    <i class="fas fa-user-plus"></i> Sign Up Free
                </a>
            @else
                <a href="{{ route('student.my-learning') }}" style="padding:0.9rem 2rem;border:2px solid var(--c);background:transparent;color:var(--c);border-radius:8px;text-decoration:none;font-weight:700;text-transform:uppercase;letter-spacing:1px;transition:all 0.3s;display:inline-flex;align-items:center;gap:0.75rem">
                    <i class="fas fa-chart-line"></i> Continue Learning
                </a>
            @endif
        </div>
    </div>
</section>

<script>
    function toggleFaq(element) {
        element.parentElement.classList.toggle('open');
    }
</script>
@endsection
