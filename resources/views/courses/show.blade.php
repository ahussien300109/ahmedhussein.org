@extends('layouts.app')

@section('title', $course->title)

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-lg-8">
            <div class="mb-4">
                @if($course->image)
                    <img src="{{ asset('storage/' . $course->image) }}" class="img-fluid rounded mb-4" style="max-height: 400px; width: 100%; object-fit: cover;" alt="{{ $course->title }}">
                @else
                    <div class="bg-light rounded mb-4 d-flex align-items-center justify-content-center" style="height: 400px;">
                        <i class="fas fa-book fa-8x text-muted"></i>
                    </div>
                @endif

                <h1 class="mb-3">{{ $course->title }}</h1>
                <div class="mb-3">
                    @if($course->is_free)
                        <span class="badge badge-free fs-6">FREE COURSE</span>
                    @else
                        <span class="badge badge-premium fs-6">PREMIUM COURSE</span>
                    @endif
                    <span class="badge bg-info ms-2">{{ $course->lessons->count() }} Lessons</span>
                </div>
                <p class="text-muted">
                    <i class="fas fa-user me-2"></i>Instructor: <strong>{{ $course->creator->name ?? 'Admin' }}</strong>
                </p>

                <h3 class="mt-5 mb-3">Course Description</h3>
                <p class="lead">{{ $course->description }}</p>

                @auth
                    @if(!auth()->user()->isAdmin())
                        @if(!$userEnrolled)
                            <form method="POST" action="{{ route('courses.enroll', $course) }}" class="mt-4">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-lg" @if(!$course->is_free) disabled @endif>
                                    @if($course->is_free)
                                        <i class="fas fa-check-circle me-2"></i>Enroll Now (FREE)
                                    @else
                                        <i class="fas fa-lock me-2"></i>Premium Course
                                    @endif
                                </button>
                                @if(!$course->is_free)
                                    <span class="text-muted ms-2">(Available soon)</span>
                                @endif
                            </form>
                        @else
                            <div class="alert alert-success mt-4">
                                <i class="fas fa-check-circle me-2"></i>You are enrolled in this course
                            </div>
                        @endif
                    @endif
                @else
                    @if($course->is_free)
                        <a href="/login" class="btn btn-primary btn-lg mt-4">
                            <i class="fas fa-sign-in-alt me-2"></i>Login to Enroll
                        </a>
                    @endif
                @endauth

                @auth
                    @if(auth()->user()->isAdmin() && auth()->user()->id === $course->created_by)
                        <a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-warning btn-lg mt-4">
                            <i class="fas fa-edit me-2"></i>Edit Course
                        </a>
                    @endif
                @endauth
            </div>

            <h3 class="mt-5 mb-3">Course Lessons</h3>
            @if($course->lessons->isEmpty())
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i>No lessons yet.
                    @auth
                        @if(auth()->user()->isAdmin() && auth()->user()->id === $course->created_by)
                            <a href="{{ route('admin.lessons.create', $course) }}">Create the first lesson</a>
                        @endif
                    @endauth
                </div>
            @else
                <div class="list-group">
                    @foreach($course->lessons as $index => $lesson)
                        <div class="list-group-item border-1">
                            <div class="row align-items-center">
                                <div class="col">
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-primary rounded-circle me-3 p-2" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                            {{ $index + 1 }}
                                        </span>
                                        <div>
                                            <h6 class="mb-1">{{ $lesson->title }}</h6>
                                            <p class="text-muted small mb-0">
                                                @if($lesson->content)
                                                    <i class="fas fa-file-alt me-1"></i>Content
                                                @endif
                                                @if($lesson->video_url)
                                                    <i class="fas fa-video me-1"></i>Video
                                                @endif
                                                @if($lesson->file_path)
                                                    <i class="fas fa-download me-1"></i>File
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                @auth
                                    @if(auth()->user()->isAdmin() && auth()->user()->id === $course->created_by)
                                        <div class="col-auto">
                                            <a href="{{ route('admin.lessons.edit', [$course, $lesson]) }}" class="btn btn-sm btn-warning me-2">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="POST" action="{{ route('admin.lessons.destroy', [$course, $lesson]) }}" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this lesson?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                @endauth
                            </div>

                            @if($lesson->content)
                                <div class="mt-2 ps-5">
                                    <p class="text-muted small mb-0">{{ Str::limit(strip_tags($lesson->content), 150) }}</p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

                @auth
                    @if(auth()->user()->isAdmin() && auth()->user()->id === $course->created_by)
                        <a href="{{ route('admin.lessons.create', $course) }}" class="btn btn-success mt-3">
                            <i class="fas fa-plus me-2"></i>Add Lesson
                        </a>
                    @endif
                @endauth
            @endif
        </div>

        <div class="col-lg-4">
            <div class="card sticky-top" style="top: 80px;">
                <div class="card-body">
                    <h5 class="card-title">Course Stats</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fas fa-book text-primary me-2"></i>
                            <strong>{{ $course->lessons->count() }}</strong> Lessons
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-users text-success me-2"></i>
                            <strong>{{ $course->enrollments->count() }}</strong> Students
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-user text-info me-2"></i>
                            <strong>{{ $course->creator->name ?? 'Admin' }}</strong> Instructor
                        </li>
                        <li>
                            <i class="fas fa-calendar text-warning me-2"></i>
                            Created on <strong>{{ $course->created_at->format('M d, Y') }}</strong>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
