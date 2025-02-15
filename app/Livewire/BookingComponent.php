<?php

namespace App\Livewire;

use App\Models\Booking;
use App\Models\Hotel;
use App\Models\RoomType;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
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

    // USER FORM DATA
    #[Validate]
    public int $hotel_id = 0;
    #[Validate]
    public $room_type_id;
    #[Validate]
    public $selected_date_range = '';
    #[Validate]
    public $check_in_date;
    #[Validate]
    public $check_out_date;
    #[Validate]
    public int $num_nights = 1;
    #[Validate]
    public $num_rooms = 1;
    #[Validate]
    public int $num_pax = 1;
    #[Validate]
    public $notes;
    // #[Validate]
    public $total_cost = 0;

    public function mount()
    {
        $this->hotelDropdown = Hotel::all();
        if (app()->environment() !== 'local') $this->showDebug = false;
        // DEFAULT FOR DATE RANGE? Thinking best not.
        // $this->check_in_date = today()->toDateString();
        // $this->check_out_date = today()->addDays(1)->toDateString();
        // $this->selected_date_range = today()->toDateString().' to '.today()->addDays(1)->toDateString();
    }

    public function render()
    {
        return view('livewire.booking-component');
    }

    public function save()
    {
        $rules = $this->rules();
        $validation = $this->validate($rules);

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
            'hotel_name' => ['string', 'max:255', [Rule::requiredIf(fn() => $this->hotel_id > 0)]],
            'room_type_name' => ['string', 'max:255', [Rule::requiredIf(fn() => $this->room_type_id > 0)]],
            'hotel_id' => 'required|numeric|gt:0',
            'room_type_id' => 'required|numeric|gt:0',
            'selected_date_range' => 'required|string|max:255',
            'check_in_date' => [[Rule::requiredIf(fn() => $this->room_type_id > 0)], 'date', 'after:yesterday'],
            'check_out_date' => [[Rule::requiredIf(fn() => $this->room_type_id > 0)], 'date', 'after:check_in_date'],
            'num_nights' => 'required|numeric|min:1|max:7',
            'num_rooms' => 'required|numeric|min:1|max:2',
            'num_pax' => 'required|numeric|min:1|max:5',
            'notes' => [Rule::requiredIf(fn() => $this->num_pax > 1)],
            // 'total_cost' => 'required',
        ];
    }

    protected $messages = [
        'selected_date_range' => 'Please select a Date Range for your booking.',
        'hotel_name' => 'ERROR: Hotel Name fail, please contact us for support.',
        'room_type_name' => 'ERROR: Room Type Name fail, please contact us for support.',
        'hotel_id' => 'Please select a Hotel from the dropdown.',
        'room_type_id' => 'Please select a Room Type from the dropdown.',
        'notes' => 'Please provide notes when the Number of Pax is greater than 1.',
        'check_in_date' => 'Please set a Check-in Date from the Dates field above.',
        'check_out_date' => 'Please set an Check-out Date from the Dates field above.',
        'num_rooms' => 'Number of Rooms must be at least 1.',
        'num_pax' => 'Number of Pax must be 1 to 5.',
        'num_nights' => 'Number of Nights must be 1 to 7.',
    ];

    // FORM CUSTOM METHODS
    public function updatedHotelId($value) : void
    {
        $hotel = Hotel::find($value);
        if ($hotel) $this->hotel_name = $hotel->name;
        if ($hotel && $hotel->rooms->count() > 0) {
            $rooms = RoomType::query()->where('hotel_id', $value)->get();
            $this->roomTypeDropdown = $rooms;
        }
    }

    public function updatedRoomTypeId($value) : void
    {
        $room = RoomType::find($value);
        if ($room) $this->room_type_name = $room->name;
    }

    public function updatedNumPax($value) : void
    {
        // when num pax changes notes may not be required but the
        // validation could still be on screen, so re-run validation
        $this->validate();
    }

    public function updatedSelectedDateRange($value) : void
    {
        $this->num_nights = 1;
        if ($value) {
            [$startDate, $endDate] = array_pad(explode(' to ', $value), 2, null);
            $startDate = \Carbon\Carbon::parse($startDate);
            $endDate = \Carbon\Carbon::parse($endDate);
            $numDays = $startDate->diffInDays($endDate);

            $this->check_in_date = $startDate->toDateString();
            $this->check_out_date = $endDate->toDateString();
            $this->num_nights = (int)$numDays;

            $this->validate();
        }
    }

    public function num_rooms_dropdown() : array
    {
        return [
            ['value' => 1, 'title' => '1 Room'],
            ['value' => 2, 'title' => '2 Rooms'],
        ];
    }

    public function num_pax_dropdown() : array
    {
        return [
            ['value' => 1, 'title' => '1 Pax'],
            ['value' => 2, 'title' => '2 Pax'],
            ['value' => 3, 'title' => '3 Pax'],
            ['value' => 4, 'title' => '4 Pax'],
            ['value' => 5, 'title' => '5 Pax'],
        ];
        // return collect(range(1, 5))->map(fn($value) => ['value' => $value, 'title' => (string) $value])->toArray();
    }

    public function resetForm() : void
    {
        $this->reset();
        $this->mount();
        $this->toast(type: 'success', title: 'Booking form reset', position: 'toast-top', css: 'alert-success');
    }
}
