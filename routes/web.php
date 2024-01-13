<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('pages.home');
})->name('home');
Route::get('/catalog', function () {
    return view('pages.catalog');
})->name('catalog');
Route::get('/about-us', function () {
    return view('pages.about-us');
})->name('about-us');
Route::get('/contact-us', function () {
    return view('pages.contact-us');
})->name('contact-us');

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/my-account', function () {
        return view('profile.account');
    })->name('my-account');
    Route::get('/wishlist', function () {
        return view('profile.wishlist');
    })->name('wishlist');
    Route::get('/order-history', function () {
        return view('profile.order-history');
    })->name('order-history');
    Route::get('/payment-method', function () {
        return view('profile.payment-method');
    })->name('payment-method');
    Route::get('/profile-information', function () {
        return view('profile.profile-information');
    })->name('profile-information');
    Route::get('/profile-information', function () {
        return view('profile.profile-information');
    })->name('profile-information');
    Route::get('/manage-address', function () {
        return view('profile.manage-address');
    })->name('manage-address');
});
