<?php

namespace Tests\Feature\Livewire;

use App\Livewire\BookingComponent;
use App\Models\Hotel;
use App\Models\RoomType;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->artisan('db:seed');
});

it('hotel dropdown is populated on mount', function () {
    $component = Livewire::test(BookingComponent::class);
    $component->assertViewHas('hotelDropdown');
    $hotels = $component->viewData('hotelDropdown');
    expect($hotels)->not()->toBeEmpty();
});

it('reset form method', function () {
    $component = Livewire::test(BookingComponent::class);

    $component
        ->set('hotel_id', 1)
        ->set('room_type_id', 1)
        ->set('selected_date_range', '17 Feb 2025 to 24 Feb 2025')
        ->set('num_nights', 7)
        ->set('num_rooms', 2)
        ->set('num_pax', 3)
        ->set('notes', 'Test Notes')
        ->call('resetForm');

    $component->assertSet('hotel_id', 0)
        ->assertSet('room_type_id', 0)
        ->assertSet('selected_date_range', '')
        ->assertSet('num_nights', 0)
        ->assertSet('num_rooms', 0)
        ->assertSet('num_pax', 0)
        ->assertSet('notes', '')
        ->assertSet('summary', []) // Changed from assertNotSet to assertSet([])
        ->assertSet('total_cost', 0) // Changed from assertNotSet to assertSet
        ->assertDispatched('toast');
});

it('calculate summary calculates correctly', function () {
    $hotel = Hotel::find(1);
    $roomType = RoomType::find(1);
    $checkInDate = Carbon::now()->addDay();
    $numNights = 3;
    $numRooms = 2;
    $expectedDailyCost = $numRooms * $roomType->room_night_cost;
    $expectedTotalCost = $expectedDailyCost * $numNights;

    // Create the Date Range String
    $check_out_date = $checkInDate->addDays($numNights);
    $fromDate = \DateTime::createFromFormat('Y-m-d', $checkInDate->format('Y-m-d'));
    $toDate = \DateTime::createFromFormat('Y-m-d', $check_out_date->format('Y-m-d'));
    $selected_date_range = $fromDate->format('j M Y') . ' to ' . $toDate->format('j M Y');

    $component = Livewire::test(BookingComponent::class)
        ->set('hotel_id', $hotel->id)
        ->set('room_type_id', $roomType->id)
        ->set('selected_date_range', $selected_date_range)
        ->set('check_in_date', $checkInDate->toDateString())
        ->set('check_out_date', $check_out_date->toDateString())
        ->set('num_nights', $numNights)
        ->set('num_rooms', $numRooms)
        ->call('calculateSummary');

    $component->assertSet('total_cost', $expectedTotalCost);
    expect($component->get('summary'))
        ->toHaveCount($numNights);
    $summary = $component->get('summary');
    expect($summary[0]['details'])
        ->toContain((string)$numRooms) //Cast to string to avoid type comparison issues
        ->toContain((string)$roomType->room_night_cost);//Cast to string to avoid type comparison issues
    expect($summary[0]['daily_total'])
        ->toEqual($expectedDailyCost);
});

it('updated hotel id resets room type and fetches rooms', function () {
    $hotel = Hotel::find(1);
    $room = RoomType::find(1);

    $component = Livewire::test(BookingComponent::class)
        ->set('hotel_id', $hotel->id)
        ->set('room_type_id', $room->id)
        ->call('updatedHotelId', $hotel->id);

    $component->assertSet('room_type_id', 0);
    $component->assertSet('room_type_name', '');
    $component->assertViewHas('roomTypeDropdown');
    $rooms = $component->viewData('roomTypeDropdown');
    expect($rooms)->not()->toBeEmpty();
});

it('updated room type id updates room type name', function () {
    $hotel = Hotel::find(1);
    $room = RoomType::find(1);
    $expectedName = $room->name;

    $component = Livewire::test(BookingComponent::class)
        ->set('hotel_id', $hotel->id)
        ->set('room_type_id', $room->id)
        ->call('updatedRoomTypeId', $room->id);

    $component->assertSet('room_type_name', $expectedName);
});

it('updated num pax triggers validation', function () {
    $component = Livewire::test(BookingComponent::class)
        ->set('num_pax', 3)
        ->call('updatedNumPax', 3);

    $component->assertHasNoErrors();
});

it('num rooms dropdown returns expected values', function () {
    $expectedValues = [
        ['value' => 1, 'title' => '1 Room'],
        ['value' => 2, 'title' => '2 Rooms'],
    ];
    $component = Livewire::test(BookingComponent::class);

    $dropdownValues = $component->get('num_rooms_dropdown');

    expect($dropdownValues)->toEqual($expectedValues);
});

it('num pax dropdown returns expected values', function () {
    $expectedValues = [
        ['value' => 1, 'title' => '1 Pax'],
        ['value' => 2, 'title' => '2 Pax'],
        ['value' => 3, 'title' => '3 Pax'],
        ['value' => 4, 'title' => '4 Pax'],
        ['value' => 5, 'title' => '5 Pax'],
        ['value' => 6, 'title' => '6 Pax'],
    ];

    $component = Livewire::test(BookingComponent::class);
    $dropdownValues = $component->get('num_pax_dropdown');

    expect($dropdownValues)->toEqual($expectedValues);
});
