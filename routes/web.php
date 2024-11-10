<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController; // Corrected line

Route::get('/', function () {
    return view('landing');
})->name('landing'); // Assigning a name to the route

//Register Controller
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');

//Login Controller
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);