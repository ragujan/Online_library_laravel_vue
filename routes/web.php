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

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware([EnsureUserIsLoggedIn::class])->group(function () {
    Route::get('/browse-books', [BookAccessController::class, 'browseBooks'])->name('browseBooks');
    Route::post('/borrow-book', [UserBookManagementController::class, 'borrowBookToUser'])->name('borrowBook');
    Route::get('/retrieve-borrowed-books', [BookAccessController::class, 'retrieveBorrowedBooks'])->name('retrieveBorrowedBooks');
    Route::post('/return-book', [UserBookManagementController::class, 'returnBook'])->name('returnBook');
});

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__ . '/auth.php';
