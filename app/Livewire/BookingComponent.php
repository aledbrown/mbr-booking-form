<?php

namespace App\Livewire;

use App\Models\Booking;
use App\Models\Hotel;
use Illuminate\Support\Collection;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Mary\Traits\Toast;

class BookingComponent extends Component
{
    use Toast;
    private $showDebug = true;

    // COMPUTED PROPERTIES
    public Collection $hotelDropdown;
    public $hotel_name = '';
    public $room_type_name = '';
    public $check_out_date;

    // USER FORM DATA
    // #[Validate('required')]
    #[Validate]
    public int $hotel_id = 0;
    // #[Validate]
    public $room_type_id;
    // #[Validate]
    public $check_in_date;
    // #[Validate]
    public $num_nights;
    // #[Validate]
    public $num_rooms;
    // #[Validate]
    public int $num_pax = 1;
    // #[Validate]
    public $notes;
    // #[Validate]
    public $total_cost;

    public function mount()
    {
        // $this->form->num_pax = 4;
        $this->hotelDropdown = Hotel::all();
        // dump($this->hotelDropdown);
    }

    public function render()
    {
        return view('livewire.booking-component');
    }

    public function save()
    {
        $rules = $this->rules();
        $validation = $this->validate($rules);
        dump($validation);

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

        return $this->redirect('/test'); // TODO: thank you page
    }

    public function rules()
    {
        return [
            // 'hotel_name' => 'required|string|max:255',
            'hotel_id' => 'required|numeric|gt:0',
            // 'room_type_id' => 'required',
            // 'check_in_date' => 'required',
            // 'num_nights' => 'required',
            // 'num_rooms' => 'required',
            // 'num_pax' => 'required|integer|min:1',
            // 'notes' => 'nullable|required_if:num_pax,>,1',
            // 'total_cost' => 'required',
        ];
    }

    protected $messages = [
        'hotel_id' => 'Please select a hotel.'
    ];

    // FORM CUSTOM METHODS
    public function updatedHotelId($value)
    {
        $hotel = Hotel::find($value);
        $this->hotel_name = $hotel->name;
    }

    public function testButton()
    {
        // $this->reset();
        $this->toast(type: 'success', title: 'Testing, 1, 2, 3.', position: 'toast-top', css: 'alert-success');
    }
}
