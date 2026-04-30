@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="dash-layout">
    <!-- SIDEBAR -->
    <aside class="dash-sidebar" id="dash-sidebar">
        <div class="ds-logo-area">
            <div class="ds-logo">DASHBOARD</div>
            <div class="ds-role" id="ds-role-txt">Admin Portal</div>
        </div>
        <nav class="ds-nav" id="ds-nav">
            <div class="ds-item act" onclick="showPanel('overview')">
                <i class="fas fa-chart-line"></i>
                <span>Overview</span>
            </div>
            <div class="ds-item" onclick="showPanel('courses')">
                <i class="fas fa-book"></i>
                <span>Courses</span>
            </div>
            <div class="ds-item" onclick="showPanel('lessons')">
                <i class="fas fa-graduation-cap"></i>
                <span>Lessons</span>
            </div>
            <div class="ds-item" onclick="showPanel('users')">
                <i class="fas fa-users"></i>
                <span>Users</span>
            </div>
            <div class="ds-item" onclick="showPanel('settings')">
                <i class="fas fa-cog"></i>
                <span>Settings</span>
            </div>
        </nav>
        <button class="sidebar-toggle" id="sidebar-toggle">☰</button>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="dash-main">
        <!-- OVERVIEW PANEL -->
        <div class="dash-panel act" id="dash-overview">
            <div class="dash-toprow">
                <div>
                    <div class="dash-hello">WELCOME, <span>{{ auth()->user()->name }}</span></div>
                    <div class="dash-sub">Admin Control Panel</div>
                </div>
                <div class="dash-plan-chip">
                    <div class="dpc-lbl">Role</div>
                    <div class="dpc-val">{{ ucfirst(auth()->user()->role) }}</div>
                </div>
            </div>

            <!-- STATS -->
            <div class="dash-stats">
                <div class="dstat">
                    <div class="dstat-ico ico-c"><i class="fas fa-book"></i></div>
                    <div class="dstat-num">{{ $totalCourses }}</div>
                    <div class="dstat-lbl">Total Courses</div>
                </div>
                <div class="dstat">
                    <div class="dstat-ico ico-g"><i class="fas fa-pencil-alt"></i></div>
                    <div class="dstat-num">{{ $myCourses }}</div>
                    <div class="dstat-lbl">My Courses</div>
                </div>
                <div class="dstat">
                    <div class="dstat-ico ico-o"><i class="fas fa-users"></i></div>
                    <div class="dstat-num">{{ $totalUsers }}</div>
                    <div class="dstat-lbl">Total Users</div>
                </div>
                <div class="dstat">
                    <div class="dstat-ico ico-p"><i class="fas fa-graduation-cap"></i></div>
                    <div class="dstat-num">{{ $totalEnrollments }}</div>
                    <div class="dstat-lbl">Total Enrollments</div>
                </div>
            </div>

            <!-- QUICK ACTIONS BANNER -->
            <div class="upgrade-banner">
                <div class="ub-text">
                    <div class="ub-t">MANAGE YOUR COURSES</div>
                    <div class="ub-d">Create, edit, and organize your courses and lessons</div>
                </div>
                <a href="{{ route('admin.courses.create') }}" class="btn btn-c"><i class="fas fa-plus"></i> New Course</a>
            </div>
        </div>

        <!-- COURSES PANEL -->
        <div class="dash-panel" id="dash-courses">
            <div class="dash-toprow">
                <div><div class="dash-hello">COURSE <span>MANAGER</span></div></div>
                <a href="{{ route('admin.courses.create') }}" class="btn btn-c"><i class="fas fa-plus"></i> Add Course</a>
            </div>

            <div class="admin-table">
                <div class="admin-table-header">
                    <span>Course Title</span>
                    <span>Created By</span>
                    <span>Type</span>
                    <span>Lessons</span>
                    <span style="text-align:right">Actions</span>
                </div>
                @forelse($recentCourses as $course)
                    <div class="admin-table-row">
                        <span><strong>{{ Str::limit($course->title, 30) }}</strong></span>
                        <span>{{ $course->creator->name ?? 'Admin' }}</span>
                        <span>
                            @if($course->is_free)
                                <span class="lvl-tag">FREE</span>
                            @else
                                <span class="lvl-tag premium-tag">PREMIUM</span>
                            @endif
                        </span>
                        <span>{{ $course->lessons->count() }}</span>
                        <span style="text-align:right;display:flex;gap:0.5rem;justify-content:flex-end">
                            <a href="{{ route('courses.show', $course) }}" class="btn btn-sm" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-sm" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                        </span>
                    </div>
                @empty
                    <div style="padding:2rem;text-align:center;color:var(--tm)">
                        <i class="fas fa-inbox" style="font-size:2rem;opacity:0.3;display:block;margin-bottom:1rem"></i>
                        No courses yet. <a href="{{ route('admin.courses.create') }}" style="color:var(--c)">Create one</a>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- LESSONS PANEL -->
        <div class="dash-panel" id="dash-lessons">
            <div class="dash-toprow">
                <div><div class="dash-hello">LESSON <span>MANAGER</span></div></div>
                <span style="color:var(--tm);font-size:0.9rem">Total: {{ $recentCourses->sum(fn($c) => $c->lessons->count()) }} lessons</span>
            </div>

            <div class="admin-table">
                <div class="admin-table-header">
                    <span>Lesson Title</span>
                    <span>Course</span>
                    <span>Order</span>
                    <span>Media</span>
                    <span style="text-align:right">Actions</span>
                </div>
                @forelse($recentCourses->flatMap(fn($c) => $c->lessons) as $lesson)
                    <div class="admin-table-row">
                        <span><strong>{{ Str::limit($lesson->title, 25) }}</strong></span>
                        <span>{{ Str::limit($lesson->course->title, 20) }}</span>
                        <span>#{{ $lesson->order }}</span>
                        <span>
                            @if($lesson->content)<i class="fas fa-file-alt" title="Content"></i> @endif
                            @if($lesson->video_url)<i class="fas fa-video" title="Video"></i> @endif
                            @if($lesson->file_path)<i class="fas fa-download" title="File"></i> @endif
                        </span>
                        <span style="text-align:right;display:flex;gap:0.5rem;justify-content:flex-end">
                            <a href="{{ route('admin.lessons.edit', [$lesson->course, $lesson]) }}" class="btn btn-sm" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                        </span>
                    </div>
                @empty
                    <div style="padding:2rem;text-align:center;color:var(--tm)">
                        <i class="fas fa-inbox" style="font-size:2rem;opacity:0.3;display:block;margin-bottom:1rem"></i>
                        No lessons yet
                    </div>
                @endforelse
            </div>
        </div>

        <!-- USERS PANEL -->
        <div class="dash-panel" id="dash-users">
            <div class="dash-toprow">
                <div><div class="dash-hello">USER <span>MANAGEMENT</span></div></div>
            </div>

            <div class="admin-table">
                <div class="admin-table-header">
                    <span>Name</span>
                    <span>Email</span>
                    <span>Role</span>
                    <span>Status</span>
                </div>
                @forelse(\App\Models\User::latest()->limit(10)->get() as $user)
                    <div class="admin-table-row">
                        <span><strong>{{ $user->name }}</strong></span>
                        <span>{{ $user->email }}</span>
                        <span><span class="lvl-tag">{{ ucfirst($user->role) }}</span></span>
                        <span><i class="fas fa-check-circle" style="color:var(--g)"></i> Active</span>
                    </div>
                @empty
                    <div style="padding:2rem;text-align:center;color:var(--tm)">
                        <i class="fas fa-inbox" style="font-size:2rem;opacity:0.3;display:block;margin-bottom:1rem"></i>
                        No users
                    </div>
                @endforelse
            </div>
        </div>

        <!-- SETTINGS PANEL -->
        <div class="dash-panel" id="dash-settings">
            <div class="dash-toprow">
                <div><div class="dash-hello">SYSTEM <span>INFORMATION</span></div></div>
            </div>

            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:1.5rem">
                <div class="admin-table" style="grid-column:1">
                    <div style="padding:1.5rem;border-bottom:1px solid var(--bdr)">
                        <div style="font-size:0.7rem;color:var(--tm);text-transform:uppercase;letter-spacing:1px;margin-bottom:0.5rem">Server</div>
                        <div style="color:var(--c);font-weight:600">Laravel 11.x</div>
                    </div>
                    <div style="padding:1.5rem;border-bottom:1px solid var(--bdr)">
                        <div style="font-size:0.7rem;color:var(--tm);text-transform:uppercase;letter-spacing:1px;margin-bottom:0.5rem">Database</div>
                        <div style="color:var(--c);font-weight:600">MySQL</div>
                    </div>
                    <div style="padding:1.5rem">
                        <div style="font-size:0.7rem;color:var(--tm);text-transform:uppercase;letter-spacing:1px;margin-bottom:0.5rem">Environment</div>
                        <div style="color:var(--c);font-weight:600">Production</div>
                    </div>
                </div>
                <div class="admin-table">
                    <div style="padding:1.5rem;border-bottom:1px solid var(--bdr)">
                        <div style="font-size:0.7rem;color:var(--tm);text-transform:uppercase;letter-spacing:1px;margin-bottom:0.5rem">Your Role</div>
                        <div style="color:var(--c);font-weight:600">{{ ucfirst(auth()->user()->role) }}</div>
                    </div>
                    <div style="padding:1.5rem;border-bottom:1px solid var(--bdr)">
                        <div style="font-size:0.7rem;color:var(--tm);text-transform:uppercase;letter-spacing:1px;margin-bottom:0.5rem">Total Students</div>
                        <div style="color:var(--c);font-weight:600">{{ $totalUsers }}</div>
                    </div>
                    <div style="padding:1.5rem">
                        <div style="font-size:0.7rem;color:var(--tm);text-transform:uppercase;letter-spacing:1px;margin-bottom:0.5rem">Active Enrollments</div>
                        <div style="color:var(--c);font-weight:600">{{ $totalEnrollments }}</div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
function showPanel(panelId) {
    // Hide all panels
    document.querySelectorAll('.dash-panel').forEach(p => p.classList.remove('act'));

    // Show selected panel
    const panel = document.getElementById('dash-' + panelId);
    if (panel) {
        panel.classList.add('act');
    }

    // Update sidebar active state
    document.querySelectorAll('.ds-item').forEach(item => item.classList.remove('act'));
    if (event && event.target) {
        const dsItem = event.target.closest('.ds-item');
        if (dsItem) {
            dsItem.classList.add('act');
        }
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    // Ensure overview panel is shown by default
    const overviewPanel = document.getElementById('dash-overview');
    if (overviewPanel) {
        overviewPanel.classList.add('act');
    }

    // Set first sidebar item as active
    const firstItem = document.querySelector('.ds-item');
    if (firstItem) {
        firstItem.classList.add('act');
    }

    // Sidebar toggle for mobile
    const sidebarToggle = document.getElementById('sidebar-toggle');
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            document.getElementById('dash-sidebar').classList.toggle('open');
        });
    }

    // Close sidebar when link is clicked on mobile
    document.querySelectorAll('.ds-item').forEach(item => {
        item.addEventListener('click', function() {
            if (window.innerWidth <= 768) {
                document.getElementById('dash-sidebar').classList.remove('open');
            }
        });
    });
});
</script>
@endsection
