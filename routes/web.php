<?php

use App\Http\Controllers\AvailabilityController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Host\BookingController as HostBookingController;
use App\Http\Controllers\Host\ListingController;
use App\Http\Controllers\Host\Onboarding\ListingWizardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicListingController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

// Route::view('/', 'home')->name('home');
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/listings', [PublicListingController::class, 'index'])->name('listings.index');
Route::get('/listings/{listing}', [PublicListingController::class, 'show'])->name('listings.show');

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

    Route::get('bookings', [HostBookingController::class, 'index'])->name('bookings.index');
    Route::patch('bookings/{booking}/cancel', [HostBookingController::class, 'cancel'])
        ->name('bookings.cancel');

    Route::get('onboarding/listings/create', [ListingController::class, 'createWizard'])
        ->name('onboarding.listings.create');
    Route::post('onboarding/listings', [ListingController::class, 'storeWizardStep1'])
        ->name('onboarding.listings.storeStep1');
    Route::get('onboarding/listings/{listing}/step/{step}', [ListingWizardController::class, 'show'])
        ->name('onboarding.listings.show');
    Route::post('onboarding/listings/{listing}/step/{step}', [ListingWizardController::class, 'store'])
        ->name('onboarding.listings.store');

    Route::get('/host/dashboard', [ListingController::class, 'index'])->name('host.dashboard');
});
Route::middleware('auth')->group(function () {
    Route::get('/trips', [TripController::class, 'index'])->name('trips.index');
});

Route::middleware('auth')->group(function () {
    Route::post('/listings/{listing}/book', [BookingController::class, 'store'])->name('bookings.store');
    Route::patch('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])
        ->name('bookings.cancel');
});
Route::get('/listings/{listing}/availability', [AvailabilityController::class, 'show'])
    ->name('listings.availability');

Route::middleware('auth')->group(function () {
    Route::post('/wishlist/{listing}', [WishlistController::class, 'store'])
        ->name('wishlist.store');

    Route::delete('/wishlist/{listing}', [WishlistController::class, 'destroy'])
        ->name('wishlist.destroy');

    Route::get('/wishlist', [WishlistController::class, 'index'])
        ->name('wishlist.index');
});
require __DIR__.'/auth.php';
