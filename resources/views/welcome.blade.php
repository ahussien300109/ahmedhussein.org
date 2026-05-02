@extends('layouts.app')

@section('title', 'Home - Ahmed Hussein LMS')
@section('description', 'Expert Cisco CCNA, CCNP and Network Security training with 96% exam pass rate.')

@section('content')
<style>
    /* URGENCY PILL */
    .urgency-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255,106,0,0.1);
        border: 1px solid rgba(255,106,0,0.22);
        border-radius: 20px;
        padding: 5px 14px;
        font-size: 0.72rem;
        color: var(--t);
        margin-bottom: 1.1rem;
    }

    .up-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: var(--o);
        animation: pls 1.5s infinite;
        flex-shrink: 0;
    }

    @keyframes pls {
        0%, 100% {
            opacity: 1;
            box-shadow: 0 0 0 0 rgba(255,106,0,0.7);
        }
        50% {
            opacity: 0.7;
            box-shadow: 0 0 0 6px rgba(255,106,0,0);
        }
    }

    [data-theme="light"] .urgency-pill {
        background: rgba(201,79,8,0.08);
        border-color: rgba(201,79,8,0.2);
        color: #0f172a;
    }

    /* FLOATING PARTICLES BACKGROUND */
    .particle {
        position: fixed;
        pointer-events: none;
        opacity: 0.5;
        z-index: 0;
    }

    /* SCROLL REVEAL ANIMATIONS */
    .reveal {
        opacity: 0;
        transform: translateY(30px);
        transition: all 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    }

    .reveal.active {
        opacity: 1;
        transform: translateY(0);
    }

    /* ANIMATED COUNTER */
    .counter-num {
        font-family: 'Orbitron', monospace;
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--c);
    }

    .stat {
        animation: statPulse 2s ease-in-out infinite;
    }

    .stat:nth-child(2) {
        animation-delay: 0.3s;
    }

    .stat:nth-child(3) {
        animation-delay: 0.6s;
    }

    @keyframes statPulse {
        0%, 100% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.05);
        }
    }

    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-50px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(50px);
        }
        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes slideInUp {
        from {
            opacity: 0;
            transform: translateY(50px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .hero-left {
        animation: slideInLeft 0.8s ease-out;
    }

    .hero-right {
        animation: slideInRight 0.8s ease-out 0.2s both;
    }

    /* HERO SECTION */
    .hero {
        min-height: 90vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 2.5rem;
        padding-top: 20px;
        z-index: 1;
        position: relative;
        overflow: hidden;
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
        gap: 5rem;
        align-items: center;
        position: relative;
        z-index: 1;
        margin-top: 30px;
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
        letter-spacing: 4px;
        text-transform: uppercase;
    }

    .hero-h1 {
        font-family: 'Orbitron', monospace;
        font-size: clamp(2rem, 3.5vw, 3.2rem);
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
        font-size: 1rem;
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
        gap: 1rem;
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
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .cert-title-dots {
        display: flex;
        gap: 8px;
    }

    .cert-title-dots .dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
    }

    .cert-title-dots .red {
        background: #ff4444;
    }

    .cert-title-dots .orange {
        background: #ffaa00;
    }

    .cert-title-dots .green {
        background: #00cc88;
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
        transform: translateY(-6px);
        box-shadow: 0 12px 40px rgba(0,212,255,0.15);
    }

    .course-thumb {
        height: 170px;
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
            gap: 3rem;
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
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background: rgba(0,212,255,0.1);
        border: 1px solid rgba(0,212,255,0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.3rem;
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
        padding: 1.8rem;
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
        background: var(--bg);
        position: relative;
        z-index: 1;
        border-top: 1px solid var(--bdr);
    }

    .faq-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
        max-width: 1100px;
        margin: 3rem auto 0;
    }

    .faq-card {
        background: var(--card);
        border: 1px solid var(--bdr);
        border-radius: 12px;
        padding: 1.5rem;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .faq-card:hover {
        border-color: var(--c);
        background: rgba(0, 212, 255, 0.02);
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0, 212, 255, 0.1);
    }

    .faq-card h3 {
        margin: 0 0 0.75rem 0;
        font-family: 'Orbitron', monospace;
        font-size: 0.95rem;
        color: var(--tw);
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .faq-card h3 i {
        color: var(--c);
        font-size: 0.85rem;
    }

    .faq-card p {
        margin: 0;
        color: var(--tm);
        font-size: 0.88rem;
        line-height: 1.6;
    }

    @media (max-width: 820px) {
        .faq-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }
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
        .hero-inner {
            grid-template-columns: 1fr;
            gap: 3rem;
        }

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
        .urgency-pill {
            position: static !important;
            margin-bottom: 1rem;
        }

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
        .features-grid,
        .testimonials-grid {
            gap: 1rem;
        }
    }

    /* ═══════════════════════════════════════
       CAREER PATH CHART - HERO RIGHT
       ═══════════════════════════════════════ */
    @keyframes nodeGlow {
        0%, 100% { filter: drop-shadow(0 0 4px currentColor); }
        50% { filter: drop-shadow(0 0 12px currentColor); }
    }

    @keyframes lineDraw {
        from { stroke-dashoffset: 100; }
        to { stroke-dashoffset: 0; }
    }

    @keyframes badgeFloat {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-6px); }
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes scanLine {
        0%, 100% { transform: translateX(-100%); opacity: 0; }
        50% { opacity: 0.3; }
    }

    .path-chart-card {
        position: relative;
        overflow: hidden;
    }

    .pcc-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--bdr);
    }

    .pcc-title {
        font-family: 'Orbitron', monospace;
        font-size: 0.8rem;
        color: var(--c);
        text-transform: uppercase;
        letter-spacing: 2px;
        font-weight: 700;
    }

    .pcc-dots {
        display: flex;
        gap: 6px;
    }

    .pcc-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        display: inline-block;
    }

    .pcc-dot-red { background: #ff4444; }
    .pcc-dot-orange { background: #ff9a40; }
    .pcc-dot-green { background: #00ff88; }

    .pcc-chart {
        position: relative;
        width: 100%;
        height: 420px;
        margin-bottom: 1.5rem;
        display: flex;
        justify-content: center;
        align-items: center;
        background: rgba(0,212,255,0.03);
        border: 1px solid rgba(0,212,255,0.15);
        border-radius: 8px;
        padding: 1rem 0;
    }

    .pcc-chart svg {
        width: 100%;
        max-width: 100%;
        height: 100%;
        display: block;
        filter: drop-shadow(0 0 30px rgba(0,212,255,0.15));
    }

    /* SVG path animation */
    .pcc-line {
        stroke-dasharray: 100;
        stroke-dashoffset: 100;
        animation: lineDraw 2s ease-out forwards;
        stroke: var(--line-color);
        stroke-width: 2.5;
        fill: none;
        stroke-linecap: round;
        filter: drop-shadow(0 0 2px var(--line-color));
    }

    .pcc-line:nth-child(2) { animation-delay: 0.3s; }
    .pcc-line:nth-child(4) { animation-delay: 0.6s; }
    .pcc-line:nth-child(6) { animation-delay: 0.9s; }

    /* SVG node animation */
    .pcc-node {
        animation: fadeIn 0.6s ease-out forwards;
    }

    .pcc-node:nth-child(3) { animation-delay: 0.3s; }
    .pcc-node:nth-child(5) { animation-delay: 0.6s; }
    .pcc-node:nth-child(7) { animation-delay: 0.9s; }
    .pcc-node:nth-child(9) { animation-delay: 1.2s; }
    .pcc-node:nth-child(11) { animation-delay: 1.2s; }
    .pcc-node:nth-child(13) { animation-delay: 1.5s; }
    .pcc-node:nth-child(15) { animation-delay: 1.8s; }

    .pcc-node-outer {
        animation: nodeGlow 2.5s ease-in-out infinite;
    }

    .pcc-node:hover .pcc-node-outer {
        filter: drop-shadow(0 0 16px currentColor);
    }

    .pcc-label {
        font-size: 0.65rem;
        font-weight: 600;
        text-anchor: middle;
        fill: var(--t);
        text-transform: uppercase;
    }

    .pcc-code {
        font-size: 0.5rem;
        fill: var(--tm);
        text-anchor: middle;
    }

    /* Floating badge */
    .pcc-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background: rgba(0,255,136,0.15);
        border: 1px solid rgba(0,255,136,0.3);
        border-radius: 20px;
        padding: 6px 12px;
        font-size: 0.65rem;
        color: #00ff88;
        font-weight: 700;
        letter-spacing: 1px;
        animation: badgeFloat 3s ease-in-out infinite;
    }

    /* Tooltip */
    .pcc-tooltip {
        position: absolute;
        background: rgba(12,22,40,0.95);
        border: 1px solid var(--bdr);
        border-radius: 8px;
        padding: 0.75rem;
        font-size: 0.7rem;
        color: var(--t);
        z-index: 10;
        pointer-events: none;
        opacity: 0;
        transition: opacity 0.2s;
        max-width: 120px;
        text-align: center;
    }

    .pcc-tooltip.active {
        opacity: 1;
    }

    .pcc-tooltip-title {
        font-weight: 700;
        color: var(--tw);
        margin-bottom: 2px;
    }

    .pcc-tooltip-code {
        font-family: 'Orbitron', monospace;
        font-size: 0.55rem;
        color: var(--c);
        margin-bottom: 2px;
    }

    .pcc-tooltip-salary {
        font-size: 0.6rem;
        color: var(--g);
    }

    /* Parallax effect */
    .path-chart-card {
        transition: transform 0.3s ease-out;
    }

    /* Typewriter Animation - Looping */
    .terminal-line {
        overflow: hidden;
        white-space: nowrap;
        display: block;
        animation: typewriter 0.6s steps(60, end) 1 infinite, holdFade 9s ease-in-out infinite;
    }

    .terminal-line:nth-child(1) {
        animation-delay: 0s, 0s;
    }
    .terminal-line:nth-child(2) {
        animation-delay: 0.7s, 0s;
    }
    .terminal-line:nth-child(3) {
        animation-delay: 1.4s, 0s;
    }
    .terminal-line:nth-child(4) {
        animation-delay: 2.1s, 0s;
    }
    .terminal-line:nth-child(5) {
        animation-delay: 2.8s, 0s;
    }

    @keyframes typewriter {
        0% {
            width: 0;
            opacity: 1;
        }
        100% {
            width: 100%;
            opacity: 1;
        }
    }

    @keyframes holdFade {
        0% {
            opacity: 0;
        }
        38% {
            opacity: 1;
        }
        85% {
            opacity: 1;
        }
        100% {
            opacity: 0;
        }
    }

    .terminal-cursor {
        display: inline-block;
        width: 2px;
        height: 1em;
        background: var(--c);
        margin-left: 4px;
        animation: blink 0.7s infinite;
    }

    @keyframes blink {
        0%, 49% { opacity: 1; }
        50%, 100% { opacity: 0; }
    }
</style>

<!-- HERO SECTION -->
<section class="hero">
    <div class="hero-inner">
        <!-- Urgency Banner -->
        <div class="urgency-pill" style="position: absolute; top: 20px; left: 2.5rem; z-index: 10;">
            <span class="up-dot"></span>
            <span>Next cohort — Only <span id="seats-count">6</span> seats left</span>
        </div>

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
                    <div class="counter-num">1200+</div>
                    <div class="stat-label">Students Trained</div>
                </div>
                <div class="stat">
                    <div class="counter-num">96%</div>
                    <div class="stat-label">Pass Rate</div>
                </div>
                <div class="stat">
                    <div class="counter-num">10+</div>
                    <div class="stat-label">Years Experience</div>
                </div>
            </div>
        </div>

        <!-- RIGHT SIDE - CERT TRACKS -->
        <div class="hero-right">
            <div class="cert-showcase">
                                <div class="cert-card">
                    <!-- Header -->
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; padding-bottom: 1.5rem; border-bottom: 1px solid var(--bdr);">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <span style="width: 10px; height: 10px; border-radius: 50%; background: #00d4ff; box-shadow: 0 0 12px #00d4ff;"></span>
                            <h3 style="margin: 0; font-size: 1.1rem; font-weight: 700; letter-spacing: 2px; color: #00d4ff; font-family: Orbitron;">CERT TRACKS</h3>
                        </div>
                        <div style="display: flex; gap: 8px;">
                            <span style="width: 12px; height: 12px; border-radius: 50%; background: #ff4444;"></span>
                            <span style="width: 12px; height: 12px; border-radius: 50%; background: #ffaa00;"></span>
                            <span style="width: 12px; height: 12px; border-radius: 50%; background: #00ff88;"></span>
                        </div>
                    </div>

                    <!-- 4 Tile Grid -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
                        <!-- CCNA Tile -->
                        <div style="border: 1px solid rgba(0,212,255,0.25); border-radius: 12px; padding: 1.5rem; background: rgba(0,212,255,0.05); transition: all 0.3s ease; cursor: pointer;" onmouseover="this.style.borderColor='#00d4ff'; this.style.background='rgba(0,212,255,0.1)'; this.style.transform='translateY(-4px)';" onmouseout="this.style.borderColor='rgba(0,212,255,0.25)'; this.style.background='rgba(0,212,255,0.05)'; this.style.transform='translateY(0)';">
                            <div style="text-align: center; margin-bottom: 1rem;">
                                <i class="fas fa-globe" style="font-size: 2.5rem; color: #00d4ff;"></i>
                            </div>
                            <div style="text-align: center;">
                                <div style="font-size: 1rem; font-weight: 700; color: #c8ddf0; margin-bottom: 0.5rem; font-family: Orbitron;">CCNA</div>
                                <div style="font-size: 0.85rem; color: #00d4ff; font-weight: 600;">EXAM 200-301</div>
                            </div>
                        </div>

                        <!-- CCNP Tile -->
                        <div style="border: 1px solid rgba(255,106,0,0.25); border-radius: 12px; padding: 1.5rem; background: rgba(255,106,0,0.05); transition: all 0.3s ease; cursor: pointer;" onmouseover="this.style.borderColor='#ff6a00'; this.style.background='rgba(255,106,0,0.1)'; this.style.transform='translateY(-4px)';" onmouseout="this.style.borderColor='rgba(255,106,0,0.25)'; this.style.background='rgba(255,106,0,0.05)'; this.style.transform='translateY(0)';">
                            <div style="text-align: center; margin-bottom: 1rem;">
                                <i class="fas fa-diamond" style="font-size: 2.5rem; color: #ff6a00;"></i>
                            </div>
                            <div style="text-align: center;">
                                <div style="font-size: 1rem; font-weight: 700; color: #c8ddf0; margin-bottom: 0.5rem; font-family: Orbitron;">CCNP</div>
                                <div style="font-size: 0.85rem; color: #ff6a00; font-weight: 600;">ENCOR 350-401</div>
                            </div>
                        </div>

                        <!-- Security Tile -->
                        <div style="border: 1px solid rgba(255,106,0,0.25); border-radius: 12px; padding: 1.5rem; background: rgba(255,106,0,0.05); transition: all 0.3s ease; cursor: pointer;" onmouseover="this.style.borderColor='#ff6a00'; this.style.background='rgba(255,106,0,0.1)'; this.style.transform='translateY(-4px)';" onmouseout="this.style.borderColor='rgba(255,106,0,0.25)'; this.style.background='rgba(255,106,0,0.05)'; this.style.transform='translateY(0)';">
                            <div style="text-align: center; margin-bottom: 1rem;">
                                <i class="fas fa-lock" style="font-size: 2.5rem; color: #ff6a00;"></i>
                            </div>
                            <div style="text-align: center;">
                                <div style="font-size: 1rem; font-weight: 700; color: #c8ddf0; margin-bottom: 0.5rem; font-family: Orbitron;">SECURITY</div>
                                <div style="font-size: 0.85rem; color: #ff6a00; font-weight: 600;">SCOR 350-701</div>
                            </div>
                        </div>

                        <!-- Automation Tile -->
                        <div style="border: 1px solid rgba(100,200,255,0.25); border-radius: 12px; padding: 1.5rem; background: rgba(100,200,255,0.05); transition: all 0.3s ease; cursor: pointer;" onmouseover="this.style.borderColor='#64c8ff'; this.style.background='rgba(100,200,255,0.1)'; this.style.transform='translateY(-4px)';" onmouseout="this.style.borderColor='rgba(100,200,255,0.25)'; this.style.background='rgba(100,200,255,0.05)'; this.style.transform='translateY(0)';">
                            <div style="text-align: center; margin-bottom: 1rem;">
                                <i class="fas fa-cog" style="font-size: 2.5rem; color: #9b9bff;"></i>
                            </div>
                            <div style="text-align: center;">
                                <div style="font-size: 1rem; font-weight: 700; color: #c8ddf0; margin-bottom: 0.5rem; font-family: Orbitron;">AUTOMATION</div>
                                <div style="font-size: 0.85rem; color: #9b9bff; font-weight: 600;">SD-WAN + PYTHON</div>
                            </div>
                        </div>
                    </div>

                    <!-- Instructor Footer -->
                    <div class="cert-instructor" style="margin-top: 0; padding-top: 1rem; border-top: 1px solid var(--bdr);">
                        <div class="cert-avatar">AH</div>
                        <div class="cert-instructor-info">
                            <div class="cert-instructor-name">AHMED HUSSEIN</div>
                            <div class="cert-instructor-role">Cisco Certified Professional</div>
                        </div>
                        <div style="color:var(--g);font-size:0.75rem;font-weight:700;text-transform:uppercase">● LIVE</div>
                    </div>
                </div></div>
            </div>
        </div>
    </div>
</section>

<!-- TRY BEFORE YOU ENROLL SECTION -->
<section style="padding: 4rem 2rem; background: linear-gradient(135deg, var(--bg) 0%, var(--bg2) 100%); position: relative; z-index: 1; overflow: hidden;">
    <div style="max-width: 1200px; margin: 0 auto;">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: center;">
            <!-- LEFT SIDE -->
            <div>
                <div style="display: inline-flex; align-items: center; gap: 8px; margin-bottom: 1.5rem; color: var(--c); font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 2px;">
                    <span style="width: 20px; height: 2px; background: var(--c);"></span>
                    TRY BEFORE YOU ENROLL
                </div>

                <h2 style="font-size: 2.5rem; font-weight: 800; color: var(--tw); margin-bottom: 1.5rem; line-height: 1.2; font-family: 'Orbitron', monospace;">
                    Run a Real Lab<br>Right Now
                </h2>

                <p style="font-size: 1rem; color: var(--c); margin-bottom: 2rem; line-height: 1.6;">
                    Configure 802.1Q trunking and LACP on actual Cisco topology. Free Packet Tracer file included.
                </p>

                <!-- Features -->
                <ul style="list-style: none; padding: 0; margin-bottom: 2.5rem;">
                    <li style="display: flex; align-items: center; gap: 12px; margin-bottom: 1rem; color: var(--t); font-size: 1rem;">
                        <span style="width: 20px; height: 20px; border-radius: 50%; background: var(--g); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i class="fas fa-check" style="color: var(--bg); font-size: 0.75rem;"></i>
                        </span>
                        Real Cisco IOS commands
                    </li>
                    <li style="display: flex; align-items: center; gap: 12px; margin-bottom: 1rem; color: var(--t); font-size: 1rem;">
                        <span style="width: 20px; height: 20px; border-radius: 50%; background: var(--g); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i class="fas fa-check" style="color: var(--bg); font-size: 0.75rem;"></i>
                        </span>
                        Step-by-step task guide
                    </li>
                    <li style="display: flex; align-items: center; gap: 12px; color: var(--t); font-size: 1rem;">
                        <span style="width: 20px; height: 20px; border-radius: 50%; background: var(--g); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i class="fas fa-check" style="color: var(--bg); font-size: 0.75rem;"></i>
                        </span>
                        Free Packet Tracer software
                    </li>
                </ul>

                <!-- CTA Buttons -->
                <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                    <a href="{{ route('courses.index') }}" style="display: inline-flex; align-items: center; gap: 8px; background: var(--c); color: var(--bg); padding: 12px 28px; border-radius: 8px; font-weight: 700; text-transform: uppercase; font-size: 0.9rem; text-decoration: none; transition: all 0.3s; border: 2px solid var(--c);">
                        <i class="fas fa-flask-vial"></i> START FREE LAB
                    </a>
                    <a href="{{ route('courses.index') }}" style="display: inline-flex; align-items: center; gap: 8px; background: transparent; color: var(--c); padding: 10px 26px; border: 2px solid var(--c); border-radius: 8px; font-weight: 700; text-transform: uppercase; font-size: 0.9rem; text-decoration: none; transition: all 0.3s;">
                        <i class="fas fa-eye"></i> PREVIEW LABS
                    </a>
                </div>
            </div>

            <!-- RIGHT SIDE - TERMINAL MOCKUP -->
            <div style="background: rgba(12, 22, 40, 0.6); border: 1px solid var(--bdr); border-radius: 12px; padding: 1.5rem; font-family: 'Courier New', monospace; overflow: hidden;">
                <!-- Terminal Header -->
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid var(--bdr);">
                    <span style="width: 10px; height: 10px; border-radius: 50%; background: #ff6a56;"></span>
                    <span style="width: 10px; height: 10px; border-radius: 50%; background: #ffbd44;"></span>
                    <span style="width: 10px; height: 10px; border-radius: 50%; background: #00d4ff;"></span>
                    <span style="margin-left: auto; font-size: 0.75rem; color: var(--c); font-weight: 700; letter-spacing: 2px;">CISCO IOS - LAB 01</span>
                </div>

                <!-- Terminal Content -->
                <div style="font-size: 0.85rem; line-height: 1.6; color: var(--c);">
                    <div class="terminal-line" style="margin-bottom: 0.5rem;">sw1$ <span style="color: var(--t);">configure terminal</span></div>
                    <div class="terminal-line" style="margin-bottom: 0.5rem;">sw1(config)$ <span style="color: var(--t);">interface range Fa0/1-2</span></div>
                    <div class="terminal-line" style="margin-bottom: 0.5rem;">sw1(config-if)$ <span style="color: var(--t);">switchport trunk encapsulation dotlq</span></div>
                    <div class="terminal-line" style="margin-bottom: 0.5rem;">sw1(config-if)$ <span style="color: var(--t);">switchport mode trunk</span></div>
                    <div class="terminal-line" style="color: var(--c);">sw1(config-if)$ <span style="color: var(--t);">channel-group 10 mode active</span><span class="terminal-cursor"></span></div>
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
                <div class="course-card reveal" data-stagger="{{ $loop->index + 1 }}">
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
        <div class="feature-item reveal" data-stagger="1">
            <div class="feature-icon"><i class="fas fa-laptop"></i></div>
            <div class="feature-title">Hands-On Labs</div>
            <p class="feature-desc">20+ practical Packet Tracer labs with real-world configuration scenarios</p>
        </div>
        <div class="feature-item reveal" data-stagger="2">
            <div class="feature-icon"><i class="fas fa-book"></i></div>
            <div class="feature-title">Structured Curriculum</div>
            <p class="feature-desc">Comprehensive lessons aligned with official Cisco certification exams</p>
        </div>
        <div class="feature-item reveal" data-stagger="3">
            <div class="feature-icon"><i class="fas fa-chart-line"></i></div>
            <div class="feature-title">Progress Tracking</div>
            <p class="feature-desc">Monitor your learning journey with detailed progress analytics</p>
        </div>
        <div class="feature-item reveal" data-stagger="4">
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
            <div class="testimonial-card reveal" data-stagger="1">
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

            <div class="testimonial-card reveal" data-stagger="2">
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

            <div class="testimonial-card reveal" data-stagger="3">
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
            <div class="pricing-card reveal" data-stagger="1">
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
            <div class="pricing-card featured reveal" data-stagger="2">
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
            <p>Quick answers to help you get started</p>
        </div>

        <div class="faq-grid reveal">
            <div class="faq-card">
                <h3><i class="fas fa-book"></i> What are the prerequisites?</h3>
                <p>No formal prerequisites required. Basic IT knowledge recommended. We cover everything from fundamentals to advanced topics with review materials for beginners.</p>
            </div>

            <div class="faq-card">
                <h3><i class="fas fa-clock"></i> How long to complete?</h3>
                <p>CCNA typically takes 4-6 weeks at 10-12 hours/week. Lifetime access lets you learn at your pace. Most students complete within 8-12 weeks with labs and exams.</p>
            </div>

            <div class="faq-card">
                <h3><i class="fas fa-check"></i> Are labs NetAcad aligned?</h3>
                <p>Yes, all labs align with Cisco NetAcad curriculum and real exam scenarios. We use official Cisco Packet Tracer simulation software for hands-on practice.</p>
            </div>

            <div class="faq-card">
                <h3><i class="fas fa-star"></i> What's in Premium?</h3>
                <p>Full course access, all labs, direct mentorship, certificates, downloadable resources, lifetime access, and exclusive weekly live Q&A sessions with Ahmed Hussein.</p>
            </div>

            <div class="faq-card">
                <h3><i class="fas fa-chart-line"></i> What's the pass rate?</h3>
                <p>Our students achieve 96% pass rate on Cisco exams. We provide comprehensive curriculum, hands-on labs, and dedicated mentorship. Money-back guarantee if unsatisfied.</p>
            </div>

            <div class="faq-card">
                <h3><i class="fas fa-credit-card"></i> Payment options?</h3>
                <p>Flexible plans available: monthly ($29/mo), quarterly, or annual with discounts. Interest-free payment plans available through our trusted payment processors.</p>
            </div>
        </div>
    </div>
</section>

<!-- FINAL CTA SECTION -->
<section style="padding:4rem 2rem;background:linear-gradient(135deg,rgba(0,212,255,0.08),rgba(255,106,0,0.04));border-top:1px solid var(--bdr);position:relative;z-index:1;text-align:center">
    <div style="max-width:800px;margin:0 auto" class="reveal">
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
    // FLOATING PARTICLES ANIMATION
    function createParticles() {
        const particleCount = 20;
        const container = document.body;

        for (let i = 0; i < particleCount; i++) {
            const particle = document.createElement('div');
            particle.className = 'particle';

            const size = Math.random() * 3 + 1;
            const x = Math.random() * window.innerWidth;
            const y = Math.random() * window.innerHeight;
            const duration = Math.random() * 20 + 20;
            const delay = Math.random() * 5;

            particle.style.width = size + 'px';
            particle.style.height = size + 'px';
            particle.style.left = x + 'px';
            particle.style.top = y + 'px';
            particle.style.background = ['rgba(0, 212, 255, 0.5)', 'rgba(0, 255, 136, 0.5)', 'rgba(255, 106, 0, 0.3)'][Math.floor(Math.random() * 3)];
            particle.style.borderRadius = '50%';
            particle.style.animation = `float ${duration}s linear ${delay}s infinite`;

            container.appendChild(particle);
        }
    }

    @keyframes float {
        0% {
            transform: translateY(0) translateX(0);
            opacity: 0.5;
        }
        50% {
            opacity: 1;
        }
        100% {
            transform: translateY(-100vh) translateX(100px);
            opacity: 0;
        }
    }

    // SCROLL REVEAL ANIMATION
    function initScrollReveal() {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.reveal').forEach(el => {
            observer.observe(el);
        });
    }

    // ANIMATED COUNTERS
    function animateCounters() {
        const counters = document.querySelectorAll('.counter-num');

        counters.forEach(counter => {
            const target = parseInt(counter.innerText);
            const increment = target / 30;
            let current = 0;

            const updateCounter = () => {
                current += increment;
                if (current < target) {
                    counter.innerText = Math.floor(current) + (counter.innerText.includes('+') ? '+' : counter.innerText.includes('%') ? '%' : '');
                    requestAnimationFrame(updateCounter);
                } else {
                    counter.innerText = counter.dataset.original;
                }
            };

            counter.dataset.original = counter.innerText;

            const observer = new IntersectionObserver((entries) => {
                if (entries[0].isIntersecting) {
                    updateCounter();
                    observer.unobserve(counter);
                }
            }, { threshold: 0.5 });

            observer.observe(counter);
        });
    }

    // INITIALIZE ANIMATIONS ON PAGE LOAD
    document.addEventListener('DOMContentLoaded', function() {
        createParticles();
        initScrollReveal();
        animateCounters();

        // Career Path Chart - Tooltips & Parallax
        (function() {
            // Tooltip data
            const chartData = {
                node0: { name: 'CCST Networking', code: '100-150', desc: 'Entry-level foundations', salary: 'Entry-level IT' },
                node1: { name: 'CCNA Enterprise', code: '200-301', desc: 'Routing & Switching', salary: '$55K-$85K' },
                node2: { name: 'CCNP Enterprise', code: '350-401', desc: 'Advanced networking', salary: '$90K-$130K' },
                node3: { name: 'CCIE Enterprise', code: '★ Expert', desc: 'Master level', salary: '$140K-$200K+' },
                node4: { name: 'CCST Cyber', code: '100-160', desc: 'Security foundations', salary: 'Entry-level Sec' },
                node5: { name: 'CCNA Cyber', code: '200-201', desc: 'Threat analysis', salary: '$65K-$100K' },
                node6: { name: 'CCNP Cyber', code: 'Coming', desc: 'Advanced security', salary: 'TBD' }
            };

            // Create tooltip
            const tooltip = document.createElement('div');
            tooltip.className = 'pcc-tooltip';
            tooltip.innerHTML = '<div class="pcc-tooltip-title">Title</div><div class="pcc-tooltip-code">Code</div><div class="pcc-tooltip-salary">Salary</div>';
            document.querySelector('.path-chart-card').appendChild(tooltip);

            // SVG nodes hover
            const svg = document.querySelector('.chart-svg');
            if (!svg) return;

            const nodes = svg.querySelectorAll('.pcc-node');
            let currentNode = null;

            nodes.forEach((node, idx) => {
                node.style.cursor = 'pointer';
                node.addEventListener('mouseenter', function(e) {
                    const key = 'node' + idx;
                    const data = chartData[key];
                    if (!data) return;

                    const rect = node.getBoundingClientRect();
                    const parentRect = node.closest('.path-chart-card').getBoundingClientRect();

                    tooltip.querySelector('.pcc-tooltip-title').textContent = data.name;
                    tooltip.querySelector('.pcc-tooltip-code').textContent = data.code;
                    tooltip.querySelector('.pcc-tooltip-salary').textContent = data.salary;
                    tooltip.classList.add('active');

                    const offsetY = rect.top - parentRect.top - 60;
                    const offsetX = rect.left - parentRect.left - 60;
                    tooltip.style.top = Math.max(5, offsetY) + 'px';
                    tooltip.style.left = Math.max(5, offsetX) + 'px';

                    currentNode = node;
                });

                node.addEventListener('mouseleave', function() {
                    tooltip.classList.remove('active');
                    currentNode = null;
                });
            });

            // Parallax effect
            let parallaxCard = document.querySelector('.path-chart-card');
            if (parallaxCard) {
                window.addEventListener('scroll', function() {
                    const rect = parallaxCard.getBoundingClientRect();
                    const offset = (window.innerHeight - rect.top) * 0.02;
                    parallaxCard.style.transform = 'translateY(' + offset + 'px)';
                });
            }
        })();

        // Career Paths - Tooltip Interactions
        const chartCard = document.querySelector('.path-chart-card');
        if (chartCard) {
            const tooltip = chartCard.querySelector('.pcc-tooltip');
            const nodes = chartCard.querySelectorAll('.pcc-node');

            nodes.forEach(node => {
                node.style.cursor = 'pointer';
                node.style.transition = 'all 0.3s ease';

                node.addEventListener('mouseenter', function() {
                    const name = this.getAttribute('data-name');
                    const code = this.getAttribute('data-code');
                    const salary = this.getAttribute('data-salary');

                    if (tooltip && name) {
                        tooltip.querySelector('.pcc-tooltip-title').textContent = name;
                        tooltip.querySelector('.pcc-tooltip-code').textContent = code;
                        tooltip.querySelector('.pcc-tooltip-salary').textContent = salary;
                        tooltip.style.display = 'block';

                        const rect = this.getBoundingClientRect();
                        const cardRect = chartCard.getBoundingClientRect();
                        tooltip.style.left = (rect.left - cardRect.left + rect.width / 2 - 60) + 'px';
                        tooltip.style.top = (rect.top - cardRect.top - 80) + 'px';
                    }

                    this.style.filter = 'brightness(1.3) drop-shadow(0 0 20px currentColor)';
                });

                node.addEventListener('mouseleave', function() {
                    if (tooltip) tooltip.style.display = 'none';
                    this.style.filter = 'none';
                });
            });
        }

        // Add keyframes dynamically
        const style = document.createElement('style');
        style.textContent = `
            @keyframes float {
                0% { transform: translateY(0) translateX(0); opacity: 0.5; }
                50% { opacity: 1; }
                100% { transform: translateY(-100vh) translateX(100px); opacity: 0; }
            }

            .pcc-tooltip {
                position: absolute;
                background: rgba(12, 22, 40, 0.95);
                border: 1px solid rgba(0, 212, 255, 0.3);
                border-radius: 8px;
                padding: 10px 14px;
                font-size: 0.75rem;
                color: #c8ddf0;
                white-space: nowrap;
                z-index: 1000;
                box-shadow: 0 0 15px rgba(0, 212, 255, 0.2), inset 0 0 15px rgba(0, 212, 255, 0.05);
                backdrop-filter: blur(4px);
            }

            .pcc-tooltip-title {
                font-weight: 700;
                color: #00d4ff;
                margin-bottom: 4px;
            }

            .pcc-tooltip-code {
                color: #7a9ab5;
                font-size: 0.7rem;
                margin-bottom: 2px;
            }

            .pcc-tooltip-salary {
                color: #00ff88;
                font-weight: 600;
                font-size: 0.7rem;
            }
        `;
        document.head.appendChild(style);
    });

</script>
@endsection
