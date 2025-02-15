<?php

namespace Database\Seeders;

use App\Models\Hotel;
use App\Models\RoomType;
use Illuminate\Database\Seeder;

class HotelSeeder extends Seeder
{
    public function run(): void
    {
        $hotelData = [];

        $hotelData[] = [
            'name' => 'Sunshine Beach Hotel',
            'room_types' => [
                [
                    'name' => 'Standard Room',
                    'room_night_cost' => 170,
                ],
                [
                    'name' => 'Luxury Room',
                    'room_night_cost' => 225,
                ],
            ],
        ];

        $hotelData[] = [
            'name' => 'Highland Retreat',
            'room_types' => [
                [
                    'name' => 'The Cabin',
                    'room_night_cost' => 100,
                ],
            ],
        ];

        $hotelData[] = [
            'name' => 'Low Wood Hotel',
            'room_types' => [
                [
                    'name' => 'Classic Double',
                    'room_night_cost' => 145,
                ],
                [
                    'name' => 'Lake View Double',
                    'room_night_cost' => 205,
                ],
                [
                    'name' => 'Lake View Deluxe',
                    'room_night_cost' => 245,
                ],
            ],
        ];


        foreach ($hotelData as $item) {
            $hotel = Hotel::factory()->create([
                'name' => $item['name'],
            ]);

            foreach ($item['room_types'] as $roomType) {
                RoomType::factory()->create([
                    'hotel_id' => $hotel->id,
                    'name' => $roomType['name'],
                    'room_night_cost' => $roomType['room_night_cost'],
                ]);
            }
        }

    }
}
