<div class="">
    <table class="table-auto w-full border-collapse border border-gray-200 overflow-hidden">
        <thead>
        <tr class="bg-gray-100">
            <th class="border px-4 py-2 text-left">Date</th>
            <th class="border px-4 py-2 text-left">Details</th>
            <th class="border px-4 py-2 text-right">Daily Total</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($summary as $day)
            <tr>
                <td class="border px-4 py-2">{{ $day['date'] }}</td>
                <td class="border px-4 py-2">{{ $day['details'] }}</td>
                <td class="border px-4 py-2 text-right">{{ $day['daily_total'] }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="3" class="border px-4 py-2 text-center text-gray-500">No data available</td>
            </tr>
        @endforelse
        </tbody>
    </table>
    <div class="w-full text-center mt-4">
        <p class="text-primary font-bold text-xl">Total Cost : {{ number_format($this->total_cost, 2) }} USD</p>
    </div>
</div>
