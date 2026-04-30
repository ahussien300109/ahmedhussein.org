@extends('layouts.app')

@section('title', 'Courses - Ahmed Hussein LMS')

@section('content')
<style>
    .courses-header {
        padding: 3rem 2rem;
        background: linear-gradient(135deg, rgba(0,212,255,0.05) 0%, rgba(0,255,136,0.05) 100%);
        border-bottom: 1px solid var(--c);
        margin-bottom: 3rem;
    }

    .courses-header h1 {
        font-family: 'Orbitron', monospace;
        font-size: clamp(2rem, 4vw, 3rem);
        background: linear-gradient(135deg, var(--c) 0%, #00ff88 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin: 0;
    }

    .courses-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 2rem;
    }

    .courses-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 2rem;
        margin-bottom: 3rem;
    }

    .course-card {
        border: 1px solid var(--c);
        border-radius: 10px;
        overflow: hidden;
        background: var(--bg);
        transition: all 0.3s ease;
    }

    .course-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 0 30px rgba(0,212,255,0.2);
        border-color: var(--c);
    }

    .course-image {
        height: 200px;
        background: linear-gradient(135deg, var(--c) 0%, #00ff88 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Orbitron', monospace;
        color: white;
        font-weight: 700;
        font-size: 1.2rem;
    }

    .course-body {
        padding: 1.5rem;
    }

    .course-badge {
        display: inline-block;
        padding: 0.4rem 0.8rem;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 0.75rem;
    }

    .course-badge.free {
        background: rgba(0, 255, 136, 0.2);
        color: #00ff88;
    }

    .course-badge.premium {
        background: rgba(255, 106, 0, 0.2);
        color: #ff6a00;
    }

    .course-title {
        font-family: 'Orbitron', monospace;
        font-size: 1.1rem;
        font-weight: 700;
        margin: 0 0 0.75rem 0;
    }

    .course-desc {
        color: var(--tm);
        font-size: 0.9rem;
        margin: 0 0 1rem 0;
        line-height: 1.5;
    }

    .course-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 1rem;
        border-top: 1px solid var(--c);
    }

    .course-meta-item {
        color: var(--tm);
        font-size: 0.85rem;
    }

    .course-actions {
        display: flex;
        gap: 0.5rem;
        margin-top: 1rem;
    }

    .course-btn {
        flex: 1;
        padding: 0.6rem;
        border: 1px solid var(--c);
        background: transparent;
        color: var(--c);
        border-radius: 5px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        text-align: center;
        font-size: 0.85rem;
    }

    .course-btn:hover {
        background: var(--c);
        color: var(--bg);
    }

    .course-btn.solid {
        background: var(--c);
        color: var(--bg);
    }

    .add-course-btn {
        padding: 0.75rem 2rem;
        border: 2px solid var(--c);
        background: var(--c);
        color: var(--bg);
        border-radius: 50px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .add-course-btn:hover {
        box-shadow: 0 0 30px rgba(0,212,255,0.5);
    }

    @media (max-width: 768px) {
        .courses-grid {
            grid-template-columns: 1fr;
        }

        .courses-header h1 {
            font-size: 1.75rem;
        }
    }
</style>

<div class="courses-header">
    <div class="courses-container" style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:1rem">
        <div>
            <h1>
                @auth
                    @if(auth()->user()->isAdmin())
                        <i class="fas fa-cogs"></i> Manage Courses
                    @else
                        <i class="fas fa-book"></i> Explore Courses
                    @endif
                @else
                    <i class="fas fa-book"></i> Explore Courses
                @endauth
            </h1>
        </div>
        @auth
            @if(auth()->user()->isAdmin())
                <a href="{{ route('courses.create') }}" class="add-course-btn">
                    <i class="fas fa-plus"></i> Create Course
                </a>
            @endif
        @endauth
    </div>
</div>

<div class="courses-container">

    @if($courses->isEmpty())
        <div style="text-align:center;padding:3rem 2rem;color:var(--tm)">
            <i class="fas fa-inbox" style="font-size:3rem;opacity:0.3;margin-bottom:1rem;display:block"></i>
            <p style="font-size:1.1rem;margin:0">
                @auth
                    @if(auth()->user()->isAdmin())
                        No courses yet. <a href="{{ route('courses.create') }}" style="color:var(--c)">Create your first course</a>
                    @else
                        No courses available at the moment.
                    @endif
                @else
                    No courses available. <a href="/register" style="color:var(--c)">Register</a> to get started!
                @endauth
            </p>
        </div>
    @else
        <div class="courses-grid">
            @foreach($courses as $course)
                <div class="course-card">
                    <div class="course-image">
                        @if($course->image)
                            <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}" style="width:100%;height:100%;object-fit:cover">
                        @else
                            <div style="display:flex;flex-direction:column;align-items:center;justify-content:center;width:100%;height:100%">
                                <i class="fas fa-book fa-2x"></i>
                                <span style="font-size:0.9rem;margin-top:0.5rem">{{ $course->title }}</span>
                            </div>
                        @endif
                    </div>
                    <div class="course-body">
                        <div class="course-badge @if($course->is_free) free @else premium @endif">
                            {{ $course->is_free ? 'FREE' : 'PREMIUM' }}
                        </div>
                        <h3 class="course-title">{{ Str::limit($course->title, 40) }}</h3>
                        <p class="course-desc">{{ Str::limit($course->description, 100) }}</p>
                        <div class="course-meta">
                            <span class="course-meta-item"><i class="fas fa-user"></i> {{ $course->creator->name ?? 'Admin' }}</span>
                            <span class="course-meta-item"><i class="fas fa-users"></i> {{ $course->enrollments->count() }} students</span>
                        </div>
                        <div class="course-actions">
                            <a href="{{ route('courses.show', $course) }}" class="course-btn solid">
                                <i class="fas fa-eye"></i> View
                            </a>
                            @auth
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('courses.edit', $course) }}" class="course-btn" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form method="POST" action="{{ route('courses.destroy', $course) }}" style="flex:1" onsubmit="return confirm('Delete this course?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="course-btn" style="width:100%;border-color:#ff6a00;color:#ff6a00" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
