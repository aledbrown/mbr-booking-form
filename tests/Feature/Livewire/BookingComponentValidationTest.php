<?php

namespace Tests\Feature\Livewire;

use App\Livewire\BookingComponent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->artisan('db:seed');
});

it('hotel id validation works', function () {
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
