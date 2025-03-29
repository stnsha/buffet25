<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Buffet 2025</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="flex flex-col items-center justify-center w-auto mx-auto h-screen bg-sky-200">
        <img src="{{ asset('img/thank-you.svg') }}" alt="thank-you" class="w-auto md:w-1/2 px-4 py-6">
    </div>
</body>

</html>
