@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<style>
    /* Dashboard Layout */
    .dashboard-wrapper {
        max-width: 1400px;
        margin: 0 auto;
        padding: 2rem;
        position: relative;
        z-index: 1;
    }

    /* Header Section */
    .dash-header {
        margin-bottom: 3rem;
    }

    .dash-header h1 {
        font-family: 'Orbitron', monospace;
        font-size: clamp(2rem, 4vw, 2.5rem);
        background: linear-gradient(135deg, var(--c) 0%, #00ff88 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin: 0 0 0.5rem 0;
        font-weight: 700;
    }

    .dash-header p {
        color: var(--tm);
        margin: 0;
        font-size: 0.95rem;
        font-family: 'Exo 2', sans-serif;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.5rem;
        margin-bottom: 3rem;
    }

    .stat-card {
        border: 1px solid var(--c);
        border-radius: 10px;
        padding: 1.5rem;
        background: var(--card);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        cursor: pointer;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 2px;
        background: linear-gradient(90deg, transparent, var(--c), transparent);
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 0 25px rgba(0,212,255,0.15);
        border-color: #00ff88;
    }

    .stat-icon {
        font-size: 2.2rem;
        color: var(--c);
        margin-bottom: 0.75rem;
    }

    .stat-label {
        font-family: 'Exo 2', sans-serif;
        color: var(--tm);
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin: 0 0 0.5rem 0;
    }

    .stat-number {
        font-family: 'Orbitron', monospace;
        font-size: 2.2rem;
        font-weight: 700;
        color: var(--c);
        margin: 0;
    }

    /* Section Title */
    .section-title {
        font-family: 'Orbitron', monospace;
        font-size: 1.2rem;
        color: var(--tw);
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid var(--bdr);
    }

    /* Quick Actions */
    .quick-actions {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 1rem;
        margin-bottom: 3rem;
    }

    .action-btn {
        padding: 1rem;
        border: 1.5px solid var(--c);
        background: transparent;
        color: var(--c);
        border-radius: 8px;
        text-decoration: none;
        text-align: center;
        font-weight: 600;
        font-size: 0.9rem;
        font-family: 'Exo 2', sans-serif;
        transition: all 0.3s;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
    }

    .action-btn:hover {
        background: var(--c);
        color: var(--bg);
        box-shadow: 0 0 20px rgba(0,212,255,0.3);
        text-decoration: none;
        transform: translateY(-2px);
    }

    .action-btn.primary {
        background: var(--c);
        color: var(--bg);
    }

    .action-btn.primary:hover {
        box-shadow: 0 0 30px rgba(0,212,255,0.5);
        background: #00ff88;
        border-color: #00ff88;
    }

    .action-icon {
        font-size: 1.4rem;
    }

    /* Courses Section */
    .courses-section {
        margin-bottom: 3rem;
    }

    .courses-table {
        border: 1px solid var(--bdr);
        border-radius: 10px;
        overflow: hidden;
        background: var(--card);
    }

    .courses-table table {
        width: 100%;
        border-collapse: collapse;
        margin: 0;
    }

    .courses-table thead {
        background: var(--bg3);
        border-bottom: 1px solid var(--bdr);
    }

    .courses-table th {
        font-family: 'Orbitron', monospace;
        color: var(--c);
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.75rem;
        font-weight: 700;
        padding: 1rem;
        text-align: left;
    }

    .courses-table td {
        padding: 1rem;
        color: var(--t);
        border-bottom: 1px solid var(--bdr);
        font-size: 0.9rem;
    }

    .courses-table tbody tr:hover {
        background: rgba(0,212,255,0.03);
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
        font-size: 2.5rem;
        color: var(--c);
        opacity: 0.4;
        margin-bottom: 1rem;
        display: block;
    }

    .empty-state p {
        margin: 0.5rem 0;
        font-size: 0.95rem;
    }

    .empty-state a {
        color: var(--c);
        text-decoration: none;
        font-weight: 600;
        transition: all 0.2s;
    }

    .empty-state a:hover {
        color: #00ff88;
    }

    /* System Info */
    .system-info {
        border: 1px solid var(--bdr);
        border-radius: 10px;
        padding: 1.5rem;
        background: var(--card);
    }

    .system-info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
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
        font-size: 0.7rem;
        font-family: 'Exo 2', sans-serif;
    }

    .info-value {
        color: var(--c);
        font-weight: 600;
        font-family: 'Orbitron', monospace;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .dashboard-wrapper {
            padding: 1rem;
        }

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        .quick-actions {
            grid-template-columns: repeat(2, 1fr);
        }

        .courses-table {
            font-size: 0.85rem;
        }

        .courses-table th,
        .courses-table td {
            padding: 0.75rem;
        }
    }

    @media (max-width: 480px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }

        .quick-actions {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="dashboard-wrapper">
    <!-- HEADER -->
    <div class="dash-header">
        <h1>Admin Dashboard</h1>
        <p>Welcome back, <strong>{{ auth()->user()->name }}!</strong></p>
    </div>

    <!-- STATISTICS -->
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
                <table>
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
                                    <a href="{{ route('courses.show', $course) }}" title="View" style="color:var(--c);text-decoration:none;margin-right:1rem;">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.courses.edit', $course) }}" title="Edit" style="color:var(--c);text-decoration:none;">
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
                    <a href="{{ route('admin.courses.create') }}">Create your first course →</a>
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
