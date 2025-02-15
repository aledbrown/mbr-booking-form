<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    /** @use HasFactory<\Database\Factories\BookingFactory> */
    use HasFactory;

    protected $fillable = [
        'hotel_name',
        'room_type_name',
        'hotel_id',
        'room_type_id',
        'check_in_date',
        'check_out_date',
        'num_nights',
        'num_rooms',
        'num_pax',
        'notes',
        'total_cost',
    ];

    public function getTotalCostAttribute($value): float|int
    {
        return $value / 100; // Convert cents to dollars
    }

    public function setTotalCostAttribute($value): void
    {
        $this->attributes['total_cost'] = $value * 100; // Convert dollars to cents
    }

}
