<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvestorController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ─── Public ────────────────────────────────────────────────
Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
});

// ─── Auth ──────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',    [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login',   [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register',[RegisterController::class, 'register']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// ─── Role Selection (auth but no role yet) ─────────────────
Route::middleware('auth')->group(function () {
    Route::get('/register/role',  [RegisterController::class, 'showRoleForm'])->name('register.role');
    Route::post('/register/role', [RegisterController::class, 'storeRole'])->name('register.role.store');
});

// ─── Authenticated Routes ──────────────────────────────────
Route::middleware(['auth'])->group(function () {

    // Dashboard (redirects by role)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Company public view
    Route::get('/companies/{company}', [CompanyController::class, 'show'])->name('companies.show');

    // Profile
    Route::get('/profile/edit',    [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    // Notifications
    Route::get('/notifications',                         [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/read',    [NotificationController::class, 'markRead'])->name('notifications.read');
    Route::get('/notifications/unread-count',            [NotificationController::class, 'unreadCount'])->name('notifications.unread');

    // ─── Entrepreneur ───────────────────────────────────────
    Route::middleware('role:entrepreneur')->prefix('entrepreneur')->name('entrepreneur.')->group(function () {
        Route::get('/companies',                 [CompanyController::class, 'index'])->name('companies');
        Route::get('/companies/create',          [CompanyController::class, 'create'])->name('companies.create');
        Route::post('/companies',                [CompanyController::class, 'store'])->name('companies.store');
        Route::get('/companies/{company}/edit',  [CompanyController::class, 'edit'])->name('companies.edit');
        Route::put('/companies/{company}',       [CompanyController::class, 'update'])->name('companies.update');
        Route::delete('/companies/{company}',    [CompanyController::class, 'destroy'])->name('companies.destroy');
        Route::post('/companies/{company}/send', [CompanyController::class, 'sendToInvestor'])->name('companies.send');
        Route::get('/investors',                 [ProfileController::class, 'investors'])->name('investors');
    });

    // ─── Investor ───────────────────────────────────────────
    Route::middleware('role:investor')->prefix('investor')->name('investor.')->group(function () {
        Route::get('/dashboard',   [InvestorController::class, 'dashboard'])->name('dashboard');
        Route::get('/companies',   [InvestorController::class, 'receivedCompanies'])->name('companies');
        Route::get('/investments', [InvestorController::class, 'investments'])->name('investments');
        Route::get('/search',      [InvestorController::class, 'search'])->name('search');
    });

    // Investor public profile (accessible by entrepreneurs too)
    Route::get('/investor/{user}/profile', [InvestorController::class, 'profile'])->name('investor.profile');
});
