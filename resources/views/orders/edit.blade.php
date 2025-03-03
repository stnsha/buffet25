<x-app-layout>
    <div class="flex flex-col w-full bg-white rounded-md p-8">
        <span class="font-semibold text-md pb-2 border-b-2 border-zinc-400">Edit Order #{{ $order->ref_id }}</span>

        <div class="flex flex-col mt-4 w-full">
            <form action="{{ route('order.update', $order) }}" method="POST">
                @csrf
                @method('put')

                <div class="flex flex-row w-full justify-start items-center mb-3">
                    <span class="w-1/4 font-medium text-sm pb-2 capitalize">Venue</span>
                    <input type="text" name="venue_id" value="{{ $order->capacity->venue->name }}" readonly
                        class="w-3/4 border-1 border-zinc-300 shadow-md bg-zinc-100 py-2 text-sm rounded-md">
                </div>
                <div class="flex flex-row w-full justify-start items-center mb-3">
                    <span class="w-1/4 font-medium text-sm pb-2 capitalize">Date & Day</span>
                    <select name="capacity_id" id=""
                        class="w-3/4 border-1 border-zinc-300 shadow-md bg-zinc-50 py-2 text-sm rounded-md"
                        type="text">
                        @foreach ($capacities as $key => $cp)
                            <option value="{{ $cp->id }}" {{ $cp->id == $order->venue_id ? 'selected' : '' }}
                                {{ $cp->available_capacity != 0 ? '' : 'disabled' }}>
                                {{ \Carbon\Carbon::parse($cp->venue_date)->locale('ms_MY')->format('l, d M Y, g:i a') }}
                                - {{ $cp->available_capacity }} pax
                            </option>
                        @endforeach
                    </select>
                </div>

                @if (session('error'))
                    <div class="flex w-auto bg-red-200 text-red-800 ml-4 mr-8 my-2 rounded-md">
                        <span class="font-medium text-sm px-4 py-2">{{ session('error') }}</span>
                    </div>
                @endif
                <div class="flex flex-col justify-center items-center mt-4">
                    <input
                        class="font-medium text-sm border-1 border-zinc-300 shadow-md bg-white py-2 px-4 rounded-md cursor-pointer hover:bg-zinc-100"
                        type="submit" value="Submit" name="submit">
                    <a href="{{ route('order.index') }}"
                        class="font-medium text-sm pt-2 text-gray-900 hover:text-zinc-800 hover:underline">Back to
                        Orders</a>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
