# Varpix Deployment Guide - Ahmed Hussein LMS

This guide covers deploying the Laravel 11 LMS application to Varpix hosting.

## Prerequisites
- Varpix hosting account with cPanel/FTP access
- Domain: ahmedhussein.org
- MySQL database credentials from Varpix
- SSH access (if available) or FTP client

## Step 1: Prepare Production Environment

### 1.1 Update .env for Production

Create or update `.env.production` with Varpix credentials:

```
APP_NAME="Ahmed Hussein LMS"
APP_ENV=production
APP_KEY=base64:mbu2bjWZdG8ZetRORZGcWxsVdj3W7trjvphlb888fLA=
APP_DEBUG=false
APP_URL=https://ahmedhussein.org

LOG_CHANNEL=stack
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=<varpix-db-host>
DB_PORT=3306
DB_DATABASE=<varpix-db-name>
DB_USERNAME=<varpix-db-user>
DB_PASSWORD=<varpix-db-password>

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=public
QUEUE_CONNECTION=sync

MAIL_MAILER=smtp
MAIL_HOST=<varpix-mail-host>
MAIL_PORT=587
MAIL_USERNAME=<your-email>
MAIL_PASSWORD=<mail-password>
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="admin@ahmedhussein.org"
MAIL_FROM_NAME="Ahmed Hussein LMS"

SESSION_DRIVER=file
SESSION_LIFETIME=120

VITE_APP_NAME="Ahmed Hussein LMS"
```

**Important**: Get actual values from Varpix cPanel:
- Database credentials from MySQL databases
- Mail settings from Mail Configuration
- Replace placeholders with real values

## Step 2: Files to Upload to Varpix

### 2.1 What to Upload (Production Build)

```
Root Directory (usually public_html/):
├── public/              (All files - CSS, JS, images)
├── app/                 (All files)
├── bootstrap/           (All files)
├── config/              (All files)
├── database/            (migrations folder only)
├── resources/           (All files - views)
├── routes/              (All files - web.php, api.php)
├── storage/             (Create uploads/ subfolder)
├── tests/               (Optional)
├── vendor/              (Run composer install after upload)
├── .env                 (Production version with Varpix credentials)
├── .htaccess            (For mod_rewrite - Apache server)
├── artisan              (Laravel CLI)
├── composer.json        (For composer install)
├── composer.lock        (For composer install)
├── package.json         (If using npm)
```

### 2.2 What NOT to Upload

```
.git/                   (Version control)
.gitignore              
node_modules/           (Too large, reinstall via npm install)
*.log                   (Log files)
.DS_Store               (Mac files)
Thumbs.db               (Windows)
documentation files    (SETUP.md, README.md, etc.)
```

## Step 3: Upload to Varpix via FTP

### 3.1 Using FTP Client (FileZilla recommended)

1. **Connect to Varpix FTP**:
   - Host: ftp.ahmedhussein.org (or Varpix FTP host)
   - Username: Your FTP username (from Varpix)
   - Password: Your FTP password (from Varpix)
   - Port: 21 (standard FTP) or 990 (SFTP)

2. **Upload Process**:
   - Navigate to `public_html/` or root directory on server
   - Upload all project files (except node_modules, .git)
   - Maintain directory structure exactly
   - This typically takes 5-15 minutes depending on file count

3. **Set Permissions** (via FTP file properties):
   - `storage/` folder: 755 (readable/writable)
   - `bootstrap/cache/` folder: 755
   - `artisan` file: 755
   - Public files: 644

## Step 4: Create htaccess for Pretty URLs

Create `.htaccess` in your public root with:

```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)/$ /$1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

## Step 5: Server-Side Setup via SSH

If Varpix provides SSH access:

```bash
# SSH into server
ssh username@ahmedhussein.org

# Navigate to project directory
cd /home/username/public_html  # adjust path

# Install Composer dependencies
composer install --no-dev --optimize-autoloader

# Generate application key (if not set)
php artisan key:generate

# Create necessary directories
mkdir -p storage/logs storage/uploads storage/app/public
chmod -R 755 storage bootstrap/cache

# Create storage link (for uploads)
php artisan storage:link

# Run migrations (creates database tables)
php artisan migrate --force

# Clear caches
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Step 6: Without SSH - Manual Steps via cPanel

If SSH not available, use cPanel tools:

1. **Create database**:
   - Go to cPanel → MySQL Databases
   - Create new database: `lms_db`
   - Create new user with password
   - Assign user to database (all privileges)

2. **Run migrations** - Option A (if cPanel has PHP CLI):
   - In cPanel File Manager, navigate to project root
   - Right-click artisan → Terminal
   - Run: `php artisan migrate`

3. **Run migrations** - Option B (via web):
   - Create `public/migrate.php`:
   ```php
   <?php
   require __DIR__ . '/../vendor/autoload.php';
   $app = require __DIR__ . '/../bootstrap/app.php';
   $kernel = $app->make('Illuminate\Contracts\Console\Kernel');
   $status = $kernel->call('migrate');
   exit($status);
   ?>
   ```
   - Visit: `https://ahmedhussein.org/migrate.php`
   - Delete file after completion

4. **Create symbolic link for uploads**:
   - Create `public/storage` folder
   - Upload `.htaccess` inside:
   ```apache
   <IfModule mod_rewrite.c>
       RewriteEngine On
       RewriteRule ^(.*)$ ../storage/app/public/$1 [L]
   </IfModule>
   ```

## Step 7: Verify Deployment

1. **Test home page**: https://ahmedhussein.org/
   - Should see professional hero section
   - Navbar with logo, navigation, auth buttons
   - Featured courses grid

2. **Test courses page**: https://ahmedhussein.org/courses
   - Should list all courses from database
   - Professional card layout with cyan borders

3. **Test course detail**: https://ahmedhussein.org/courses/1
   - Should show course with lessons
   - Enroll button for free courses

4. **Test admin login**: https://ahmedhussein.org/ → Sign In
   - Email: admin@lms.local
   - Password: (your admin password)
   - Should access admin dashboard

5. **Test student login**:
   - Email: student@lms.local
   - Should see "My Learning" with enrolled courses
   - Progress bar showing 45% on test course

## Step 8: SSL/TLS Certificate Setup

1. **Via cPanel AutoSSL**:
   - cPanel → SSL/TLS Status
   - Should auto-generate free Let's Encrypt certificate
   - Wait 2-5 minutes for activation

2. **Update APP_URL** in `.env`:
   ```
   APP_URL=https://ahmedhussein.org
   ```

3. **Force HTTPS in code**:
   - In `config/app.php`, add:
   ```php
   'url' => env('APP_URL', 'https://ahmedhussein.org'),
   ```

4. **Add to AppServiceProvider** (app/Providers/AppServiceProvider.php):
   ```php
   public function boot(): void
   {
       if ($this->app->environment('production')) {
           \URL::forceScheme('https');
       }
   }
   ```

## Step 9: Post-Deployment Tasks

1. **Create first admin course**:
   - Login to admin dashboard
   - Create course: "CCNA 200-301 - Fundamentals"
   - Add 3-5 lessons with content
   - Test enrollment as student

2. **Configure email settings**:
   - Update MAIL settings in .env with real SMTP credentials
   - Test password reset functionality

3. **Set up backups**:
   - Via cPanel Backups
   - Schedule automated daily backups
   - Download backups regularly

4. **Monitor logs**:
   - Check `storage/logs/laravel.log` for errors
   - Monitor database size and optimize if needed

5. **Update DNS** (if needed):
   - Update domain DNS to point to Varpix
   - Allow 24-48 hours for propagation

## Troubleshooting

### 500 Internal Server Error
- Check `storage/logs/laravel.log`
- Verify `.env` file exists and readable
- Check database credentials
- Ensure `storage/` folder is writable

### Database Connection Failed
- Verify DB credentials in `.env`
- Check Varpix firewall allows PHP connections
- Test via cPanel MySQL terminal

### Uploads Not Working
- Ensure `storage/` folder exists and writable
- Check `config/filesystems.php` has correct paths
- Run: `php artisan storage:link`

### Page Showing Raw PHP Code
- PHP not installed/configured on server
- Contact Varpix support for PHP version verification

### Static Files (CSS/JS) Not Loading
- Check `.htaccess` syntax
- Verify `public/` folder permissions
- Clear browser cache and refresh

## Important Notes

1. **Database Backup Before Migration**:
   - Always backup production database
   - Keep backup during development
   - Test migrations locally first

2. **Keep .env Secure**:
   - Never commit .env to git
   - Set proper file permissions (644)
   - Use strong database passwords

3. **Regular Updates**:
   - Keep Laravel and dependencies updated
   - Monitor security advisories
   - Test updates in development first

4. **Monitoring**:
   - Set up error logging
   - Monitor storage/logs regularly
   - Watch database growth

## Quick Reference - Varpix Details Needed

Before deploying, collect from Varpix:

```
[ ] FTP Host: _______________
[ ] FTP Username: _______________
[ ] FTP Password: _______________
[ ] Root/Public HTML Path: _______________
[ ] MySQL Host: _______________
[ ] MySQL Database: _______________
[ ] MySQL Username: _______________
[ ] MySQL Password: _______________
[ ] SMTP Host: _______________
[ ] SMTP Port: _______________
[ ] SMTP Username: _______________
[ ] SMTP Password: _______________
[ ] Admin Email: _______________
```

## Support

For Varpix-specific issues:
- Contact: Varpix support
- Documentation: https://varpix.com/docs

For Laravel issues:
- Documentation: https://laravel.com/docs
- Community: https://laracasts.com
