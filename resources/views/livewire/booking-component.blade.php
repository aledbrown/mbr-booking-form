@push('styles')
    {{-- Flatpickr  --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
@endpush
<div class="pb-12">
    <div class="max-w-full mx-auto sm:px-6 lg:px-8 space-y-4">
        <form wire:submit="save">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="w-full">
                    <div class="sm:flex sm:items-center">
                        <div class="sm:flex-auto">
                            <p class="mb-3 text-sm text-gray-700">Please use the form below to book your vacation:</p>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-mary-select class="text-lg leading-loose" wire:model.live="hotel_id" icon="o-home-modern" label="Hotel Name:" required
                                           option-value="id"
                                           option-label="name"
                                           placeholder="Select Hotel..."
                                           placeholder-value="0"
                                           :options="$this->hotelDropdown" />
                        </div>

                        <div>
                            <x-mary-select class="text-lg leading-loose" wire:model.live="room_type_id" icon="o-key" label="Room Type:" required
                                           option-value="id"
                                           option-label="name"
                                           placeholder="Select Room Type..."
                                           placeholder-value="0"
                                           :options="$this->roomTypeDropdown ?? []"
                                           :disabled="$this->hotel_id==0"/>
                        </div>

{{--
                        <div>
                            <x-mary-datepicker wire:model.live="selected_date_range" icon="o-calendar-days" label="Dates:" :config="['mode' => 'range','minDate' => 'today','dateFormat' => 'Y-m-d',]" required />
                        </div>
--}}
                        
{{--
                        <div x-data="datePicker">
                            <label class="pt-0 label label-text font-semibold">Dates:</label>
                            <input wire:model.live="selected_date_range" class="w-full input input-primary" type="text" x-ref="daterange" name="dates" placeholder="Select date range"/>
                        </div>
--}}
                        <div x-data="datePicker">
                            {{--<x-mary-input wire:model.live="selected_date_range" icon="o-calendar-days" label="Dates:" class="w-full input input-primary" type="text" x-ref="daterange" name="dates" placeholder="Select date range" x-on:keydown="$refs.daterange.value = ''" wire:keyup="clearSelectedDateRange()" />--}}
                            <x-mary-input @keydown.prevent placeholder wire:model.live="selected_date_range" icon="o-calendar-days" label="Dates:" class="w-full input input-primary" type="text" x-ref="daterange" name="dates" placeholder="Select date range" />
                        </div>
                        <script>
                            document.addEventListener("alpine:init", () => {
                                Alpine.data("datePicker", () => ({
                                    init() {
                                        flatpickr(this.$refs.daterange, {
                                            mode: "range",
                                            minDate: "today", // Prevent selecting past dates
                                            dateFormat: "Y-m-d",
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




                        <div>
                            <x-mary-input wire:model.live="num_nights" type="number" min="1" max="5" icon="o-moon" label="Number of Nights:" required disabled />
                        </div>

                        <div>
                            {{--<x-mary-input wire:model.live="num_rooms" type="number" min="1" max="2" label="Number of Rooms:" required />--}}
                            <x-mary-select class="text-lg leading-loose" wire:model.live="num_rooms" icon="o-briefcase" label="Number of Rooms:" required
                                           option-value="value"
                                           option-label="title"
                                           placeholder="Number of Rooms..."
                                           placeholder-value="0"
                                           :options="$this->num_rooms_dropdown()"/>
                        </div>

                        <div>
                            {{--<x-mary-input wire:model.live="num_pax" type="number" min="1" max="5" label="Number of Pax:" required />--}}
                            <x-mary-select class="text-lg leading-loose" wire:model.live="num_pax" icon="o-user" label="Number of Pax:" required
                                           option-value="value"
                                           option-label="title"
                                           placeholder="Number of Pax..."
                                           placeholder-value="0"
                                           :options="$this->num_pax_dropdown()"/>
                        </div>

                        <div class="md:col-span-2">
                            <label class="pt-0 label label-text font-semibold">
                                <span>Notes:
                                    @if($this->num_pax>1)
                                        <span class="text-error">*</span>
                                    @endif
                                </span>
                            </label>
                            <x-mary-textarea wire:model.live.debounce="notes" />
                        </div>

                    </div>

                    @if($this->showErrorBag)
                        <div class="mt-4">
                            <x-mary-errors class="bg-primary text-primary-content"  title="Oops!" description="There were some issues with your submission, please scroll up to fix them." icon="o-face-frown" :errors="$errors" />
                        </div>
                    @endif
                </div>
            </div>

            <div class="mt-4 p-4 sm:p-8 grid grid-cols-1 md:grid-cols-5 bg-white shadow sm:rounded-lg">
                <div class="md:col-span-3 items-end">
                    @if(!empty($this->summary))
                        <livewire:booking-summary :summary="$this->summary" :total_cost="$this->total_cost" />
                    @endif
                    {{--
                    @if(!empty($this->summary))
                        @forelse($this->summary as $day)
                            <p>{{ $day['date'] }}, {{ $day['details'] }}, {{ $day['daily_total'] }}</p>
                        @empty
                            <p>No Summary</p>
                        @endforelse
                        <p>Total Cost: {{ $this->total_cost }} USD</p>
                    @endif
                    --}}
                </div>
                <div class="order-first mb-4 md:mb-0 md:col-span-2">
                    <div class="w-full flex space-x-4">
                        <x-mary-button class="btn btn-accent text-white" type="submit" spinner="save">Submit Booking</x-mary-button>
                        <x-mary-button wire:click="resetForm">Reset</x-mary-button>
                    </div>
                </div>
            </div>
        </form>


        @if($this->showDebug)
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <h1 class="font-bold">Debug Info</h1>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <p>Selected hotel: {{ $this->hotel_name }} [{{ $this->hotel_id }}]</p>
                    <p>Room Type: {{ $this->room_type_name }} [{{ $this->room_type_id }}]</p>
                    @if(isset($this->num_pax))<p>Number of pax: {{ $this->num_pax }}</p>@endif
                    <p>Selected date range: {{ $this->selected_date_range }}</p>
                    <p>Check in Date: {{ $this->check_in_date }}</p>
                    <p>Check out Date: {{ $this->check_out_date }}</p>
                    <p>Number of nights: {{ $this->num_nights }}</p>
                    <p>Total Cost: ${{ number_format((int)$this->total_cost, 2) }}</p>
                </div>
            </div>
        @endif
    </div>
</div>
