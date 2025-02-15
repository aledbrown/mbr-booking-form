<?php

use App\Models\Hotel;
use App\Models\RoomType;
use Illuminate\Foundation\Testing\RefreshDatabase;
uses(RefreshDatabase::class);

it('has hotels', function () {
    // Arrange
    $hotels = Hotel::factory(3)->create();

    // Act & Assert
    expect($hotels)
        ->toHaveCount(3)
        ->each->toBeInstanceOf(Hotel::class);
});

it('has rooms', function () {
    // Arrange
    $hotel = Hotel::factory()->create();
    RoomType::factory(3)->create([
        'hotel_id' => $hotel->id,
    ]);

    // Act & Assert
    expect($hotel->rooms)
        ->toHaveCount(3)
        ->each->toBeInstanceOf(RoomType::class);
});
