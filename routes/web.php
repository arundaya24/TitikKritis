<?php

use App\Http\Controllers\Admin\AdminCritiqueController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminUserManagementController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CritiqueController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StatisticController;
use Illuminate\Support\Facades\Route;

Route::get('/get-regencies', [RegisterController::class, 'getRegencies'])->name('get.regencies');
Route::get('/get-districts', [RegisterController::class, 'getDistricts'])->name('get.districts');

Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        return redirect()->route('login');
    });
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    Route::get('/forgot-password', [PasswordResetController::class, 'showForgotForm'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('/statistic', [StatisticController::class, 'index'])->name('statistic.index');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::delete('/profile/avatar', [ProfileController::class, 'deleteAvatar'])->name('profile.delete.avatar');

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

    Route::delete('/critique/force-delete/{id}', [CritiqueController::class, 'forceDelete'])->name('critique.force.delete');
    Route::put('/critique/archive/{id}', [CritiqueController::class, 'archive'])->name('critique.archive');
    Route::put('/critique/unarchive/{id}', [CritiqueController::class, 'unarchive'])->name('critique.unarchive');
    Route::delete('/critique/delete-archived/{id}', [CritiqueController::class, 'deleteArchived'])->name('critique.delete.archived');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('/critiques', [AdminCritiqueController::class, 'index'])->name('critiques.index');
    Route::get('/critiques/{id}', [AdminCritiqueController::class, 'show'])->name('critiques.show');
    Route::put('/critiques/{id}/status', [AdminCritiqueController::class, 'updateStatus'])->name('critiques.status');
    Route::post('/critiques/{id}/respond', [AdminCritiqueController::class, 'respond'])->name('critiques.respond');

    Route::delete('/critiques/force-delete/{id}', [AdminCritiqueController::class, 'forceDelete'])->name('critiques.force.delete');
    Route::put('/critiques/archive/{id}', [AdminCritiqueController::class, 'archive'])->name('critiques.archive');
    Route::put('/critiques/unarchive/{id}', [AdminCritiqueController::class, 'unarchive'])->name('critiques.unarchive');
    Route::delete('/critiques/delete-archived/{id}', [AdminCritiqueController::class, 'deleteArchived'])->name('critiques.delete.archived');

    Route::get('/critiques/archived-list', [AdminCritiqueController::class, 'archiveIndex'])->name('critiques.archive.index');

    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [AdminUserController::class, 'create'])->name('users.create');
    Route::post('/users', [AdminUserController::class, 'store'])->name('users.store');
    Route::delete('/users/{id}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    Route::put('/users/demote/{id}', [AdminUserController::class, 'demote'])->name('users.demote');
    Route::put('/users/promote/{id}', [AdminUserController::class, 'promote'])->name('users.promote');

    Route::get('/users/manage', [AdminUserManagementController::class, 'index'])->name('users.manage');
    Route::get('/users/detail/{id}', [AdminUserManagementController::class, 'show'])->name('users.detail');
    Route::delete('/users/delete/{id}', [AdminUserManagementController::class, 'destroy'])->name('users.delete');
    Route::get('/users/toggle/{id}', [AdminUserManagementController::class, 'toggleAdmin'])->name('users.toggle');
});
