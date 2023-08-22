<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Models\Familyname;
use App\Http\Controllers\DonationController;

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
    $familynames = Familyname::all();
    return view ('LandingPage', compact('familynames'));
});

// Show registration form and handle registration
Route::get('/register', [AdminController::class, 'showRegistrationForm'])->name('registration');
Route::post('/register', [AdminController::class, 'register'])->name('register');

// Family Register

Route::get('/register/family', [AdminController::class, 'showRegisterFamily'])->name('family.registration')->middleware('auth');
Route::post('/register/family', [AdminController::class, 'registerFamily'])->name('family.register');

// Family Page
Route::get('/family/{family_code}', [AdminController::class, 'showFamilyPage'])->name('familyPage');
// Register to existing family page SHOW
Route::get('register/existing/{family_code?}', [AdminController::class, 'registerExistingFamily'])->name('register.existing')->middleware('auth');
// Register to existing family page REGISTER
Route::post('register/existing/family/{family_code?}', [AdminController::class, 'familyRegistrationExisting'])->name('familyRegistrationExisting')->middleware('auth');

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

// Family member search
Route::get('/search-family-members', [AdminController::class, 'searchFamilyMembers'])->name('search.family.members');


// Show login form and handle login
Route::get('/login', [AdminController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AdminController::class, 'login'])->name('login.post');

// Logout
Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

Route::get('/account/{account_id}', [AdminController::class, 'myAccount'])->name('myAccount');
