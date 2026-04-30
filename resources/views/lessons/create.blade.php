@extends('layouts.app')

@section('title', 'Create Lesson')

@section('content')
<style>
    .create-header {
        background: linear-gradient(135deg, rgba(0,212,255,0.1) 0%, rgba(0,255,136,0.1) 100%);
        border-bottom: 2px solid var(--c);
        padding: 3rem 2rem;
        margin-bottom: 3rem;
        position: relative;
        z-index: 1;
    }

    .create-header h1 {
        font-family: 'Orbitron', monospace;
        font-size: clamp(2rem, 4vw, 2.5rem);
        background: linear-gradient(135deg, var(--c) 0%, #00ff88 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin: 0;
    }

    .form-container {
        max-width: 900px;
        margin: 0 auto;
        padding: 0 2rem;
        position: relative;
        z-index: 1;
    }

    .form-card {
        border: 1px solid var(--c);
        border-radius: 12px;
        padding: 3rem;
        background: var(--bg);
        overflow: hidden;
        position: relative;
    }

    .form-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, transparent, var(--c), transparent);
        z-index: 1;
    }

    .form-group {
        margin-bottom: 2rem;
        position: relative;
        z-index: 2;
    }

    .form-group label {
        display: block;
        font-family: 'Exo 2', sans-serif;
        color: var(--c);
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.85rem;
        font-weight: 600;
        margin-bottom: 0.75rem;
    }

    .form-group input[type="text"],
    .form-group input[type="url"],
    .form-group input[type="number"],
    .form-group input[type="file"],
    .form-group textarea {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid var(--c);
        border-radius: 8px;
        background: transparent;
        color: var(--t);
        font-family: 'Exo 2', sans-serif;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        box-sizing: border-box;
    }

    .form-group input[type="text"]:focus,
    .form-group input[type="url"]:focus,
    .form-group input[type="number"]:focus,
    .form-group input[type="file"]:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #00ff88;
        box-shadow: 0 0 20px rgba(0,255,136,0.2);
    }

    .form-group textarea {
        resize: vertical;
        min-height: 150px;
    }

    .form-group input[type="file"] {
        padding: 0.5rem;
    }

    .help-text {
        display: block;
        font-family: 'Exo 2', sans-serif;
        color: var(--tm);
        font-size: 0.8rem;
        margin-top: 0.5rem;
        letter-spacing: 0.5px;
    }

    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 3rem;
        justify-content: flex-end;
    }

    .btn-cancel,
    .btn-submit {
        padding: 0.75rem 2rem;
        border-radius: 8px;
        font-family: 'Exo 2', sans-serif;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s ease;
        font-size: 0.9rem;
        border: 2px solid var(--c);
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
    }

    .btn-cancel {
        color: var(--c);
        background: transparent;
    }

    .btn-cancel:hover {
        background: var(--c);
        color: var(--bg);
    }

    .btn-submit {
        background: var(--c);
        color: var(--bg);
        border-color: var(--c);
    }

    .btn-submit:hover {
        box-shadow: 0 0 30px rgba(0,212,255,0.5);
        transform: translateY(-2px);
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--tm);
        text-decoration: none;
        margin-bottom: 2rem;
        font-family: 'Exo 2', sans-serif;
        transition: all 0.3s ease;
    }

    .back-link:hover {
        color: var(--c);
    }

    @media (max-width: 768px) {
        .create-header {
            padding: 2rem 1rem;
            margin-bottom: 2rem;
        }

        .form-container {
            padding: 0 1rem;
        }

        .form-card {
            padding: 1.5rem;
        }

        .form-actions {
            flex-direction: column-reverse;
        }

        .btn-cancel,
        .btn-submit {
            width: 100%;
            justify-content: center;
        }
    }
</style>

<!-- HEADER -->
<div class="create-header">
    <div class="form-container">
        <h1>Create New Lesson</h1>
    </div>
</div>

<!-- FORM -->
<div class="form-container">
    <a href="{{ route('courses.show', $course) }}" class="back-link">
        <i class="fas fa-arrow-left"></i>Back to {{ $course->title }}
    </a>

    <div class="form-card">
        <form method="POST" action="{{ route('admin.lessons.store', $course) }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="title">Lesson Title *</label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" required placeholder="e.g., Introduction to Routing Concepts">
                @error('title')
                    <span class="help-text" style="color: #ff6b6b;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="order">Lesson Order *</label>
                <input type="number" id="order" name="order" value="{{ old('order', $course->lessons()->count() + 1) }}" required min="1">
                @error('order')
                    <span class="help-text" style="color: #ff6b6b;">{{ $message }}</span>
                @enderror
                <span class="help-text">Position of this lesson in the course</span>
            </div>

            <div class="form-group">
                <label for="content">Lesson Content</label>
                <textarea id="content" name="content" placeholder="Enter lesson content, HTML, text, or markdown...">{{ old('content') }}</textarea>
                @error('content')
                    <span class="help-text" style="color: #ff6b6b;">{{ $message }}</span>
                @enderror
                <span class="help-text">You can add HTML, text, and markdown here</span>
            </div>

            <div class="form-group">
                <label for="video_url">Video URL</label>
                <input type="url" id="video_url" name="video_url" value="{{ old('video_url') }}" placeholder="https://www.youtube.com/embed/...">
                @error('video_url')
                    <span class="help-text" style="color: #ff6b6b;">{{ $message }}</span>
                @enderror
                <span class="help-text">Enter YouTube embed URL or direct video URL</span>
            </div>

            <div class="form-group">
                <label for="file">Downloadable File</label>
                <input type="file" id="file" name="file">
                @error('file')
                    <span class="help-text" style="color: #ff6b6b;">{{ $message }}</span>
                @enderror
                <span class="help-text">Max file size: 10MB (PDF, DOC, ZIP, etc.)</span>
            </div>

            <div class="form-actions">
                <a href="{{ route('courses.show', $course) }}" class="btn-cancel">Cancel</a>
                <button type="submit" class="btn-submit">Create Lesson</button>
            </div>
        </form>
    </div>
</div>
@endsection
