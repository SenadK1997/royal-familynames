<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function() {
    return view ('LandingPage');
});

// Show registration form and handle registration
Route::get('/register', [AdminController::class, 'showRegistrationForm'])->name('registration');
Route::post('/register', [AdminController::class, 'register'])->name('register');

// Family Register

Route::get('/register/family', [AdminController::class, 'showRegisterFamily'])->name('family.registration')->middleware('auth');
Route::post('/register/family', [AdminController::class, 'registerFamily'])->name('family.register');

// Show login form and handle login
Route::get('/login', [AdminController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AdminController::class, 'login'])->name('login.post');

// Logout
Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

Route::get('/account/{account_id}', [AdminController::class, 'myAccount'])->name('myAccount');
