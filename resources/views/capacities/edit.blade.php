<x-app-layout>
    <div class="flex flex-col w-full py-4 px-2 bg-zinc-100 rounded-lg">
        <span class="font-semibold text-lg  pb-2">Edit Capacity</span>
        <span class="font-medium text-sm border-b-2 border-zinc-400 pb-2">
            {{ \Carbon\Carbon::parse($capacity->venue_date)->format('j F Y, g:i A') }}
        </span>

    </div>
</x-app-layout>
