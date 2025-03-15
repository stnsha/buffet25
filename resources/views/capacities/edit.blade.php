<x-app-layout>
    <div class="flex flex-col w-full bg-white rounded-md p-8">
        <span class="font-semibold text-md pb-2 border-b-2 border-zinc-400">Edit Capacity</span>

        <div class="flex flex-col mt-4 w-full">
            <form action="{{ route('capacity.update', $capacity->id) }}" method="POST">
                @csrf
                @method('put')
                <div class="flex flex-row w-full justify-start items-center mb-3">
                    <span class="w-1/4 font-medium text-sm pb-2 capitalize">Date & Day</span>
                    <input class="w-3/4 border-1 border-zinc-300 shadow-md bg-zinc-50 py-2 text-sm rounded-md"
                        type="text" name="date_day" id="date_day"
                        value="{{ \Carbon\Carbon::parse($capacity->venue_date)->format('j F Y, g:i A') }}" readonly>
                    <input class="w-3/4 border-1 border-zinc-300 shadow-md bg-zinc-50 py-2 text-sm rounded-md"
                        type="text" name="venue_date" id="venue_date" value="{{ $capacity->venue_date }}" readonly
                        hidden>
                </div>
                <div class="flex flex-row mb-3 w-full justify-between items-center">
                    <div class="flex flex-col w-1/3 mr-1">
                        <span class="font-medium text-sm pb-2 capitalize mr-4">Full Capacity</span>
                        <input class="w-full border-1 border-zinc-300 shadow-md bg-white py-2 rounded-md" type="text"
                            name="full_capacity" id="full_capacity" value="{{ $capacity->full_capacity }}">
                    </div>
                    <div class="flex flex-col w-1/3 mr-1">
                        <span class="font-medium text-sm pb-2 capitalize mr-4">Minimum Capacity</span>
                        <input class="w-full border-1 border-zinc-300 shadow-md bg-white py-2 rounded-md" type="text"
                            name="min_capacity" id="min_capacity" value="{{ $capacity->min_capacity }}">
                    </div>
                    <div class="flex flex-col w-1/3 mr-1">
                        <span class="font-medium text-sm pb-2 capitalize mr-4">Available Capacity</span>
                        <input class="w-full border-1 border-zinc-300 shadow-md bg-white py-2 rounded-md" type="text"
                            name="available_capacity" id="available_capacity"
                            value="{{ $capacity->available_capacity }}">
                    </div>
                </div>
                <div class="flex flex-row mb-3 w-full justify-between items-center">
                    <div class="flex flex-col w-1/3 mr-1">
                        <span class="font-medium text-sm pb-2 capitalize mr-4">Total paid</span>
                        <input class="w-full border-1 border-zinc-300 shadow-md bg-white py-2 rounded-md" type="text"
                            name="total_paid" id="total_paid" value="{{ $capacity->total_paid }}" readonly>
                    </div>
                    <div class="flex flex-col w-1/3 mr-1">
                        <span class="font-medium text-sm pb-2 capitalize mr-4">Total Reserved</span>
                        <input class="w-full border-1 border-zinc-300 shadow-md bg-white py-2 rounded-md" type="text"
                            name="total_reserved" id="total_reserved" value="{{ $capacity->total_reserved }}">
                    </div>
                    <div class="flex flex-col w-1/3 mr-1">
                        <span class="font-medium text-sm pb-2 capitalize mr-4">Status</span>
                        <select class="w-full border-1 border-zinc-300 shadow-md bg-white py-2 rounded-md text-md"
                            name="status" id="status">
                            <option value="1" {{ $capacity->status == '1' ? 'selected' : '' }}>Available</option>
                            <option value="2" {{ $capacity->status == '2' ? 'selected' : '' }}>Sold Out</option>
                        </select>
                    </div>
                </div>
                <div class="flex flex-col justify-center items-center mt-4">
                    <input
                        class="font-medium text-sm border-1 border-zinc-300 shadow-md bg-white py-2 px-4 rounded-md cursor-pointer hover:bg-zinc-100"
                        type="submit" value="Submit" name="submit">
                    <a href="{{ route('venue.index', $capacity->venue_id) }}"
                        class="font-medium text-sm pt-2 text-gray-900 hover:text-zinc-800 hover:underline">Back to
                        Capacity</a>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
