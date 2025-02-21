<x-form-layout :footerBg="request()->routeIs('form.chermin') ? 'bg-[#F6F5EE]' : 'bg-[#F6F5EE]'" :bodyBg="request()->routeIs('form.chermin') ? 'bg-[#EB8B50]' : 'bg-[#F6F5EE]'" :menuBg="request()->routeIs('form.chermin') ? 'bg-[#EB8B50]' : 'bg-[#F6F5EE]'" :menuItemBg="request()->routeIs('form.chermin') ? 'bg-[#E6B537]' : 'bg-[#F6F5EE]'">
    <div class="flex flex-col justify-center items-center text-center w-full mr-0">
        <img src="{{ asset('img/arena_header.png') }}" alt="arena_header" class="w-full md:w-1/2 mx-auto">
        <span
            class="bg-[#E6B537] py-3 md:py-4 px-6 md:px-52 rounded-full mt-6 font-inria text-[#F6F5EE] text-sm md:text-md font-normal">5
            Mac 2025 sehingga 27 Mac 2025</span>
        <div class="flex flex-col rounded-tl-[160px] rounded-tr-[160px] justify-center items-center bg-[#F6F5EE] mt-6 w-full"
            id="price-list">
            <div
                class="flex flex-col md:flex-row justify-center md:justify-evenly items-center md:items-start px-8 mt-8 text-[#F6F5EE] font-semibold">
                @foreach ($prices as $pr)
                    <div
                        class="flex flex-col rounded-3xl bg-[#E6B537] {{ $pr->id == 5 ? 'py-8 px-6' : 'p-5' }} mx-6 mb-3">
                        <div class="flex flex-row justify-center">
                            <span class="text-sm content-start pt-2 md:pt-4 text-[#FEF0BE] }}">RM</span>
                            <span class="text-[35px] md:text-[55px] text-[#FEF0BE]">{{ $pr->normal_price }}</span>
                        </div>
                        <span
                            class="text-sm md:text-md uppercase tracking-widest font-normal pb-4">{{ $pr->name }}</span>

                        <span class="text-sm tracking-wide font-normal">{{ $pr->description }}</span>
                    </div>
                @endforeach
            </div>
            <div class="flex flex-col border-2 border-[#E6B537] w-full md:w-3/4 rounded-[35px] mt-6"
                id="tempah-sekarang">
                <span class="font-inria font-semibold text-lg text-slate-900 pt-4">Tempahan</span>
                <form action="{{ route('form.store') }}" method="POST">
                    @csrf
                    @method('post')
                    <div class="flex flex-col mx-auto w-full pb-4 px-4 md:px-48">
                        <span class="font-medium text-md text-start tracking-wider pb-1">Nama<span
                                class="text-red-600 pl-0.5">*</span></span>
                        <input type="text" name="nama" id="nama" class="bg-gray-50 rounded-full border-0">
                    </div>
                    <div class="flex flex-col md:flex-row justify-between mx-auto w-full pb-4 px-4 md:px-48">
                        <div class="flex flex-col w-full md:w-1/2 mr-2">
                            <span class="font-medium text-md text-start tracking-wider pb-1">No. Telefon<span
                                    class="text-red-600 pl-0.5">*</span> </span>
                            <input type="text" name="phone" id="phone"
                                class="bg-gray-50 rounded-full border-0">
                        </div>
                        <div class="flex flex-col w-full md:w-1/2">
                            <span class="font-medium text-md text-start tracking-wider pb-1">Email</span>
                            <input type="text" name="email" id="email"
                                class="bg-gray-50 rounded-full border-0">
                        </div>
                    </div>
                    <div class="flex flex-col mx-auto w-full pb-4 px-4 md:px-48">
                        <span class="font-medium text-md text-start tracking-wider pb-1">Pilihan Tarikh<span
                                class="text-red-600 pl-0.5">*</span></span>
                        <select name="selected_date" id="selected_date" class="bg-gray-50 rounded-full border-0">
                            @foreach ($dates as $dt)
                                <option value="{{ $dt->id }}">
                                    {{ \Carbon\Carbon::parse($dt->venue_date)->locale('ms_MY')->format('l, d M Y, g:i a') }}
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
                                        class="text-red-600 pl-0.5">*</span> </span>
                            </div>
                            <div class="flex flex-col w-full md:w-2/5 mr-0 md:mr-4 mb-3 md:mb-0">
                                <select name="{{ $price->id }}_quantity" id="{{ $price->id }}_quantity"
                                    class="bg-gray-50 rounded-full border-0">
                                    @for ($i = 0; $i <= 20; $i++)
                                        <option value="{{ $i }}" {{ $i == 1 ? 'selected' : '' }}>
                                            {{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="flex flex-col w-full md:w-2/5">
                                <input type="text" name="{{ $price->id . '_price' }}"
                                    id="{{ $price->id }}_price"
                                    value="{{ number_format($price->normal_price, 2) }}"
                                    data-base-price="{{ $price->normal_price }}"
                                    class="bg-gray-50 rounded-full border-0 text-center" readonly>
                            </div>
                        </div>
                    @endforeach

                    <div
                        class="flex flex-col md:flex-row justify-between items-center mx-auto w-full pb-4 px-4 md:px-48">
                        <div class="flex flex-col w-full md:w-1/5 mr-4">
                            <span class="font-medium text-md text-start tracking-wider pb-1">Baby chair?</span>
                        </div>
                        <div class="flex flex-col w-full md:w-2/5 mr-0 md:mr-4 mb-3 md:mb-0">
                            <select name="baby_chair" id="baby_chair" class="bg-gray-50 rounded-full border-0">
                                @for ($i = 0; $i <= 15; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="flex flex-col w-full md:w-2/5">
                            <input type="text" name="bchair_price" id="bchair_price" value="FOC"
                                class="bg-gray-50 rounded-full border-0 text-center" readonly>
                        </div>
                    </div>

                    <div class="flex flex-row justify-end items-center mx-auto w-full pb-4 px-4 md:px-48">
                        <span class="font-medium text-md text-end tracking-wider pb-1 w-3/5">Subtotal</span>
                        <input type="text" name="subtotal" id="subtotal" value="0.00"
                            class="bg-gray-50 rounded-full border-0 w-2/5 ml-8 text-center" readonly>
                    </div>
                    <div class="flex flex-row justify-end items-center mx-auto w-full pb-4 px-4 md:px-48">
                        <input type="submit" value="Bayar Sekarang"
                            class="font-medium text-md text-center tracking-wider bg-gray-50 rounded-full border-0 px-4 py-2 w-full md:w-1/2">
                    </div>
                </form>
            </div>
            <div class="flex flex-col md:flex-row justify-evenly w-full md:w-1/2 mx-auto items-center bg-[#E6B537] text-[#F6F5EE] rounded-3xl py-4 my-6 px-6"
                id="hubungi-kami">
                <div class="flex flex-col w-full justify-start px-4">
                    <span class="font-inria font-medium text-md pt-2 text-start">Hubungi Kami</span>
                    <div class="flex flex-col md:flex-row justify-start items-start md:items-center pt-3">
                        <div class="flex flex-col mr-4">
                            <span class="font-medium text-sm text-start tracking-wider pt-2">Myra</span>
                            <a href="https://api.whatsapp.com/send?phone=60123456789&text=Buffet%20Arena"
                                class="font-normal text-sm tracking-wider pt-2">+6012 345
                                6789
                            </a>
                            <span class="font-medium text-sm text-start tracking-wider pt-2">Myra</span>
                            <a href="https://api.whatsapp.com/send?phone=60123456789&text=Buffet%20Arena"
                                class="font-normal text-sm tracking-wider pt-2">+6012 345
                                6789
                            </a>
                        </div>
                        <div class="flex flex-col mr-4">
                            <span class="font-medium text-sm text-start tracking-wider pt-2">Myra</span>
                            <a href="https://api.whatsapp.com/send?phone=60123456789&text=Buffet%20Arena"
                                class="font-normal text-sm tracking-wider pt-2">+6012 345
                                6789
                            </a>
                            <span class="font-medium text-sm text-start tracking-wider pt-2">Myra</span>
                            <a href="https://api.whatsapp.com/send?phone=60123456789&text=Buffet%20Arena"
                                class="font-normal text-sm tracking-wider pt-2">+6012 345
                                6789
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
                            <a href=""><img src="{{ asset('img/gmaps.png') }}" alt="google maps"
                                    class="w-[100px]"></a>
                            <a href=""><img src="{{ asset('img/waze.png') }}" alt="waze"
                                    class="w-[100px]"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-form-layout>
