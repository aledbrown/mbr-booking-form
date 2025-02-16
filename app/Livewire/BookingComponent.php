<?php

namespace App\Livewire;

use App\Models\Booking;
use App\Models\Hotel;
use App\Models\RoomType;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Mary\Traits\Toast;

class BookingComponent extends Component
{
    use Toast;
    private bool $showDebug = false;
    private bool $showErrorBag = false;

    // COMPUTED PROPERTIES
    public array $summary = [];
    public int $total_cost = 0;
    public Collection $hotelDropdown;
    public Collection $roomTypeDropdown;
    #[Validate]
    public $hotel_name = '';
    #[Validate]
    public $room_type_name = '';

    // USER FORM DATA
    #[Validate]
    public int $hotel_id = 0;
    #[Validate]
    public int $room_type_id = 0;
    #[Validate]
    public string $selected_date_range = '';
    #[Validate]
    public string $check_in_date = '';
    #[Validate]
    public string $check_out_date = '';
    #[Validate]
    public int $num_nights = 1;
    #[Validate]
    public int $num_rooms = 1;
    #[Validate]
    public int $num_pax = 1;
    #[Validate]
    public string $notes = '';

    public function mount()
    {
        $this->hotelDropdown = Hotel::query()->orderBy('name')->get();
        if (app()->environment() !== 'local') $this->showDebug = false;
    }

    public function render()
    {
        return view('livewire.booking-component');
    }

    public function updated($property)
    {
        $this->calculateSummary();
    }

    public function save()
    {
        $this->validate($this->rules());

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

        return $this->redirect(route('pages.booking-form.thank-you'));
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
        ];
    }

    protected $messages = [
        'selected_date_range' => 'Please select a Date Range for your booking.',
        'hotel_name' => 'Please select a Hotel from the dropdown.',
        'room_type_name' => 'Please select a Room Type from the dropdown.',
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
    public function calculateSummary(): void
    {
        // RESET
        $this->summary = [];
        $this->total_cost = 0;

        // VALIDATE
        if (!$this->validate()) return;

        // GATHER DATA
        $roomType = RoomType::find($this->room_type_id);
        $startDate = Carbon::parse($this->check_in_date);

        // CALCULATE
        for ($i = 0; $i < $this->num_nights; $i++) {
            $date = $startDate->copy()->addDays($i);
            $dailyTotal = $this->num_rooms * $roomType->room_night_cost;
            $this->total_cost += $dailyTotal;

            $this->summary[] = [
                'date' => $date->format('D, d M Y'),
                'details' => "{$this->num_rooms} x ".Str::plural('Room', $this->num_rooms)." * {$roomType->room_night_cost} USD",
                'daily_total' => number_format($dailyTotal, 0)." USD",
            ];
        }
    }

    public function updatedHotelId($value) : void
    {
        $this->room_type_name = '';
        $this->room_type_id = 0;
        $hotel = Hotel::find($value);
        if ($hotel) $this->hotel_name = $hotel->name;
        if ($hotel && $hotel->rooms->count() > 0) {
            $rooms = RoomType::query()->where('hotel_id', $value)->get();
            if ($rooms) $this->roomTypeDropdown = $rooms;
        }
        $this->calculateSummary();
        $this->validate();
    }

    public function updatedRoomTypeId($value) : void
    {
        $this->room_type_name = '';
        $room = RoomType::find($value);
        if ($room) $this->room_type_name = $room->name;
        $this->calculateSummary();
        $this->validate();
    }

    public function updatedNumPax($value) : void
    {
        // validation for notes could still be on screen when num pax changes
        $this->validate();
    }

    public function updatedSelectedDateRange($value) : void
    {
        $this->num_nights = 1;
        if ($value) {
            [$startDate, $endDate] = array_pad(explode(' to ', $value), 2, null);
            $startDate = Carbon::parse($startDate);
            $endDate = Carbon::parse($endDate);
            $numDays = $startDate->diffInDays($endDate);

            $this->check_in_date = $startDate->toDateString();
            $this->check_out_date = $endDate->toDateString();
            $this->num_nights = (int)$numDays;

        }
        $this->calculateSummary();
        $this->validate();
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
        return collect(range(1, 5))->map(fn($value) => ['value' => $value, 'title' => (string) $value.' Pax'])->toArray();
    }

    public function resetForm() : void
    {
        $this->reset();
        $this->mount();
        $this->toast(type: 'success', title: 'Booking form reset', position: 'toast-top', css: 'alert-info');
    }
}
