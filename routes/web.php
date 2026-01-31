<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BannerCardController;
use App\Http\Controllers\KolaborasiController;
use App\Http\Controllers\SlideBloggerController;
use App\Http\Controllers\User\CourseController as UserCourseController;
use App\Http\Controllers\Admin\CourseController as AdminCourseController;
use App\Http\Controllers\Bank\DashboardController as BankDashboardController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Bank\TransactionController as BankTransactionController;
use App\Http\Controllers\User\TransactionController as UserTransactionController;
use App\Http\Controllers\Admin\CourseContentController as AdminCourseContentController;

// ============================================
// PUBLIC ROUTES
// ============================================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/blog', [HomeController::class, 'blog'])->name('blog');
Route::get('/partnerkolaborasi', [HomeController::class, 'partnerkolaborasi'])->name('partnerkolaborasi');

// FIXED: Login Dashboard sekarang mengarah ke halaman pemilihan login
Route::get('/login-dashboard', [AuthController::class, 'showLoginDashboard'])->name('login-dashboard');

// ============================================
// AUTH ROUTES (UNIFIED SYSTEM)
// ============================================

// Register dengan Email Verification
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Email Verification
Route::get('/verify', [AuthController::class, 'showVerify'])->name('verify.show');
Route::post('/verify', [AuthController::class, 'verify'])->name('verify');
Route::post('/verify/resend', [AuthController::class, 'resendCode'])->name('verify.resend');

// Login Split
Route::get('/login/admin', [AuthController::class, 'showLoginAdmin'])->name('login.admin');
Route::post('/login/admin', [AuthController::class, 'loginAdmin']);

Route::get('/login/user', [AuthController::class, 'showLoginUser'])->name('login.user');
Route::post('/login/user', [AuthController::class, 'loginUser']);

// Bank Login
Route::get('/bank/login', [AuthController::class, 'showBankLogin'])->name('bank.login');
Route::post('/bank/login', [AuthController::class, 'loginBank']);

// Forgot Password
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('forgot.password');
Route::post('/forgot-password', [AuthController::class, 'sendResetCode']);
Route::get('/reset/verify', [AuthController::class, 'showResetVerify'])->name('reset.verify.show');
Route::post('/reset/verify', [AuthController::class, 'verifyResetCode'])->name('reset.verify');
Route::get('/reset/password', [AuthController::class, 'showResetPassword'])->name('reset.password.show');
Route::post('/reset/password', [AuthController::class, 'resetPassword'])->name('reset.password');

// Google OAuth (Optional)
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ============================================
// ADMIN ROUTES
// ============================================
Route::prefix('admin')->middleware(['auth', 'role:admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/home', [AdminController::class, 'index'])->name('admin-home');

    // Course Management
    Route::resource('courses', AdminCourseController::class)->names('admin.courses');
    Route::get('courses/{course}/contents', [AdminCourseContentController::class, 'index'])->name('admin.courses.contents.index');
    Route::get('courses/{course}/contents/create', [AdminCourseContentController::class, 'create'])->name('admin.courses.contents.create');
    Route::post('courses/{course}/contents', [AdminCourseContentController::class, 'store'])->name('admin.courses.contents.store');
    Route::get('courses/{course}/contents/{type}/{id}', [AdminCourseContentController::class, 'show'])->name('admin.courses.contents.show');
    Route::get('courses/{course}/contents/{type}/{id}/edit', [AdminCourseContentController::class, 'edit'])->name('admin.courses.contents.edit');
    Route::put('courses/{course}/contents/{type}/{id}', [AdminCourseContentController::class, 'update'])->name('admin.courses.contents.update');
    Route::delete('courses/{course}/contents/{type}/{id}', [AdminCourseContentController::class, 'destroy'])->name('admin.courses.contents.destroy');

    // Course Results
    Route::get('courses/{course}/results', [AdminCourseController::class, 'results'])->name('admin.courses.results');
    Route::get('users/{user}/course/{course}/results', [AdminCourseController::class, 'userResults'])->name('admin.users.course.results');

    // Admin Content Management
    Route::get('/content', [AdminController::class, 'content'])->name('admin-content');
    Route::get('/kelolaakun', [AdminController::class, 'kelolaakun'])->name('admin-kelolaakun');
    Route::get('/home/search', [AdminController::class, 'search'])->name('adminSearch');
    Route::post('/register-proses', [AdminController::class, 'registar_proses'])->name('admin-register');
    Route::post('/slidebanner/store', [AdminController::class, 'store'])->name('slidebanner.store');
    Route::delete('/slidebanner/delete/{id}', [AdminController::class, 'delete'])->name('slidebanner.delete');
    Route::post('/login/update/{id}', [AdminController::class, 'update'])->name('login-update');
    Route::post('/login/akun-delete/{id}', [AdminController::class, 'akun_delete'])->name('akun-delete');

    // Kolaborasi
    Route::prefix('kolaborasi')->group(function () {
        Route::get('/create', [KolaborasiController::class, 'create'])->name('kolaborasi.create');
        Route::post('/', [KolaborasiController::class, 'store'])->name('kolaborasi.store');
        Route::get('{id}/detail-form', [KolaborasiController::class, 'detailForm'])->name('kolaborasi.detail.form');
        Route::post('{id}/detail-form', [KolaborasiController::class, 'submitDetail'])->name('kolaborasi.detail.submit');
        Route::delete('/delete/{id}', [KolaborasiController::class, 'delete'])->name('kolaborasi.delete');
    });

    // BannerCard
    Route::prefix('bannercard')->group(function () {
        Route::get('/create', [BannerCardController::class, 'create'])->name('bannercard.create');
        Route::post('/', [BannerCardController::class, 'store'])->name('bannercard.store');
        Route::get('{id}/detail-form', [BannerCardController::class, 'detailForm'])->name('bannercard.detail.form');
        Route::post('{id}/detail-form', [BannerCardController::class, 'submitDetail'])->name('bannercard.detail.submit');
        Route::delete('/delete/{id}', [BannerCardController::class, 'delete'])->name('bannercard.delete');
    });

    // Cards
    Route::prefix('cards')->group(function () {
        Route::get('/create', [CardController::class, 'create'])->name('cards.create');
        Route::post('/', [CardController::class, 'store'])->name('cards.store');
        Route::get('{id}/detail-form', [CardController::class, 'detailForm'])->name('cards.detail.form');
        Route::post('{id}/detail-form', [CardController::class, 'submitDetail'])->name('cards.detail.submit');
        Route::delete('/delete/{id}', [CardController::class, 'delete'])->name('card.delete');
    });

    // Slide Blogger
    Route::prefix('slideblogger')->group(function () {
        Route::get('/create', [SlideBloggerController::class, 'create'])->name('slideblogger.create');
        Route::post('/', [SlideBloggerController::class, 'store'])->name('slideblogger.store');
        Route::get('{id}/detail-form', [SlideBloggerController::class, 'detailForm'])->name('slideblogger.detail.form');
        Route::post('{id}/detail-form', [SlideBloggerController::class, 'submitDetail'])->name('slideblogger.detail.submit');
        Route::delete('/delete/{id}', [SlideBloggerController::class, 'delete'])->name('blogger.delete');
    });
});

// ============================================
// BANK ROUTES
// ============================================
Route::prefix('bank')->middleware(['auth', 'role:bank'])->group(function () {
    Route::get('/dashboard', [BankDashboardController::class, 'index'])->name('bank.dashboard');
    Route::get('/reports', [BankDashboardController::class, 'reports'])->name('bank.reports');
    Route::get('/audit-logs', [BankDashboardController::class, 'auditLogs'])->name('bank.audit-logs');
    Route::get('/users/{user}/balance-history', [BankDashboardController::class, 'userBalanceHistory'])->name('bank.users.balance-history');

    // Transaction management
    Route::get('/transactions', [BankTransactionController::class, 'index'])->name('bank.transactions.index');
    Route::get('/transactions/{transaction}', [BankTransactionController::class, 'show'])->name('bank.transactions.show');
    Route::get('/transactions/{transaction}/confirm', [BankTransactionController::class, 'confirm'])->name('bank.transactions.confirm');
    Route::post('/transactions/{transaction}/confirm', [BankTransactionController::class, 'processConfirmation'])->name('bank.transactions.process-confirmation');
    Route::get('/transactions/{transaction}/reject', [BankTransactionController::class, 'reject'])->name('bank.transactions.reject');
    Route::post('/transactions/{transaction}/reject', [BankTransactionController::class, 'processRejection'])->name('bank.transactions.process-rejection');
    Route::post('/transactions/bulk-action', [BankTransactionController::class, 'bulkAction'])->name('bank.transactions.bulk-action');

    // Manual topup
    Route::get('/users/{user}/manual-topup', [BankTransactionController::class, 'manualTopup'])->name('bank.users.manual-topup');
    Route::post('/users/{user}/manual-topup', [BankTransactionController::class, 'processManualTopup'])->name('bank.users.process-manual-topup');
});

// ============================================
// USER ROUTES
// ============================================
Route::prefix('user')->middleware(['auth', 'role:user'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
    Route::get('/home/{user}', [UserDashboardController::class, 'index'])->name('user-home');

    // Course browsing and purchase
    Route::get('/courses', [UserCourseController::class, 'index'])->name('user.courses.index');
    Route::get('/courses/{course}', [UserCourseController::class, 'show'])->name('user.courses.show');
    Route::post('/courses/{course}/purchase', [UserCourseController::class, 'purchase'])->name('user.courses.purchase');

    // Course learning
    Route::get('/my-courses', [UserCourseController::class, 'myCourses'])->name('user.my-courses');
    Route::get('/courses/{course}/learn', [UserCourseController::class, 'learn'])->name('user.courses.learn');
    Route::get('/courses/{course}/content/{contentId}', [UserCourseController::class, 'content'])->name('user.courses.content');
    Route::post('/courses/{course}/content/{contentId}/answer', [UserCourseController::class, 'submitAnswer'])->name('user.courses.answer');

    // Results
    Route::get('/courses/{course}/results', [UserCourseController::class, 'results'])->name('user.courses.results');

    // Transactions
    Route::get('/transactions', [UserTransactionController::class, 'index'])->name('user.transactions.index');
    Route::get('/transactions/topup', [UserTransactionController::class, 'topup'])->name('user.transactions.topup');
    Route::post('/transactions/topup', [UserTransactionController::class, 'processTopup'])->name('user.transactions.topup.process');
    Route::get('/transactions/{transaction}', [UserTransactionController::class, 'show'])->name('user.transactions.show');
    Route::get('/balance-history', [UserTransactionController::class, 'balanceHistory'])->name('user.balance-history');
    Route::post('/transactions/{transaction}/confirm', [UserTransactionController::class, 'confirmPayment'])->name('user.transactions.confirm');

    // Midtrans callback
    Route::post('/midtrans/callback', [UserTransactionController::class, 'midtransCallback'])->name('user.midtrans.callback');
});

// ============================================
// DEVELOPER ROUTES
// ============================================
Route::prefix('developer')->middleware(['auth', 'role:developer'])->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('developer.dashboard');
    Route::get('/home/{user}', [UserDashboardController::class, 'index'])->name('developer-home');
});

// ============================================
// DYNAMIC ROUTES (Public)
// ============================================
Route::get('kolaborasi/{slug}', [KolaborasiController::class, 'dynamicView'])->name('kolaborasi.dynamic')->where('slug', '[A-Za-z0-9\-_]+');
Route::get('bannercard/{slug}', [BannerCardController::class, 'dynamicView'])->name('bannercard.dynamic')->where('slug', '[A-Za-z0-9\-_]+');
Route::get('cards/{slug}', [CardController::class, 'dynamicView'])->name('cards.dynamic')->where('slug', '[A-Za-z0-9\-_]+');
Route::get('slideblogger/{slug}', [SlideBloggerController::class, 'dynamicView'])->name('slideblogger.dynamic')->where('slug', '[A-Za-z0-9\-_]+');
