<x-app-layout>
    <div class="flex flex-col w-full">
        <span class="font-medium text-lg">New Date</span>
        <div class="flex flex-col mt-4 w-1/2">
            <form action="{{ route('capacity.store') }}" method="post">
                @csrf
                <div class="flex flex-col">
                    <span>Venue</span>
                    <input type="text" name="venue_id" id="venue_id" value="{{ $venue_id }}" hidden>
                    <input type="text" name="venue_name" id="venue_name" value="{{ $venue_name }}" readonly>
                </div>
                <div class="flex flex-row justify-between">
                    <div class="flex flex-col">
                        <span>From</span>
                        <input type="date" name="from_date" id="from_date">
                    </div>
                    <div class="flex flex-col">
                        <span>To</span>
                        <input type="date" name="to_date" id="to_date">
                    </div>
                </div>
                <div class="flex flex-col">
                    <span>Full Capacity</span>
                    <input type="text" name="full_capacity" id="full_capacity">
                </div>
                <div class="flex flex-col">
                    <span>Baby chair/per day</span>
                    <input type="text" name="baby_chair" id="baby_chair">
                </div>
                <div class="flex flex-col">
                    <span>Status</span>
                    <select name="status" id="status">
                        <option value="1">Available</option>
                        <option value="2">Sold Out</option>
                    </select>
                </div>
                <div class="flex flex-col">
                    <input type="submit" value="submit" name="Submit">
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
