// ── DASHBOARD JS ──
// Modular dashboard functionality for admin and student views

// State management
let currentPanel = 'dash-overview';
let isAdmin = false;

// Initialize dashboard
function initDashboard() {
  renderNav();
  renderOverview();
  setupEventListeners();
}

// Navigation rendering
function renderNav() {
  const nav = document.getElementById('ds-nav');
  const role = document.getElementById('ds-role-txt');

  if (isAdmin) {
    role.textContent = 'Admin Portal';
    nav.innerHTML = `
      <div class="ds-item act" data-panel="dash-overview" onclick="switchPanel('dash-overview')">
        <i class="fas fa-chart-bar"></i> Dashboard
      </div>
      <div class="ds-item" data-panel="dash-admin-courses" onclick="switchPanel('dash-admin-courses')">
        <i class="fas fa-book"></i> Manage Courses
      </div>
      <div class="ds-item" data-panel="dash-admin-lessons" onclick="switchPanel('dash-admin-lessons')">
        <i class="fas fa-chalkboard-teacher"></i> Manage Lessons
      </div>
    `;
  } else {
    role.textContent = 'Student Portal';
    nav.innerHTML = `
      <div class="ds-item act" data-panel="dash-overview" onclick="switchPanel('dash-overview')">
        <i class="fas fa-home"></i> Overview
      </div>
      <div class="ds-item" data-panel="dash-my-courses" onclick="switchPanel('dash-my-courses')">
        <i class="fas fa-book-open"></i> My Courses
      </div>
      <div class="ds-item" data-panel="dash-progress" onclick="switchPanel('dash-progress')">
        <i class="fas fa-chart-line"></i> Progress
      </div>
    `;
  }
}

// Panel switching
function switchPanel(panelId) {
  document.querySelectorAll('.dash-panel').forEach(p => p.classList.remove('act'));
  document.getElementById(panelId).classList.add('act');
  document.querySelectorAll('.ds-item').forEach(i => i.classList.remove('act'));
  document.querySelector(`[data-panel="${panelId}"]`).classList.add('act');
  currentPanel = panelId;

  // Load panel content
  switch (panelId) {
    case 'dash-admin-courses': renderAdminCourses(); break;
    case 'dash-admin-lessons': renderAdminLessons(); break;
    case 'dash-my-courses': renderMyCourses(); break;
    case 'dash-progress': renderProgress(); break;
  }
}

// Overview rendering
function renderOverview() {
  // Update user info
  const nameEl = document.getElementById('dash-name');
  const planEl = document.getElementById('dash-plan');
  const enrolledEl = document.getElementById('dash-enrolled-n');

  // Mock data - replace with real data
  nameEl.textContent = 'John Doe';
  planEl.textContent = isAdmin ? 'ADMIN' : 'PREMIUM';
  enrolledEl.textContent = '3';
}

// Admin: Course Management
function renderAdminCourses() {
  const container = document.getElementById('admin-courses-table');
  const courses = getCourses(); // Mock function

  container.innerHTML = `
    <div class="admin-table">
      <div class="admin-table-header">
        <div>Title</div>
        <div>Category</div>
        <div>Students</div>
        <div>Price</div>
        <div>Actions</div>
      </div>
      ${courses.map(course => `
        <div class="admin-table-row">
          <div>${course.title}</div>
          <div>${course.category}</div>
          <div>${course.students}</div>
          <div>${course.price}</div>
          <div>
            <button class="btn btn-ghost" onclick="editCourse(${course.id})">Edit</button>
            <button class="btn btn-ghost" onclick="deleteCourse(${course.id})">Delete</button>
          </div>
        </div>
      `).join('')}
    </div>
  `;
}

function openEditCourse(id) {
  // Modal for adding/editing course
  alert(id ? 'Edit course modal' : 'Add course modal');
}

function editCourse(id) {
  openEditCourse(id);
}

function deleteCourse(id) {
  if (confirm('Delete this course?')) {
    // Delete logic
    renderAdminCourses();
  }
}

// Admin: Lesson Management
function renderAdminLessons() {
  const container = document.getElementById('admin-lessons-table');
  const lessons = getLessons(); // Mock function

  container.innerHTML = `
    <div class="admin-table">
      <div class="admin-table-header">
        <div>Title</div>
        <div>Course</div>
        <div>Duration</div>
        <div>Type</div>
        <div>Actions</div>
      </div>
      ${lessons.map(lesson => `
        <div class="admin-table-row">
          <div>${lesson.title}</div>
          <div>${lesson.course}</div>
          <div>${lesson.duration}</div>
          <div>${lesson.type}</div>
          <div>
            <button class="btn btn-ghost" onclick="editLesson(${lesson.id})">Edit</button>
            <button class="btn btn-ghost" onclick="deleteLesson(${lesson.id})">Delete</button>
          </div>
        </div>
      `).join('')}
    </div>
  `;
}

function openEditLesson(id) {
  alert(id ? 'Edit lesson modal' : 'Add lesson modal');
}

function editLesson(id) {
  openEditLesson(id);
}

function deleteLesson(id) {
  if (confirm('Delete this lesson?')) {
    renderAdminLessons();
  }
}

// Student: My Courses
function renderMyCourses() {
  const container = document.getElementById('dash-enr-list');
  const enrolledCourses = getEnrolledCourses(); // Mock function

  container.innerHTML = enrolledCourses.map(course => `
    <div class="enrolled-card" onclick="viewCourse(${course.id})">
      <div class="enrolled-thumb">
        <i class="fas fa-graduation-cap"></i>
      </div>
      <div class="enrolled-body">
        <div class="enrolled-title">${course.title}</div>
        <div class="enrolled-meta">
          <span><i class="fas fa-clock"></i> ${course.duration}</span>
          <span><i class="fas fa-users"></i> ${course.students} enrolled</span>
        </div>
        <div class="enrolled-progress">
          <div class="progress-bar">
            <div class="progress-fill" style="width: ${course.progress}%"></div>
          </div>
          <div class="progress-text">${course.progress}% Complete</div>
        </div>
        <div class="enrolled-actions">
          <button class="btn btn-c" onclick="event.stopPropagation(); continueCourse(${course.id})">
            <i class="fas fa-play"></i> Continue
          </button>
          <button class="btn btn-ghost" onclick="event.stopPropagation(); viewCertificate(${course.id})">
            <i class="fas fa-certificate"></i> Certificate
          </button>
        </div>
      </div>
    </div>
  `).join('');
}

function viewCourse(id) {
  // Navigate to course page
  console.log('View course:', id);
}

function continueCourse(id) {
  // Continue learning
  console.log('Continue course:', id);
}

function viewCertificate(id) {
  // Show certificate
  console.log('View certificate:', id);
}

// Student: Progress Tracking
function renderProgress() {
  const container = document.getElementById('progress-content');
  const progressData = getProgressData(); // Mock function

  container.innerHTML = progressData.map(course => `
    <div class="progress-item">
      <div class="progress-course-title">${course.title}</div>
      <div class="progress-lessons">
        ${course.lessons.map(lesson => `
          <div class="lesson-item" onclick="playLesson(${lesson.id})">
            <div class="lesson-status ${lesson.completed ? 'completed' : 'incomplete'}">
              ${lesson.completed ? '✓' : '○'}
            </div>
            <div class="lesson-title">${lesson.title}</div>
            <div class="lesson-duration">${lesson.duration}</div>
          </div>
        `).join('')}
      </div>
    </div>
  `).join('');
}

function playLesson(id) {
  // Play lesson
  console.log('Play lesson:', id);
}

// Event listeners
function setupEventListeners() {
  const sidebarToggle = document.getElementById('sidebar-toggle');
  const sidebar = document.getElementById('dash-sidebar');

  sidebarToggle.addEventListener('click', () => {
    sidebar.classList.toggle('open');
  });

  // Close sidebar on mobile when clicking outside
  document.addEventListener('click', (e) => {
    if (window.innerWidth <= 768 && !sidebar.contains(e.target) && e.target !== sidebarToggle) {
      sidebar.classList.remove('open');
    }
  });
}

// Mock data functions (replace with real API calls)
function getCourses() {
  return [
    { id: 1, title: 'CCNA Fundamentals', category: 'Networking', students: 245, price: '$149' },
    { id: 2, title: 'CCNP Enterprise', category: 'Advanced', students: 89, price: '$249' },
    { id: 3, title: 'Network Security', category: 'Security', students: 156, price: '$199' }
  ];
}

function getLessons() {
  return [
    { id: 1, title: 'OSI Model Basics', course: 'CCNA Fundamentals', duration: '45min', type: 'Video' },
    { id: 2, title: 'IP Addressing', course: 'CCNA Fundamentals', duration: '60min', type: 'Interactive' },
    { id: 3, title: 'Routing Protocols', course: 'CCNP Enterprise', duration: '90min', type: 'Lab' }
  ];
}

function getEnrolledCourses() {
  return [
    { id: 1, title: 'CCNA Fundamentals', duration: '80h', students: 245, progress: 75 },
    { id: 2, title: 'Network Security', duration: '60h', students: 156, progress: 30 },
    { id: 3, title: 'CCNP Enterprise', duration: '120h', students: 89, progress: 10 }
  ];
}

function getProgressData() {
  return [
    {
      title: 'CCNA Fundamentals',
      lessons: [
        { id: 1, title: 'Introduction to Networking', completed: true, duration: '30min' },
        { id: 2, title: 'OSI Model', completed: true, duration: '45min' },
        { id: 3, title: 'IP Addressing', completed: false, duration: '60min' },
        { id: 4, title: 'Subnetting Practice', completed: false, duration: '90min' }
      ]
    }
  ];
}

// Initialize on load
document.addEventListener('DOMContentLoaded', initDashboard);

// Export functions for global access
window.switchPanel = switchPanel;
window.openEditCourse = openEditCourse;
window.editCourse = editCourse;
window.deleteCourse = deleteCourse;
window.openEditLesson = openEditLesson;
window.editLesson = editLesson;
window.deleteLesson = deleteLesson;
window.viewCourse = viewCourse;
window.continueCourse = continueCourse;
window.viewCertificate = viewCertificate;
window.playLesson = playLesson;