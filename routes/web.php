<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Models\Familyname;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\VerificationController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
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
Route::get('/', [AdminController::class, 'homepage'])->name('homepage');

Route::get('/about', [AdminController::class, 'showAbout'])->name('about');
// Show registration form and handle registration
Route::get('/register', [AdminController::class, 'showRegistrationForm'])->name('registration');
Route::post('/register', [AdminController::class, 'register'])->name('register');

// Family Page
Route::get('/family/{family_code}', [AdminController::class, 'showFamilyPage'])->name('familyPage');
// Show login form and handle login
Route::get('/login', [AdminController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AdminController::class, 'login'])->name('login.post');
// EMAIL
Route::post('email/verify/resend', [VerificationController::class, 'resend'])->name('verification.resend');
Route::get('email/verify/notice', [VerificationController::class, 'showVerifyMail'])->name('verification.notice');
// Route::get('email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect()->route('homepage');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
Route::middleware(['auth', 'verified'])->group(function() {
    // Family Register
    Route::get('/register/family', [AdminController::class, 'showRegisterFamily'])->name('family.registration');
    Route::post('/register/family', [DonationController::class, 'registerFamily'])->name('family.register');

    // Register to existing family page SHOW
    Route::get('/register/existing/{family_code?}', [AdminController::class, 'registerExistingFamily'])->name('register.existing');
    // Register to existing family page REGISTER
    Route::post('/register/existing/family', [DonationController::class, 'familyRegistrationExisting'])->name('familyRegistrationExisting');

    

    Route::get('/account/{account_id}', [AdminController::class, 'myAccount'])->name('myAccount');

    // Upload avatar
    Route::post('/upload/avatar', [AdminController::class, 'uploadAvatar'])->name('upload.avatar');
    // Upload social media
    Route::post('/upload/social-media', [AdminController::class, 'uploadSocialMedia'])->name('upload.social');
    // Upload quote
    Route::post('/upload/quote', [AdminController::class, 'uploadQuote'])->name('upload.quote');
    // See the quote
    Route::get('/get-user-quote/{userId}', [AdminController::class, 'getUserQuote']);
    // Support Family Page
    Route::get('support/family/{family_code?}', [AdminController::class, 'showSupportFamily'])->name('support.family');
    Route::post('support/family', [DonationController::class, 'supportFamily'])->name('supportFamily');
});







