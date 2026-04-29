/* ─────────────────────────────────────────────
   lesson-viewer.js
   Renders the lesson player at #lesson?course={courseId}&lesson={lessonId}
   ───────────────────────────────────────────── */

async function renderLessonViewer(courseId, lessonId) {
  const root = document.getElementById('root');
  root.innerHTML = `<div class="lv-loading">
    <i class="fas fa-spinner fa-spin"></i> Loading lesson...
  </div>`;

  try {
    // Parallel fetch: course metadata + all lessons
    const [course, lessons] = await Promise.all([
      DB.getCourse(courseId),
      DB.getLessons(courseId)
    ]);

    if (!course) { Router.go('courses'); return; }

    const currentIndex = lessons.findIndex(l => l.lessonId === lessonId);
    const lesson = lessons[currentIndex];
    if (!lesson) { Router.go('courses'); return; }

    const prevLesson = lessons[currentIndex - 1] || null;
    const nextLesson = lessons[currentIndex + 1] || null;

    // Check access: enrolled OR freePreview
    const hasAccess = lesson.freePreview
      || (S.user && S.enrolled.includes(courseId))
      || S.isAdmin;

    root.innerHTML = `
      <div class="lv-layout">
        <!-- Sidebar: course outline -->
        <aside class="lv-sidebar">
          <div class="lv-sidebar-title">
            <span>${course.icon}</span> ${course.title}
          </div>
          <div class="lv-lesson-list">
            ${lessons.map((l, i) => `
              <div class="lv-lesson-item ${l.lessonId === lessonId ? 'active' : ''}"
                   onclick="navigateLesson('${courseId}', '${l.lessonId}')">
                <span class="lv-lesson-num">${i + 1}</span>
                <span class="lv-lesson-title">${l.title}</span>
                ${l.freePreview
                  ? '<span class="lv-free-badge">Free</span>'
                  : (S.user && S.enrolled.includes(courseId))
                    ? '<i class="fas fa-check-circle lv-done-ico"></i>'
                    : '<i class="fas fa-lock lv-lock-ico"></i>'}
              </div>`).join('')}
          </div>
        </aside>

        <!-- Main content -->
        <main class="lv-main">
          <div class="lv-breadcrumb">
            <a href="#" onclick="Router.go('courses');return false">Courses</a>
            <i class="fas fa-chevron-right"></i>
            <span>${course.title}</span>
            <i class="fas fa-chevron-right"></i>
            ${lesson.title}
          </div>

          <h1 class="lv-lesson-title-h1">${lesson.title}</h1>

          ${hasAccess
            ? renderLessonContent(lesson)
            : renderLockedContent(course, courseId)}

          <!-- Bottom navigation -->
          <div class="lv-nav-bar">
            ${prevLesson
              ? `<button class="btn btn-ghost"
                         onclick="navigateLesson('${courseId}','${prevLesson.lessonId}')">
                   <i class="fas fa-arrow-left"></i> ${prevLesson.title}
                 </button>`
              : '<div></div>'}
            ${nextLesson
              ? `<button class="btn btn-c"
                         onclick="navigateLesson('${courseId}','${nextLesson.lessonId}')">
                   ${nextLesson.title} <i class="fas fa-arrow-right"></i>
                 </button>`
              : `<button class="btn btn-c"
                          onclick="Router.go('courses')">
                    <i class="fas fa-graduation-cap"></i> Back to Courses
                  </button>`}
          </div>
        </main>
      </div>`;

    // Progress tracking: mark as visited if enrolled
    if (S.user && S.enrolled.includes(courseId)) {
      DB.markLessonDone(S.user.uid, courseId, lessonId, true).catch(console.warn);
    }

  } catch (e) {
    console.error('[LessonViewer]', e);
    root.innerHTML = `<div class="lv-error">
      <i class="fas fa-exclamation-triangle"></i>
      Could not load lesson. <button class="btn btn-ghost" onclick="history.back()">Go Back</button>
    </div>`;
  }
}

// ── Content renderers by type ────────────────────────────────

function renderLessonContent(lesson) {
  switch (lesson.type) {
    case 'video':
      return renderVideoLesson(lesson);
    case 'image':
      return renderImageLesson(lesson);
    case 'file':
      return renderFileLesson(lesson);
    case 'text':
    default:
      return renderTextLesson(lesson);
  }
}

function renderTextLesson(lesson) {
  return `<div class="lv-text-content">${lesson.content || ''}</div>`;
}

function renderVideoLesson(lesson) {
  const isYT = lesson.videoUrl && (
    lesson.videoUrl.includes('youtube.com') ||
    lesson.videoUrl.includes('youtu.be')
  );

  if (isYT) {
    // Convert watch?v=ID or youtu.be/ID to embed URL
    let embedUrl = lesson.videoUrl
      .replace('watch?v=', 'embed/')
      .replace('youtu.be/', 'youtube.com/embed/');
    return `<div class="lv-video-wrap">
      <iframe class="lv-video-frame"
              src="${embedUrl}"
              allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
              allowfullscreen
              loading="lazy">
      </iframe>
    </div>`;
  }

  // Direct video file
  return `<div class="lv-video-wrap">
    <video class="lv-video-native" controls>
      <source src="${lesson.videoUrl}" type="video/mp4">
      Your browser does not support video.
    </video>
  </div>`;
}

function renderImageLesson(lesson) {
  return `<figure class="lv-image-wrap">
    <img src="${lesson.imageUrl}" alt="${lesson.title}" class="lv-image" loading="lazy">
    ${lesson.caption
      ? `<figcaption class="lv-image-caption">${lesson.caption}</figcaption>`
      : ''}
  </figure>`;
}

function renderFileLesson(lesson) {
  return `<div class="lv-file-block">
    <div class="lv-file-icon"><i class="fas fa-file-archive"></i></div>
    <div class="lv-file-info">
      <div class="lv-file-name">${lesson.fileName || 'Download File'}</div>
      ${lesson.fileSize
        ? `<div class="lv-file-size">${lesson.fileSize}</div>`
        : ''}
    </div>
    <a href="${lesson.fileUrl}"
       download="${lesson.fileName || 'download'}"
       class="btn btn-c"
       onclick="toast('Preparing download: ${lesson.fileName}', 'suc')">
      <i class="fas fa-download"></i> Download
    </a>
  </div>`;
}

function renderLockedContent(course, courseId) {
  return `<div class="lv-locked">
    <div class="lv-lock-icon"><i class="fas fa-lock"></i></div>
    <h3 class="lv-lock-title">Enroll to Access This Lesson</h3>
    <p class="lv-lock-desc">This lesson is part of <strong>${course.title}</strong>.</p>
    <div class="lv-lock-price">${course.price}</div>
    <button class="btn btn-c" onclick="enrollCourse('${courseId}')">
      <i class="fas fa-graduation-cap"></i> Enroll Now
    </button>
  </div>`;
}

function navigateLesson(courseId, lessonId) {
  location.hash = `lesson?course=${courseId}&lesson=${lessonId}`;
}
