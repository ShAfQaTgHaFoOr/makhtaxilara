<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');

// Fleet
Route::get('/our-taxis', [PageController::class, 'fleet'])->name('fleet');
Route::get('/vehicle/{vehicle}', [PageController::class, 'vehicle'])->name('vehicle.show');

// Booking
Route::get('/booking', [BookingController::class, 'create'])->name('booking.create');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
Route::post('/booking/estimate', [BookingController::class, 'estimate'])->name('booking.estimate');
Route::get('/booking/confirmation/{booking_no}', [BookingController::class, 'confirmation'])->name('booking.confirmation');
Route::get('/booking/{booking_no}/pay', [PaymentController::class, 'checkout'])->name('payment.checkout');
Route::get('/booking/{booking_no}/paid', [PaymentController::class, 'success'])->name('payment.success');

// Blog
Route::get('/blog', [PageController::class, 'blog'])->name('blog');
Route::get('/blog/{post}', [PageController::class, 'post'])->name('post.show');

// Contact
Route::get('/contact-us', [PageController::class, 'contact'])->name('contact');
Route::post('/contact-us', [PageController::class, 'contactSubmit'])->name('contact.submit');

// Auth (login, register, my-bookings) — must come before the generic {slug} catch-all
if (file_exists(__DIR__ . '/auth.php')) {
    require __DIR__ . '/auth.php';
}

// Generic CMS pages (about-us, etc.) — keep LAST so it doesn't shadow named routes
Route::get('/{slug}', [PageController::class, 'page'])->name('page.show')->where('slug', '[a-z0-9\-]+');
