<?php

namespace App\Livewire;

use App\Livewire\Forms\BookingForm;
use App\Models\Hotel;
use Illuminate\Support\Collection;
use Livewire\Component;
use Mary\Traits\Toast;

class BookingComponent extends Component
{
    use Toast;
    public BookingForm $form;

    public Collection $hotelDropdown;

    public function mount()
    {
        // $this->form->num_pax = 4;
        $this->hotelDropdown = Hotel::all();
        dump($this->hotelDropdown);
    }

    public function render()
    {
        return view('livewire.booking-component');
    }

    public function testButton()
    {
        // $this->reset();
        $this->toast(type: 'success', title: 'Testing, 1, 2, 3.', position: 'toast-top', css: 'alert-success');
    }
}
