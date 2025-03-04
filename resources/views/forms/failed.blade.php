<x-form-layout>
    <div class="font-inter flex flex-col w-full mx-auto justify-center items-center h-screen mb-24">
        <img src="{{ asset('img/failed.png') }}" alt="failed" class="mt-36 w-1/2 md:w-3/4">
        <div class="flex flex-col w-full">
            <div class="flex flex-col justify-center items-center">
                <span class="font-medium text-md text-center py-4">Maaf, tempahan anda tidak berjaya. Sila cuba sekali
                    lagi.</span>

                <div class="flex flex-col md:flex-row justify-evenly w-full md:w-1/2 mx-auto items-center bg-red-200 text-slate-800 rounded-3xl py-4 my-12 px-6"
                    id="hubungi-kami">
                    <div class="flex flex-col w-full justify-start px-4">
                        <span class="font-inria font-medium text-md pt-2 text-start">Hubungi Kami</span>
                        <div class="flex flex-col md:flex-row justify-start items-start md:items-center pt-3">
                            <div class="flex flex-col mr-4">
                                <span class="font-medium text-sm text-start tracking-wider pt-2">Myra</span>
                                <a href="https://api.whatsapp.com/send?phone=60194464177&text=Buffet%20Arena"
                                    class="font-normal text-sm tracking-wider pt-2 hover:text-red-800 hover:underline">+6019
                                    446 4177
                                </a>
                                <span class="font-medium text-sm text-start tracking-wider pt-2">Bella</span>
                                <a href="https://api.whatsapp.com/send?phone=60193044022&text=Buffet%20Arena"
                                    class="font-normal text-sm tracking-wider pt-2 hover:text-red-800 hover:underline">+6019
                                    304 4022
                                </a>
                            </div>
                            <div class="flex flex-col mr-4">
                                <span class="font-medium text-sm text-start tracking-wider pt-2">Linn</span>
                                <a href="https://api.whatsapp.com/send?phone=60172469492&text=Buffet%20Arena"
                                    class="font-normal text-sm tracking-wider pt-2 hover:text-red-800 hover:underline">+6017
                                    246 9492
                                </a>
                                <span class="font-medium text-sm text-start tracking-wider pt-2">Emy</span>
                                <a href="https://api.whatsapp.com/send?phone=60127844505&text=Buffet%20Arena"
                                    class="font-normal text-sm tracking-wider pt-2 hover:text-red-800 hover:underline">+6012
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
                                    Dewan Arena CMC</span>
                                <span class="font-normal text-sm text-start tracking-wide">
                                    Lot 31848 batu 2 1, 4,
                                    Jalan Sikamat,
                                    70400 Seremban,
                                    Negeri Sembilan.
                                </span>
                            </div>
                            <div class="flex flex-row justify-between items-center pt-3">
                                <a href=""><img src="{{ asset('img/gmaps.png') }}" alt="google maps"
                                        class="w-[100px]"></a>
                                <a href=""><img src="{{ asset('img/waze.png') }}" alt="waze"
                                        class="w-[100px]"></a>
                            </div>
                        </div>
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
    </div>
</x-form-layout>
