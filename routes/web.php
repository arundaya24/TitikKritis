<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CritiqueController;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminCritiqueController;
use App\Http\Controllers\Admin\AdminUserController;

// ============ GUEST ROUTES ============
Route::middleware('guest')->group(function () {
    // Auth
    Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    Route::get('/get-regencies', [RegisterController::class, 'getRegencies'])->name('get.regencies');
    Route::get('/get-districts', [RegisterController::class, 'getDistricts'])->name('get.districts');

    // ============ LUPA PASSWORD ============
    Route::get('/forgot-password', [PasswordResetController::class, 'showForgotForm'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])->name('password.update');
});

// ============ AUTH ROUTES ============
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('/statistic', [StatisticController::class, 'index'])->name('statistic.index');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    Route::get('/critique', [CritiqueController::class, 'index'])->name('critique.index');
    Route::get('/critique/history', [CritiqueController::class, 'history'])->name('critique.history');
    Route::get('/critique/create', [CritiqueController::class, 'create'])->name('critique.create');
    Route::post('/critique', [CritiqueController::class, 'store'])->name('critique.store');
    Route::get('/critique/{id}', [CritiqueController::class, 'show'])->name('critique.show');
    Route::get('/critique/{id}/edit', [CritiqueController::class, 'edit'])->name('critique.edit');
    Route::put('/critique/{id}', [CritiqueController::class, 'update'])->name('critique.update');
    Route::delete('/critique/{id}', [CritiqueController::class, 'destroy'])->name('critique.destroy');

    Route::get('/get-regencies-critique', [CritiqueController::class, 'getRegencies'])->name('get.regencies.critique');
    Route::get('/get-districts-critique', [CritiqueController::class, 'getDistricts'])->name('get.districts.critique');
});

// ============ ADMIN ROUTES ============
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('/critiques', [AdminCritiqueController::class, 'index'])->name('critiques.index');
    Route::get('/critiques/{id}', [AdminCritiqueController::class, 'show'])->name('critiques.show');
    Route::put('/critiques/{id}/status', [AdminCritiqueController::class, 'updateStatus'])->name('critiques.status');
    Route::post('/critiques/{id}/respond', [AdminCritiqueController::class, 'respond'])->name('critiques.respond');

    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [AdminUserController::class, 'create'])->name('users.create');
    Route::post('/users', [AdminUserController::class, 'store'])->name('users.store');
    Route::delete('/users/{id}', [AdminUserController::class, 'destroy'])->name('users.destroy');
});
