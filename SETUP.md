# Laravel LMS Platform - Setup Guide

A complete Learning Management System (LMS) built with Laravel 11, MySQL, and Bootstrap 5. Similar to Udemy with admin and student functionality.

## Features

✅ **Admin Dashboard** - Manage courses and lessons  
✅ **Course Management** - Create, edit, delete courses  
✅ **Lesson Management** - Add lessons with text, images, videos, and downloadable files  
✅ **Student Enrollment** - Students can enroll in free courses  
✅ **Progress Tracking** - Track student progress in courses  
✅ **Responsive UI** - Bootstrap 5 responsive design  
✅ **Authentication** - Laravel Breeze with role-based access  

---

## System Requirements

- **PHP**: 8.1 or higher
- **MySQL**: 5.7 or higher (or MariaDB 10.2+)
- **Composer**: Latest version
- **Node.js & npm**: (Optional, for asset compilation)
- **Git**: (For version control)

---

## Installation Steps

### 1. Clone or Download the Repository

```bash
cd /your/project/directory
# If using git
git clone <your-repo-url> .

# Or download and extract the files
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Setup Environment Configuration

```bash
# Copy the example env file
cp .env.example .env

# Or manually create .env with the content from .env.example
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Configure Database

Edit `.env` file and set your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=lms_db
DB_USERNAME=root
DB_PASSWORD=your_password
```

**Create the database:**

```bash
# MySQL CLI
mysql -u root -p -e "CREATE DATABASE lms_db;"

# Or using phpMyAdmin, create a database named 'lms_db'
```

### 6. Run Migrations

```bash
php artisan migrate
```

This will create all necessary tables:
- `users`
- `courses`
- `lessons`
- `enrollments`
- `password_reset_tokens`
- `sessions`

### 7. Create Storage Symlink

```bash
php artisan storage:link
```

This creates a symbolic link from `public/storage` to `storage/app/public` for file uploads.

### 8. Create Admin User (Seeder)

Create a seeder file to add test data:

```bash
php artisan make:seeder AdminUserSeeder
```

Add this to `database/seeders/AdminUserSeeder.php`:

```php
<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@lms.local',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Test Student',
            'email' => 'student@lms.local',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);
    }
}
```

Run the seeder:

```bash
php artisan db:seed --class=AdminUserSeeder
```

### 9. Clear Cache

```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
```

---

## Running the Application

### Development Server

```bash
php artisan serve
```

The application will be available at `http://localhost:8000`

### Test Accounts

- **Admin Account**
  - Email: `admin@lms.local`
  - Password: `password`
  - URL: `http://localhost:8000/admin/dashboard`

- **Student Account**
  - Email: `student@lms.local`
  - Password: `password`
  - URL: `http://localhost:8000`

---

## File Upload Configuration

### Local Storage (Default)

Files are stored in `storage/app/public` and accessed via `public/storage/`.

**Configuration** (in `.env`):
```env
FILESYSTEM_DISK=public
```

### Directory Structure

```
storage/
├── app/
│   └── public/
│       ├── courses/        (Course images)
│       └── lessons/        (Lesson files)
public/
└── storage/               (Symlink to storage/app/public)
```

### Upload Size Limits

Edit `php.ini` or `.htaccess` to increase limits:

```ini
post_max_size = 10M
upload_max_filesize = 10M
```

---

## Project Structure

```
app/
├── Models/              (Eloquent Models)
│   ├── User.php
│   ├── Course.php
│   ├── Lesson.php
│   └── Enrollment.php
├── Http/
│   ├── Controllers/     (Request Handlers)
│   │   ├── CourseController.php
│   │   ├── LessonController.php
│   │   ├── EnrollmentController.php
│   │   └── DashboardController.php
│   └── Middleware/
│       └── AdminMiddleware.php
├── Policies/            (Authorization)
│   └── CoursePolicy.php

resources/
└── views/               (Blade Templates)
    ├── layouts/
    │   └── app.blade.php
    ├── welcome.blade.php
    ├── courses/
    │   ├── index.blade.php
    │   ├── show.blade.php
    │   ├── create.blade.php
    │   └── edit.blade.php
    ├── lessons/
    │   ├── create.blade.php
    │   └── edit.blade.php
    ├── admin/
    │   └── dashboard.blade.php
    └── student/
        └── my-learning.blade.php

database/
├── migrations/          (Database Schema)
└── seeders/            (Database Seeds)

routes/
└── web.php             (Route Definitions)
```

---

## Database Schema

### Users Table
```
id | name | email | password | role (admin/user) | created_at | updated_at
```

### Courses Table
```
id | title | description | image | is_free | created_by | created_at | updated_at
```

### Lessons Table
```
id | course_id | title | content | video_url | file_path | order | created_at | updated_at
```

### Enrollments Table
```
id | user_id | course_id | progress | completed_at | created_at | updated_at
```

---

## API Routes

### Public Routes

| Route | Method | Description |
|-------|--------|-------------|
| `/` | GET | Homepage |
| `/courses` | GET | Course listing |
| `/courses/{id}` | GET | Course details |
| `/login` | GET/POST | User login |
| `/register` | GET/POST | User registration |

### Authenticated Routes

| Route | Method | Description |
|-------|--------|-------------|
| `/my-learning` | GET | Student's enrolled courses |
| `/courses/{id}/enroll` | POST | Enroll in a course |
| `/courses/{id}/progress` | POST | Update course progress |

### Admin Routes

| Route | Method | Description |
|-------|--------|-------------|
| `/admin/dashboard` | GET | Admin dashboard |
| `/admin/courses` | GET | Manage courses |
| `/admin/courses` | POST | Create course |
| `/admin/courses/{id}` | PUT | Update course |
| `/admin/courses/{id}` | DELETE | Delete course |
| `/admin/courses/{id}/lessons` | POST | Create lesson |
| `/admin/courses/{id}/lessons/{lessonId}` | PUT | Update lesson |
| `/admin/courses/{id}/lessons/{lessonId}` | DELETE | Delete lesson |

---

## Deployment to Varpix (or Any Shared Hosting)

### 1. Prepare Files

```bash
# Create a production build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 2. Upload to Server

Use FTP, SFTP, or the hosting control panel to upload:
- All application files
- `.env` file (with production settings)
- `vendor/` directory (or run `composer install` on server)

### 3. Set Permissions

```bash
# Via SSH
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
chmod -R 775 public/storage/
```

### 4. Configure Database on Server

- Create a MySQL database on your hosting
- Update `.env` with server database credentials

### 5. Run Migrations

```bash
php artisan migrate --force
```

### 6. Create Symlink (if needed)

```bash
php artisan storage:link
```

### 7. Create Admin User

```bash
php artisan tinker
# Then run:
User::create(['name' => 'Admin', 'email' => 'admin@yourdomain.com', 'password' => Hash::make('password'), 'role' => 'admin']);
```

### 8. Set Web Root

Set your hosting's web root to the `public/` directory.

---

## Troubleshooting

### 404 Errors

- Ensure `.htaccess` is present in the `public/` directory
- Check if mod_rewrite is enabled on your server
- Verify the web root is pointing to the `public/` folder

### File Upload Issues

- Check `storage/` and `public/storage/` permissions
- Verify `FILESYSTEM_DISK=public` in `.env`
- Run `php artisan storage:link`

### Database Connection Error

- Verify MySQL is running
- Check database credentials in `.env`
- Ensure database user has proper permissions

### Storage Link Not Working

```bash
# Remove and recreate
rm public/storage
php artisan storage:link
```

### Password Hashing Issues

Ensure you're using the proper hashing method:

```php
use Illuminate\Support\Facades\Hash;
Hash::make('password')
```

---

## Security Considerations

1. **Environment Variables**
   - Never commit `.env` to version control
   - Use `.env.example` as a template

2. **File Uploads**
   - Files are uploaded to `storage/app/public`
   - Validate file types and sizes
   - Use Laravel's built-in validation

3. **Database**
   - Use strong passwords
   - Keep MySQL updated
   - Use parameterized queries (Laravel ORM does this)

4. **Authentication**
   - Implement rate limiting
   - Use HTTPS in production
   - Keep Laravel and packages updated

5. **Authorization**
   - Verify user roles before actions
   - Admins can only manage their own courses
   - Use Laravel's Gate and Policy system

---

## Additional Features (Optional)

### Enable Course Search

Add to `CourseController@index`:
```php
public function index(Request $request)
{
    $courses = Course::where('title', 'like', '%'.$request->search.'%')
                      ->latest()
                      ->get();
    return view('courses.index', compact('courses'));
}
```

### Add Course Categories

```php
php artisan make:model Category -m
```

### Enable Course Ratings

```php
php artisan make:model Rating -m
```

### Add Comments/Discussion

```php
php artisan make:model Comment -m
```

---

## Support & Maintenance

- **Laravel Docs**: https://laravel.com/docs
- **Bootstrap Docs**: https://getbootstrap.com/docs
- **MySQL Docs**: https://dev.mysql.com/doc/

---

## License

This project is open source and available under the MIT License.

---

## Quick Reference

```bash
# Start development server
php artisan serve

# Run migrations
php artisan migrate

# Create seeder
php artisan make:seeder ClassName

# Run seeders
php artisan db:seed

# Cache clearing
php artisan cache:clear
php artisan config:clear

# Create symlink for storage
php artisan storage:link

# Tinker (Laravel shell)
php artisan tinker
```

---

**Happy Learning! 🎓**
