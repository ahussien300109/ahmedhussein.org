window.UI = {
  renderHome: () => {
    console.log('[UI] Rendering Home');
    const root = document.getElementById('root');
    if (!root) return;
    root.innerHTML = `
      <div class="hero-section">
        <h1>Welcome to Ahmed Hussein's Lab</h1>
        <p>Network Engineering & Virtualization Expert</p>
        <div class="cta-buttons">
          <a href="#courses" class="btn btn-primary">View Courses</a>
          <a href="#about" class="btn btn-secondary">About Me</a>
        </div>
      </div>
      <div class="features-grid">
        <div class="feature-card"><i class="fas fa-network-wired"></i><h3>Network Design</h3></div>
        <div class="feature-card"><i class="fas fa-server"></i><h3>Virtualization</h3></div>
        <div class="feature-card"><i class="fas fa-shield-alt"></i><h3>Security</h3></div>
      </div>
    `;
  },

  renderCourses: () => {
    console.log('[UI] Rendering Courses');
    const root = document.getElementById('root');
    if (!root) return;
    
    const courses = window.COURSES || [];
    if (!courses.length) {
      root.innerHTML = `<div class="container"><h2>Courses</h2><p>No courses found.</p></div>`;
      return;
    }
    
    const html = courses.map(c => `
      <div class="course-card">
        <h3>${c.title || 'Untitled'}</h3>
        <p>${c.description || ''}</p>
      </div>
    `).join('');
    
    root.innerHTML = `<div class="container"><h2>Available Courses</h2><div class="courses-grid">${html}</div></div>`;
  },

  renderAbout: () => {
    const root = document.getElementById('root');
    if (!root) return;
    root.innerHTML = `<div class="container"><h2>About</h2><p>Senior Network Engineer.</p></div>`;
  },

  renderContact: () => {
    const root = document.getElementById('root');
    if (!root) return;
    root.innerHTML = `<div class="container"><h2>Contact</h2><p>Get in touch.</p></div>`;
  }
};