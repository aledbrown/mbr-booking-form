<?php

namespace App\Livewire\Forms;

use App\Models\Booking;
use Livewire\Form;

class BookingForm extends Form
{
    public ?Booking $booking;


    public function store()
    {
        $this->validate();

        Booking::create($this->only([
            'name', 'email', 'phone', 'room_type_id', 'check_in', 'check_out', 'guests', 'message'
        ]));
    }

    public function setBooking(Booking $booking): void
    {
        $this->booking = $booking;
    }
}
