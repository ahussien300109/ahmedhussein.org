// ui.js - Clean version with no syntax errors
window.UI = {
  renderHome: function() {
    console.log('[UI] Rendering Home');
    var root = document.getElementById('root');
    if (!root) return;
    root.innerHTML = '<div class="hero-section"><h1>Welcome to Ahmed Hussein\'s Lab</h1><p>Network Engineering Expert</p><div class="cta-buttons"><a href="#courses" class="btn btn-primary">View Courses</a><a href="#about" class="btn btn-secondary">About Me</a></div></div>';
  },

  renderCourses: function() {
    console.log('[UI] Rendering Courses');
    var root = document.getElementById('root');
    if (!root) return;
    var courses = window.COURSES || [];
    if (!courses || courses.length === 0) {
      root.innerHTML = '<div class="container"><h2>Courses</h2><p>No courses available.</p></div>';
      return;
    }
    var html = '';
    for (var i = 0; i < courses.length; i++) {
      var c = courses[i];
      html += '<div class="course-card"><h3>' + (c.title || 'Untitled') + '</h3><p>' + (c.description || '') + '</p></div>';
    }
    root.innerHTML = '<div class="container"><h2>Available Courses</h2><div class="courses-grid">' + html + '</div></div>';
  },

  renderAbout: function() {
    console.log('[UI] Rendering About');
    var root = document.getElementById('root');
    if (!root) return;
    root.innerHTML = '<div class="container"><h2>About</h2><p>Senior Network Engineer specializing in enterprise infrastructure.</p></div>';
  },

  renderContact: function() {
    console.log('[UI] Rendering Contact');
    var root = document.getElementById('root');
    if (!root) return;
    root.innerHTML = '<div class="container"><h2>Contact</h2><p>Get in touch for consulting opportunities.</p></div>';
  }
};

console.log('[UI] UI module loaded successfully');