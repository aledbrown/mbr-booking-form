<?php

namespace App\Livewire;

use Livewire\Attributes\Reactive;
use Livewire\Component;

class BookingSummary extends Component
{
    #[Reactive]
    public array $summary = [];
    #[Reactive]
    public $total_cost = 0;

    public function render()
    {
        return view('livewire.booking-summary');
    }
}
