<?php

use App\Http\Controllers\Host\ListingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicListingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/listings', [PublicListingController::class, 'index'])->name('listings.index');
Route::get('/listings/{listing}', [PublicListingController::class, 'show'])->name('listings.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware(['auth'])->prefix('host')->name('host.')->group(function () {
    Route::post('listings/quick', [ListingController::class, 'quickStore'])->name('listings.quickStore');
    Route::resource('listings', ListingController::class);
    Route::post('listings/{listing}/photos', [ListingController::class, 'storePhoto'])->name('listings.photos.store');
    Route::delete('listings/{listing}/photos/{photo}', [ListingController::class, 'destroyPhoto'])->name('listings.photos.destroy');
    Route::patch('listings/{listing}/photos/{photo}/cover', [ListingController::class, 'setCoverPhoto'])->name('listings.photos.cover');
});

require __DIR__.'/auth.php';
