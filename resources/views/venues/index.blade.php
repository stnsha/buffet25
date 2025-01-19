<x-app-layout>
    <div class="flex flex-col w-full">
        <span class="font-medium text-lg">Venues</span>

        <div class="flex flex-row w-full">
            <div class="flex flex-col w-full my-2 py-4">
                <div class="flex flex-col">
                    <span class="font-medium text-md">{{ $venue->name }}</span>
                    <span class="font-regular text-sm">{{ $venue->location }}</span>
                </div>
                <div class="flex flex-row">
                    <a href="{{ route('capacity.create', ['venue_id' => $venue_id]) }}" type="button"
                        class="btn-primary text-xs text-center font-regular px-4 py-1.5 rounded-lg bg-blue-100 my-2 mr-2">Add
                        Date</a>
                    <a href="#" type="button"
                        class="btn-primary text-xs text-center font-regular px-4 py-1.5 rounded-lg bg-blue-100 my-2 mr-2">Add
                        Price</a>
                </div>
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left rtl:text-right text-[#133944]">
                        <thead class="text-xs text-[#133944] uppercase bg-gray-50 rounded-lg">
                            <tr>
                                <th class="text-sm font-regular px-6 py-3">Date</th>
                                <th class="text-sm font-regular px-6 py-3">Total Capacity</th>
                                <th class="text-sm font-regular px-6 py-3">Booked</th>
                                <th class="text-sm font-regular px-6 py-3">Available Left</th>
                                <th class="text-sm font-regular px-6 py-3">Status</th>
                                <th class="text-sm font-regular px-6 py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($venue->capacities as $key => $cp)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($cp->venue_date)->format('d M Y, g:i a') }}</td>
                                    <td>
                                        <div class="flex flex-col p-2">
                                            <span>Total Capacity: {{ $cp->full_capacity }}</span>
                                            <span>Total Baby Chair: {{ $cp->baby_chair }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="flex flex-col p-2">
                                            <span>Total Reserved: {{ $cp->total_reserved }}</span>
                                            <span>Total Paid: {{ $cp->total_paid }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="flex flex-col p-2">
                                            <span>Availability: {{ $cp->available_capacity }}</span>
                                            <span>Baby Chair: {{ $cp->available_bchair }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span>{{ $cp->status == 1 ? 'Available' : 'Sold Out' }}</span>
                                    </td>
                                    <td>
                                        <div class="flex flex-col p-2">
                                            <a href="#">Edit Date</a>
                                            <a href="#">Mark as Sold Out</a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
