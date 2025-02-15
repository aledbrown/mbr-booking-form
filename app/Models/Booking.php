<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    /** @use HasFactory<\Database\Factories\BookingFactory> */
    use HasFactory;

    public function getTotalCostAttribute($value): float|int
    {
        return $value / 100; // Convert cents to dollars
    }

    public function setTotalCostAttribute($value): void
    {
        $this->attributes['total_cost'] = $value * 100; // Convert dollars to cents
    }

}
