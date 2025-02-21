<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Buffet Ramadhan 2025</title>
    @vite(['resources/js/app.js', 'resources/css/app.css'])
</head>
@props([
    'footerBg' => 'bg-slate-100',
    'bodyBg' => 'bg-slate-100',
    'menuBg' => 'bg-slate-100',
    'menuItemBg' => 'bg-slate-600',
])

<body class="font-inter antialiased {{ $bodyBg }}">
    <nav class="mt-4">
        <div class="max-w-screen-xl flex flex-wrap items-center md:justify-center mx-auto p-4">
            <div class="flex md:order-2 justify-start">
                <button data-collapse-toggle="navbar-search" type="button"
                    class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-slate-950 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200"
                    aria-controls="navbar-search" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 17 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M1 1h15M1 7h15M1 13h15" />
                    </svg>
                </button>
            </div>
            <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-search">
                <ul
                    class="flex flex-col p-4 md:p-0 font-normal text-sm border border-gray-100 rounded-lg {{ $menuBg }} md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0">
                    <li>
                        <a href="#price-list"
                            class="block py-2 px-3 text-[#F6F5EE] rounded-sm md:bg-transparent md:text-[#F6F5EE] md:py-2"
                            aria-current="page">Lihat Harga</a>
                    </li>
                    <li>
                        <a href="#tempah-sekarang"
                            class="block py-2 px-3 text-[#F6F5EE] {{ $menuItemBg }} bg-opacity-60 rounded-full hover:bg-gray-100 md:hover:bg-transparent md:hover:bg-[#DAB666] md:hover:bg-opacity-60 md:hover:font-medium md:py-2">Tempah
                            Sekarang</a>
                    </li>
                    <li>
                        <a href="#hubungi-kami"
                            class="block py-2 px-3 text-[#F6F5EE] rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:hover:text-[#F6F5EE] md:py-2">Hubungi
                            Kami</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="flex w-auto justify-center items-center">
        {{ $slot }}
    </div>
    <footer class="flex flex-row justify-center items-center {{ $footerBg }} py-2 mx-auto">
        <span class="font-light text-xs text-slate-400">made by ans, 2025.</span>
    </footer>
</body>

</html>
