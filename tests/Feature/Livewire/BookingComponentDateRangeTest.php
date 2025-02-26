<?php

namespace Tests\Feature\Livewire;

use App\Livewire\BookingComponent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->artisan('db:seed');
});

it('selected date range set 1 night', function () {
    $selected_date_range = '23 Feb 2025 to 24 Feb 2025';

    Livewire::test(BookingComponent::class)
        ->set('selected_date_range', $selected_date_range)
        ->assertSet('selected_date_range', $selected_date_range)
        ->assertSet('num_nights', 1);
});

it('selected date range set 7 nights with correct check in and out dates', function () {
    $selected_date_range = '17 Feb 2025 to 24 Feb 2025';

    Livewire::test(BookingComponent::class)
        ->set('selected_date_range', $selected_date_range)
        ->assertSet('selected_date_range', $selected_date_range)
        ->assertSet('num_nights', 7)
        ->assertSet('check_in_date', '2025-02-17')
        ->assertSet('check_out_date', '2025-02-24');
});

it('8 nights is invalid', function () {
    $selected_date_range = '17 Feb 2025 to 25 Feb 2025';

    Livewire::test(BookingComponent::class)
        ->set('selected_date_range', $selected_date_range)
        ->assertSet('selected_date_range', $selected_date_range)
        ->assertSet('num_nights', 8)
        ->assertSet('check_in_date', '2025-02-17')
        ->assertSet('check_out_date', '2025-02-25')
        ->assertHasErrors('num_nights');
});
