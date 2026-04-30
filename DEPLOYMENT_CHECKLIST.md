# Pre-Deployment Checklist - Ahmed Hussein LMS

Complete this checklist before deploying to Varpix. ✅ = Done, ❌ = Needs Action

## Local Testing & Verification

- [ ] ✅ Laravel application runs locally (`php artisan serve`)
- [ ] ✅ All migrations complete and database tables created
- [ ] ✅ Admin account created (admin@lms.local)
- [ ] ✅ Test student account created (student@lms.local)
- [ ] ✅ Test course created with 3 lessons
- [ ] ✅ Home page loads with professional design
- [ ] ✅ Courses page displays course list from database
- [ ] ✅ Course detail page shows lessons with content
- [ ] ✅ Enrollment functionality works
- [ ] ✅ Admin dashboard accessible and functional
- [ ] ✅ CSS/styling consistent across all pages
- [ ] ✅ Responsive design works on mobile

## Code & Configuration

- [ ] All code committed to git
  ```bash
  git status  # Should show "nothing to commit"
  ```

- [ ] .env file has production settings ready
  ```bash
  APP_ENV=production
  APP_DEBUG=false
  APP_URL=https://ahmedhussein.org
  ```

- [ ] All third-party dependencies installed
  ```bash
  composer install --no-dev --optimize-autoloader
  npm install (if using npm)
  ```

- [ ] Environment variables documented
  - [ ] Database credentials prepared
  - [ ] Mail settings prepared
  - [ ] Storage configuration correct

- [ ] Security settings configured
  - [ ] APP_KEY generated (`php artisan key:generate`)
  - [ ] CSRF protection enabled
  - [ ] Session configuration secure

## Varpix Account Setup

- [ ] Varpix hosting account active
- [ ] Domain ahmedhussein.org registered
- [ ] FTP/SFTP credentials obtained
  ```
  FTP Host: _______________
  FTP Username: _______________
  FTP Password: _______________
  Root Path: _______________
  ```

- [ ] MySQL database created on Varpix
  ```
  DB Host: _______________
  DB Name: _______________
  DB User: _______________
  DB Password: _______________
  ```

- [ ] SMTP/Mail settings available (optional but recommended)
  ```
  SMTP Host: _______________
  SMTP Port: _______________
  SMTP User: _______________
  SMTP Password: _______________
  ```

## Files Prepared for Upload

- [ ] Remove unnecessary files:
  ```bash
  # Delete before uploading
  rm -rf .git/
  rm -rf node_modules/
  rm SETUP.md INSTALLATION_NOTES.md README.md QUICK_START.md
  rm *.bat *.ps1
  rm ahmedhussein_website.zip
  ```

- [ ] Create/verify necessary directories:
  ```
  storage/
  storage/logs/
  storage/uploads/
  storage/app/public/
  bootstrap/cache/
  public/storage (symlink)
  ```

- [ ] .htaccess file ready for Apache
  - Located in public root
  - Contains proper rewrite rules
  - See VARPIX_DEPLOYMENT.md for content

## Database Preparation

- [ ] Backup current local database
  ```bash
  mysqldump -u root lms_db > lms_db_backup.sql
  ```

- [ ] Migration files tested locally
  ```bash
  php artisan migrate
  php artisan migrate:rollback
  php artisan migrate
  ```

- [ ] Seeder data prepared (if needed)
  ```bash
  php artisan db:seed  # Optional
  ```

## File Upload Process

- [ ] FTP client configured and tested
  - [ ] Connection successful
  - [ ] Correct root directory identified
  
- [ ] Dry run completed (test with small folder)
  - [ ] Files uploaded correctly
  - [ ] Directory structure maintained
  - [ ] Permissions set correctly (755 for folders, 644 for files)

- [ ] All project files uploaded to Varpix
  - [ ] app/ directory
  - [ ] bootstrap/ directory
  - [ ] config/ directory
  - [ ] database/migrations/ directory
  - [ ] public/ directory (with CSS, JS, images)
  - [ ] resources/ directory (views)
  - [ ] routes/ directory
  - [ ] storage/ directory (empty, directories only)
  - [ ] .env file (production version with real credentials)
  - [ ] artisan file
  - [ ] composer.json & composer.lock
  - [ ] .htaccess file (in public root)

## Post-Upload Server Setup

- [ ] Composer dependencies installed on Varpix
  ```bash
  composer install --no-dev --optimize-autoloader
  ```

- [ ] Application key verified/generated
  ```bash
  php artisan key:generate  # Only if not already set
  ```

- [ ] Directory permissions set correctly
  ```bash
  chmod -R 755 storage bootstrap/cache
  chmod 644 .env
  chmod 755 artisan
  ```

- [ ] Database migrations executed
  ```bash
  php artisan migrate --force
  ```

- [ ] Storage link created (for file uploads)
  ```bash
  php artisan storage:link
  ```

- [ ] Configuration caches cleared
  ```bash
  php artisan config:cache
  php artisan route:cache
  php artisan view:cache
  ```

## SSL/TLS Certificate

- [ ] SSL certificate installed (Let's Encrypt via AutoSSL)
  - [ ] Certificate active and valid
  - [ ] HTTPS accessible at https://ahmedhussein.org

- [ ] APP_URL updated to HTTPS
  ```
  APP_URL=https://ahmedhussein.org
  ```

- [ ] Force HTTPS configured in AppServiceProvider
  - [ ] Redirect HTTP to HTTPS
  - [ ] Secure cookies configured

## Post-Deployment Testing

- [ ] Home page loads
  - [ ] URL: https://ahmedhussein.org/
  - [ ] Professional design displays
  - [ ] No 500 errors in logs

- [ ] Courses page works
  - [ ] URL: https://ahmedhussein.org/courses
  - [ ] Course list displays from database
  - [ ] CSS styling correct

- [ ] Course detail page functional
  - [ ] URL: https://ahmedhussein.org/courses/1
  - [ ] Lessons display with content
  - [ ] Enroll button works

- [ ] Admin login functional
  - [ ] Login page accessible
  - [ ] Admin can login with credentials
  - [ ] Admin dashboard loads
  - [ ] Can create/edit courses

- [ ] Student functionality works
  - [ ] Student can login
  - [ ] My Learning page shows enrolled courses
  - [ ] Progress tracking displays
  - [ ] Can view course lessons

- [ ] File uploads work
  - [ ] Course image upload successful
  - [ ] Lesson file upload successful
  - [ ] Files accessible from storage

- [ ] Error logging functional
  - [ ] Check `storage/logs/laravel.log`
  - [ ] No critical errors present

## DNS & Domain

- [ ] DNS records configured (if migrating)
  - [ ] A record points to Varpix IP
  - [ ] MX records updated (if using Varpix mail)
  - [ ] CNAME records configured (if needed)
  - [ ] Wait for DNS propagation (24-48 hours)

- [ ] Domain accessible
  - [ ] https://ahmedhussein.org/ loads
  - [ ] Both www and non-www work

## Monitoring & Backups

- [ ] Automated backups configured
  - [ ] Via Varpix cPanel backup feature
  - [ ] Daily backup schedule
  - [ ] Test restore process

- [ ] Error monitoring setup
  - [ ] Check logs regularly
  - [ ] Monitor storage/logs/laravel.log
  - [ ] Subscribe to Varpix status updates

- [ ] Performance monitoring
  - [ ] Page load times acceptable
  - [ ] Database queries optimized
  - [ ] CPU/Memory usage reasonable

## Documentation

- [ ] Save Varpix credentials securely
  - [ ] Not in public repositories
  - [ ] Backed up safely
  - [ ] Share with team if needed

- [ ] Document admin login credentials
  - [ ] Admin email and password saved securely
  - [ ] Recovery options configured
  - [ ] Password changed from defaults

- [ ] Create maintenance contact info
  - [ ] Varpix support contact
  - [ ] Emergency procedures documented

## Final Verification

- [ ] Entire application tested end-to-end
  - [ ] Create a test course as admin
  - [ ] Enroll as student
  - [ ] View progress
  - [ ] Complete course

- [ ] All team members have access
  - [ ] Admin credentials shared securely
  - [ ] Documentation updated

- [ ] Deployment successful and stable
  - [ ] No errors in logs after 24 hours
  - [ ] All features functional
  - [ ] Performance acceptable

---

## Quick Reference - Current Status

✅ **Completed**:
- Laravel 11 application built
- All models and migrations created
- Database setup with test data
- Professional UI/UX design
- Admin dashboard
- Course management
- Lesson management
- Student enrollment
- Progress tracking

✅ **Tested Locally**:
- Home page
- Courses listing
- Course details with lessons
- Enrollment system
- Admin dashboard access

**Next Steps**:
1. Get Varpix credentials
2. Update production .env file
3. Upload files to Varpix via FTP
4. Run migrations on production server
5. Verify everything works on live domain

---

**Estimated Time to Full Deployment**: 2-4 hours
**Key Risks**: Database configuration, file permissions, DNS propagation
**Support**: See VARPIX_DEPLOYMENT.md for detailed troubleshooting
