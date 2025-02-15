<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoomType extends Model
{
    /** @use HasFactory<\Database\Factories\RoomTypeFactory> */
    use HasFactory;

    public function hotel(): BelongsTo
    {
        return $this->belongsTo(Hotel::class);
    }

    public function getRoomNightCostAttribute($value): float|int
    {
        return $value / 100; // Convert cents to dollars
    }

    public function setRoomNightCostAttribute($value): void
    {
        $this->attributes['room_night_cost'] = $value * 100; // Convert dollars to cents
    }

}
