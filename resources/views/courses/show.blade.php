@extends('layouts.app')

@section('title', $course->title)

@section('content')
<style>
    .course-header {
        background: linear-gradient(135deg, rgba(0,212,255,0.1) 0%, rgba(0,255,136,0.1) 100%);
        border-bottom: 2px solid var(--c);
        padding: 3rem 2rem;
        margin-bottom: 3rem;
        position: relative;
        z-index: 1;
    }

    .course-header h1 {
        font-family: 'Orbitron', monospace;
        font-size: clamp(2rem, 4vw, 2.5rem);
        background: linear-gradient(135deg, var(--c) 0%, #00ff88 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin: 0 0 1rem 0;
        font-weight: 700;
    }

    .course-meta {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        align-items: center;
        color: var(--tm);
        font-size: 0.9rem;
    }

    .course-meta i {
        color: var(--c);
        margin-right: 0.5rem;
    }

    .course-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 2rem;
        position: relative;
        z-index: 1;
        display: grid;
        grid-template-columns: 1fr 320px;
        gap: 2rem;
    }

    .course-main {
        min-width: 0;
    }

    .course-image {
        border: 1px solid var(--bdr);
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 2rem;
        height: 350px;
        background: var(--bg3);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--tm);
    }

    .course-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .course-image-placeholder {
        font-size: 4rem;
        opacity: 0.3;
    }

    .course-description {
        margin-bottom: 2rem;
    }

    .course-description h3 {
        font-family: 'Orbitron', monospace;
        font-size: 1.2rem;
        color: var(--c);
        margin-bottom: 1rem;
    }

    .course-description p {
        color: var(--t);
        line-height: 1.7;
    }

    .section-title {
        font-family: 'Orbitron', monospace;
        font-size: 1.2rem;
        color: var(--c);
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid var(--bdr);
    }

    .lesson-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .lesson-item {
        border: 1px solid var(--bdr);
        border-radius: 10px;
        padding: 1.5rem;
        background: var(--card);
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .lesson-item:hover {
        border-color: var(--c);
        background: rgba(0,212,255,0.02);
        box-shadow: 0 0 20px rgba(0,212,255,0.1);
    }

    .lesson-header {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 0.75rem;
    }

    .lesson-number {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--c), var(--c2));
        color: var(--bg);
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Orbitron', monospace;
        font-weight: 700;
        flex-shrink: 0;
    }

    .lesson-title {
        font-family: 'Orbitron', monospace;
        font-size: 1.1rem;
        color: var(--tw);
        margin: 0;
        flex: 1;
    }

    .lesson-content-type {
        display: flex;
        gap: 0.75rem;
        color: var(--tm);
        font-size: 0.85rem;
        margin-top: 0.5rem;
    }

    .lesson-content-type i {
        color: var(--c);
    }

    .lesson-actions {
        display: flex;
        gap: 0.5rem;
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid var(--bdr);
    }

    .lesson-actions a,
    .lesson-actions button {
        flex: 1;
        padding: 0.5rem;
        background: transparent;
        border: 1px solid var(--c);
        color: var(--c);
        border-radius: 6px;
        text-decoration: none;
        text-align: center;
        font-size: 0.8rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }

    .lesson-actions a:hover,
    .lesson-actions button:hover {
        background: var(--c);
        color: var(--bg);
    }

    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
        color: var(--tm);
    }

    .empty-state i {
        font-size: 2.5rem;
        opacity: 0.3;
        display: block;
        margin-bottom: 1rem;
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        margin-top: 2rem;
    }

    .btn-lms {
        padding: 0.75rem 1.5rem;
        border: 2px solid var(--c);
        background: transparent;
        color: var(--c);
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        font-family: 'Exo 2', sans-serif;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.9rem;
        cursor: pointer;
    }

    .btn-lms:hover {
        background: var(--c);
        color: var(--bg);
        transform: translateY(-2px);
    }

    .btn-lms.primary {
        background: var(--c);
        color: var(--bg);
    }

    .btn-lms.primary:hover {
        box-shadow: 0 0 30px rgba(0,212,255,0.5);
    }

    .course-sidebar {
        position: sticky;
        top: 80px;
    }

    .sidebar-card {
        border: 1px solid var(--bdr);
        border-radius: 10px;
        padding: 1.5rem;
        background: var(--card);
        margin-bottom: 1.5rem;
    }

    .sidebar-title {
        font-family: 'Orbitron', monospace;
        font-size: 1.1rem;
        color: var(--c);
        margin-bottom: 1rem;
    }

    .sidebar-stat {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 0;
        color: var(--t);
        border-bottom: 1px solid var(--bdr);
    }

    .sidebar-stat:last-child {
        border-bottom: none;
    }

    .sidebar-stat i {
        color: var(--c);
        min-width: 20px;
    }

    .sidebar-stat strong {
        color: var(--tw);
        margin-left: auto;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--tm);
        text-decoration: none;
        margin-bottom: 2rem;
        font-family: 'Exo 2', sans-serif;
        transition: all 0.2s;
    }

    .back-link:hover {
        color: var(--c);
    }

    @media (max-width: 1024px) {
        .course-container {
            grid-template-columns: 1fr;
        }

        .course-sidebar {
            position: static;
        }
    }

    @media (max-width: 768px) {
        .course-header {
            padding: 2rem 1rem;
            margin-bottom: 2rem;
        }

        .course-container {
            padding: 0 1rem;
        }

        .lesson-header {
            flex-direction: column;
            align-items: flex-start;
        }

        .lesson-actions {
            flex-direction: column;
        }

        .action-buttons {
            flex-direction: column;
        }

        .btn-lms {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<!-- HEADER -->
<div class="course-header">
    <div class="course-container" style="grid-template-columns: 1fr; gap: 0">
        <div>
            <a href="{{ route('courses.index') }}" class="back-link">
                <i class="fas fa-arrow-left"></i>Back to Courses
            </a>
            <h1>{{ $course->title }}</h1>
            <div class="course-meta">
                <span>
                    @if($course->is_free)
                        <span style="color:#00ff88;font-weight:600">FREE COURSE</span>
                    @else
                        <span style="color:#ff6a00;font-weight:600">PREMIUM COURSE</span>
                    @endif
                </span>
                <span>{{ $course->lessons->count() }} Lessons</span>
                <span><i class="fas fa-user"></i>{{ $course->creator->name ?? 'Admin' }}</span>
            </div>
        </div>
    </div>
</div>

<!-- MAIN CONTENT -->
<div class="course-container">
    <div class="course-main">
        <!-- COURSE IMAGE -->
        @if($course->image)
            <div class="course-image">
                <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}">
            </div>
        @else
            <div class="course-image">
                <div class="course-image-placeholder">
                    <i class="fas fa-book"></i>
                </div>
            </div>
        @endif

        <!-- DESCRIPTION -->
        <div class="course-description">
            <h3>Course Description</h3>
            <p>{{ $course->description }}</p>
        </div>

        <!-- ENROLLMENT BUTTON -->
        @auth
            @if(!auth()->user()->isAdmin())
                <div class="action-buttons">
                    @if(!$userEnrolled)
                        <form method="POST" action="{{ route('courses.enroll', $course) }}" style="display:contents">
                            @csrf
                            <button type="submit" class="btn-lms primary" @if(!$course->is_free) disabled @endif>
                                @if($course->is_free)
                                    <i class="fas fa-check-circle"></i>Enroll Now (FREE)
                                @else
                                    <i class="fas fa-lock"></i>Premium Course (Coming Soon)
                                @endif
                            </button>
                        </form>
                    @else
                        <div style="padding:1rem;border:1px solid var(--g);border-radius:8px;background:rgba(0,255,136,0.05);color:var(--g);display:flex;align-items:center;gap:0.5rem">
                            <i class="fas fa-check-circle"></i>You are enrolled in this course
                        </div>
                    @endif
                </div>
            @endif
        @else
            @if($course->is_free)
                <div class="action-buttons">
                    <a href="/login" class="btn-lms primary">
                        <i class="fas fa-sign-in-alt"></i>Login to Enroll
                    </a>
                </div>
            @endif
        @endauth

        <!-- ADMIN EDIT BUTTON -->
        @auth
            @if(auth()->user()->isAdmin() && auth()->user()->id === $course->created_by)
                <div class="action-buttons">
                    <a href="{{ route('admin.courses.edit', $course) }}" class="btn-lms primary">
                        <i class="fas fa-edit"></i>Edit Course
                    </a>
                </div>
            @endif
        @endauth

        <!-- LESSONS SECTION -->
        <h3 class="section-title" style="margin-top:3rem">Course Lessons</h3>

        @if($course->lessons->isEmpty())
            <div class="empty-state">
                <i class="fas fa-inbox"></i>
                <p>No lessons yet</p>
                @auth
                    @if(auth()->user()->isAdmin() && auth()->user()->id === $course->created_by)
                        <a href="{{ route('admin.lessons.create', $course) }}" class="btn-lms primary" style="margin-top:1rem">
                            <i class="fas fa-plus"></i>Create First Lesson
                        </a>
                    @endif
                @endauth
            </div>
        @else
            <div class="lesson-list">
                @foreach($course->lessons as $index => $lesson)
                    <div class="lesson-item">
                        <div class="lesson-header">
                            <div class="lesson-number">{{ $index + 1 }}</div>
                            <h4 class="lesson-title">{{ $lesson->title }}</h4>
                        </div>

                        <div class="lesson-content-type">
                            @if($lesson->content)
                                <span><i class="fas fa-file-alt"></i>Content</span>
                            @endif
                            @if($lesson->video_url)
                                <span><i class="fas fa-video"></i>Video</span>
                            @endif
                            @if($lesson->file_path)
                                <span><i class="fas fa-download"></i>File</span>
                            @endif
                        </div>

                        @if($lesson->content)
                            <p style="color:var(--tm);font-size:0.9rem;margin-top:0.75rem;margin-bottom:0">
                                {{ Str::limit(strip_tags($lesson->content), 150) }}
                            </p>
                        @endif

                        @auth
                            @if(auth()->user()->isAdmin() && auth()->user()->id === $course->created_by)
                                <div class="lesson-actions">
                                    <a href="{{ route('admin.lessons.edit', [$course, $lesson]) }}">
                                        <i class="fas fa-edit"></i>Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.lessons.destroy', [$course, $lesson]) }}" style="display:contents" onsubmit="return confirm('Delete this lesson?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit">
                                            <i class="fas fa-trash"></i>Delete
                                        </button>
                                    </form>
                                </div>
                            @endif
                        @endauth
                    </div>
                @endforeach
            </div>

            @auth
                @if(auth()->user()->isAdmin() && auth()->user()->id === $course->created_by)
                    <div class="action-buttons" style="margin-top:2rem">
                        <a href="{{ route('admin.lessons.create', $course) }}" class="btn-lms">
                            <i class="fas fa-plus"></i>Add Lesson
                        </a>
                    </div>
                @endif
            @endauth
        @endif
    </div>

    <!-- SIDEBAR -->
    <aside class="course-sidebar">
        <div class="sidebar-card">
            <h4 class="sidebar-title">Course Stats</h4>
            <div class="sidebar-stat">
                <i class="fas fa-book"></i>
                <span>Lessons</span>
                <strong>{{ $course->lessons->count() }}</strong>
            </div>
            <div class="sidebar-stat">
                <i class="fas fa-users"></i>
                <span>Students</span>
                <strong>{{ $course->enrollments->count() }}</strong>
            </div>
            <div class="sidebar-stat">
                <i class="fas fa-user"></i>
                <span>Instructor</span>
                <strong>{{ $course->creator->name ?? 'Admin' }}</strong>
            </div>
            <div class="sidebar-stat">
                <i class="fas fa-calendar"></i>
                <span>Created</span>
                <strong>{{ $course->created_at->format('M d, Y') }}</strong>
            </div>
        </div>
    </aside>
</div>
@endsection
