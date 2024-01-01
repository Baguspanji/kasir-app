<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Share Transaksi</title>

    <style>
        @page {
            margin: 0
        }

        body {
            margin: 0;
            padding: 10px 0;
            font-size: 10px;
            font-family: monospace;
        }

        td {
            font-size: 10px;
        }

        .sheet {
            margin: 0;
            overflow: hidden;
            position: relative;
            box-sizing: border-box;
            /* page-break-after: always; */
        }

        /** Paper sizes **/
        /* body.struk .sheet {
            width: 58mm;
        } */

        table {
            /* table-layout: fixed; */
        }

        body.struk .sheet {
            padding: 2mm;
        }

        .txt-left {
            text-align: left;
        }

        .txt-center {
            text-align: center;
        }

        .txt-right {
            text-align: right;
        }
    </style>
</head>

<body class="struk">
    <section class="sheet">
        <table cellpadding="0" cellspacing="0" style="width:100%">
            <tr>
                <td align="left" colspan="3" class="txt-left">{{ auth()->user()->app->name }}</td>
            </tr>
            <tr>
                <td align="left" colspan="3" class="txt-left">{{ auth()->user()->app->address }}</td>
            </tr>
            <tr>
                <td align="left" colspan="3" class="txt-left">{{ auth()->user()->app->phone }}</td>
            </tr>
            </br>
            <tr>
                <td align="left" class="txt-left" width="70px">Tgl Trx </td>
                <td align="left" class="txt-left" width="10px">:</td>
                <td align="left" class="txt-left"> {{ $data->date }}</td>
            </tr>
            <tr>
                <td align="left" class="txt-left" width="70px">Jml Jns Brg </td>
                <td align="left" class="txt-left" width="10px">:</td>
                <td align="left" class="txt-left"> {{ count($data->details) }}</td>
            </tr>
            <tr>
                <td align="left" class="txt-left" width="70px">Pembeli </td>
                <td align="left" class="txt-left" width="10px">:</td>
                <td align="left" class="txt-left"> {{ $data->name ?? '-' }}</td>
            </tr>
        </table>
        <br />
        <table cellpadding="0" cellspacing="0" style="width:100%">
            <tr>
                <td align="left" colspan="2" class="txt-left">{{ str_repeat('=', 38) }}</td>
            </tr>
            @foreach ($data->details as $item)
                <tr>
                    <td align="left" colspan="2" class="txt-left">{{ $item->item->name }}</td>
                </tr>
                <tr>
                    @php
                        $unit = explode('/', $item->item->unit);
                        $per = (float) ($unit[0] ?? 1);
                        $satuan = $unit[1] ?? '';
                    @endphp
                    <td class="txt-left" align="left">
                        {{ $per * $item->quantity }} {{ $satuan }} x
                        {{ ltrim(rupiah($item->price), 'Rp ') }}
                    </td>
                    <td class="txt-right" align="right">{{ ltrim(rupiah($item->price * $item->quantity), 'Rp ') }}
                    </td>
                </tr>
            @endforeach
        </table>
        <table cellpadding="0" cellspacing="0" style="width:100%">
            <tr>
                <td align="left" colspan="2" class="txt-left">{{ str_repeat('=', 38) }}</td>
            </tr>
            <tr>
                <td class="txt-left" align="left">Total</td>
                <td class="txt-right" align="right">{{ rupiah($data->total_price) }}</td>
            </tr>
            <tr>
                <td class="txt-left" align="left">Bayar</td>
                <td class="txt-right" align="right">{{ rupiah($data->amount_paid) }}</td>
            </tr>
            <tr>
                <td class="txt-left" align="left">Kembali</td>
                <td class="txt-right" align="right">
                    {{ rupiah($data->amount_paid == 0 ? 0 : $data->amount_paid - $data->total_price) }}
                </td>
            </tr>
            </br>
            <tr>
                <td align="center" colspan="2" class="txt-center">{{ auth()->user()->app->open_time }}</td>
            </tr>
            <tr>
                <td align="center" colspan="2" class="txt-center">* Terima kasih atas kunjungan anda *</td>
            </tr>
            <tr>
                <td align="center" colspan="2" class="txt-center">
                    {{ nama_hari(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->format('Y-m-d')) }},
                    {{ tanggal($data->created_at) }}
                </td>
            </tr>
        </table>
    </section>

</body>

</html>
