<?php

namespace App\Livewire;

use App\Livewire\Forms\BookingForm;
use Livewire\Component;
use Mary\Traits\Toast;

class BookingComponent extends Component
{
    use Toast;
    public BookingForm $form;

    public function render()
    {
        return view('livewire.booking-component');
    }

    public function testButton()
    {
        $this->reset();
        $this->toast(type: 'success', title: 'Testing, 1, 2, 3.', position: 'toast-top', css: 'alert-success');
    }
}
