@extends('layouts.app')

@section('title', 'My Learning')

@section('content')
<style>
    .learning-header {
        background: linear-gradient(135deg, rgba(0,212,255,0.1) 0%, rgba(0,255,136,0.1) 100%);
        border-bottom: 2px solid var(--c);
        padding: 3rem 2rem;
        margin-bottom: 3rem;
        position: relative;
        z-index: 1;
    }

    .learning-header h1 {
        font-family: 'Orbitron', monospace;
        font-size: clamp(2rem, 4vw, 2.5rem);
        background: linear-gradient(135deg, var(--c) 0%, #00ff88 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin: 0;
        font-weight: 700;
    }

    .learning-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 2rem;
        position: relative;
        z-index: 1;
    }

    .enrollment-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
        gap: 2rem;
        margin-bottom: 3rem;
    }

    .enrollment-card {
        border: 1px solid var(--bdr);
        border-radius: 12px;
        overflow: hidden;
        background: var(--card);
        transition: all 0.3s;
        display: flex;
        flex-direction: column;
    }

    .enrollment-card:hover {
        border-color: var(--c);
        transform: translateY(-8px);
        box-shadow: 0 12px 40px rgba(0,212,255,0.15);
    }

    .enrollment-thumb {
        height: 200px;
        background: linear-gradient(135deg, var(--c), var(--c2));
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--bg);
        font-family: 'Orbitron', monospace;
        font-weight: 700;
        font-size: 1.1rem;
        text-align: center;
        padding: 1rem;
    }

    .enrollment-body {
        padding: 1.75rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .enrollment-title {
        font-family: 'Orbitron', monospace;
        font-size: 1.15rem;
        color: var(--tw);
        margin: 0 0 0.75rem 0;
        font-weight: 700;
    }

    .enrollment-desc {
        color: var(--tm);
        font-size: 0.9rem;
        margin: 0 0 1.25rem 0;
        line-height: 1.6;
    }

    .progress-section {
        margin-bottom: 1.5rem;
    }

    .progress-label {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.75rem;
        font-size: 0.85rem;
    }

    .progress-label-text {
        color: var(--tm);
    }

    .progress-percent {
        color: var(--c);
        font-weight: 700;
        font-family: 'Orbitron', monospace;
    }

    .progress-bar-container {
        height: 6px;
        background: var(--bg3);
        border-radius: 3px;
        overflow: hidden;
    }

    .progress-bar-fill {
        height: 100%;
        background: linear-gradient(90deg, var(--c), var(--c2));
        border-radius: 3px;
        transition: width 0.3s ease;
    }

    .enrollment-meta {
        display: flex;
        gap: 1rem;
        padding: 1rem 0;
        border-top: 1px solid var(--bdr);
        border-bottom: 1px solid var(--bdr);
        margin-bottom: 1rem;
    }

    .meta-item {
        flex: 1;
        text-align: center;
        color: var(--tm);
        font-size: 0.85rem;
    }

    .meta-item i {
        color: var(--c);
        margin-right: 0.5rem;
    }

    .meta-value {
        display: block;
        color: var(--t);
        font-weight: 600;
        margin-top: 0.25rem;
    }

    .completion-badge {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem;
        background: rgba(0,255,136,0.1);
        border: 1px solid rgba(0,255,136,0.3);
        border-radius: 8px;
        color: var(--g);
        font-size: 0.85rem;
        margin-bottom: 1rem;
    }

    .completion-badge i {
        color: var(--g);
    }

    .continue-btn {
        padding: 0.75rem 1.5rem;
        border: 1.5px solid var(--c);
        background: var(--c);
        color: var(--bg);
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        font-family: 'Exo 2', sans-serif;
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .continue-btn:hover {
        box-shadow: 0 0 30px rgba(0,212,255,0.5);
        transform: translateY(-2px);
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        background: var(--card);
        border: 1px solid var(--bdr);
        border-radius: 12px;
    }

    .empty-state-icon {
        font-size: 3.5rem;
        color: var(--c);
        opacity: 0.3;
        margin-bottom: 1.5rem;
        display: block;
    }

    .empty-state h2 {
        font-family: 'Orbitron', monospace;
        font-size: 1.5rem;
        color: var(--tw);
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        color: var(--tm);
        margin-bottom: 1.5rem;
    }

    .empty-state-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.9rem 2rem;
        border: 2px solid var(--c);
        background: var(--c);
        color: var(--bg);
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        font-family: 'Exo 2', sans-serif;
        transition: all 0.3s;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .empty-state-btn:hover {
        box-shadow: 0 0 30px rgba(0,212,255,0.5);
        transform: translateY(-3px);
    }

    @media (max-width: 768px) {
        .learning-header {
            padding: 2rem 1rem;
            margin-bottom: 2rem;
        }

        .learning-container {
            padding: 0 1rem;
        }

        .enrollment-grid {
            grid-template-columns: 1fr;
        }

        .enrollment-meta {
            flex-direction: column;
            gap: 0;
        }

        .meta-item {
            padding: 0.5rem 0;
        }
    }
</style>

<!-- HEADER -->
<div class="learning-header">
    <div class="learning-container">
        <h1>My Learning</h1>
    </div>
</div>

<!-- CONTENT -->
<div class="learning-container">
    @if($enrollments->isEmpty())
        <div class="empty-state">
            <i class="fas fa-book-open empty-state-icon"></i>
            <h2>No Courses Enrolled Yet</h2>
            <p>You haven't enrolled in any courses yet. Start your learning journey now!</p>
            <a href="{{ route('courses.index') }}" class="empty-state-btn">
                <i class="fas fa-book"></i> Explore Courses
            </a>
        </div>
    @else
        <div class="enrollment-grid">
            @foreach($enrollments as $enrollment)
                <div class="enrollment-card">
                    <div class="enrollment-thumb">
                        {{ Str::limit($enrollment->course->title, 25) }}
                    </div>

                    <div class="enrollment-body">
                        <h3 class="enrollment-title">{{ $enrollment->course->title }}</h3>
                        <p class="enrollment-desc">{{ Str::limit($enrollment->course->description, 100) }}</p>

                        <!-- PROGRESS -->
                        <div class="progress-section">
                            <div class="progress-label">
                                <span class="progress-label-text">Your Progress</span>
                                <span class="progress-percent">{{ (int)$enrollment->progress }}%</span>
                            </div>
                            <div class="progress-bar-container">
                                <div class="progress-bar-fill" style="width: {{ $enrollment->progress }}%"></div>
                            </div>
                        </div>

                        <!-- META INFO -->
                        <div class="enrollment-meta">
                            <div class="meta-item">
                                <i class="fas fa-book"></i>
                                <span class="meta-value">{{ $enrollment->course->lessons->count() }} Lessons</span>
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-user"></i>
                                <span class="meta-value">{{ Str::limit($enrollment->course->creator->name ?? 'Admin', 12) }}</span>
                            </div>
                        </div>

                        <!-- COMPLETION BADGE -->
                        @if($enrollment->completed_at)
                            <div class="completion-badge">
                                <i class="fas fa-check-circle"></i>
                                <span>Completed on {{ $enrollment->completed_at->format('M d, Y') }}</span>
                            </div>
                        @endif

                        <!-- CTA BUTTON -->
                        <a href="{{ route('courses.show', $enrollment->course) }}" class="continue-btn">
                            <i class="fas fa-play"></i> Continue Learning
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
