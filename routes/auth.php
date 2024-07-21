<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserLoginController;
use App\Http\Controllers\UserRegisterController;
use App\Http\Middleware\EnsureUserIsAGuest;
use App\Http\Middleware\EnsureUserIsLoggedIn;
use Illuminate\Support\Facades\Route;


Route::middleware([EnsureUserIsAGuest::class])->group(function () {
    Route::get('/signup', [UserRegisterController::class, 'init'])->name('signupView');
    Route::post('/signup', [UserRegisterController::class, 'store'])->name('signup');
    Route::get('/login', [UserLoginController::class, 'init'])->name('login');
    Route::post('/login', [UserLoginController::class, 'store'])->name('login');
});
Route::middleware([EnsureUserIsLoggedIn::class])->group(function () {
    Route::get('/home', [HomeController::class, 'init'])->name('home');
    Route::post('logout', [UserLoginController::class, 'destroy'])
        ->name('logout');
});


