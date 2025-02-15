<?php

namespace App\Livewire\Forms;

use App\Models\Booking;
use Livewire\Attributes\Validate;
use Livewire\Form;

class BookingForm extends Form
{
    public ?Booking $booking;

    // COMPUTED FIELDS
    public $hotel_name;
    public $room_type_name;
    public $check_out_date;
    // USER FIELDS
    #[Validate]
    public $hotel_id;
    #[Validate]
    public $room_type_id;
    #[Validate]
    public $check_in_date;
    #[Validate]
    public $num_nights;
    #[Validate]
    public $num_rooms;
    #[Validate]
    public int $num_pax = 1;
    #[Validate]
    public $notes;
    #[Validate]
    public $total_cost;

    public function mount()
    {
        $this->num_pax = 1;
    }

    protected function rules()
    {
        return [
            'hotel_id' => 'required',
            'room_type_id' => 'required',
            'check_in_date' => 'required',
            'num_nights' => 'required',
            'num_rooms' => 'required',
            'num_pax' => 'required|integer|min:1',
            'notes' => 'nullable|required_if:num_pax,>,1',
            'total_cost' => 'required',
        ];
    }

    public function store()
    {
        $this->validate();

        Booking::create($this->only([
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
        ]));
    }

    public function setBooking(Booking $booking): void
    {
        $this->booking = $booking;
    }
}
