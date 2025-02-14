<?php

use Illuminate\Support\Facades\Route;

Route::get('/', \App\Livewire\BookingForm::class)->name('pages.booking-form');

Route::get('/test', \App\Livewire\TestComponent::class)->name('pages.livewire-test');

Route::get('/blade', function () {
    return view('test');
})->name('pages.blade-test');
