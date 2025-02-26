<?php

namespace Tests\Feature\Livewire;

use App\Livewire\BookingComponent;
use App\Livewire\BookingSummary;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->artisan('db:seed');
});

it('summary component appears when form is valid', function () {
    // remember check in must be today onwards
    $number_of_nights = 7;
    $check_in_date = now()->format('Y-m-d');
    $check_out_date = now()->addDays($number_of_nights)->format('Y-m-d');
    // Create the Date Range String
    $fromDate = \DateTime::createFromFormat('Y-m-d', $check_in_date);
    $toDate = \DateTime::createFromFormat('Y-m-d', $check_out_date);
    $selected_date_range = $fromDate->format('j M Y') . ' to ' . $toDate->format('j M Y');

    Livewire::test(BookingComponent::class)
        ->set('hotel_id', 1)
        ->set('room_type_id', 1)
        ->set('selected_date_range', $selected_date_range)
        ->assertSet('selected_date_range', $selected_date_range)
        ->assertSet('num_nights', $number_of_nights)
        ->assertSet('check_in_date', $check_in_date)
        ->assertHasNoErrors('check_in_date')
        ->assertSet('check_out_date', $check_out_date)
        ->assertHasNoErrors('check_out_date')
        ->set('num_rooms', 1)
        ->set('num_pax', 1)
        ->assertSeeHtml('Total Cost : ')
        ->assertSeeLivewire(BookingSummary::class)
        ->call('save')
        ->assertRedirect(route('pages.booking-form.thank-you'));
});

it('summary component disappears when form is invalid', function () {
    // remember check in must be today onwards
    $number_of_nights = 7;
    $check_in_date = now()->format('Y-m-d');
    $check_out_date = now()->addDays($number_of_nights)->format('Y-m-d');
    // Create the Date Range String
    $fromDate = \DateTime::createFromFormat('Y-m-d', $check_in_date);
    $toDate = \DateTime::createFromFormat('Y-m-d', $check_out_date);
    $selected_date_range = $fromDate->format('j M Y') . ' to ' . $toDate->format('j M Y');

    // Make it invalid
    $num_pax = 2;

    Livewire::test(BookingComponent::class)
        ->set('hotel_id', 1)
        ->set('room_type_id', 1)
        ->set('selected_date_range', $selected_date_range)
        ->assertSet('selected_date_range', $selected_date_range)
        ->assertSet('num_nights', $number_of_nights)
        ->assertSet('check_in_date', $check_in_date)
        ->assertSet('check_out_date', $check_out_date)
        ->set('num_rooms', 1)
        ->set('num_pax', $num_pax)
        ->assertDontSeeLivewire(BookingSummary::class);
});

it('summary component appears only when notes is filled with pax is 2', function () {
    // remember check in must be today onwards
    $number_of_nights = 7;
    $check_in_date = now()->format('Y-m-d');
    $check_out_date = now()->addDays($number_of_nights)->format('Y-m-d');
    // Create the Date Range String
    $fromDate = \DateTime::createFromFormat('Y-m-d', $check_in_date);
    $toDate = \DateTime::createFromFormat('Y-m-d', $check_out_date);
    $selected_date_range = $fromDate->format('j M Y') . ' to ' . $toDate->format('j M Y');

    Livewire::test(BookingComponent::class)
        ->set('hotel_id', 1)
        ->set('room_type_id', 1)
        ->set('selected_date_range', $selected_date_range)
        ->assertSet('selected_date_range', $selected_date_range)
        ->assertSet('num_nights', $number_of_nights)
        ->assertSet('check_in_date', $check_in_date)
        ->assertHasNoErrors('check_in_date')
        ->assertSet('check_out_date', $check_out_date)
        ->assertHasNoErrors('check_out_date')
        ->set('num_rooms', 2)
        ->assertSet('num_rooms', 2)
        ->set('num_pax', 2)
        ->assertSet('num_pax', 2)
        ->set('notes', 'This is a note')
        ->assertSet('notes', 'This is a note')
        ->assertSeeHtml('Total Cost : ')
        ->assertSeeLivewire(BookingSummary::class)
        ->call('save')
        ->assertRedirect(route('pages.booking-form.thank-you'));
});
