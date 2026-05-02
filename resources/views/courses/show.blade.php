@extends('layouts.app')

@php
    $userEnrolled = auth()->check() ? auth()->user()->enrollments()->where('course_id', $course->id)->exists() : false;
@endphp

@section('title', $course->title)

@section('content')
<style>
    /* ========== PREMIUM COURSE LAYOUT ========== */
    .course-container-pro {
        display: grid;
        grid-template-columns: 360px 1fr;
        gap: 0;
        margin-top: 80px;
        min-height: calc(100vh - 80px);
        background: var(--bg);
    }

    .course-main-pro {
        overflow-y: auto;
        display: flex;
        flex-direction: column;
    }

    /* ========== PREMIUM SIDEBAR ========== */
    .course-sidebar-pro {
        background: rgba(10, 21, 37, 0.85);
        backdrop-filter: blur(24px);
        -webkit-backdrop-filter: blur(24px);
        border-right: 1px solid rgba(255, 255, 255, 0.06);
        overflow-y: auto;
        display: flex;
        flex-direction: column;
    }

    .sidebar-header-pro {
        padding: 2rem 1.5rem 1.5rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.06);
    }

    .sidebar-title-pro {
        font-family: 'Orbitron', monospace;
        font-size: 1rem;
        font-weight: 700;
        color: var(--tw);
        margin-bottom: 1.5rem;
        letter-spacing: -0.02em;
    }

    /* ========== PREMIUM STAT CARDS ========== */
    .course-stats {
        display: grid;
        gap: 0.75rem;
    }

    .stat-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 0.875rem 1.125rem;
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(255, 255, 255, 0.06);
        border-radius: 10px;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .stat-item:hover {
        background: rgba(255, 255, 255, 0.05);
        border-color: rgba(255, 255, 255, 0.1);
    }

    .stat-icon {
        font-size: 1.25rem;
        color: var(--c);
        min-width: 32px;
        text-align: center;
    }

    .stat-label {
        font-size: 0.6875rem;
        text-transform: uppercase;
        color: var(--tm);
        font-weight: 600;
        letter-spacing: 0.08em;
        line-height: 1;
    }

    .stat-value {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--tw);
        font-family: 'Orbitron', monospace;
        line-height: 1;
    }

    /* ========== PREMIUM CURRICULUM SIDEBAR ========== */
    .curriculum-sidebar {
        flex: 1;
        padding: 1.5rem;
        overflow-y: auto;
    }

    .curriculum-item-pro {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 0.875rem;
        margin-bottom: 0.5rem;
        color: var(--tm);
        border-radius: 8px;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        text-decoration: none;
        position: relative;
        border-left: 3px solid transparent;
    }

    .curriculum-item-pro:hover {
        color: var(--tw);
        background: rgba(0, 212, 255, 0.05);
        border-left-color: rgba(0, 212, 255, 0.4);
    }

    .curriculum-item-pro.active {
        color: var(--c);
        background: rgba(0, 212, 255, 0.08);
        border-left-color: var(--c);
    }

    .curriculum-number-pro {
        min-width: 28px;
        font-size: 0.8125rem;
        font-weight: 700;
        color: rgba(0, 212, 255, 0.8);
        font-family: 'Orbitron', monospace;
    }

    /* ========== PREMIUM HERO SECTION ========== */
    .course-hero-pro {
        position: relative;
        height: 420px;
        background: linear-gradient(135deg, rgba(0, 212, 255, 0.1), rgba(0, 255, 136, 0.05));
        border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        display: flex;
        align-items: center;
        padding: 3rem 2.5rem;
        overflow: hidden;
    }

    .course-hero-content {
        position: relative;
        z-index: 2;
        flex: 1;
        max-width: 900px;
    }

    .course-badge-pro {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background: rgba(0, 212, 255, 0.1);
        border: 1px solid rgba(0, 212, 255, 0.3);
        border-radius: 6px;
        font-size: 0.7rem;
        color: var(--c);
        font-weight: 700;
        margin-bottom: 1.5rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
    }

    .course-badge-pro.free {
        background: rgba(0, 255, 136, 0.1);
        border-color: rgba(0, 255, 136, 0.3);
        color: #00ff88;
    }

    .course-badge-pro.premium {
        background: rgba(255, 106, 0, 0.1);
        border-color: rgba(255, 106, 0, 0.3);
        color: #ff6a00;
    }

    .course-title-pro {
        font-family: 'Orbitron', monospace;
        font-size: clamp(2rem, 4vw, 3rem);
        font-weight: 900;
        color: var(--tw);
        margin-bottom: 1.25rem;
        line-height: 1.1;
        letter-spacing: -0.02em;
    }

    .course-meta-pro {
        display: flex;
        gap: 2.5rem;
        flex-wrap: wrap;
        color: var(--tm);
        font-size: 0.9rem;
    }

    .meta-item-pro {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .meta-item-pro i {
        color: var(--c);
        font-size: 1rem;
    }

    .course-hero-image {
        position: absolute;
        right: 0;
        top: 0;
        height: 100%;
        width: 35%;
        object-fit: cover;
        opacity: 0.25;
        z-index: 1;
    }

    /* ========== PREMIUM TABS ========== */
    .course-tabs-pro {
        display: flex;
        gap: 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        background: rgba(255, 255, 255, 0.02);
        padding: 0 2.5rem;
        overflow-x: auto;
    }

    .course-tab-pro {
        padding: 1rem 1.5rem;
        color: var(--tm);
        border: none;
        background: none;
        cursor: pointer;
        font-size: 0.875rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        transition: color 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        border-bottom: 2px solid transparent;
        white-space: nowrap;
        position: relative;
    }

    .course-tab-pro:hover {
        color: var(--tw);
    }

    .course-tab-pro.active {
        color: var(--c);
        border-bottom-color: var(--c);
    }

    .course-tab-pro i {
        margin-right: 0.5rem;
    }

    /* ========== CONTENT AREA ========== */
    .course-content-area-pro {
        flex: 1;
        padding: 2.5rem;
        overflow-y: auto;
    }

    .tab-panel {
        display: none;
    }

    .tab-panel.active {
        display: block;
        animation: fadeInUp 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .description-section {
        margin-bottom: 3rem;
    }

    .section-heading {
        font-family: 'Orbitron', monospace;
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--tw);
        margin-bottom: 1.5rem;
        letter-spacing: -0.02em;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .section-heading::before {
        content: '';
        display: inline-block;
        width: 3px;
        height: 24px;
        background: linear-gradient(180deg, var(--c), var(--c2));
        border-radius: 1px;
    }

    .description-text {
        color: var(--t);
        line-height: 1.75;
        font-size: 0.95rem;
    }

    .curriculum-list {
        display: grid;
        gap: 1rem;
    }

    .curriculum-item {
        padding: 1rem 1.25rem;
        background: rgba(0, 212, 255, 0.04);
        border: 1px solid rgba(0, 212, 255, 0.15);
        border-radius: 10px;
        display: flex;
        align-items: center;
        gap: 0.875rem;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .curriculum-item:hover {
        background: rgba(0, 212, 255, 0.08);
        border-color: rgba(0, 212, 255, 0.25);
    }

    .curriculum-item i {
        color: #00ff88;
        font-size: 1rem;
    }

    /* ========== LESSON CARDS ========== */
    .lessons-grid-pro {
        display: grid;
        gap: 1.25rem;
    }

    .lesson-card-pro {
        border: 1px solid rgba(0, 212, 255, 0.15);
        border-radius: 12px;
        padding: 1.5rem;
        background: rgba(0, 212, 255, 0.04);
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        display: flex;
        gap: 1.5rem;
        align-items: flex-start;
        text-decoration: none;
        color: inherit;
    }

    .lesson-card-pro:hover {
        background: rgba(0, 212, 255, 0.08);
        border-color: var(--c);
        transform: translateY(-2px);
        box-shadow: 0 0 0 1px rgba(255, 255, 255, 0.05), 0 8px 24px rgba(0, 0, 0, 0.3);
    }

    .lesson-number-pro {
        min-width: 48px;
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, var(--c), var(--c2));
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--bg);
        font-weight: 700;
        font-family: 'Orbitron', monospace;
        font-size: 1rem;
        flex-shrink: 0;
    }

    .lesson-info-pro {
        flex: 1;
    }

    .lesson-title-pro {
        font-weight: 600;
        color: var(--tw);
        margin-bottom: 0.5rem;
        font-size: 0.9375rem;
        line-height: 1.4;
    }

    .lesson-preview-pro {
        color: var(--tm);
        font-size: 0.8125rem;
        line-height: 1.5;
        margin-bottom: 0.75rem;
    }

    .lesson-meta-pro {
        display: flex;
        gap: 1.25rem;
        font-size: 0.75rem;
        color: var(--tm);
    }

    .lesson-meta-pro i {
        color: rgba(0, 212, 255, 0.6);
        margin-right: 0.25rem;
    }

    /* ========== ENROLLMENT BUTTON ========== */
    .enroll-button-pro {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        background: linear-gradient(135deg, var(--c), var(--c2));
        color: var(--bg);
        border: none;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        font-size: 0.9rem;
        text-decoration: none;
    }

    .enroll-button-pro:hover {
        transform: translateY(-2px);
        box-shadow: 0 0 0 1px rgba(255, 255, 255, 0.1), 0 8px 32px rgba(0, 212, 255, 0.3);
    }

    /* ========== LIGHT THEME ========== */
    [data-theme="light"] .course-sidebar-pro {
        background: rgba(255, 255, 255, 0.95);
        border-right: 1px solid rgba(0, 0, 0, 0.08);
    }

    [data-theme="light"] .stat-item {
        background: rgba(0, 0, 0, 0.02);
        border-color: rgba(0, 0, 0, 0.08);
    }

    [data-theme="light"] .course-hero-pro {
        background: linear-gradient(135deg, rgba(0, 98, 204, 0.08), rgba(0, 150, 136, 0.05));
        border-bottom: 1px solid rgba(0, 0, 0, 0.08);
    }

    [data-theme="light"] .course-tabs-pro {
        background: rgba(0, 0, 0, 0.02);
        border-bottom: 1px solid rgba(0, 0, 0, 0.08);
    }

    [data-theme="light"] .lesson-card-pro {
        background: rgba(0, 98, 204, 0.04);
        border-color: rgba(0, 98, 204, 0.15);
    }

    [data-theme="light"] .lesson-card-pro:hover {
        background: rgba(0, 98, 204, 0.08);
        border-color: #0062cc;
    }

    /* ========== RESPONSIVE ========== */
    @media (max-width: 1024px) {
        .course-container-pro {
            grid-template-columns: 1fr;
        }

        .course-sidebar-pro {
            border-right: none;
            border-top: 1px solid rgba(255, 255, 255, 0.06);
            max-height: 300px;
        }
    }

    @media (max-width: 768px) {
        .course-hero-pro {
            height: 300px;
            padding: 2rem 1.5rem;
        }

        .course-title-pro {
            font-size: 1.75rem;
        }

        .course-meta-pro {
            gap: 1.5rem;
            font-size: 0.85rem;
        }

        .course-tabs-pro {
            padding: 0 1.5rem;
        }

        .course-content-area-pro {
            padding: 1.5rem;
        }

        .lesson-card-pro {
            flex-direction: column;
            gap: 1rem;
        }

        .lesson-number-pro {
            width: 40px;
            height: 40px;
            font-size: 0.9rem;
        }
    }
</style>

<div class="course-container-pro">
    <!-- SIDEBAR (LEFT) -->
    <div class="course-sidebar-pro">
        <div class="sidebar-header-pro">
            <h4 class="sidebar-title-pro">{{ $course->title }}</h4>
            <div class="course-stats">
                <div class="stat-item">
                    <div class="stat-icon"><i class="fas fa-book"></i></div>
                    <div>
                        <div class="stat-label">Lessons</div>
                        <div class="stat-value">{{ $course->lessons->count() }}</div>
                    </div>
                </div>
                <div class="stat-item">
                    <div class="stat-icon"><i class="fas fa-users"></i></div>
                    <div>
                        <div class="stat-label">Students</div>
                        <div class="stat-value">{{ $course->enrollments->count() }}</div>
                    </div>
                </div>
                <div class="stat-item">
                    <div class="stat-icon"><i class="fas fa-user"></i></div>
                    <div>
                        <div class="stat-label">Instructor</div>
                        <div class="stat-value">{{ auth()->user()->name ?? 'Admin' }}</div>
                    </div>
                </div>
                @if($course->rating)
                    <div class="stat-item">
                        <div class="stat-icon"><i class="fas fa-star" style="color: #ffd700;"></i></div>
                        <div>
                            <div class="stat-label">Rating</div>
                            <div class="stat-value">{{ number_format($course->rating, 1) }}</div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="curriculum-sidebar">
            @foreach($course->lessons as $lesson)
                <a href="{{ route('lessons.show', [$course, $lesson]) }}" class="curriculum-item-pro">
                    <div class="curriculum-number-pro">{{ $lesson->order }}</div>
                    <div style="flex: 1; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">{{ $lesson->title }}</div>
                </a>
            @endforeach
        </div>
    </div>

    <!-- MAIN CONTENT (RIGHT) -->
    <div class="course-main-pro">
        <!-- Hero Section -->
        <div class="course-hero-pro">
            @if($course->image)
                <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}" class="course-hero-image">
            @else
                <div class="course-hero-image" style="background: linear-gradient(135deg, var(--c), var(--c2)); display: flex; align-items: center; justify-content: center; opacity: 0.3;">
                    <i class="fas fa-book" style="font-size: 100px;"></i>
                </div>
            @endif

            <div class="course-hero-content">
                <div style="margin-bottom: 1rem;">
                    <span class="course-badge-pro {{ $course->is_free ? 'free' : 'premium' }}">
                        <i class="fas {{ $course->is_free ? 'fa-check-circle' : 'fa-crown' }}"></i>
                        {{ $course->is_free ? 'Free Course' : 'Premium Course' }}
                    </span>
                </div>

                <h1 class="course-title-pro">{{ $course->title }}</h1>

                <div class="course-meta-pro">
                    <div class="meta-item-pro">
                        <i class="fas fa-book-open"></i>
                        <span>{{ $course->lessons->count() }} Lessons</span>
                    </div>
                    <div class="meta-item-pro">
                        <i class="fas fa-users"></i>
                        <span>{{ $course->enrollments->count() }} Students</span>
                    </div>
                    <div class="meta-item-pro">
                        <i class="fas fa-graduation-cap"></i>
                        <span>{{ $course->level ?? 'Intermediate' }}</span>
                    </div>
                    @if($course->rating)
                        <div class="meta-item-pro">
                            <i class="fas fa-star" style="color: #ffd700;"></i>
                            <span>{{ number_format($course->rating, 1) }} Rating</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Tabs -->
        <div class="course-tabs-pro">
            <button class="course-tab-pro active" onclick="showCourseTab('overview')">
                <i class="fas fa-book"></i> Overview
            </button>
            <button class="course-tab-pro" onclick="showCourseTab('curriculum')">
                <i class="fas fa-list"></i> Curriculum
            </button>
            <button class="course-tab-pro" onclick="showCourseTab('details')">
                <i class="fas fa-info-circle"></i> Details
            </button>
        </div>

        <!-- Content Area -->
        <div class="course-content-area-pro">
            <!-- Overview Tab -->
            <div id="overview" class="tab-panel active">
                @auth
                    @if(!auth()->user()->isAdmin())
                        <div style="margin-bottom: 2rem;">
                            @if(!$userEnrolled && $course->is_free)
                                <form method="POST" action="{{ route('courses.enroll', $course) }}" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="enroll-button-pro">
                                        <i class="fas fa-play-circle"></i>
                                        Start This Course
                                    </button>
                                </form>
                            @elseif($userEnrolled)
                                <button class="enroll-button-pro" disabled style="opacity: 1; background: rgba(0,255,136,0.3); color: #00ff88; cursor: default;">
                                    <i class="fas fa-check-circle"></i>
                                    Already Enrolled
                                </button>
                            @elseif(!$course->is_free)
                                <a href="{{ route('payment.checkout', $course) }}" class="enroll-button-pro" style="text-decoration: none; background: linear-gradient(135deg, var(--c), var(--c2)); color: var(--bg); display: flex; align-items: center; justify-content: center; gap: 0.75rem;">
                                    <i class="fas fa-credit-card"></i>
                                    Buy Now — ${{ number_format($course->price, 2) }}
                                </a>
                            @endif
                        </div>
                    @endif
                @else
                    @if($course->is_free)
                        <div style="margin-bottom: 2rem;">
                            <a href="/login" class="enroll-button-pro" style="text-decoration: none;">
                                <i class="fas fa-sign-in-alt"></i>
                                Login to Enroll
                            </a>
                        </div>
                    @endif
                @endauth

                <div class="description-section">
                    <h3 class="section-heading">Course Description</h3>
                    <p class="description-text">{{ $course->description }}</p>
                </div>

                @if($course->curriculum)
                    <div class="description-section">
                        <h3 class="section-heading">What You'll Learn</h3>
                        <div class="curriculum-list">
                            @php
                                $topics = is_string($course->curriculum) ? json_decode($course->curriculum, true) : $course->curriculum;
                            @endphp
                            @foreach($topics as $topic)
                                <div class="curriculum-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>{{ $topic }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Curriculum Tab -->
            <div id="curriculum" class="tab-panel">
                <h3 class="section-heading">Course Lessons</h3>
                @if($course->lessons->isEmpty())
                    <div style="text-align: center; padding: 3rem 0; color: var(--tm);">
                        <i class="fas fa-inbox" style="font-size: 2.5rem; opacity: 0.3; display: block; margin-bottom: 1rem;"></i>
                        <p>No lessons yet</p>
                    </div>
                @else
                    <div class="lessons-grid-pro">
                        @foreach($course->lessons as $lesson)
                            <a href="{{ route('lessons.show', [$course, $lesson]) }}" class="lesson-card-pro">
                                <div class="lesson-number-pro">{{ $lesson->order }}</div>
                                <div class="lesson-info-pro">
                                    <div class="lesson-title-pro">{{ $lesson->title }}</div>
                                    @if($lesson->content)
                                        <div class="lesson-preview-pro">
                                            {{ Str::limit(strip_tags($lesson->content), 100) }}
                                        </div>
                                    @endif
                                    <div class="lesson-meta-pro">
                                        @if($lesson->video_url)
                                            <span><i class="fas fa-video"></i>Video</span>
                                        @endif
                                        @if($lesson->content)
                                            <span><i class="fas fa-file-alt"></i>Content</span>
                                        @endif
                                        <span><i class="fas fa-clock"></i>{{ ceil(strlen($lesson->content ?? '') / 1000) * 5 }} min</span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Details Tab -->
            <div id="details" class="tab-panel">
                @if($course->prerequisites)
                    <div class="description-section">
                        <h3 class="section-heading">Prerequisites</h3>
                        <p class="description-text">{{ $course->prerequisites }}</p>
                    </div>
                @endif

                <div class="description-section">
                    <h3 class="section-heading">Course Information</h3>
                    <div style="display: grid; gap: 1rem;">
                        <div style="padding: 1rem 1.25rem; background: rgba(0, 212, 255, 0.04); border: 1px solid rgba(0, 212, 255, 0.15); border-radius: 10px;">
                            <div style="color: var(--tm); font-size: 0.8rem; margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.08em;">Instructor</div>
                            <div style="color: var(--tw); font-weight: 600;">{{ $course->creator->name ?? 'Admin' }}</div>
                        </div>
                        <div style="padding: 1rem 1.25rem; background: rgba(0, 212, 255, 0.04); border: 1px solid rgba(0, 212, 255, 0.15); border-radius: 10px;">
                            <div style="color: var(--tm); font-size: 0.8rem; margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.08em;">Duration</div>
                            <div style="color: var(--tw); font-weight: 600;">{{ $course->duration ?? 'Self-paced' }}</div>
                        </div>
                        <div style="padding: 1rem 1.25rem; background: rgba(0, 212, 255, 0.04); border: 1px solid rgba(0, 212, 255, 0.15); border-radius: 10px;">
                            <div style="color: var(--tm); font-size: 0.8rem; margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: 0.08em;">Created</div>
                            <div style="color: var(--tw); font-weight: 600;">{{ $course->created_at->format('M d, Y') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function showCourseTab(tabName) {
        document.querySelectorAll('.tab-panel').forEach(panel => {
            panel.classList.remove('active');
        });
        document.querySelectorAll('.course-tab-pro').forEach(tab => {
            tab.classList.remove('active');
        });
        document.getElementById(tabName).classList.add('active');
        event.target.closest('.course-tab-pro').classList.add('active');
    }
</script>
@endsection
