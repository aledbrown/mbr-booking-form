<x-layouts.app title="Test">
    <div class="max-w-full mx-auto sm:px-6 lg:px-8 space-y-4">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg text-center">
            <h1 class="mb-4 mt-4 text-4xl font-extrabold tracking-tight leading-none text-primary md:text-5xl lg:text-6xl">
                Success!
            </h1>
            <p class="mb-8 text-lg font-normal text-gray-500 lg:text-xl sm:px-16">
                Thank you for booking a vacation today.
            </p>
            <div class="flex flex-col mb-4 sm:flex-row sm:justify-center sm:space-y-0 sm:space-x-4">
                <x-mary-button link="{{ route('pages.booking-form') }}" class="btn btn-accent text-white">Click here for another go!</x-mary-button>
            </div>
        </div>
    </div>
</x-layouts.app>
