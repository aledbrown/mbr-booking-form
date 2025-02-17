<?php

use App\Models\Hotel;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('add given hotels', function () {
    // Assert
    $this->assertDatabaseCount(Hotel::class, 0);

    // Arrange
    $this->artisan('db:seed');

    // Assert
    $this->assertDatabaseCount(Hotel::class, 3);
    $this->assertDatabaseHas(Hotel::class, ['name' => 'Sunshine Beach Hotel']);
    $this->assertDatabaseHas(Hotel::class, ['name' => 'Highland Retreat']);
    $this->assertDatabaseHas(Hotel::class, ['name' => 'Low Wood Hotel']);
});

it('adds given hotels only once', function () {
    // Assert
    $this->assertDatabaseCount(Hotel::class, 0);

    // Act
    $this->artisan('db:seed');
    $this->artisan('db:seed');

    // Assert
    $this->assertDatabaseCount(Hotel::class, 3);
});

it('adds given room types', function () {
    // Assert
    $this->assertDatabaseCount(\App\Models\Hotel::class, 0);
    $this->assertDatabaseCount(\App\Models\RoomType::class, 0);

    // Arrange
    $this->artisan('db:seed');

    // Assert
    $hotel_01 = Hotel::where('name', 'Sunshine Beach Hotel')->firstOrFail();
    $hotel_02 = Hotel::where('name', 'Highland Retreat')->firstOrFail();
    $hotel_03 = Hotel::where('name', 'Low Wood Hotel')->firstOrFail();

    $this->assertDatabaseCount(Hotel::class, 3);
    expect($hotel_01->rooms)->toHaveCount(2);
    expect($hotel_02->rooms)->toHaveCount(1);
    expect($hotel_03->rooms)->toHaveCount(3);
});
