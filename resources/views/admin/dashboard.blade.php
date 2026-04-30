@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="dash-layout">
    <!-- SIDEBAR -->
    <aside class="dash-sidebar">
        <div class="ds-logo-area">
            <div class="ds-logo">DASHBOARD</div>
            <div class="ds-role">Admin Portal</div>
        </div>
        <nav class="ds-nav">
            <a href="#" class="ds-item act" data-panel="overview">
                <i class="fas fa-chart-line"></i>
                <span>Overview</span>
            </a>
            <a href="#" class="ds-item" data-panel="courses">
                <i class="fas fa-book"></i>
                <span>Courses</span>
            </a>
            <a href="#" class="ds-item" data-panel="lessons">
                <i class="fas fa-graduation-cap"></i>
                <span>Lessons</span>
            </a>
            <a href="#" class="ds-item" data-panel="users">
                <i class="fas fa-users"></i>
                <span>Users</span>
            </a>
            <a href="#" class="ds-item" data-panel="settings">
                <i class="fas fa-cog"></i>
                <span>Settings</span>
            </a>
        </nav>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="dash-main">
        <!-- OVERVIEW PANEL -->
        <div class="dash-panel act" id="panel-overview">
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

            <!-- BANNER -->
            <div class="upgrade-banner">
                <div class="ub-text">
                    <div class="ub-t">MANAGE YOUR LMS</div>
                    <div class="ub-d">Create courses, add lessons, manage students and track progress</div>
                </div>
                <a href="{{ route('admin.courses.create') }}" class="btn btn-c"><i class="fas fa-plus"></i> New Course</a>
            </div>
        </div>

        <!-- COURSES PANEL -->
        <div class="dash-panel" id="panel-courses">
            <div class="dash-toprow">
                <div><div class="dash-hello">COURSE <span>MANAGER</span></div></div>
                <a href="{{ route('admin.courses.create') }}" class="btn btn-c"><i class="fas fa-plus"></i> New Course</a>
            </div>

            @if($recentCourses->count() > 0)
                <div class="admin-table">
                    <div class="admin-table-header">
                        <span>Title</span>
                        <span>Created By</span>
                        <span>Type</span>
                        <span>Lessons</span>
                        <span style="text-align:right">Actions</span>
                    </div>
                    @foreach($recentCourses as $course)
                        <div class="admin-table-row">
                            <span><strong>{{ Str::limit($course->title, 30) }}</strong></span>
                            <span>{{ $course->creator->name ?? 'Admin' }}</span>
                            <span><span class="lvl-tag" style="@if($course->is_free) color:var(--g) @else color:var(--o) @endif">{{ $course->is_free ? 'FREE' : 'PREMIUM' }}</span></span>
                            <span>{{ $course->lessons->count() }}</span>
                            <span style="text-align:right;display:flex;gap:0.5rem;justify-content:flex-end">
                                <a href="{{ route('courses.show', $course) }}" class="btn btn-sm"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-sm"><i class="fas fa-edit"></i></a>
                            </span>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="padding:3rem;text-align:center;color:var(--tm)">
                    <i class="fas fa-inbox" style="font-size:2rem;opacity:0.3;display:block;margin-bottom:1rem"></i>
                    <p>No courses yet</p>
                    <a href="{{ route('admin.courses.create') }}" style="color:var(--c);font-weight:600">Create your first course</a>
                </div>
            @endif
        </div>

        <!-- LESSONS PANEL -->
        <div class="dash-panel" id="panel-lessons">
            <div class="dash-toprow">
                <div><div class="dash-hello">LESSON <span>MANAGER</span></div></div>
            </div>

            @php
                $allLessons = $recentCourses->flatMap(fn($c) => $c->lessons);
            @endphp

            @if($allLessons->count() > 0)
                <div class="admin-table">
                    <div class="admin-table-header">
                        <span>Title</span>
                        <span>Course</span>
                        <span>Order</span>
                        <span>Content</span>
                        <span style="text-align:right">Actions</span>
                    </div>
                    @foreach($allLessons as $lesson)
                        <div class="admin-table-row">
                            <span><strong>{{ Str::limit($lesson->title, 25) }}</strong></span>
                            <span>{{ Str::limit($lesson->course->title, 20) }}</span>
                            <span>#{{ $lesson->order }}</span>
                            <span>
                                @if($lesson->content)<i class="fas fa-file-alt" title="Content" style="color:var(--c);margin-right:0.5rem"></i>@endif
                                @if($lesson->video_url)<i class="fas fa-video" title="Video" style="color:var(--c);margin-right:0.5rem"></i>@endif
                                @if($lesson->file_path)<i class="fas fa-download" title="File" style="color:var(--c)"></i>@endif
                            </span>
                            <span style="text-align:right">
                                <a href="{{ route('admin.lessons.edit', [$lesson->course, $lesson]) }}" class="btn btn-sm"><i class="fas fa-edit"></i></a>
                            </span>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="padding:3rem;text-align:center;color:var(--tm)">
                    <i class="fas fa-inbox" style="font-size:2rem;opacity:0.3;display:block;margin-bottom:1rem"></i>
                    <p>No lessons yet</p>
                </div>
            @endif
        </div>

        <!-- USERS PANEL -->
        <div class="dash-panel" id="panel-users">
            <div class="dash-toprow">
                <div><div class="dash-hello">USER <span>MANAGEMENT</span></div></div>
            </div>

            @php
                $users = \App\Models\User::latest()->limit(20)->get();
            @endphp

            @if($users->count() > 0)
                <div class="admin-table">
                    <div class="admin-table-header">
                        <span>Name</span>
                        <span>Email</span>
                        <span>Role</span>
                        <span>Status</span>
                    </div>
                    @foreach($users as $user)
                        <div class="admin-table-row">
                            <span><strong>{{ $user->name }}</strong></span>
                            <span>{{ $user->email }}</span>
                            <span><span class="lvl-tag">{{ ucfirst($user->role) }}</span></span>
                            <span><i class="fas fa-check-circle" style="color:var(--g)"></i> Active</span>
                        </div>
                    @endforeach
                </div>
            @else
                <div style="padding:3rem;text-align:center;color:var(--tm)">
                    <i class="fas fa-inbox" style="font-size:2rem;opacity:0.3"></i>
                    <p>No users</p>
                </div>
            @endif
        </div>

        <!-- SETTINGS PANEL -->
        <div class="dash-panel" id="panel-settings">
            <div class="dash-toprow">
                <div><div class="dash-hello">SYSTEM <span>SETTINGS</span></div></div>
            </div>

            <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:1.5rem">
                <div class="admin-table">
                    <div style="padding:1.5rem;border-bottom:1px solid var(--bdr)">
                        <div style="font-size:0.7rem;color:var(--tm);text-transform:uppercase;letter-spacing:1px;margin-bottom:0.5rem">Framework</div>
                        <div style="color:var(--c);font-weight:600;font-size:1.1rem">Laravel 11.x</div>
                    </div>
                    <div style="padding:1.5rem;border-bottom:1px solid var(--bdr)">
                        <div style="font-size:0.7rem;color:var(--tm);text-transform:uppercase;letter-spacing:1px;margin-bottom:0.5rem">Database</div>
                        <div style="color:var(--c);font-weight:600;font-size:1.1rem">MySQL</div>
                    </div>
                    <div style="padding:1.5rem">
                        <div style="font-size:0.7rem;color:var(--tm);text-transform:uppercase;letter-spacing:1px;margin-bottom:0.5rem">Environment</div>
                        <div style="color:var(--c);font-weight:600;font-size:1.1rem">Production</div>
                    </div>
                </div>

                <div class="admin-table">
                    <div style="padding:1.5rem;border-bottom:1px solid var(--bdr)">
                        <div style="font-size:0.7rem;color:var(--tm);text-transform:uppercase;letter-spacing:1px;margin-bottom:0.5rem">Your Role</div>
                        <div style="color:var(--c);font-weight:600;font-size:1.1rem">{{ ucfirst(auth()->user()->role) }}</div>
                    </div>
                    <div style="padding:1.5rem;border-bottom:1px solid var(--bdr)">
                        <div style="font-size:0.7rem;color:var(--tm);text-transform:uppercase;letter-spacing:1px;margin-bottom:0.5rem">Total Students</div>
                        <div style="color:var(--c);font-weight:600;font-size:1.1rem">{{ $totalUsers }}</div>
                    </div>
                    <div style="padding:1.5rem">
                        <div style="font-size:0.7rem;color:var(--tm);text-transform:uppercase;letter-spacing:1px;margin-bottom:0.5rem">Enrollments</div>
                        <div style="color:var(--c);font-weight:600;font-size:1.1rem">{{ $totalEnrollments }}</div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
document.querySelectorAll('.ds-item').forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault();

        // Get panel ID from data attribute
        const panelId = this.getAttribute('data-panel');

        // Hide all panels
        document.querySelectorAll('.dash-panel').forEach(panel => {
            panel.classList.remove('act');
        });

        // Show selected panel
        const selectedPanel = document.getElementById('panel-' + panelId);
        if (selectedPanel) {
            selectedPanel.classList.add('act');
        }

        // Update active menu item
        document.querySelectorAll('.ds-item').forEach(item => {
            item.classList.remove('act');
        });
        this.classList.add('act');
    });
});
</script>
@endsection
