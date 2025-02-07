<x-app-layout>
    <div class="flex flex-col w-full">
        <span class="font-medium text-lg">Reservations</span>

        <div class="flex flex-col w-full my-8">
            <div class="relative overflow-x-auto rounded-lg border-0">
                <table class="w-full text-sm text-left text-[#133944]" id="reservations-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Status</th>
                            <th>Venue</th>
                            <th>Customer Details</th>
                            <th>Pax Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $key => $od)
                            @php
                                $order_id = '#';
                                if ($od->venue_id == 1) {
                                    $order_id = '#ARN';
                                } else {
                                    $order_id = '#CHR';
                                }
                            @endphp
                            <tr>
                                <td>
                                    <a href="#"
                                        class="font-medium text-sm uppercase text-slate-900 hover:underline hover:text-slate-800">{{ $order_id . $od->id }}</a>
                                </td>

                                <td><span
                                        class="font-medium text-sm text-slate-900 px-4 py-2 rounded-md {{ $od->status == 1 ? 'bg-orange-500 text-orange-200' : 'bg-green-400 text-slate-400' }}">{{ $od->status == 1 ? 'Reserved' : 'Completed' }}</span>
                                </td>
                                <td>
                                    <span
                                        class="font-normal text-sm uppercase text-slate-900">{{ $od->venue->name }}</span>
                                </td>
                                <td>
                                    <span class="font-normal text-sm uppercase text-slate-900">{{ $od->customer->name }}
                                    </span>
                                </td>
                                <td>
                                    <div class="flex flex-col">
                                        @foreach ($od->order_details as $key => $od_det)
                                            <div class="flex flex-row">
                                                <span
                                                    class="font-medium text-sm uppercase text-slate-900 w-2/3">{{ $od_det->hasPrice->name }}</span>
                                                {{-- <span
                                                class="font-medium text-sm uppercase text-slate-900 w-1/3 text-end">RM{{ number_format($od_det->price, 2) }}</span> --}}
                                                <span
                                                    class="font-medium text-sm uppercase text-slate-900 w-1/3 text-end">{{ $od_det->quantity }}
                                                    pax</span>
                                            </div>
                                        @endforeach
                                        @if ($od->is_bchair == 1)
                                            <span
                                                class="font-medium text-sm uppercase text-slate-900 w-2/3">{{ $od->total_bchair }}</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</x-app-layout>
