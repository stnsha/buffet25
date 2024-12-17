<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Buffet 2025</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="flex flex-col w-auto mx-38 px-auto bg-blue-100">
        <span class="text-lg text-center">Buffet Ramadhan 2025 by Cahya Mata Catering (CMC)</span>
        <div class="flex flex-col w-auto mx-32">
            <form action="" method="post">
                @csrf
                @method('post')
                <div class="flex flex-col">
                    <span>Nama</span>
                    <input type="text" name="nama" required>
                </div>
                <div class="flex flex-col">
                    <span>Syarikat/Organisasi</span>
                    <input type="text" name="nama">
                </div>
                <div class="flex flex-col">
                    <span>No. Telefon</span>
                    <input type="text" name="nama" required>
                </div>
                <div class="flex flex-col">
                    <span>Email</span>
                    <input type="text" name="nama">
                </div>
                <div class="flex flex-col">
                    <span>Tempat</span>
                    <select name="tempat" id="">
                        <option value="">Dewan Arena CMC, Ujong Pasir</option>
                        <option value="">Dewan Chermin, Nilai</option>
                    </select>
                </div>
                <div class="flex flex-col">
                    <span>Tarikh Tempahan</span>
                    <select name="tarikh_tempah" id="">
                        @for ($i = 0; $i < 30; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="flex flex-col">
                    <span>Warga Emas</span>
                    <input type="text" name="nama">
                </div>
                <div class="flex flex-col">
                    <span>Dewasa</span>
                    <input type="text" name="nama">
                </div>
                <div class="flex flex-col">
                    <span>Kanak-kanak (6 tahun dan ke atas)</span>
                    <input type="text" name="nama">
                </div>
                <div class="flex flex-col">
                    <span>Kanak-kanak (5 tahun dan ke bawah)</span>
                    <input type="text" name="nama">
                </div>
                <div class="flex flex-row">
                    <span>Baby chair</span>
                    <input type="checkbox" name="baby_chair">
                </div>
            </form>
        </div>
    </div>
</body>

</html>
