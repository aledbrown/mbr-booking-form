<?php

use Illuminate\Support\Facades\Route;

Route::get('/', \App\Livewire\BookingComponent::class)->name('pages.booking-form');

Route::get('/thank-you', function () {
    return view('booking-thank-you');
})->name('pages.booking-form.thank-you');
