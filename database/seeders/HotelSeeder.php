<?php

namespace Database\Seeders;

use App\Models\Hotel;
use App\Models\RoomType;
use Illuminate\Database\Seeder;

class HotelSeeder extends Seeder
{
    public function run(): void
    {

        if ($this->isDataAlreadyGiven()) {
            return;
        }

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

    private function isDataAlreadyGiven(): bool
    {
        return Hotel::where('name', 'Sunshine Beach Hotel')->exists()
            && Hotel::where('name', 'Highland Retreat')->exists()
            && Hotel::where('name', 'Low Wood Hotel')->exists();
    }
}
