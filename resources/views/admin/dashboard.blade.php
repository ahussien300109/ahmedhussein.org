@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container my-5">
    <div class="row mb-4">
        <div class="col">
            <h1>Admin Dashboard</h1>
            <p class="text-muted">Welcome back, {{ auth()->user()->name }}!</p>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-0">Total Courses</p>
                            <h3 class="mb-0">{{ $totalCourses }}</h3>
                        </div>
                        <i class="fas fa-book fa-3x text-primary opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-0">My Courses</p>
                            <h3 class="mb-0">{{ $myCourses }}</h3>
                        </div>
                        <i class="fas fa-user-edit fa-3x text-success opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-0">Total Users</p>
                            <h3 class="mb-0">{{ $totalUsers }}</h3>
                        </div>
                        <i class="fas fa-users fa-3x text-info opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-0">Total Enrollments</p>
                            <h3 class="mb-0">{{ $totalEnrollments }}</h3>
                        </div>
                        <i class="fas fa-chart-bar fa-3x text-warning opacity-25"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">Recent Courses</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Title</th>
                                    <th>Created By</th>
                                    <th>Free</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentCourses as $course)
                                    <tr>
                                        <td>{{ Str::limit($course->title, 30) }}</td>
                                        <td>{{ $course->creator->name ?? 'Admin' }}</td>
                                        <td>
                                            @if($course->is_free)
                                                <span class="badge badge-free">Yes</span>
                                            @else
                                                <span class="badge badge-premium">No</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('courses.show', $course) }}" class="btn btn-sm btn-info" title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-sm btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">
                                            No courses yet. <a href="{{ route('admin.courses.create') }}">Create one now</a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <a href="{{ route('admin.courses.create') }}" class="btn btn-primary w-100 mb-2">
                        <i class="fas fa-plus me-2"></i>Create New Course
                    </a>
                    <a href="{{ route('courses.index') }}" class="btn btn-outline-primary w-100 mb-2">
                        <i class="fas fa-list me-2"></i>View All Courses
                    </a>
                    <a href="/" class="btn btn-outline-secondary w-100">
                        <i class="fas fa-home me-2"></i>Go to Frontend
                    </a>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">System Info</h5>
                </div>
                <div class="card-body">
                    <p class="mb-1">
                        <small class="text-muted">Laravel Version: 11.x</small>
                    </p>
                    <p class="mb-1">
                        <small class="text-muted">Database: MySQL</small>
                    </p>
                    <p>
                        <small class="text-muted">Your Role: {{ auth()->user()->role }}</small>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
