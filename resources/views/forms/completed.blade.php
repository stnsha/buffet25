<x-form-layout>
    <div class="font-inter flex flex-col w-full mx-auto justify-center items-center h-screen mb-24">
        <img src="{{ asset('img/completed.svg') }}" alt="completed" class="w-3/4">
        <div class="flex flex-col w-full">
            <div class="flex flex-col justify-center items-center">
                <span class="font-medium text-md text-center py-4">Terima kasih atas tempahan anda! Buffet Ramadan anda
                    telah
                    disahkan.</span>
                <table
                    class="flex w-auto justify-center items-start text-left border-collapse p-4 rounded-lg shadow-sm bg-indigo-200">
                    <tr>
                        <th class="font-medium text-sm pr-4">ID </th>
                        <td class="font-normal text-sm pl-4">
                            {{ $order->ref_id }}
                        </td>
                    </tr>
                    <tr>
                        <th class="font-medium text-sm pr-4">Tempat</th>
                        <td class="font-normal text-sm pl-4">
                            {{ $order->capacity->venue->name }}
                        </td>
                    </tr>
                    <tr>
                        <th class="font-medium text-sm pr-4">Tarikh</th>
                        <td class="font-normal text-sm pl-4">
                            {{ \Carbon\Carbon::parse($order->capacity->venue_date)->locale('ms_MY')->format('l, d M Y, g:i a') }}
                        </td>
                    </tr>
                </table>
                <div class="flex flex-col md:flex-row justify-evenly w-full md:w-1/2 mx-auto items-center bg-indigo-200 text-slate-800 rounded-3xl py-4 my-6 px-6"
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
                        @if ($order->capacity->venue_id == 1)
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
                        @else
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
                        @endif

                    </div>
                </div>
            </div>

        </div>
    </div>
</x-form-layout>
