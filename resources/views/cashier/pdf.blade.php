<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nota Transaksi</title>

    <link href="{{ asset('assets/fonts/fake-receipt/Fake Receipt Regular.ttf') }}" rel="stylesheet">

    <?php
    $style = '
                        <style>
                            * {
                                font-family: "Fake Receipt", sans-serif;
                                color: black;
                                font-weight: bold;
                            }
                            p {
                                display: block;
                                margin: 3px;
                                font-size: 9pt;
                            }
                            table td {
                                font-size: 8pt;
                            }
                            .text-center {
                                text-align: center;
                            }
                            .text-right {
                                text-align: right;
                            }
                            @media print {
                                @page {
                                    margin: 2px;
                                    size: 7cm
                        ';

    $style .= !empty($_COOKIE['innerHeight']) ? $_COOKIE['innerHeight'] . 'mm; }' : '}';

    $style .= '
                                    html, body {
                                        width: 7cm;
                                    }
                                    .btn-print {
                                        display: none;
                                    }
                                }
                            </style>
                            ';
    ?>

    {!! $style !!}
</head>

<body onload="window.print()" style="width: 7cm;">
    <button class="btn-print" style="position: absolute; right: 1rem; top: rem;" onclick="window.print()">Print</button>
    <div class="text-center">
        <h3 style="margin-bottom: 5px;">{{ strtoupper($app->name ?? config('app.name')) }}</h3>
        <p>{{ $app->address }}</p>
        <p>{{ $app->phone }}</p>
    </div>
    <br>
    <div>
        <p style="float: left;">{{ tanggalDate(date('Y-m-d')) }}</p>
        <p style="float: right">{{ strtoupper(auth()->user()->name) }}</p>
    </div>
    <div class="clear-both" style="clear: both;"></div>
    <p>Nama : {{ $item->name ?? '-' }}</p>
    <p class="text-center">===================================</p>

    <br>
    <table width="100%" style="border: 0;">
        @foreach ($item->details as $detail)
            <tr>
                <td colspan="3">{{ $detail->item->name }}</td>
            </tr>
            <tr>
                <td>{{ $detail->quantity }} x {{ rupiah($detail->price) }}</td>
                <td></td>
                <td class="text-right">{{ rupiah($detail->quantity * $detail->price) }}</td>
            </tr>
        @endforeach
    </table>
    <p class="text-center">-----------------------------------</p>

    <table width="100%" style="border: 0;">
        <tr>
            <td>Total Harga : </td>
            <td class="text-right">{{ rupiah($item->total_price) }}</td>
        </tr>
        {{-- <tr>
            <td>Total Item:</td>
            <td class="text-right">{{ rupiah($item->total_take_price) }}</td>
        </tr>
        <tr>
            <td>Diskon:</td>
            <td class="text-right">{{ rupiah($order->discount) }}</td>
        </tr>
        <tr>
            <td>Total Bayar:</td>
            <td class="text-right">{{ rupiah($order->total_price - $order->discount) }}</td>
        </tr> --}}
        <tr>
            <td>Diterima : </td>
            <td class="text-right">{{ rupiah($item->amount_paid) }}</td>
        </tr>
        <tr>
            <td>Kembali : </td>
            <td class="text-right">{{ rupiah($item->amount_paid - $item->total_price) }}</td>
        </tr>
    </table>

    <p class="text-center">===================================</p>
    <p class="text-center">-- TERIMA KASIH --</p>

    <script>
        let body = document.body;
        let html = document.documentElement;
        let height = Math.max(
            body.scrollHeight, body.offsetHeight,
            html.clientHeight, html.scrollHeight, html.offsetHeight
        );
        document.cookie = "innerHeight=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        // document.cookie = "innerHeight="+ ((height + 50) * 0.264583);
    </script>
</body>

</html>
