@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<style>
    .admin-header {
        background: linear-gradient(135deg, rgba(0,212,255,0.1) 0%, rgba(0,255,136,0.1) 100%);
        border-bottom: 2px solid var(--c);
        padding: 3rem 2rem;
        margin-bottom: 3rem;
        position: relative;
        z-index: 1;
    }

    .admin-header h1 {
        font-family: 'Orbitron', monospace;
        font-size: clamp(2rem, 4vw, 3rem);
        background: linear-gradient(135deg, var(--c) 0%, #00ff88 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin: 0;
    }

    .admin-header p {
        color: var(--tm);
        margin: 0.5rem 0 0 0;
        font-size: 1rem;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
        margin-bottom: 3rem;
        max-width: 1400px;
        margin-left: auto;
        margin-right: auto;
    }

    .stat-card {
        border: 1px solid var(--c);
        border-radius: 10px;
        padding: 2rem;
        background: var(--bg);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, transparent, var(--c), transparent);
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0 30px rgba(0,212,255,0.2);
    }

    .stat-icon {
        font-size: 2.5rem;
        color: var(--c);
        margin-bottom: 1rem;
    }

    .stat-label {
        font-family: 'Exo 2', sans-serif;
        color: var(--tm);
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin: 0;
    }

    .stat-number {
        font-family: 'Orbitron', monospace;
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--c);
        margin: 0.5rem 0 0 0;
    }

    .content-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 2rem;
        position: relative;
        z-index: 1;
    }

    .section-title {
        font-family: 'Orbitron', monospace;
        font-size: 1.3rem;
        color: var(--c);
        margin-bottom: 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid var(--c);
    }

    .courses-section {
        margin-bottom: 3rem;
    }

    .courses-table {
        border: 1px solid var(--c);
        border-radius: 10px;
        overflow: hidden;
        background: var(--bg);
    }

    .courses-table table {
        margin: 0;
    }

    .courses-table thead {
        background: rgba(0,212,255,0.1);
        border-bottom: 2px solid var(--c);
    }

    .courses-table th {
        font-family: 'Orbitron', monospace;
        color: var(--c);
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.85rem;
        font-weight: 700;
        padding: 1rem;
    }

    .courses-table td {
        padding: 1rem;
        color: var(--t);
        border-bottom: 1px solid var(--bdr);
    }

    .courses-table tbody tr:hover {
        background: rgba(0,212,255,0.05);
    }

    .courses-table tbody tr:last-child td {
        border-bottom: none;
    }

    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
        color: var(--tm);
    }

    .empty-state-icon {
        font-size: 3rem;
        color: var(--c);
        opacity: 0.3;
        margin-bottom: 1rem;
        display: block;
    }

    .quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 3rem;
    }

    .action-btn {
        padding: 1rem;
        border: 2px solid var(--c);
        background: transparent;
        color: var(--c);
        border-radius: 8px;
        text-decoration: none;
        text-align: center;
        font-weight: 600;
        transition: all 0.3s;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
    }

    .action-btn:hover {
        background: var(--c);
        color: var(--bg);
        box-shadow: 0 0 20px rgba(0,212,255,0.3);
        text-decoration: none;
    }

    .action-btn.primary {
        background: var(--c);
        color: var(--bg);
    }

    .action-btn.primary:hover {
        box-shadow: 0 0 30px rgba(0,212,255,0.5);
    }

    .action-icon {
        font-size: 1.5rem;
    }

    .system-info {
        border: 1px solid var(--c);
        border-radius: 10px;
        padding: 1.5rem;
        background: rgba(0,212,255,0.02);
        font-family: 'Exo 2', sans-serif;
    }

    .system-info-item {
        display: flex;
        justify-content: space-between;
        padding: 0.5rem 0;
        color: var(--t);
        font-size: 0.9rem;
        border-bottom: 1px solid var(--bdr);
    }

    .system-info-item:last-child {
        border-bottom: none;
    }

    .info-label {
        color: var(--tm);
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.75rem;
    }

    .info-value {
        color: var(--c);
        font-weight: 600;
    }

    @media (max-width: 768px) {
        .admin-header {
            padding: 2rem 1rem;
            margin-bottom: 2rem;
        }

        .stats-grid {
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            padding: 1.5rem;
        }

        .quick-actions {
            margin-bottom: 2rem;
        }
    }
</style>

<!-- HEADER -->
<div class="admin-header">
    <div class="content-container">
        <h1>Admin Dashboard</h1>
        <p>Welcome back, <strong>{{ auth()->user()->name }}!</strong></p>
    </div>
</div>

<!-- STATISTICS -->
<div class="content-container">
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-book"></i></div>
            <p class="stat-label">Total Courses</p>
            <p class="stat-number">{{ $totalCourses }}</p>
        </div>

        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-pencil-alt"></i></div>
            <p class="stat-label">My Courses</p>
            <p class="stat-number">{{ $myCourses }}</p>
        </div>

        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-users"></i></div>
            <p class="stat-label">Total Users</p>
            <p class="stat-number">{{ $totalUsers }}</p>
        </div>

        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-graduation-cap"></i></div>
            <p class="stat-label">Total Enrollments</p>
            <p class="stat-number">{{ $totalEnrollments }}</p>
        </div>
    </div>

    <!-- QUICK ACTIONS -->
    <h2 class="section-title">Quick Actions</h2>
    <div class="quick-actions">
        <a href="{{ route('admin.courses.create') }}" class="action-btn primary">
            <span class="action-icon"><i class="fas fa-plus"></i></span>
            <span>Create Course</span>
        </a>
        <a href="{{ route('admin.courses.index') }}" class="action-btn">
            <span class="action-icon"><i class="fas fa-list"></i></span>
            <span>View All Courses</span>
        </a>
        <a href="{{ route('courses.index') }}" class="action-btn">
            <span class="action-icon"><i class="fas fa-eye"></i></span>
            <span>View as Student</span>
        </a>
        <a href="/" class="action-btn">
            <span class="action-icon"><i class="fas fa-home"></i></span>
            <span>Go to Homepage</span>
        </a>
    </div>

    <!-- RECENT COURSES -->
    <div class="courses-section">
        <h2 class="section-title">Recent Courses</h2>
        <div class="courses-table">
            @if($recentCourses->count() > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>Course Title</th>
                            <th>Created By</th>
                            <th>Type</th>
                            <th>Lessons</th>
                            <th style="text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentCourses as $course)
                            <tr>
                                <td><strong>{{ Str::limit($course->title, 40) }}</strong></td>
                                <td>{{ $course->creator->name ?? 'Admin' }}</td>
                                <td>
                                    @if($course->is_free)
                                        <span style="color:#00ff88;font-weight:600">FREE</span>
                                    @else
                                        <span style="color:#ff6a00;font-weight:600">PREMIUM</span>
                                    @endif
                                </td>
                                <td>{{ $course->lessons->count() }} lessons</td>
                                <td style="text-align: right;">
                                    <a href="{{ route('courses.show', $course) }}" title="View" style="color:var(--c);text-decoration:none;margin-right:1rem">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.courses.edit', $course) }}" title="Edit" style="color:var(--c);text-decoration:none">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    <i class="fas fa-inbox empty-state-icon"></i>
                    <p>No courses created yet.</p>
                    <a href="{{ route('admin.courses.create') }}" style="color:var(--c);text-decoration:none;font-weight:600">Create your first course →</a>
                </div>
            @endif
        </div>
    </div>

    <!-- SYSTEM INFO -->
    <h2 class="section-title">System Information</h2>
    <div class="system-info">
        <div class="system-info-item">
            <span class="info-label">Laravel Version</span>
            <span class="info-value">11.x</span>
        </div>
        <div class="system-info-item">
            <span class="info-label">Database</span>
            <span class="info-value">MySQL</span>
        </div>
        <div class="system-info-item">
            <span class="info-label">Your Role</span>
            <span class="info-value">{{ ucfirst(auth()->user()->role) }}</span>
        </div>
        <div class="system-info-item">
            <span class="info-label">Environment</span>
            <span class="info-value">Production</span>
        </div>
    </div>
</div>
@endsection
