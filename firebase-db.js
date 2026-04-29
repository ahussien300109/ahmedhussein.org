/* ─────────────────────────────────────────────
   firebase-db.js
   Firestore CRUD helpers for courses, lessons,
   users, and admin checks.
   All functions return Promises.
   ───────────────────────────────────────────── */

const DB = (() => {
  const db = () => window.FB.db;

  // ── COURSES ──────────────────────────────────────────────────

  /** Load all published courses (or all for admin). Returns array. */
  async function getCourses(includeUnpublished = false) {
    let q = db().collection('courses');
    if (!includeUnpublished) q = q.where('published', '==', true);
    q = q.orderBy('createdAt', 'asc');
    const snap = await q.get();
    return snap.docs.map(d => ({ ...d.data(), id: d.id }));
  }

  /** Get single course by slug-id. */
  async function getCourse(courseId) {
    const doc = await db().collection('courses').doc(courseId).get();
    return doc.exists ? { ...doc.data(), id: doc.id } : null;
  }

  /**
   * Create or update a course document.
   * If courseId is null, Firestore auto-generates the ID.
   */
  async function saveCourse(courseId, data) {
    const col = db().collection('courses');
    const ts = firebase.firestore.FieldValue.serverTimestamp();
    if (courseId) {
      await col.doc(courseId).set(
        { ...data, updatedAt: ts },
        { merge: true }
      );
      return courseId;
    } else {
      // Generate a slug from title
      const slug = data.title
        .toLowerCase()
        .replace(/[^a-z0-9]+/g, '-')
        .replace(/^-|-$/g, '');
      const uniqueSlug = slug + '-' + Date.now().toString(36);
      await col.doc(uniqueSlug).set({ ...data, createdAt: ts, updatedAt: ts });
      return uniqueSlug;
    }
  }

  /** Hard-delete a course and all its lessons. */
  async function deleteCourse(courseId) {
    const lessonsSnap = await db()
      .collection('courses').doc(courseId)
      .collection('lessons').get();
    const batch = db().batch();
    lessonsSnap.docs.forEach(d => batch.delete(d.ref));
    batch.delete(db().collection('courses').doc(courseId));
    await batch.commit();
  }

  // ── LESSONS ──────────────────────────────────────────────────

  /** Get all lessons for a course, ordered by `order` field. */
  async function getLessons(courseId) {
    const snap = await db()
      .collection('courses').doc(courseId)
      .collection('lessons')
      .orderBy('order', 'asc')
      .get();
    return snap.docs.map(d => ({ ...d.data(), lessonId: d.id }));
  }

  /** Save a lesson (create or update). Returns lessonId. */
  async function saveLesson(courseId, lessonId, data) {
    const col = db().collection('courses').doc(courseId).collection('lessons');
    const ts = firebase.firestore.FieldValue.serverTimestamp();
    if (lessonId) {
      await col.doc(lessonId).set({ ...data, updatedAt: ts }, { merge: true });
      return lessonId;
    } else {
      const ref = await col.add({ ...data, createdAt: ts, updatedAt: ts });
      // Update denormalized count on parent course
      await db().collection('courses').doc(courseId).update({
        lessonCount: firebase.firestore.FieldValue.increment(1),
        updatedAt: ts
      });
      return ref.id;
    }
  }

  /** Delete a lesson by ID. */
  async function deleteLesson(courseId, lessonId) {
    await db()
      .collection('courses').doc(courseId)
      .collection('lessons').doc(lessonId)
      .delete();
    const ts = firebase.firestore.FieldValue.serverTimestamp();
    await db().collection('courses').doc(courseId).update({
      lessonCount: firebase.firestore.FieldValue.increment(-1),
      updatedAt: ts
    });
  }

  // ── USERS ─────────────────────────────────────────────────────

  /** Read user profile document. */
  async function getUser(uid) {
    const doc = await db().collection('users').doc(uid).get();
    return doc.exists ? doc.data() : null;
  }

  /** Create user profile after registration. */
  async function createUserProfile(uid, data) {
    await db().collection('users').doc(uid).set({
      ...data,
      enrolled: [],
      progress: {},
      tier: 'free',
      joined: firebase.firestore.FieldValue.serverTimestamp()
    });
  }

  /** Enroll user in a course. */
  async function enrollUser(uid, courseId) {
    await db().collection('users').doc(uid).update({
      enrolled: firebase.firestore.FieldValue.arrayUnion(courseId),
      updatedAt: firebase.firestore.FieldValue.serverTimestamp()
    });
  }

  /** Mark a lesson as complete for progress tracking. */
  async function markLessonDone(uid, courseId, lessonId, done = true) {
    const key = `progress.${courseId}.${lessonId}`;
    await db().collection('users').doc(uid).update({
      [key]: done,
      updatedAt: firebase.firestore.FieldValue.serverTimestamp()
    });
  }

  /** Update user profile fields. */
  async function updateUserProfile(uid, data) {
    await db().collection('users').doc(uid).update({
      ...data,
      updatedAt: firebase.firestore.FieldValue.serverTimestamp()
    });
  }

  // ── ADMIN CHECK ───────────────────────────────────────────────

  /** Check if uid is in the admins collection. */
  async function isAdmin(uid) {
    if (!uid) return false;
    const doc = await db().collection('admins').doc(uid).get();
    return doc.exists;
  }

  return {
    getCourses, getCourse, saveCourse, deleteCourse,
    getLessons, saveLesson, deleteLesson,
    getUser, createUserProfile, enrollUser, markLessonDone,
    updateUserProfile, isAdmin
  };
})();
