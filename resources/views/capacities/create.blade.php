<x-app-layout>
    <div class="flex flex-col w-full py-4 px-2 bg-zinc-100 rounded-lg">
        <span class="font-semibold text-lg border-b-2 border-zinc-400 pb-4">New Date</span>
        <div class="flex flex-col mt-4 w-full rounded-lg">
            <form action="{{ route('capacity.store') }}" method="post">
                @csrf
                <div class="flex flex-row justify-between w-full">
                    <div class="flex flex-col w-1/2 mr-2">
                        <span class="font-medium text-sm py-2">Venue</span>
                        <input class="border-0 bg-zinc-50 py-2 rounded-md" type="text" name="venue_id" id="venue_id"
                            value="{{ $venue_id }}" hidden>
                        <input class="border-0 bg-zinc-50 py-2 rounded-md" type="text" name="venue_name"
                            id="venue_name" value="{{ $venue_name }}" readonly>
                    </div>
                    <div class="flex flex-col w-1/2 ml-2">
                        <span class="font-medium text-sm py-2">Status</span>
                        <select name="status" id="status" class="border-0 bg-zinc-50 py-2 rounded-md">
                            <option value="1">Available</option>
                            <option value="2">Sold Out</option>
                        </select>
                    </div>
                </div>
                <div class="flex flex-row justify-between w-full">
                    <div class="flex flex-col w-1/2 mr-2">
                        <span class="font-medium text-sm py-2">From</span>
                        <input class="border-0 bg-zinc-50 py-2 rounded-md" type="date" name="from_date"
                            id="from_date">
                    </div>
                    <div class="flex flex-col w-1/2 ml-2">
                        <span class="font-medium text-sm py-2">To</span>
                        <input class="border-0 bg-zinc-50 py-2 rounded-md" type="date" name="to_date" id="to_date">
                    </div>
                </div>
                <div class="flex flex-row justify-between w-full">
                    <div class="flex flex-col w-1/2 mr-2">
                        <span class="font-medium text-sm py-2">Full Capacity</span>
                        <input class="border-0 bg-zinc-50 py-2 rounded-md" type="text" name="full_capacity"
                            id="full_capacity">
                    </div>
                    <div class="flex flex-col w-1/2 ml-2">
                        <span class="font-medium text-sm py-2">Baby chair/per day</span>
                        <input class="border-0 bg-zinc-50 py-2 rounded-md" type="text" name="baby_chair"
                            id="baby_chair">
                    </div>
                </div>

                <div class="flex flex-col justify-center items-center mt-4">
                    <input
                        class="font-medium text-sm border-0 bg-zinc-50 py-2 px-4 rounded-md cursor-pointer hover:bg-zinc-300"
                        type="submit" value="Submit" name="submit">
                    <a href="{{ route('venue.index', $venue_id) }}"
                        class="font-medium text-sm pt-2 text-gray-900 hover:text-zinc-800 hover:underline">Back to
                        Venue</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
