<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice {{ $booking->booking_no }} — {{ config('app.name') }}</title>
    @php
        $navy   = '#16295c';
        $labelbg = '#c7d3ea';
        $fmt = fn ($n) => rtrim(rtrim(number_format((float) $n, 2), '0'), '.');
        $total = (float) $booking->fare_amount;
        $received = $booking->payment_status === 'paid' ? $total : 0;
        $remaining = $total - $received;
        $routeText = $booking->pickup_location . ($booking->dropoff_location ? ' → ' . $booking->dropoff_location : '');
        [$startDate, $endDate] = $booking->tripDateRange();
        $logoSrc = $pdf ? 'data:image/png;base64,' . base64_encode(file_get_contents(public_path('logo.png'))) : asset('logo.png');
    @endphp
    <style>
        * { box-sizing: border-box; }
        @page { margin: 16px; }
        body { font-family: 'DejaVu Sans', Arial, sans-serif; color: #16295c; font-size: 12px; margin: 0; padding: 0; background: #e9edf4; }
        .sheet { width: 780px; max-width: 100%; margin: 0 auto; background: #fff; padding: 18px; }
        @media screen { .sheet { margin: 20px auto; box-shadow: 0 10px 40px rgba(0,0,0,.15); } }

        table { width: 100%; border-collapse: collapse; }

        /* header */
        .top td { vertical-align: middle; }
        .top .title { text-align: center; font-size: 30px; font-weight: bold; letter-spacing: 1px; color: #16295c; }
        .top .logo { text-align: right; }
        .top .logo img { height: 62px; }
        .top .qr { text-align: left; }
        .top .qr img { height: 66px; width: 66px; }
        .top .qr div { font-size: 8px; color: #667; margin-top: 2px; }

        .bar { background: #16295c; color: #fff; font-weight: bold; padding: 7px 12px; }
        .bar td { color: #fff; }
        .bar-center { background: #16295c; color: #fff; font-weight: bold; text-align: center; padding: 6px 12px; font-size: 12px; }

        /* info grid */
        .info { border: 1px solid #16295c; margin-top: 10px; }
        .info td { border: 1px solid #16295c; padding: 6px 9px; height: 24px; }
        .info .lbl { font-weight: bold; background: #fff; width: 130px; }
        .info .lbl-b { font-weight: bold; background: #c7d3ea; width: 130px; }
        .info .val { color: #16295c; }

        /* route table */
        .rt { margin-top: 12px; border: 1px solid #16295c; }
        .rt th { background: #16295c; color: #fff; padding: 7px 9px; text-align: left; font-size: 11px; }
        .rt td { border: 1px solid #16295c; padding: 7px 9px; }
        .rates-note { text-align: center; font-weight: bold; font-size: 16px; color: #16295c; vertical-align: middle; }
        .tot-label { background: #c7d3ea; font-weight: bold; }
        .tot-val { text-align: right; font-weight: bold; }
        .remaining { background: #fff34d; }

        .foot { background: #16295c; color: #fff; text-align: center; font-weight: bold; padding: 9px; margin-top: 12px; letter-spacing: .5px; }

        /* web-only toolbar */
        .toolbar { width: 780px; max-width: 100%; margin: 18px auto 0; text-align: right; }
        .toolbar a, .toolbar button { display: inline-block; padding: 9px 14px; margin-left: 8px; border: 0; border-radius: 8px; font-size: 13px; font-weight: 700; cursor: pointer; text-decoration: none; font-family: inherit; }
        .btn-pdf { background: #16295c; color: #fff; }
        .btn-wa { background: #25d366; color: #fff; }
        .btn-print, .btn-copy { background: #e5e7eb; color: #333; }
        @media print { .toolbar { display: none; } body { background: #fff; } .sheet { box-shadow: none; margin: 0; width: 100%; } }
    </style>
</head>
<body>
@if (! $pdf)
    <div class="toolbar">
        <a class="btn-pdf" href="{{ route('booking.invoice.download', $booking->booking_no) }}">⬇ Download PDF</a>
        <button class="btn-print" onclick="window.print()">🖨 Print</button>
        <a class="btn-wa" target="_blank"
           href="https://wa.me/?text={{ urlencode('Invoice ' . $booking->booking_no . ' — ' . config('app.name') . ': ' . route('booking.invoice', $booking->booking_no)) }}">Share on WhatsApp</a>
        <button class="btn-copy" onclick="navigator.clipboard.writeText('{{ route('booking.invoice', $booking->booking_no) }}').then(()=>{this.textContent='✓ Link copied';})">🔗 Copy link</button>
    </div>
@endif

<div class="sheet">

    {{-- Header --}}
    <table class="top">
        <tr>
            <td class="qr" style="width:22%">
                <img src="{{ $qr }}" alt="Scan for booking details">
                <div>Scan for booking details</div>
            </td>
            <td class="title" style="width:56%">MAKHAH TAXI</td>
            <td class="logo" style="width:22%"><img src="{{ $logoSrc }}" alt="Makhah Taxi"></td>
        </tr>
    </table>

    {{-- Contact bars --}}
    <table style="margin-top:8px">
        <tr class="bar">
            <td style="text-align:left">Whatsapp : +966564921220</td>
            <td style="text-align:right">www.makhahtaxi.com</td>
        </tr>
    </table>
    <div class="bar-center" style="margin-top:2px">Other Whatsapp Numbers: +923288222231 / +923054450399 / +923342306330</div>

    {{-- Customer / booking info --}}
    <table class="info">
        <tr>
            <td class="lbl">Mr. / Mrs</td><td class="val">{{ $booking->name }}</td>
            <td class="lbl-b">Invoice No</td><td class="val">{{ $booking->booking_no }}</td>
        </tr>
        <tr>
            <td class="lbl">Cell No</td><td class="val">{{ $booking->phone }}</td>
            <td class="lbl-b">Booking Date</td><td class="val">{{ $booking->created_at?->format('Y-m-d') }}</td>
        </tr>
        <tr>
            <td class="lbl">Landline</td><td class="val"></td>
            <td class="lbl-b">Reference</td><td class="val">{{ $booking->email }}</td>
        </tr>
        <tr>
            <td class="lbl">Nationality</td><td class="val">{{ $booking->nationality }}</td>
            <td class="lbl-b">Company Name</td><td class="val"></td>
        </tr>
        <tr>
            <td class="lbl">Start Trip Date</td><td class="val">{{ $startDate }}</td>
            <td class="lbl-b">Bill</td><td class="val">{{ ucfirst($booking->payment_status) }}</td>
        </tr>
        <tr>
            <td class="lbl">End Trip Date</td><td class="val">{{ $endDate }}</td>
            <td colspan="2" rowspan="9"></td>
        </tr>
        <tr><td class="lbl">No of Pax</td><td class="val">{{ $booking->passengers }}</td></tr>
        <tr><td class="lbl">Arrival Details</td><td class="val">{{ $booking->pickup_location }}</td></tr>
        <tr><td class="lbl">Departure Details</td><td class="val">{{ $booking->dropoff_location }}</td></tr>
        <tr><td class="lbl">Makkah Hotels</td><td class="val"></td></tr>
        <tr><td class="lbl">Medina Hotels</td><td class="val"></td></tr>
        <tr><td class="lbl">Jeddah Hotels</td><td class="val"></td></tr>
        <tr><td class="lbl">Taif hotels</td><td class="val"></td></tr>
        <tr><td class="lbl">Note</td><td class="val">{{ $booking->notes }}</td></tr>
    </table>

    {{-- Route details --}}
    <div class="bar-center" style="margin-top:12px">Route Details</div>
    <table class="rt">
        <tr>
            <th style="width:12%">Date</th>
            <th style="width:10%">Time</th>
            <th>Route</th>
            <th style="width:16%">Vehicle</th>
            <th style="width:8%">Qty</th>
            <th style="width:14%">Amount</th>
        </tr>
        @foreach ($booking->routeRows() as $row)
        <tr>
            <td>{{ $row['date'] }}</td>
            <td>{{ $row['time'] }}</td>
            <td>{{ $row['route'] }}</td>
            <td>{{ $row['vehicle'] }}</td>
            <td>{{ $row['qty'] }}</td>
            <td style="text-align:right">{{ $fmt($row['amount']) }}</td>
        </tr>
        @endforeach
        <tr>
            <td colspan="3" rowspan="3" class="rates-note">All Rates are in Saudi Riyals</td>
            <td colspan="2" class="tot-label">Total Amount</td>
            <td class="tot-val">{{ $fmt($total) }}</td>
        </tr>
        <tr>
            <td colspan="2" class="tot-label">Received Amount</td>
            <td class="tot-val">{{ $fmt($received) }}</td>
        </tr>
        <tr>
            <td colspan="2" class="tot-label">Remaining Amount</td>
            <td class="tot-val remaining">{{ $fmt($remaining) }}</td>
        </tr>
    </table>

    <div class="foot">Thank You for Choosing Us</div>
</div>
</body>
</html>
