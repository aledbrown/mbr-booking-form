<?php

it('has hotels', function () {
    // Arrange
    $hotels = Hotel::factory()->create(3);

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
