<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('hotel_name');
            $table->string('room_type_name');
            $table->foreignIdFor(\App\Models\Hotel::class);
            $table->foreignIdFor(\App\Models\RoomType::class);
            $table->date('check_in_date');
            $table->date('check_out_date');
            $table->integer('num_nights');
            $table->integer('num_rooms');
            $table->integer('num_pax');
            $table->text('notes');
            $table->bigInteger('total_cost');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
