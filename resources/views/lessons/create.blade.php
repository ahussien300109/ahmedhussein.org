@extends('layouts.app')

@section('title', 'Create Lesson')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="mb-4">
                <a href="{{ route('courses.show', $course) }}" class="text-muted">
                    <i class="fas fa-arrow-left me-2"></i>Back to {{ $course->title }}
                </a>
            </div>

            <h1 class="mb-4">Create New Lesson</h1>

            <form method="POST" action="{{ route('admin.lessons.store', $course) }}" enctype="multipart/form-data" class="card">
                @csrf
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label for="title" class="form-label">Lesson Title *</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="order" class="form-label">Lesson Order *</label>
                        <input type="number" class="form-control @error('order') is-invalid @enderror" id="order" name="order" value="{{ old('order', $course->lessons()->count()) }}" required>
                        @error('order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="content" class="form-label">Lesson Content</label>
                        <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="5">{{ old('content') }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">You can add HTML, text, and markdown here</small>
                    </div>

                    <div class="mb-3">
                        <label for="video_url" class="form-label">Video URL</label>
                        <input type="url" class="form-control @error('video_url') is-invalid @enderror" id="video_url" name="video_url" value="{{ old('video_url') }}" placeholder="https://www.youtube.com/embed/...">
                        @error('video_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Enter YouTube embed URL or direct video URL</small>
                    </div>

                    <div class="mb-3">
                        <label for="file" class="form-label">Downloadable File</label>
                        <input type="file" class="form-control @error('file') is-invalid @enderror" id="file" name="file">
                        @error('file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Max file size: 10MB (PDF, DOC, ZIP, etc.)</small>
                    </div>
                </div>

                <div class="card-footer bg-light p-4">
                    <a href="{{ route('courses.show', $course) }}" class="btn btn-secondary me-2">Cancel</a>
                    <button type="submit" class="btn btn-primary">Create Lesson</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
