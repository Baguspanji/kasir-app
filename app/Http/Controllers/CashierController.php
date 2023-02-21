<?php

namespace App\Http\Controllers;

use App\Models\App;
use App\Models\Item;
use App\Models\Transaction;
use App\Helpers\ReceiptPrinter\ReceiptPrinter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CashierController extends Controller
{
    public function index()
    {
        return view('cashier.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        // ajax check

        if (!$request->ajax()) {
            return [
                'status' => false,
                'message' => 'Forbidden',
            ];
        }

        $request->validate([
            'quantity' => 'required|array',
            'price' => 'required|array',
            'id' => 'required|array',
        ]);

        $items = Item::where([
            'app_id' => Auth::user()->app_id,
        ])
            ->whereIn('id', $request->id)
            ->get();

        $total_take_price = 0;
        $total_price = 0;
        $transaction = Transaction::create([
            'app_id' => Auth::user()->app_id,
            'name' => $request->name,
            'total_take_price' => $total_take_price,
            'total_price' => $total_price,
            'amount_paid' => $request->amount_paid ?? 0,
            'date' => now()->format('Y-m-d'),
            'created_by' => Auth::user()->name,
        ]);

        foreach ($items as $value) {
            $key = array_search($value->id, $request->id);

            $total_take_price += $value->take_price * $request->quantity[$key];
            $total_price += $value->price * $request->quantity[$key];

            $detailCreated[] = [
                'app_id' => Auth::user()->app_id,
                'transaction_id' => $transaction->id,
                'take_price' => $value->take_price,
                'price' => $request->price[$key],
                'item_id' => $value->id,
                'quantity' => $request->quantity[$key],
                'created_at' => now(),
            ];
        }

        $transaction->update([
            'total_take_price' => $total_take_price,
            'total_price' => $total_price,
        ]);

        $transaction->details()->createMany($detailCreated);

        return [
            'status' => true,
            'message' => 'Transaksi berhasil',
            'data' => $transaction->id,
        ];

        // $this->print($transaction->id);
        // return redirect()->route('cashier.index', 'transaction=' . $transaction->id);
    }

    public function show($id)
    {
        $app = App::where([
            'id' => Auth::user()->app_id,
        ])->first();

        $item = Transaction::with([
            'details',
            'details.item',
        ])
            ->Where([
                'app_id' => Auth::user()->app_id,
                'id' => $id,
            ])->first();

        return view('cashier.pdf', compact('item', 'app'));

        // $pdf = PDF::loadView('cashier.pdf', compact('item', 'app'));
        // $pdf->setPaper(0, 0, 609, 440, 'potrait');
        // return $pdf->stream('Transaksi-' . date('Y-m-d-his') . '.pdf');
    }

    public function print($id)
    {
        $app = App::where([
            'id' => Auth::user()->app_id,
        ])->first();

        $item = Transaction::with([
            'details',
            'details.item',
        ])
            ->Where([
                'app_id' => Auth::user()->app_id,
                'id' => $id,
            ])->first();

        $store_name = $app->name;
        $store_address = $app->address;
        $store_phone = $app->phone;
        $store_email = '';
        $store_website = '';
        $buyer_name = $item->name;
        $currency = 'Rp ';
        $tax_percentage = 0;
        $image_path = 'logo.png';
        $amount_paid = $item->amount_paid;
        $total_price = $item->total_price;

        $sendToPrint =  [
            'store_name' => $store_name,
            'store_address' => $store_address,
            'store_phone' => $store_phone,
            'store_email' => $store_email,
            'store_website' => $store_website,
            'buyer_name' => $buyer_name,
            'currency' => $currency,
            'tax_percentage' => $tax_percentage,
            'image_path' => $image_path,
            'amount_paid' => $amount_paid,
            'total_price' => $total_price,
            'items' => array_map(function ($item) {
                return [
                    'name' => $item['item']['name'],
                    'unit' => $item['item']['unit'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ];
            }, $item->details->toArray()),
        ];

        return [
            'status' => 'success',
            'data' => $sendToPrint,
        ];

        // curl localhost 8005
        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, 'http://localhost:8005');
        // curl_setopt($ch, CURLOPT_POST, 1);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($sendToPrint));
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // $server_output = curl_exec($ch);
        // curl_close($ch);

        // return $server_output;
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
