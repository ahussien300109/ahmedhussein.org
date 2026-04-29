/* ─────────────────────────────────────────────
   migrate.js — ONE-TIME MIGRATION UTILITY
   Load this in index.html temporarily, log into admin account,
   then open browser console and run: migrateCoursesToFirestore()
   Remove this file + its <script> tag after migration is confirmed.
   ───────────────────────────────────────────── */

async function migrateCoursesToFirestore() {
  if (!S.isAdmin) {
    console.error('Must be logged in as admin to migrate.');
    return;
  }
  console.log('[Migrate] Starting migration of', DEFAULT_COURSES.length, 'courses...');

  for (const c of DEFAULT_COURSES) {
    // Convert integer id to a slug
    const slug = c.title
      .toLowerCase()
      .replace(/[^a-z0-9]+/g, '-')
      .replace(/^-|-$/g, '');

    const courseData = {
      cat:       c.cat,
      icon:      c.icon,
      th:        c.th,
      badge:     c.badge || null,
      title:     c.title,
      desc:      c.desc,
      level:     c.level,
      duration:  c.duration,
      students:  parseInt(c.students) || 0,
      price:     c.price,
      rating:    c.rating,
      reviews:   parseInt(c.reviews) || 0,
      prereqs:   c.prereqs || '',
      pageLink:  c.pageLink || null,
      btnLabel:  c.btnLabel || null,
      published: true,
      lessonCount: (c.curriculum || []).length,
    };

    try {
      await DB.saveCourse(slug, courseData);
      console.log(`[Migrate] Course saved: ${slug}`);

      // Migrate curriculum items as text lessons
      if (c.curriculum && c.curriculum.length) {
        for (let i = 0; i < c.curriculum.length; i++) {
          const lessonData = {
            order:       i + 1,
            title:       c.curriculum[i],
            type:        'text',
            content:     c.curriculum[i],
            freePreview: i === 0,
          };
          await DB.saveLesson(slug, null, lessonData);
        }
        console.log(`[Migrate] ${c.curriculum.length} lessons added to ${slug}`);
      }
    } catch (e) {
      console.error(`[Migrate] Failed for ${slug}:`, e);
    }
  }

  console.log('[Migrate] Complete. Remove migrate.js from index.html and redeploy.');
}
