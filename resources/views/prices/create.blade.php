<x-app-layout>
    <div class="flex flex-col w-full">
        <span class="font-medium text-lg">New Date</span>
        <div class="flex flex-col mt-4 w-1/2">
            <form action="{{ route('price.store') }}" method="post">
                @csrf
                <div class="flex flex-col mb-2">
                    <span class="pb-0.5">Venue</span>
                    <input type="text" name="venue_id" id="venue_id" value="{{ $venue_id }}" hidden>
                    <input type="text" name="venue_name" id="venue_name" value="{{ $venue_name }}" readonly>
                </div>
                <div id="categories-container">
                    <div class="flex flex-row justify-between items-center mb-2 w-full category-item">
                        <div class="flex flex-col w-2/5">
                            <span class="pb-0.5">Category</span>
                            <input type="text" name="price_name[]" class="mr-2">
                        </div>
                        <div class="flex flex-col w-2/5">
                            <span class="pb-0.5 ml-2">Price</span>
                            <input type="text" name="price[]" class="ml-2">
                        </div>
                        <div class="flex flex-row w-1/5 pl-4">
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
                <div class="flex flex-col">
                    <input type="submit" value="submit" name="Submit">
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
