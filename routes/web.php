<?php

use App\Http\Controllers\BookAccessController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserBookManagementController;
use App\Http\Controllers\UserLoginController;
use App\Http\Controllers\UserRegisterController;
use App\Http\Middleware\EnsureUserIsLoggedIn;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware([EnsureUserIsLoggedIn::class])->group(function () {
    Route::get('/browse-books', [BookAccessController::class, 'browseBooks'])->name('browseBooks');
    Route::post('/borrow-book', [UserBookManagementController::class, 'borrowBookToUser'])->name('borrowBook');
    Route::get('/retrieve-borrowed-books', [BookAccessController::class, 'retrieveBorrowedBooks'])->name('retrieveBorrowedBooks');
    Route::post('/return-book', [UserBookManagementController::class, 'returnBook'])->name('returnBook');
});

require __DIR__ . '/auth.php';
