<x-app-layout>
    <div class="flex flex-col w-full bg-white rounded-md p-8">
        <div class="flex flex-col w-full">
            <span
                class="font-medium text-md border-b-2 border-zinc-400 pb-2">{{ $venue->name . ',' . $venue->location }}</span>
        </div>
        @if (session('success'))
            <div class="flex w-auto bg-green-200 text-green-800 ml-4 mr-8 my-2 rounded-md">
                <span class="font-medium text-sm px-4 py-2">{{ session('success') }}</span>
            </div>
        @endif
        <div class="flex flex-row w-full">
            <div class="flex flex-col w-full my-2">
                <div class="flex flex-row justify-start items-center">
                    <a href="{{ route('capacity.create', ['venue_id' => $venue_id]) }}" type="button"
                        class="btn-primary text-sm text-center font-medium px-4 py-2 rounded-lg bg-zinc-300 my-2 mr-2 hover:bg-zinc-400">Add
                        Date</a>
                    {{-- <a href="{{ route('price.create', ['venue_id' => $venue_id]) }}" type="button"
                        class="btn-primary text-sm text-center font-medium px-4 py-2 rounded-lg bg-zinc-300 my-2 mr-2 hover:bg-zinc-400">Add
                        Price</a> --}}
                </div>
                <div class="relative overflow-x-auto rounded-lg border-0">
                    <table class="w-full text-sm text-left text-[#133944]">
                        <thead class="text-xs text-[#133944] uppercase bg-zinc-300 rounded-lg">
                            <tr>
                                <th class="text-sm text-left font-regular px-6 py-3">Date</th>
                                <th class="text-sm text-left font-regular pl-4 py-3">Full Capacity</th>
                                <th class="text-sm text-left font-regular pl-2 py-3">Available Capacity</th>
                                <th class="text-sm text-left font-regular pl-2 py-3">Booked</th>
                                <th class="text-sm text-left font-regular pl-1 py-3">Status</th>
                                <th class="text-sm text-left font-regular pl-4 py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($venue->capacities as $key => $cp)
                                <tr class="odd:bg-zinc-100 even:bg-zinc-50 text-left">
                                    <td class="pl-6">
                                        {{ \Carbon\Carbon::parse($cp->venue_date)->format('l, d M Y, g:i a') }}</td>
                                    <td>
                                        <div class="flex flex-col p-2">
                                            <div class="flex flex-col p-2">
                                                <div class="flex flex-row">
                                                    <span class="text-sm font-normal"> {{ $cp->full_capacity }}
                                                        seats</span>
                                                </div>
                                            </div>
                                        </div>

                                    </td>
                                    <td>
                                        <div class="flex flex-col p-2">
                                            <div class="flex flex-row">
                                                <span class="text-sm font-normal"> {{ $cp->available_capacity }} seats
                                                    left</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="flex flex-col p-2">
                                            <div class="flex flex-row">
                                                <span class="text-sm font-medium pr-4">Total Reserved:</span>
                                                <span class="text-sm font-normal text-end">
                                                    {{ $cp->total_reserved }}</span>
                                            </div>
                                            <div class="flex flex-row">
                                                <span class="text-sm font-medium pr-[46px]">Total Paid</span>
                                                <span class="text-sm font-normal text-end">{{ $cp->total_paid }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span
                                            class="{{ $cp->status == 1 ? 'text-green-700' : 'text-red-700' }}">{{ $cp->status == 1 ? 'Available' : 'Sold Out' }}</span>
                                    </td>
                                    <td>
                                        <div class="flex flex-row p-2 justify-center items-center">
                                            <a type="button" href="{{ route('capacity.edit', $cp->id) }}"
                                                class="pr-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-5 h-5 text-primary hover:text-orange-400">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('capacity.export', $cp->id) }}" type="button"
                                                class="pr-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-5 h-5 text-green-700 hover:text-orange-400">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M9 8.25H7.5a2.25 2.25 0 0 0-2.25 2.25v9a2.25 2.25 0 0 0 2.25 2.25h9a2.25 2.25 0 0 0 2.25-2.25v-9a2.25 2.25 0 0 0-2.25-2.25H15M9 12l3 3m0 0 3-3m-3 3V2.25" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('capacity.destroy', $cp->id) }}" type="button"
                                                onclick="return confirmDelete()" class="pr-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="w-5 h-5 text-red-500 hover:text-red-800">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                </svg>
                                            </a>
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
    <script>
        function confirmDelete() {
            return confirm('Are you sure you want to delete this?');
        }
    </script>
</x-app-layout>
