<x-app-layout>
    <div class="flex flex-col w-full py-4 px-2 bg-zinc-100 rounded-lg">
        <span class="font-semibold text-lg border-b-2 border-zinc-400 pb-2">New Price</span>
        <div class="flex flex-col mt-4 w-1/2 py-4 px-2">
            <form action="{{ route('price.store') }}" method="post">
                @csrf
                <div class="flex flex-col mb-2">
                    <span class="font-medium text-sm py-2">Venue</span>
                    <input class="border-0 bg-zinc-50 py-2 rounded-md" type="text" name="venue_id" id="venue_id"
                        value="{{ $venue_id }}" hidden>
                    <input class="border-0 bg-zinc-50 py-2 rounded-md" type="text" name="venue_name" id="venue_name"
                        value="{{ $venue_name }}" readonly>
                </div>
                <div id="categories-container">
                    <div class="flex flex-row justify-start items-center mb-2 w-full category-item">
                        <div class="flex flex-col w-1/2 mr-2">
                            <span class="font-medium text-sm py-2 pb-0.5">Category</span>
                            <input class="border-0 bg-zinc-50 py-2 rounded-md" type="text" name="price_name[]">
                        </div>
                        <div class="flex flex-col w-[25%] mr-2">
                            <span class="font-medium text-sm py-2 pb-0.5">Price</span>
                            <input class="border-0 bg-zinc-50 py-2 rounded-md" type="text" name="price[]">
                        </div>
                        <div class="flex flex-row w-[15%]">
                            <span class="add-category flex justify-center items-center pb-6 pt-12 cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                            </span>
                            <span class="remove-category flex justify-center items-center pb-6 pt-12 cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                            </span>
                        </div>
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
