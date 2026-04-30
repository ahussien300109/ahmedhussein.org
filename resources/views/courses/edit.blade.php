@extends('layouts.app')

@section('title', 'Edit Course')

@section('content')
<style>
    .edit-header {
        background: linear-gradient(135deg, rgba(0,212,255,0.1) 0%, rgba(0,255,136,0.1) 100%);
        border-bottom: 2px solid var(--c);
        padding: 3rem 2rem;
        margin-bottom: 3rem;
        position: relative;
        z-index: 1;
    }

    .edit-header h1 {
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
    .form-group input[type="file"]:focus,
    .form-group textarea:focus {
        outline: none;
        border-color: #00ff88;
        box-shadow: 0 0 20px rgba(0,255,136,0.2);
    }

    .form-group textarea {
        resize: vertical;
        min-height: 120px;
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

    .image-preview {
        margin: 1rem 0;
    }

    .image-preview img {
        max-width: 200px;
        border: 1px solid var(--c);
        border-radius: 8px;
        padding: 8px;
    }

    .form-check {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem;
        border: 1px solid var(--c);
        border-radius: 8px;
        background: rgba(0,212,255,0.02);
        transition: all 0.3s ease;
    }

    .form-check:hover {
        border-color: #00ff88;
        background: rgba(0,255,136,0.05);
    }

    .form-check input[type="checkbox"] {
        width: 20px;
        height: 20px;
        cursor: pointer;
        accent-color: var(--c);
    }

    .form-check label {
        margin: 0;
        text-transform: none;
        letter-spacing: normal;
        font-size: 0.95rem;
        cursor: pointer;
        color: var(--t);
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
        .edit-header {
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
<div class="edit-header">
    <div class="form-container">
        <h1>Edit Course</h1>
    </div>
</div>

<!-- FORM -->
<div class="form-container">
    <a href="{{ route('courses.show', $course) }}" class="back-link">
        <i class="fas fa-arrow-left"></i>Back to {{ $course->title }}
    </a>

    <div class="form-card">
        <form method="POST" action="{{ route('admin.courses.update', $course) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="title">Course Title *</label>
                <input type="text" id="title" name="title" value="{{ old('title', $course->title) }}" required>
                @error('title')
                    <span class="help-text" style="color: #ff6b6b;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Course Description *</label>
                <textarea id="description" name="description" required>{{ old('description', $course->description) }}</textarea>
                @error('description')
                    <span class="help-text" style="color: #ff6b6b;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="image">Course Image</label>
                @if($course->image)
                    <div class="image-preview">
                        <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}">
                    </div>
                @endif
                <input type="file" id="image" name="image" accept="image/*">
                <span class="help-text">Recommended: 800x600px, Max: 2MB (Leave empty to keep current)</span>
                @error('image')
                    <span class="help-text" style="color: #ff6b6b;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <div class="form-check">
                    <input type="checkbox" id="is_free" name="is_free" value="1" {{ old('is_free', $course->is_free) ? 'checked' : '' }}>
                    <label for="is_free">Free Course (available to all users)</label>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('courses.show', $course) }}" class="btn-cancel">Cancel</a>
                <button type="submit" class="btn-submit">Update Course</button>
            </div>
        </form>
    </div>
</div>
@endsection
