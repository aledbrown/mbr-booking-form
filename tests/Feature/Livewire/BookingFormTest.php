<?php

use App\Livewire\BookingComponent;
use App\Livewire\BookingSummary;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
uses(RefreshDatabase::class);

it('renders Booking Form Component successfully', function () {
    // Act & Assert
    Livewire::test(BookingComponent::class)
        ->assertStatus(200);
});

it('renders Summary Component successfully', function () {
    // Act & Assert
    Livewire::test(BookingSummary::class)
        ->assertStatus(200);
});

it('booking form component exists on the page', function () {
    // Act & Assert
    $this->get(route('pages.booking-form'))
        ->assertSeeLivewire(BookingComponent::class);
});

it('summary component does not exist on the page initially', function () {
    // Act & Assert
    $this->get(route('pages.booking-form'))
        ->assertDontSeeLivewire(BookingSummary::class);
});

it('hotel id validation works', function () {
    // Arrange
    $this->artisan('db:seed');

    // Act & Assert
    Livewire::test(BookingComponent::class)
        ->set('hotel_id', 0)
        ->call('save')
        ->assertHasErrors('hotel_id');
    Livewire::test(BookingComponent::class)
        ->set('hotel_id', 1)
        ->call('save')
        ->assertHasNoErrors('hotel_id');
});

it('room type id is required', function () {
    // Arrange
    $this->artisan('db:seed');

    // Act & Assert
    Livewire::test(BookingComponent::class)
        ->set('room_type_id', 0)
        ->call('save')
        ->assertHasErrors('room_type_id');
    Livewire::test(BookingComponent::class)
        ->set('room_type_id', 1)
        ->call('save')
        ->assertHasNoErrors('room_type_id');
});

it('num rooms validation', function () {
    // Arrange
    $this->artisan('db:seed');

    // Act & Assert
    Livewire::test(BookingComponent::class)
        ->set('num_rooms', 0)
        ->call('save')
        ->assertHasErrors('num_rooms');
    Livewire::test(BookingComponent::class)
        ->set('num_rooms', 5)
        ->call('save')
        ->assertHasErrors('num_rooms');
    Livewire::test(BookingComponent::class)
        ->set('num_rooms', 1)
        ->call('save')
        ->assertHasNoErrors('num_rooms');
    Livewire::test(BookingComponent::class)
        ->set('num_rooms', 2)
        ->call('save')
        ->assertHasNoErrors('num_rooms');
});

it('num pax validation', function () {
    // Arrange
    $this->artisan('db:seed');

    // Act & Assert
    Livewire::test(BookingComponent::class)
        ->set('num_pax', 7)
        ->call('save')
        ->assertHasErrors('num_pax');
    Livewire::test(BookingComponent::class)
        ->set('num_pax', 0)
        ->call('save')
        ->assertHasErrors('num_pax');
    Livewire::test(BookingComponent::class)
        ->set('num_pax', 1)
        ->call('save')
        ->assertHasNoErrors('num_pax');
    Livewire::test(BookingComponent::class)
        ->set('num_pax', 5)
        ->call('save')
        ->assertHasNoErrors('num_pax');
});

it('selected date range set 1 night', function () {
    // Arrange
    $this->artisan('db:seed');
    $selected_date_range = '23 Feb 2025 to 24 Feb 2025';

    // Act & Assert
    Livewire::test(BookingComponent::class)
        ->set('selected_date_range', $selected_date_range)
        ->assertSet('selected_date_range', $selected_date_range)
        ->assertSet('num_nights', 1);
});

it('selected date range set 7 nights with correct check in and out dates', function () {
    // Arrange
    $this->artisan('db:seed');
    $selected_date_range = '17 Feb 2025 to 24 Feb 2025';

    // Act & Assert
    Livewire::test(BookingComponent::class)
        ->set('selected_date_range', $selected_date_range)
        ->assertSet('selected_date_range', $selected_date_range)
        ->assertSet('num_nights', 7)
        ->assertSet('check_in_date', '2025-02-17')
        ->assertSet('check_out_date', '2025-02-24');
});

it('8 nights is invalid', function () {
    // Arrange
    $this->artisan('db:seed');
    $selected_date_range = '17 Feb 2025 to 25 Feb 2025';

    // Act & Assert
    Livewire::test(BookingComponent::class)
        ->set('selected_date_range', $selected_date_range)
        ->assertSet('selected_date_range', $selected_date_range)
        ->assertSet('num_nights', 8)
        ->assertSet('check_in_date', '2025-02-17')
        ->assertSet('check_out_date', '2025-02-25')
        ->assertHasErrors('num_nights');
});

it('summary component appears when form is valid', function () {
    // Arrange
    $this->artisan('db:seed');
    $selected_date_range = '17 Feb 2025 to 24 Feb 2025';

    // Act & Assert
    Livewire::test(BookingComponent::class)
        ->set('hotel_id', 1)
        ->set('room_type_id', 1)
        ->set('selected_date_range', $selected_date_range)
        ->assertSet('selected_date_range', $selected_date_range)
        ->assertSet('num_nights', 7)
        ->assertSet('check_in_date', '2025-02-17')
        ->assertSet('check_out_date', '2025-02-24')
        ->set('num_rooms', 1)
        ->set('num_pax', 1)
        ->assertSeeHtml('Total Cost : ')
        ->assertSeeLivewire(BookingSummary::class)
        ->call('save')
        ->assertRedirect(route('pages.booking-form.thank-you'));
});

it('summary component disappears when form is in-valid', function () {
    // Arrange
    $this->artisan('db:seed');
    $selected_date_range = '17 Feb 2025 to 24 Feb 2025';

    // Act & Assert
    Livewire::test(BookingComponent::class)
        ->set('hotel_id', 1)
        ->set('room_type_id', 1)
        ->set('selected_date_range', $selected_date_range)
        ->assertSet('selected_date_range', $selected_date_range)
        ->assertSet('num_nights', 7)
        ->assertSet('check_in_date', '2025-02-17')
        ->assertSet('check_out_date', '2025-02-24')
        ->set('num_rooms', 1)
        ->set('num_pax', 2)
        ->assertDontSeeLivewire(BookingSummary::class);
});

it('summary component appears only when notes is filled with pax is 2', function () {
    // Arrange
    $this->artisan('db:seed');
    $selected_date_range = '17 Feb 2025 to 24 Feb 2025';

    // Act & Assert
    Livewire::test(BookingComponent::class)
        ->set('hotel_id', 1)
        ->set('room_type_id', 1)
        ->set('selected_date_range', $selected_date_range)
        ->assertSet('selected_date_range', $selected_date_range)
        ->assertSet('num_nights', 7)
        ->assertSet('check_in_date', '2025-02-17')
        ->assertSet('check_out_date', '2025-02-24')
        ->set('num_rooms', 2)
        ->set('num_pax', 2)
        ->set('notes', 'This is a note')
        ->assertSeeHtml('Total Cost : ')
        ->assertSeeLivewire(BookingSummary::class)
        ->call('save')
        ->assertRedirect(route('pages.booking-form.thank-you'));
});
