<x-app-layout>
    <div class="flex flex-col w-full bg-white rounded-md p-8">
        <div class="flex flex-col w-full">
            <span class="font-medium text-md border-b-2 border-zinc-400 pb-2">Confirmed Bookings</span>
        </div>
        <div class="flex flex-col w-full my-8">
            <div class="relative overflow-x-auto rounded-lg border-0">
                <table class="w-full text-sm text-left text-[#133944] rounded-md" id="reservations-table"
                    style="table-layout: auto;">
                    <thead class="text-xs text-[#133944] uppercase bg-zinc-300 rounded-lg">
                        <tr>
                            <th class="text-sm text-left font-regular px-6 py-3 whitespace-nowrap">Order ID</th>
                            <th class="text-sm text-left font-regular px-6 py-3 whitespace-nowrap">Venue & Date</th>
                            <th class="text-sm text-left font-regular px-6 py-3 whitespace-nowrap">Customer Details</th>
                            <th class="text-sm text-left font-regular px-6 py-3 whitespace-nowrap">Pax Details</th>
                            <th class="text-sm text-left font-regular px-6 py-3 whitespace-nowrap">Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($orders as $key => $od)
                            @php
                                $statusClasses = [
                                    1 => 'bg-pink-500 text-pink-200', // Reserved
                                    2 => 'bg-blue-500 text-blue-200', // Paid
                                    3 => 'bg-yellow-500 text-yellow-200', // Pending
                                    4 => 'bg-red-500 text-red-200', // Failed
                                ];

                                $statusLabels = [
                                    1 => 'Reserved',
                                    2 => 'Paid',
                                    3 => 'Pending',
                                    4 => 'Failed',
                                ];

                                $statusClass = $statusClasses[$od->status] ?? 'bg-gray-500 text-gray-200';
                                $statusLabel = $statusLabels[$od->status] ?? 'Unknown';
                            @endphp
                            <tr class="odd:bg-zinc-100 even:bg-zinc-50 text-left">
                                <td class="p-4">
                                    <span
                                        class="font-medium text-sm uppercase text-slate-900">#{{ $od->ref_id }}</span>
                                </td>
                                <td class="p-4">
                                    <div class="flex flex-col justify-center items-start ">
                                        <span
                                            class="font-normal text-sm uppercase text-slate-900">{{ $od->capacity->venue->name }}</span>
                                        <span class="font-normal text-sm uppercase text-slate-900">
                                            {{ \Carbon\Carbon::parse($od->capacity->venue_date)->locale('ms_MY')->format('l, d M Y, g:i a') }}</span>
                                    </div>
                                </td>
                                <td class="p-4">
                                    <span class="font-normal text-sm uppercase text-slate-900">{{ $od->customer->name }}
                                    </span>
                                </td>
                                <td class="p-4">
                                    <div class="flex flex-col">
                                        @foreach ($od->order_details as $key => $od_det)
                                            <div class="flex flex-row">
                                                <span
                                                    class="font-normal text-sm uppercase text-slate-900 w-2/3">{{ $od_det->hasPrice->name }}</span>
                                                {{-- <span
                                                class="font-medium text-sm uppercase text-slate-900 w-1/3 text-end">RM{{ number_format($od_det->price, 2) }}</span> --}}
                                                <span
                                                    class="font-normal text-sm uppercase text-slate-900 w-1/3 text-end">{{ $od_det->quantity }}
                                                    pax</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </td>

                                <td class="p-4">
                                    <span
                                        class="font-normal text-sm text-slate-900 px-5 py-1 rounded-md {{ $statusClass }}">
                                        {{ $statusLabel }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const rowsPerPage = 25;
            const table = document.getElementById("reservations-table");
            const tbody = table.querySelector("tbody");
            const rows = Array.from(tbody.querySelectorAll("tr"));
            const totalPages = Math.ceil(rows.length / rowsPerPage);
            let currentPage = 1;

            function displayRows() {
                tbody.innerHTML = "";
                const start = (currentPage - 1) * rowsPerPage;
                const end = start + rowsPerPage;
                rows.slice(start, end).forEach(row => tbody.appendChild(row));
            }

            function createPaginationControls() {
                const paginationContainer = document.createElement("div");
                paginationContainer.className = "pagination flex gap-2 mt-4";

                for (let i = 1; i <= totalPages; i++) {
                    const button = document.createElement("button");
                    button.textContent = i;
                    button.className = "px-3 py-1 bg-gray-300 rounded hover:bg-gray-400";
                    button.addEventListener("click", function() {
                        currentPage = i;
                        displayRows();
                        updateActiveButton();
                    });
                    paginationContainer.appendChild(button);
                }
                table.parentElement.appendChild(paginationContainer);
            }

            function updateActiveButton() {
                document.querySelectorAll(".pagination button").forEach((btn, index) => {
                    btn.classList.toggle("bg-blue-500", index + 1 === currentPage);
                    btn.classList.toggle("text-white", index + 1 === currentPage);
                });
            }

            displayRows();
            createPaginationControls();
            updateActiveButton();
        });
    </script>
</x-app-layout>
