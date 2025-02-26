<?php

namespace Tests\Feature\Livewire;

use App\Livewire\BookingComponent;
use App\Livewire\BookingSummary;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

it('renders Booking Form Component successfully', function () {
    Livewire::test(BookingComponent::class)
        ->assertStatus(200);
});

it('renders Summary Component successfully', function () {
    Livewire::test(BookingSummary::class)
        ->assertStatus(200);
});

it('booking form component exists on the page', function () {
    $this->get(route('pages.booking-form'))
        ->assertSeeLivewire(BookingComponent::class);
});

it('summary component does not exist on the page initially', function () {
    $this->get(route('pages.booking-form'))
        ->assertDontSeeLivewire(BookingSummary::class);
});
