<?php

namespace App\Livewire;

use App\Models\Booking;
use App\Models\Hotel;
use App\Models\RoomType;
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
    public Collection $roomTypeDropdown;
    public $hotel_name = '';
    public $room_type_name = '';
    public $selected_date_range = '';
    public $check_out_date;

    // USER FORM DATA
    // #[Validate('required')]
    #[Validate]
    public int $hotel_id = 0;
    #[Validate]
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
        // dump($validation);

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
            'room_type_id' => 'required|numeric|gt:0',
            // 'check_in_date' => 'required',
            // 'num_nights' => 'required',
            // 'num_rooms' => 'required',
            // 'num_pax' => 'required|integer|min:1',
            // 'notes' => 'nullable|required_if:num_pax,>,1',
            // 'total_cost' => 'required',
        ];
    }

    protected $messages = [
        // 'hotel_name' => 'ERROR: Hotel Name fail, please contact us for support.',
        'hotel_id' => 'Please select a Hotel from the dropdown.',
        'room_type_id' => 'Please select a Room Type from the dropdown.',
    ];

    // FORM CUSTOM METHODS
    public function updatedHotelId($value)
    {
        $hotel = Hotel::find($value);
        if ($hotel) $this->hotel_name = $hotel->name;
        if ($hotel && $hotel->rooms->count() > 0) {
            $rooms = RoomType::query()->where('hotel_id', $value)->get();
            $this->roomTypeDropdown = $rooms;
        }
    }

    public function updatedSelectedDateRange($value)
    {
        if ($value) {
            [$startDate, $endDate] = array_pad(explode(' to ', $value), 2, null);
            $startDate = \Carbon\Carbon::parse($startDate);
            $endDate = \Carbon\Carbon::parse($endDate);
            $numDays = $startDate->diffInDays($endDate);

            $this->check_in_date = $startDate->toDateString();
            $this->check_out_date = $endDate->toDateString();
            $this->num_nights = (int)$numDays;

            dump([
                'start_date' => $this->check_in_date, 'end_date' => $this->check_out_date,
                'num_days' => $this->num_nights,
            ]);
        }
    }

    public function testButton()
    {
        // $this->reset();
        $this->toast(type: 'success', title: 'Testing, 1, 2, 3.', position: 'toast-top', css: 'alert-success');
    }

    public function resetForm()
    {
        $this->reset();
        $this->mount();
    }
}
