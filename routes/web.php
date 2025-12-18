<?php

use App\Http\Controllers\AvailabilityController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Host\BookingController as HostBookingController;
use App\Http\Controllers\Host\ListingController as HostListingController;
use App\Http\Controllers\Host\Onboarding\ListingWizardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicListingController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/listings', [PublicListingController::class, 'index'])->name('listings.index');
Route::get('/listings/{listing}', [PublicListingController::class, 'show'])->name('listings.show');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/trips', [TripController::class, 'index'])->name('trips.index');

    Route::post('/listings/{listing}/book', [BookingController::class, 'store'])->name('bookings.store');
    Route::patch('/bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');

    Route::post('/wishlist/{listing}', [WishlistController::class, 'store'])->name('wishlist.store');
    Route::delete('/wishlist/{listing}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
});

Route::get('/listings/{listing}/availability', [AvailabilityController::class, 'show'])
    ->name('listings.availability');

Route::middleware(['auth'])->prefix('host')->name('host.')->group(function () {

    // host dashboard (FIX: no extra /host)
    Route::get('/dashboard', [HostListingController::class, 'index'])->name('dashboard');

    // listings
    Route::post('listings/quick', [HostListingController::class, 'quickStore'])->name('listings.quickStore');
    Route::resource('listings', HostListingController::class);

    // photos
    Route::post('listings/{listing}/photos', [HostListingController::class, 'storePhoto'])->name('listings.photos.store');
    Route::delete('listings/{listing}/photos/{photo}', [HostListingController::class, 'destroyPhoto'])->name('listings.photos.destroy');
    Route::patch('listings/{listing}/photos/{photo}/cover', [HostListingController::class, 'setCoverPhoto'])->name('listings.photos.cover');

    // host bookings
    Route::get('bookings', [HostBookingController::class, 'index'])->name('bookings.index');
    Route::patch('bookings/{booking}/cancel', [HostBookingController::class, 'cancel'])->name('bookings.cancel');

    // onboarding wizard
    Route::get('onboarding/listings/create', [HostListingController::class, 'createWizard'])->name('onboarding.listings.create');
    Route::post('onboarding/listings', [HostListingController::class, 'storeWizardStep1'])->name('onboarding.listings.storeStep1');

    Route::get('onboarding/listings/{listing}/step/{step}', [ListingWizardController::class, 'show'])->name('onboarding.listings.show');
    Route::post('onboarding/listings/{listing}/step/{step}', [ListingWizardController::class, 'store'])->name('onboarding.listings.store');
});

require __DIR__.'/auth.php';
