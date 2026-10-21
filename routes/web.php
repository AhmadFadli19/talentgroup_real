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
use App\Http\Controllers\User\CodeExecutionController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\Admin\ModuleController as AdminModuleController;
use App\Http\Controllers\Admin\ModuleCategoryController as AdminModuleCategoryController;
use App\Http\Controllers\Admin\ReferralCodeController as AdminReferralCodeController;
use App\Http\Controllers\PrototypeHostController;
use App\Http\Controllers\User\PrototypeController as UserPrototypeController;
use App\Http\Controllers\Admin\PrototypeAdminController as AdminPrototypeController;

// ============================================
// PUBLIC ROUTES
// ============================================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/storage-file/{path}', [HomeController::class, 'streamFile'])->where('path', '.*')->name('storage.stream');

// Virtual Subdomain / Free Hosting Prototype Route
Route::get('/p/{slug}/{path?}', [PrototypeHostController::class, 'serve'])->where('path', '.*')->name('prototype.serve');

// Documentation / Separate Module Routes
Route::get('/modules', [ModuleController::class, 'index'])->name('modules.index');
Route::get('/modules/search', [ModuleController::class, 'search'])->name('modules.search');
Route::post('/modules/unlock', [ModuleController::class, 'unlock'])->name('modules.unlock');
Route::get('/modules/read/{slug}', [ModuleController::class, 'showLegacy'])->name('modules.show');
Route::get('/modules/{moduleSlug}', [ModuleController::class, 'showModule'])->name('modules.module.show');
Route::get('/modules/{moduleSlug}/{lessonSlug}', [ModuleController::class, 'showLesson'])->name('modules.lesson.show');

// ============================================
// AUTH ROUTES (UNIFIED SYSTEM)
// ============================================

// Unified Login (Satu Tempat Login untuk Admin dan User)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

// Backward Compatibility redirects
Route::get('/login-dashboard', function () { return redirect()->route('login'); })->name('login-dashboard');
Route::get('/login/admin', function () { return redirect()->route('login'); })->name('login.admin');
Route::post('/login/admin', [AuthController::class, 'login']);
Route::get('/login/user', function () { return redirect()->route('login'); })->name('login.user');
Route::post('/login/user', [AuthController::class, 'login']);

// Register dengan Email Verification
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Email Verification
Route::get('/verify', [AuthController::class, 'showVerify'])->name('verify.show');
Route::post('/verify', [AuthController::class, 'verify'])->name('verify');
Route::post('/verify/resend', [AuthController::class, 'resendCode'])->name('verify.resend');

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
    Route::post('courses/{course}/certificate/upload', [AdminCourseController::class, 'uploadCertificate'])->name('admin.courses.certificate.upload');
    Route::post('courses/{course}/certificate/reset', [AdminCourseController::class, 'resetCertificate'])->name('admin.courses.certificate.reset');

    // Admin: compile code to test output
    Route::post('code/compile', [AdminCourseContentController::class, 'compileCode'])->name('admin.code.compile');

    // MODULE MANAGER (Matching Screenshot 1 Course Manager pattern)
    Route::post('modules/preview', [AdminModuleController::class, 'preview'])->name('admin.modules.preview');
    Route::post('modules/upload-image', [AdminModuleController::class, 'uploadImage'])->name('admin.modules.upload-image');
    
    // Module Contents (Bab / Lessons of this module)
    Route::get('modules/{module}/contents', [AdminModuleController::class, 'contentsIndex'])->name('admin.modules.contents.index');
    Route::get('modules/{module}/contents/create', [AdminModuleController::class, 'contentsCreate'])->name('admin.modules.contents.create');
    Route::post('modules/{module}/contents', [AdminModuleController::class, 'contentsStore'])->name('admin.modules.contents.store');
    Route::get('modules/{module}/contents/{content}/edit', [AdminModuleController::class, 'contentsEdit'])->name('admin.modules.contents.edit');
    Route::put('modules/{module}/contents/{content}', [AdminModuleController::class, 'contentsUpdate'])->name('admin.modules.contents.update');
    Route::delete('modules/{module}/contents/{content}', [AdminModuleController::class, 'contentsDestroy'])->name('admin.modules.contents.destroy');

    // Private Module User Access
    Route::get('modules/{module}/access', [AdminModuleController::class, 'accessIndex'])->name('admin.modules.access.index');
    Route::post('modules/{module}/access', [AdminModuleController::class, 'accessGrant'])->name('admin.modules.access.grant');
    Route::delete('modules/{module}/access/{accessId}', [AdminModuleController::class, 'accessRevoke'])->name('admin.modules.access.revoke');

    // Toggle active / publish status
    Route::post('modules/{id}/toggle-active', [AdminModuleController::class, 'toggleActive'])->name('admin.modules.toggle-active');
    Route::post('modules/{module}/contents/{content}/toggle-publish', [AdminModuleController::class, 'contentsTogglePublish'])->name('admin.modules.contents.toggle-publish');

    Route::resource('modules', AdminModuleController::class)->names('admin.modules');

    // Referral Code Management
    Route::post('referral-codes/{id}/toggle-active', [AdminReferralCodeController::class, 'toggleActive'])->name('admin.referral-codes.toggle-active');
    Route::resource('referral-codes', AdminReferralCodeController::class)->names('admin.referral-codes');

    // Prototype Management & AI Settings
    Route::get('prototypes', [AdminPrototypeController::class, 'index'])->name('admin.prototypes.index');
    Route::post('prototypes/{id}/toggle-active', [AdminPrototypeController::class, 'toggleActive'])->name('admin.prototypes.toggle-active');
    Route::delete('prototypes/{id}', [AdminPrototypeController::class, 'destroy'])->name('admin.prototypes.destroy');
    Route::get('prototype-settings', [AdminPrototypeController::class, 'settings'])->name('admin.prototype-settings.index');
    Route::post('prototype-settings', [AdminPrototypeController::class, 'updateSettings'])->name('admin.prototype-settings.update');
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
    Route::post('/courses/{course}/check-referral', [UserCourseController::class, 'checkReferral'])->name('user.courses.check-referral');
    Route::post('/courses/{course}/retake', [UserCourseController::class, 'retake'])->name('user.courses.retake');
    


    // Course learning
    Route::get('/my-courses', [UserCourseController::class, 'myCourses'])->name('user.my-courses');
    Route::get('/courses/{course}/learn', [UserCourseController::class, 'learn'])->name('user.courses.learn');
    Route::get('/courses/{course}/content/{contentId}', [UserCourseController::class, 'content'])->name('user.courses.content');
    Route::post('/courses/{course}/content/{contentId}/answer', [UserCourseController::class, 'submitAnswer'])->name('user.courses.answer');
    Route::get('/courses/{course}/certificate', [UserCourseController::class, 'certificate'])->name('user.courses.certificate');

    // Code Execution API
    Route::post('/code/compile', [CodeExecutionController::class, 'compile'])->name('user.code.compile');
    Route::post('/code/validate-rules', [CodeExecutionController::class, 'validateRules'])->name('user.code.validate-rules');
    Route::post('/code/check', [CodeExecutionController::class, 'check'])->name('user.code.check');
    Route::post('/code/run-tests', [CodeExecutionController::class, 'runTests'])->name('user.code.run-tests');

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

    // AI Prototype Lab & Free Hosting
    Route::get('/prototypes', [UserPrototypeController::class, 'index'])->name('user.prototypes.index');
    Route::get('/prototypes/create', [UserPrototypeController::class, 'create'])->name('user.prototypes.create');
    Route::post('/prototypes/analyze', [UserPrototypeController::class, 'analyze'])->name('user.prototypes.analyze');
    Route::get('/prototypes/check-slug', [UserPrototypeController::class, 'checkSlug'])->name('user.prototypes.check-slug');
    Route::post('/prototypes/deploy', [UserPrototypeController::class, 'deploy'])->name('user.prototypes.deploy');
    Route::get('/prototypes/{id}/report', [UserPrototypeController::class, 'showReport'])->name('user.prototypes.report');
    Route::delete('/prototypes/{id}', [UserPrototypeController::class, 'destroy'])->name('user.prototypes.destroy');
});

// ============================================
// DEVELOPER ROUTES
// ============================================
Route::prefix('developer')->middleware(['auth', 'role:developer'])->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('developer.dashboard');
    Route::get('/home/{user}', [UserDashboardController::class, 'index'])->name('developer-home');
});

// ============================================
// PROFILE ROUTES (ANY AUTHENTICATED USER)
// ============================================
Route::middleware(['auth'])->group(function () {
    Route::get('/user/profile', [UserDashboardController::class, 'profile'])->name('user.profile');
    Route::post('/user/profile', [UserDashboardController::class, 'updateProfile'])->name('user.profile.update');
});