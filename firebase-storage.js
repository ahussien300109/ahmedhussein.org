/* ─────────────────────────────────────────────
   firebase-storage.js
   File upload helpers for lesson assets.
   ───────────────────────────────────────────── */

const Storage = (() => {
  const storage = () => window.FB.storage;

  /**
   * Upload a file to Firebase Storage for a lesson.
   * Returns the public download URL string.
   * Calls onProgress(0–100) if provided.
   */
  async function uploadLessonFile(courseId, lessonId, file, onProgress) {
    const path = `lessons/${courseId}/${lessonId}/${file.name}`;
    const ref = storage().ref().child(path);
    const task = ref.put(file);

    return new Promise((resolve, reject) => {
      task.on(
        'state_changed',
        snap => {
          const pct = Math.round((snap.bytesTransferred / snap.totalBytes) * 100);
          if (onProgress) onProgress(pct);
        },
        reject,
        async () => {
          const url = await task.snapshot.ref.getDownloadURL();
          resolve(url);
        }
      );
    });
  }

  /**
   * Delete a file from Storage given its full download URL.
   * Silently ignores 'object-not-found' errors.
   */
  async function deleteFile(downloadUrl) {
    try {
      const ref = storage().refFromURL(downloadUrl);
      await ref.delete();
    } catch (e) {
      if (e.code !== 'storage/object-not-found') throw e;
    }
  }

  return { uploadLessonFile, deleteFile };
})();
