<html>

<head>
    <title>Invoice #{{ $order->ref_id }}</title>
    <style>
        .location-container {
            width: 100%;
            padding: 0 16px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .location-title {
            font-family: 'Inria', sans-serif;
            font-weight: 500;
            font-size: 16px;
            padding-top: 16px;
            text-align: left;
        }

        .location-box {
            display: flex;
            flex-direction: column;
            padding-top: 12px;
            justify-content: space-between;
            align-items: flex-start;
            width: 100%;
        }

        .location-details {
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
        }

        .venue-name {
            font-weight: 600;
            font-size: 14px;
            text-align: left;
            letter-spacing: 0.05em;
        }

        .venue-address {
            font-weight: 400;
            font-size: 14px;
            text-align: left;
            letter-spacing: 0.03em;
        }

        .location-links {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            padding-top: 12px;
        }

        .map-icon {
            width: 100px;
        }

        .location-links img {
            width: 25px;
        }
    </style>
</head>

<body>
    <div
        style="max-width: 600px; margin: auto; font-family: Arial, sans-serif; padding: 20px; background-color: #f9f9f9; border-radius: 10px;">
        <h1 style="text-align: center; color: #333;">Hai {{ $order->customer->name }}!</h1>
        <p style="text-align: center; font-size: 16px; color: #555;">
            Tempahan anda untuk <strong>Buffet Ramadan</strong> di
            <strong>{{ $order->capacity->venue->name }}</strong> pada
            <strong>{{ \Carbon\Carbon::parse($order->capacity->venue_date)->locale('ms_MY')->translatedFormat('l, d M Y, g:i a') }}</strong>
            telah disahkan.
        </p>

        <div
            style="background: white; padding: 15px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);font-size:12px;">
            <h3 style="margin-bottom: 10px; color: #333;">Tempahan Anda: <span
                    style="color: #777;">{{ $order->order_number }}</span></h3>

            <table style="width: 100%; border-collapse: collapse; margin-top: 10px;">
                <tr style="background-color: #f5f5f5; text-align: left;">
                    <th style="padding: 10px; border-bottom: 1px solid #ddd;font-size:12px;">Butiran</th>
                    <th style="padding: 10px; border-bottom: 1px solid #ddd;font-size:12px;">Kuantiti</th>
                    <th style="padding: 10px; border-bottom: 1px solid #ddd;font-size:12px;">Harga</th>
                    <th style="padding: 10px; border-bottom: 1px solid #ddd;font-size:12px;">Subtotal</th>
                </tr>
                @foreach ($order->order_details as $od)
                    @if ($od->quantity != 0)
                        <tr style="border-bottom: 1px solid #ddd;font-size:12px;">
                            <td style="padding: 10px;font-size:12px;">{{ $od->hasPrice->name }}</td>
                            <td style="padding: 10px;font-size:12px;">{{ $od->quantity }}</td>
                            <td style="padding: 10px;font-size:12px;">RM{{ number_format($od->price, 2) }}</td>
                            <td style="padding: 10px;font-size:12px;">RM{{ number_format($od->subtotal, 2) }}</td>
                        </tr>
                    @endif
                @endforeach
            </table>

            <div style="margin-top: 15px; text-align: right;">
                <p><strong>Jumlah:</strong> RM{{ number_format($order->total, 2) }}</p>
            </div>
        </div>

        <div class="location-container">
            <!-- Venue 1: Dewan Arena CMC -->
            @if ($order->capacity->venue_id == 1)
                <div class="location-box">
                    <div class="location-details">
                        <span class="venue-name">Dewan Arena CMC</span>
                        <span class="venue-address">
                            Lot 31848 Batu 2 1/4, Jalan Sikamat, 70400 Seremban, Negeri Sembilan.
                        </span>
                    </div>
                    <div class="location-links">
                        <a href="https://maps.app.goo.gl/NjjdFE6aAvrjcrT39"><img
                                src="https://cahyamatacatering.com/img/gmaps.png" alt="google maps"
                                class="w-[100px]"></a>
                        <a href="https://waze.com/ul/hw22x86f1n"><img src="https://cahyamatacatering.com/img/waze.png"
                                alt="waze" class="w-[100px]"></a>
                    </div>
                </div>
            @else
                <!-- Venue 2: Dewan Chermin -->
                <div class="location-box">
                    <div class="location-details">
                        <span class="venue-name">Dewan Chermin</span>
                        <span class="venue-address">
                            4741, Jalan TS 1/19, Taman Semarak, 71800 Nilai, Negeri Sembilan
                        </span>
                    </div>
                    <div class="location-links">
                        <a href="https://maps.app.goo.gl/dEhXYa4yZkYLS2pC7"><img src="{{ asset('img/gmaps.png') }}"
                                alt="google maps" class="w-[100px]"></a>
                        <a href="https://waze.com/ul/hw22ruxv48"><img src="{{ asset('img/waze.png') }}" alt="waze"
                                class="w-[100px]"></a>
                    </div>
                </div>
            @endif
        </div>

    </div>

</body>

</html>
