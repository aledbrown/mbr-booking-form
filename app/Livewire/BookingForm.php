<?php

namespace App\Livewire;

use Livewire\Component;
use Mary\Traits\Toast;

class BookingForm extends Component
{
    use Toast;

    public function render()
    {
        return view('livewire.booking-form');
    }

    public function testButton()
    {
        $this->reset();
        $this->toast(type: 'success', title: 'Testing, 1, 2, 3.', position: 'toast-top', css: 'alert-success');
    }
}
