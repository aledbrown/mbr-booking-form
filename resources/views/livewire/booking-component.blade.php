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
                            <x-mary-select class="text-lg leading-loose" wire:model.live="hotel_id" label="Hotel Name:"
                                           option-value="id"
                                           option-label="name"
                                           placeholder="Select Hotel..."
                                           placeholder-value="0"
                                           :options="$this->hotelDropdown" />
                        </div>
                        <div>
{{--                        @if($this->hotel_id>0)--}}
                            <x-mary-select class="text-lg leading-loose" wire:model.live="room_type_id" label="Room Type:"
                                           option-value="id"
                                           option-label="name"
                                           placeholder="Select Room Type..."
                                           placeholder-value="0"
                                           :options="$this->roomTypeDropdown ?? []"
                                           :disabled="$this->hotel_id==0"/>
{{--                        @endif--}}
                        </div>
                        <div>
                            <x-mary-input wire:model.live="num_pax" type="number" min="1" max="5" label="Number of Pax:" />
                        </div>
                        <div>
                            <x-mary-input type="text" label="Field 1:" placeholder="Placeholder" />
                        </div>

{{--
                        <div x-data="datePicker">
                            <x-mary-input type="text" name="dates" x-ref="daterange" wire:model.lazy="selected_date_range" label="Dates:" placeholder="Please select up to 7 days" />
                        </div>
--}}

{{--
                        <div x-data="datePicker">
                            <label class="pt-0 label label-text font-semibold">Dates:</label>
                            <input class="w-full input input-primary" type="text" x-ref="daterange" name="dates" placeholder="Select date range">
                        </div>
--}}

                        <div>
                            @php
                                $config = [
                                    'mode' => 'range',
                                    'minDate' => 'today',
                                    'dateFormat' => 'Y-m-d',
                                    'altInput' => true,
                                ];
                            @endphp
                            <x-mary-datepicker wire:model.lazy="selected_date_range" placeholder="Click to select dates" label="Dates:" :config="$config" />
                        </div>
                    </div>


                    <script>
                        document.addEventListener("alpine:init", () => {
                            Alpine.data("datePicker", () => ({
                                init() {
                                    flatpickr(this.$refs.daterange, {
                                        mode: "range",
                                        minDate: "today", // Prevent selecting past dates
                                        dateFormat: "Y-m-d",
                                        altInput: true,
                                        onChange: (selectedDates, dateStr, instance) => {
                                            if (selectedDates.length === 2) {
                                                const diff = (selectedDates[1] - selectedDates[0]) / (1000 * 60 * 60 * 24);
                                                if (diff > 7) {
                                                    alert("You can only select up to 7 days.");
                                                    instance.clear();
                                                }
                                            }
                                        }
                                    });
                                }
                            }));
                        });
                    </script>

                    <div class="w-full flex space-x-4 mt-4">
                        <x-mary-errors class="bg-primary text-primary-content"  title="Oops!" description="There were some issues with your submission, please scroll up to fix them." icon="o-face-frown" :errors="$errors" />
                    </div>

                    <div class="w-full flex space-x-4 mt-4">
                        <x-mary-button class="btn btn-accent text-white" type="submit" spinner="save">Submit Booking</x-mary-button>
                        {{--<x-mary-button wire:click="save">Save</x-mary-button>--}}
                        <x-mary-button wire:click="resetForm">Reset</x-mary-button>
                        <x-mary-button wire:click="testButton">Toast test</x-mary-button>
                    </div>
                </div>
            </form>
        </div>
        @if($this->showDebug)
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <h1 class="font-bold">Debug Info</h1>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <p>Selected hotel: {{ $this->hotel_name }} [{{ $this->hotel_id }}]</p>
                    <p>Number of pax: {{ $this->num_pax }}</p>
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
