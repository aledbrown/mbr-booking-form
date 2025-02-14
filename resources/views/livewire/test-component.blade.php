<div>
    <h1>Livewire Test Component</h1>

    <div class="items-center justify-center text-center">

        <h2 class="font-bold text-4xl mb-4">{{ $count }}</h2>

        <div class="space-x-4">
            <x-mary-button class="btn btn-accent" wire:click="decrement">-</x-mary-button>
            <x-mary-button class="btn btn-accent" wire:click="increment">+</x-mary-button>
        </div>

    </div>
</div>
