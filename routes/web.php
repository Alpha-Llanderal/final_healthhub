<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PrivacyPolicyController;
use App\Http\Controllers\DashboardController;

// Remove any unclosed groups or middleware
Route::get('/', function () {
    return view('landing');
})->name('landing');

// Registration Routes
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])
    ->name('login')
    ->middleware('guest');

Route::post('/login', [LoginController::class, 'login'])
    ->name('login.attempt')
    ->middleware('guest');

Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

// Privacy Policy
Route::get('/privacy-policy', [PrivacyPolicyController::class, 'show'])->name('privacy_policy');

// Dashboard Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/preferences', [DashboardController::class, 'updatePreferences'])
         ->name('dashboard.preferences');
    Route::get('/dashboard/medical-info', [DashboardController::class, 'quickMedicalInfo'])
         ->name('dashboard.medical-info');
});