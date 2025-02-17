<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
uses(RefreshDatabase::class);

it('renders Booking Form Component successfully', function () {
    // Act & Assert
    Livewire::test(\App\Livewire\BookingComponent::class)
        ->assertStatus(200);
});

it('renders Summary Component successfully', function () {
    // Act & Assert
    Livewire::test(\App\Livewire\BookingSummary::class)
        ->assertStatus(200);
});

it('booking form component exists on the page', function () {
    // Act & Assert
    $this->get(route('pages.booking-form'))
        ->assertSeeLivewire(\App\Livewire\BookingComponent::class);
});

it('summary component does not exist on the page initially', function () {
    // Act & Assert
    $this->get(route('pages.booking-form'))
        ->assertDontSeeLivewire(\App\Livewire\BookingSummary::class);
});
