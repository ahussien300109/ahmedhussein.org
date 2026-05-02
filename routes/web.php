<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\QuizAttemptController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('auth.store');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Lesson View Route (Public - for enrolled users)
Route::get('/courses/{course}/lessons/{lesson}', [LessonController::class, 'show'])->name('lessons.show');

// Public Routes
Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/{course}', [CourseController::class, 'show'])->name('courses.show');
Route::get('/about', function () {
    return view('about');
})->name('about');
Route::get('/contact', function () {
    return view('contact');
})->name('contact');

// Student Routes
Route::middleware('auth')->group(function () {
    Route::post('/courses/{course}/enroll', [EnrollmentController::class, 'enroll'])->name('courses.enroll');
    Route::get('/my-learning', [EnrollmentController::class, 'myLearning'])->name('student.my-learning');
    Route::post('/courses/{course}/progress', [EnrollmentController::class, 'updateProgress'])->name('courses.progress');

    // Payment Routes
    Route::get('/courses/{course}/checkout', [PaymentController::class, 'checkout'])->name('payment.checkout');
    Route::post('/courses/{course}/payment/create-order', [PaymentController::class, 'createOrder'])->name('payment.create-order');
    Route::post('/courses/{course}/payment/capture', [PaymentController::class, 'captureOrder'])->name('payment.capture');
    Route::get('/courses/{course}/payment/success', [PaymentController::class, 'success'])->name('payment.success');
});

// Admin Routes
Route::middleware(['auth', AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('courses', CourseController::class)->except(['show']);

    Route::get('/courses/{course}/lessons/create', [LessonController::class, 'create'])->name('lessons.create');
    Route::post('/courses/{course}/lessons', [LessonController::class, 'store'])->name('lessons.store');
    Route::get('/courses/{course}/lessons/{lesson}/edit', [LessonController::class, 'edit'])->name('lessons.edit');
    Route::put('/courses/{course}/lessons/{lesson}', [LessonController::class, 'update'])->name('lessons.update');
    Route::delete('/courses/{course}/lessons/{lesson}', [LessonController::class, 'destroy'])->name('lessons.destroy');

    Route::get('/courses/{course}/lessons/{lesson}/quiz/create', [QuizController::class, 'create'])->name('quiz.create');
    Route::post('/courses/{course}/lessons/{lesson}/quiz', [QuizController::class, 'store'])->name('quiz.store');
    Route::get('/courses/{course}/lessons/{lesson}/quiz/edit', [QuizController::class, 'edit'])->name('quiz.edit');
    Route::put('/courses/{course}/lessons/{lesson}/quiz', [QuizController::class, 'update'])->name('quiz.update');
    Route::delete('/courses/{course}/lessons/{lesson}/quiz', [QuizController::class, 'destroy'])->name('quiz.destroy');

    // Note: courses resource will create admin.courses.* named routes
    // lessons routes are explicitly named without admin. prefix due to explicit ->name() calls
});

// Student Quiz Routes
Route::middleware('auth')->group(function () {
    Route::post('/courses/{course}/lessons/{lesson}/quiz', [QuizAttemptController::class, 'store'])->name('quiz.attempt.store');
    Route::get('/quiz/attempts/{attempt}', [QuizAttemptController::class, 'show'])->name('quiz.attempt.show');
});

require __DIR__.'/auth.php';
