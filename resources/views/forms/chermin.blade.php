<x-form-layout :footerBg="request()->routeIs('form.chermin') ? 'bg-yellow-50' : 'bg-[#F6F5EE]'" :bodyBg="request()->routeIs('form.chermin') ? 'bg-[#EB8B50]' : 'bg-[#F6F5EE]'" :menuBg="request()->routeIs('form.chermin') ? 'bg-[#EB8B50]' : 'bg-[#F6F5EE]'" :menuItemBg="request()->routeIs('form.chermin') ? 'bg-[#E6B537]' : 'bg-[#F6F5EE]'">
    <div class="flex flex-col justify-center items-center text-center w-full mr-0">
        <img src="{{ asset('img/chermin_header.png') }}" alt="arena_header" class="w-full md:w-1/2 mx-auto">
        <span
            class="bg-[#E6B537] py-3 md:py-4 px-6 md:px-52 rounded-full mt-6 font-inria text-yellow-50 text-sm md:text-lg font-normal">5
            Mac 2025 sehingga 27 Mac 2025</span>
        <div class="flex flex-col rounded-tl-[160px] rounded-tr-[160px] bg-yellow-50  justify-center items-center mt-4 w-full"
            id="price-list">
            <div
                class="flex flex-col md:flex-row justify-center md:justify-evenly items-center md:items-start px-8 mt-8 text-yellow-50 font-semibold">
                @foreach ($prices as $pr)
                    @if ($pr->id != 5)
                        <div
                            class="flex flex-col rounded-3xl bg-[#EB8B50] {{ $pr->id == 7 ? 'p-6' : 'p-5' }} {{ $pr->id == 5 ? 'hidden' : 'block' }} mx-6 mb-3">
                            <div class="flex flex-row justify-center">
                                <span
                                    class="text-sm content-start pt-2 md:pt-4 {{ $pr->id == 7 ? 'text-[#133944]' : '' }}">RM</span>
                                <span
                                    class="text-[35px] md:text-[55px] {{ $pr->id == 7 ? 'line-through text-[#133944]' : '' }}">{{ $pr->normal_price }}</span>
                            </div>
                            @if ($pr->id == 7)
                                <div class="flex flex-row justify-center">
                                    <span class="text-sm content-start pt-2 md:pt-4">RM</span>
                                    <span class="text-[35px] md:text-[55px]">63</span>
                                </div>
                            @endif
                            <span
                                class="text-sm md:text-md uppercase tracking-widest font-normal pb-4">{{ $pr->name }}</span>
                            @if ($pr->id == 7)
                                <span class="text-yellow-200 text-sm font-light italic">(sah untuk bayaran <span
                                        class="font-bold">ONLINE</span> sahaja)</span>
                            @endif
                            <span class="text-sm tracking-wide font-normal">{{ $pr->description }}</span>
                        </div>
                    @endif
                @endforeach
            </div>
            <div class="flex flex-col w-full border-2 border-orange-300 md:w-3/4 rounded-[35px] mt-6"
                id="tempah-sekarang">
                <span class="font-inria font-semibold text-lg text-slate-900 pt-4">Tempah
                    Sekarang</span>
                <form action="{{ route('form.store') }}" method="POST">
                    @csrf
                    @method('post')
                    <div class="flex flex-col mx-auto w-full pb-4 px-4 md:px-48">
                        <span class="font-medium text-md text-start tracking-wider pb-1 text-slate-800">Nama<span
                                class="text-red-600 pl-0.5">*</span></span>
                        <input type="text" name="nama" id="nama" class="bg-gray-50 rounded-full border-0">
                        @error('nama')
                            <span
                                class="bg-red-100 text-red-800 text-xs font-medium me-2 mt-2 px-2.5 py-0.5 rounded-md w-fit border-lg">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="flex flex-col md:flex-row justify-between mx-auto w-full pb-4 px-4 md:px-48">
                        <div class="flex flex-col w-full md:w-1/2 mr-2">
                            <span class="font-medium text-md text-start tracking-wider pb-1 text-slate-800">No.
                                Telefon<span class="text-red-600 pl-0.5">*</span> </span>
                            <input type="text" name="phone" id="phone"
                                class="bg-gray-50 rounded-full border-0">
                            @error('phone')
                                <span
                                    class="bg-red-100 text-red-800 text-xs font-medium me-2 mt-2 px-2.5 py-0.5 rounded-md w-fit border-lg">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="flex flex-col w-full md:w-1/2">
                            <span class="font-medium text-md text-start tracking-wider pb-1 text-slate-800">Email</span>
                            <input type="text" name="email" id="email"
                                class="bg-gray-50 rounded-full border-0">
                            @error('email')
                                <span
                                    class="bg-red-100 text-red-800 text-xs font-medium me-2 mt-2 px-2.5 py-0.5 rounded-md w-fit border-lg">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="flex flex-col mx-auto w-full pb-4 px-4 md:px-48">
                        <span class="font-medium text-md text-start tracking-wider pb-1">Pilihan Tarikh<span
                                class="text-red-600 pl-0.5">*</span></span>
                        <select name="selected_date" id="selected_date" class="bg-gray-50 rounded-full border-0">
                            @foreach ($dates as $dt)
                                <option value="{{ $dt->id }}" data-capacity="{{ $dt->available_capacity }}">
                                    {{ \Carbon\Carbon::parse($dt->venue_date)->locale('ms_MY')->format('l, d M Y, g:i a') }}
                                    @if ($dt->available_capacity < 50)
                                        <span class="text-red-500">‼️‼️</span>
                                    @endif
                                </option>
                            @endforeach
                        </select>
                    </div>

                    @foreach ($prices as $price)
                        <div
                            class="flex flex-col md:flex-row justify-between items-center mx-auto w-full pb-4 px-4 md:px-48">
                            <div class="flex flex-col w-full md:w-1/5 mr-4">
                                <span
                                    class="font-medium text-md text-start tracking-wider pb-1">{{ $price->name }}<span
                                        class="text-red-600 pl-0.5">*</span></span>
                                <span class="font-normal text-xs pt-1.5 text-start">{{ $price->description }}</span>
                            </div>
                            <div class="flex flex-col w-full md:w-2/5 mr-0 md:mr-4 mb-3 md:mb-0">
                                @if ($price->id < 9)
                                    <select name="{{ $price->id }}_quantity" id="{{ $price->id }}_quantity"
                                        class="bg-gray-50 rounded-full border-0">
                                    </select>
                                @else
                                    <select name="{{ $price->id }}_quantity" id="{{ $price->id }}_quantity"
                                        class="bg-gray-50 rounded-full border-0">
                                        @for ($i = 0; $i <= 20; $i++)
                                            <option value={{ $i * 20 }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                @endif
                            </div>
                            <div class="flex flex-col w-full md:w-2/5">
                                <input type="text" name="{{ $price->id . '_price' }}"
                                    id="{{ $price->id }}_price"
                                    value="{{ $price->id == 7 ? '63.00' : number_format($price->normal_price, 2) }}"
                                    data-base-price="{{ $price->id == 7 ? 63.0 : $price->normal_price }}"
                                    class="bg-gray-50 rounded-full border-0 text-center" readonly>
                            </div>
                        </div>
                    @endforeach

                    <span class="font-medium text-red-500 text-xs pt-1.5 text-end">BABY CHAIR LIMITED FIRST
                        COME FIRST SERVE</span>
                    <div class="flex flex-row justify-end items-center mx-auto w-full pb-4 px-4 md:px-48">
                        <span class="font-medium text-md text-end tracking-wider pb-1 w-3/5">Subtotal</span>
                        <input type="text" name="subtotal" id="subtotal" value="0.00"
                            class="bg-gray-50 rounded-full border-0 w-2/5 ml-8 text-center" readonly>
                    </div>
                    @if ($errors->has('subtotal'))
                        <span
                            class="bg-red-100 text-red-800 text-xs font-medium me-2 mt-2 px-2.5 py-0.5 rounded-md w-fit border-lg text-center">
                            {{ $errors->first('subtotal') }}
                        </span>
                    @endif
                    <div class="flex flex-row justify-end items-center mx-auto w-full mt-2 pb-4 px-4 md:px-48">
                        <input type="submit" value="Bayar Sekarang"
                            class="font-medium text-md text-center tracking-wider bg-orange-100 shadow-md cursor-pointer rounded-full border-0 px-4 py-2 w-full hover:bg-orange-300 md:w-1/2">
                    </div>
                </form>
            </div>
            <div class="flex flex-col md:flex-row justify-evenly w-full md:w-1/2 mx-auto items-center bg-[#EB8B50] text-yellow-50 rounded-3xl py-4 my-6 px-6"
                id="hubungi-kami">
                <div class="flex flex-col w-full justify-start px-4">
                    <span class="font-inria font-medium text-md pt-2 text-start">Hubungi Kami</span>
                    <div class="flex flex-col md:flex-row justify-start items-start md:items-center pt-3">
                        <div class="flex flex-col mr-4">
                            <span class="font-medium text-sm text-start tracking-wider pt-2">Myra</span>
                            <a href="https://api.whatsapp.com/send?phone=60194464177&text=Buffet%20Chermin"
                                class="font-normal text-sm tracking-wider pt-2 hover:text-orange-800 hover:underline">+6019
                                446 4177
                            </a>
                            <span class="font-medium text-sm text-start tracking-wider pt-2">Bella</span>
                            <a href="https://api.whatsapp.com/send?phone=60193044022&text=Buffet%20Chermin"
                                class="font-normal text-sm tracking-wider pt-2 hover:text-orange-800 hover:underline">+6019
                                304 4022
                            </a>
                        </div>
                        <div class="flex flex-col mr-4">
                            <span class="font-medium text-sm text-start tracking-wider pt-2">Linn</span>
                            <a href="https://api.whatsapp.com/send?phone=60172469492&text=Buffet%20Chermin"
                                class="font-normal text-sm tracking-wider pt-2 hover:text-orange-800 hover:underline">+6017
                                246 9492
                            </a>
                            <span class="font-medium text-sm text-start tracking-wider pt-2">Emy</span>
                            <a href="https://api.whatsapp.com/send?phone=60127844505&text=Buffet%20Chermin"
                                class="font-normal text-sm tracking-wider pt-2 hover:text-orange-800 hover:underline">+6012
                                784 4505
                            </a>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col w-full content-start px-4">
                    <span class="font-inria font-medium text-md pt-4 text-start">Lokasi Kami</span>
                    <div class="flex flex-row pt-3">
                        <div class="flex flex-col justify-start">
                            <span class="font-medium text-sm text-start tracking-wider">
                                Dewan Chermin</span>
                            <span class="font-normal text-sm text-start tracking-wide">
                                4741, Jalan TS 1/19, Taman Semarak, 71800 Nilai, Negeri Sembilan
                            </span>
                        </div>
                        <div class="flex flex-row justify-between items-center pt-3">
                            <a href="https://maps.app.goo.gl/dEhXYa4yZkYLS2pC7"><img
                                    src="{{ asset('img/gmaps.png') }}" alt="google maps" class="w-[100px]"></a>
                            <a href="https://waze.com/ul/hw22ruxv48"><img src="{{ asset('img/waze.png') }}"
                                    alt="waze" class="w-[100px]"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get form and submit button
            const form = document.querySelector('form');
            const submitButton = form.querySelector('input[type="submit"]');

            // Get date select and quantity fields
            const dateSelect = document.getElementById('selected_date');

            // Update the PHP code to include data attributes with available capacity
            // In your Blade template, modify the options to include:
            // <option value="{{ $dt->id }}" @disabled($dt->available_capacity == 0) data-capacity="{{ $dt->available_capacity }}" data-venue="{{ $dt->venue_id }}">

            // Function to update total price
            function updateTotal() {
                let subtotal = 0;

                // Loop through all price inputs and calculate subtotal
                document.querySelectorAll('input[id$="_price"]').forEach(priceInput => {
                    const priceId = priceInput.id.split('_')[0];
                    const quantitySelect = document.getElementById(priceId + '_quantity');

                    if (quantitySelect) {
                        const quantity = parseInt(quantitySelect.value) || 0;
                        const basePrice = parseFloat(priceInput.getAttribute('data-base-price')) || 0;

                        subtotal += quantity * basePrice;
                    }
                });

                // Update subtotal field
                const subtotalField = document.getElementById('subtotal');
                if (subtotalField) {
                    subtotalField.value = subtotal.toFixed(2);
                }
            }

            // Add event listeners to all quantity selects to update prices
            document.querySelectorAll('select[id$="_quantity"]').forEach(quantitySelect => {
                quantitySelect.addEventListener('change', updateTotal);
            });

            // Initialize total
            updateTotal();

            // Form submission validation
            if (form) {
                form.addEventListener('submit', function(e) {
                    if (!dateSelect) {
                        console.error('Date select element not found');
                        return;
                    }

                    // Get selected date option
                    const selectedOption = dateSelect.options[dateSelect.selectedIndex];
                    if (!selectedOption) {
                        console.error('No date selected');
                        return;
                    }

                    // Extract the available capacity from the selected option's data attribute
                    // If the data attribute isn't available, fall back to checking if the option is disabled
                    const availableCapacity = selectedOption.dataset.capacity ?
                        parseInt(selectedOption.dataset.capacity) :
                        (selectedOption.disabled ? 0 : 100);

                    // Determine which price options to include in the total based on route
                    // We'll use the current route to determine the venue
                    const isArenaRoute = window.location.href.includes('arena');

                    // Calculate total quantity
                    let totalQuantity = 0;

                    // Based on your original logic: arena uses prices 1-4, chermin uses prices 5-8
                    if (isArenaRoute) {
                        ['1_quantity', '2_quantity', '3_quantity', '4_quantity', '9_quantity'].forEach(
                            id => {
                                const el = document.getElementById(id);
                                if (el) {
                                    totalQuantity += parseInt(el.value || 0);
                                }
                            });
                    } else {
                        ['5_quantity', '6_quantity', '7_quantity', '8_quantity', '10_quantity'].forEach(
                            id => {
                                const el = document.getElementById(id);
                                if (el) {
                                    totalQuantity += parseInt(el.value || 0);
                                }
                            });
                    }


                    // Check if total quantity is 0
                    if (totalQuantity === 0) {
                        e.preventDefault(); // Prevent form submission
                        showErrorMessage('Sila pilih sekurang-kurangnya satu seat.');
                        return;
                    }

                    // Check if total quantity exceeds available capacity
                    if (totalQuantity > availableCapacity) {
                        e.preventDefault(); // Prevent form submission
                        showErrorMessage(
                            `Maaf, jumlah seat melebihi kapasiti tersedia (${availableCapacity} seat sahaja). Sila kurangkan bilangan seat.`
                        );
                    }

                    // Helper function to show error message
                    function showErrorMessage(message) {
                        // Create or update error message
                        let errorMessage = document.getElementById('capacity-error');
                        if (!errorMessage) {
                            errorMessage = document.createElement('span');
                            errorMessage.id = 'capacity-error';
                            errorMessage.className =
                                'bg-red-100 text-red-800 text-xs font-medium me-2 mt-2 px-2.5 py-0.5 rounded-md w-fit border-lg';
                            errorMessage.style.display = 'block';
                            errorMessage.style.margin = '0 auto';
                            errorMessage.style.marginBottom = '10px';
                            errorMessage.style.padding = '8px 16px';

                            // Insert before the submit button's parent div
                            submitButton.parentElement.before(errorMessage);
                        }

                        errorMessage.textContent = message;
                    }
                });
            }
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const dateSelect = document.getElementById("selected_date");
            const quantitySelects = document.querySelectorAll("[id$='_quantity']");

            function updateQuantityOptions() {
                const selectedOption = dateSelect.options[dateSelect.selectedIndex];
                const capacity = selectedOption.getAttribute("data-capacity") || 526; // Default 526 if not found

                quantitySelects.forEach(select => {
                    if (select.id === "9_quantity" || select.id === "10_quantity") {
                        return; // Skip updating 9_quantity and 10_quantity
                    }

                    select.innerHTML = ""; // Clear existing options

                    for (let i = 0; i <= capacity; i++) {
                        let option = document.createElement("option");
                        option.value = i;
                        option.textContent = i;
                        select.appendChild(option);
                    }
                });
            }

            // Initial load
            updateQuantityOptions();

            // Update when date changes
            dateSelect.addEventListener("change", updateQuantityOptions);
        });
    </script>
</x-form-layout>
