@extends('layouts.app')

@section('title', 'Create Course')

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="mb-4">Create New Course</h1>

            <form method="POST" action="{{ route('admin.courses.store') }}" enctype="multipart/form-data" class="card">
                @csrf
                <div class="card-body p-4">
                    <div class="mb-3">
                        <label for="title" class="form-label">Course Title *</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Course Description *</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5" required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Course Image</label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Recommended: 800x600px, Max: 2MB</small>
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_free" name="is_free" value="1" {{ old('is_free') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_free">
                                Free Course (available to all users)
                            </label>
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-light p-4">
                    <a href="{{ route('courses.index') }}" class="btn btn-secondary me-2">Cancel</a>
                    <button type="submit" class="btn btn-primary">Create Course</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
