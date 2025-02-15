@push('styles')
    {{-- Flatpickr  --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endpush
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
                            <x-mary-select class="text-lg leading-loose" wire:model.live="hotel_id" label="Hotel Name:" required
                                           option-value="id"
                                           option-label="name"
                                           placeholder="Select Hotel..."
                                           placeholder-value="0"
                                           :options="$this->hotelDropdown" />
                        </div>

                        <div>
                            <x-mary-select class="text-lg leading-loose" wire:model.live="room_type_id" label="Room Type:" required
                                           option-value="id"
                                           option-label="name"
                                           placeholder="Select Room Type..."
                                           placeholder-value="0"
                                           :options="$this->roomTypeDropdown ?? []"
                                           :disabled="$this->hotel_id==0"/>
                        </div>

                        <div>
                            @php
                                $config = [
                                    'mode' => 'range',
                                    'minDate' => 'today',
                                    'dateFormat' => 'Y-m-d',
                                    'altInput' => true,
                                ];
                            @endphp
                            <x-mary-datepicker wire:model.lazy="selected_date_range" placeholder="Click to select dates" label="Dates:" :config="$config" required />
                        </div>

                        <div>
                            <x-mary-input wire:model.live="num_nights" type="number" min="1" max="5" label="Number of Nights:" required disabled />
                            <x-mary-input hidden="true" wire:model="num_nights"/>
                        </div>

                        <div>
                            {{--TODO: dropdown--}}
                            <x-mary-input wire:model.live="num_rooms" type="number" min="1" max="2" label="Number of Rooms:" required />
                        </div>


                        <div>
                            <x-mary-input wire:model.live="num_pax" type="number" min="1" max="5" label="Number of Pax:" required />
                        </div>

                        <div class="col-span-2">
                            <label class="pt-0 label label-text font-semibold">
                                <span>Notes:
                                    @if($this->num_pax>1)
                                        <span class="text-error">*</span>
                                    @endif
                                </span>
                            </label>
                            <x-mary-textarea wire:model.blur="notes" />
                        </div>

                    </div>

                    <div class="w-full flex space-x-4 mt-4">
                        <x-mary-errors class="bg-primary text-primary-content"  title="Oops!" description="There were some issues with your submission, please scroll up to fix them." icon="o-face-frown" :errors="$errors" />
                    </div>

                    <div class="w-full flex space-x-4 mt-4">
                        <x-mary-button class="btn btn-accent text-white" type="submit" spinner="save">Submit Booking</x-mary-button>
                        <x-mary-button wire:click="resetForm">Reset</x-mary-button>
                    </div>
                </div>
            </form>
        </div>

        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <h1 class="font-bold">TODO: Totals box here</h1>
        </div>


    @if($this->showDebug)
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <h1 class="font-bold">Debug Info</h1>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <p>Selected hotel: {{ $this->hotel_name }} [{{ $this->hotel_id }}]</p>
                    @if(isset($this->num_pax))<p>Number of pax: {{ $this->num_pax }}</p>@endif
                    <p>Selected date range: {{ $this->selected_date_range }}</p>
                    <p>AlpineSelected date range: <span x-text="$wire.selected_date_range"></span> </p>
                    <p>Computed: Check in Date: {{ $this->check_in_date }}</p>
                    <p>Computed: Check out Date: {{ $this->check_out_date }}</p>
                    <p>Computed: Number of nights: {{ $this->num_nights }}</p>
                </div>
            </div>
        @endif
    </div>
</div>
