<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookImportController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\BookReservationController;
use App\Http\Controllers\BookReviewController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('schools', SchoolController::class);
    Route::resource('books', BookController::class);
    Route::post('/books/import', [BookImportController::class, 'import'])->name('books.import');
    Route::get('/analytics/popular', [AnalyticsController::class, 'popularBooks'])->name('analytics.popular');
    Route::get('/analytics/unpopular', [AnalyticsController::class, 'unpopularBooks'])->name('analytics.unpopular');
    Route::resource('reservations', BookReservationController::class);
    Route::post('reservations/{bookReservation}/borrow', [BookReservationController::class, 'borrow'])->name('reservations.borrow');
    Route::get('/books/{book}/reviews', [BookReviewController::class, 'index'])->name('book_reviews.index');
    Route::get('/books/{book}/review', [BookReviewController::class, 'createOrEdit'])->name('book_reviews.form');
    Route::post('/books/review', [BookReviewController::class, 'store'])->name('book_reviews.store');
    Route::delete('/books/{book}/review', [BookReviewController::class, 'destroy'])->name('book_reviews.destroy');
});


require __DIR__.'/auth.php';
