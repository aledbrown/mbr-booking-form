<div class="pb-12">
    <div class="max-w-full mx-auto sm:px-6 lg:px-8 space-y-4">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <form wire:submit="save">
                <div class="w-full">
                    <div class="sm:flex sm:items-center">
                        <div class="sm:flex-auto">
                            <p class="mb-3 text-sm text-gray-700">Please use the form below to book your hotel:</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <x-mary-select class="text-lg leading-loose" wire:model.live="hotel_id" label="Hotel Name:"
                                           option-value="id"
                                           option-label="name"
                                           placeholder="Select Hotel..."
                                           placeholder-value="0"
                                           :options="$this->hotelDropdown" />
                        </div>
                        <div>
                            <x-mary-input wire:model.live="num_pax" type="number" min="1" max="5" label="Number of Pax:" />
                        </div>
                        <div>
                            <x-mary-input type="text" label="Field 1:" placeholder="Placeholder" />
                        </div>
                        <div>
                            <x-mary-input type="text" label="Field 1:" placeholder="Placeholder" />
                        </div>
                    </div>

                    {{--@error('hotel_name') <span class="error">{{ $message }}</span> @enderror--}}

                    <div class="w-full flex space-x-4 mt-4">
                        <x-mary-button class="btn btn-accent text-white" type="submit" spinner="save">Submit Booking</x-mary-button>
                        <x-mary-button wire:click="save">Save</x-mary-button>
                        <x-mary-button wire:click="testButton">Toast test</x-mary-button>
                    </div>
                </div>
            </form>
        </div>
        @if($this->showDebug)
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <h1 class="font-bold">Debug Info</h1>
                <p>Selected hotel: {{ $this->hotel_name }} [{{ $this->hotel_id }}]</p>
                <p>Number of pax: {{ $this->num_pax }}</p>
            </div>
        @endif
    </div>
</div>
