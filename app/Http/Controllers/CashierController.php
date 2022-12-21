<?php

namespace App\Http\Controllers;

use App\Models\App;
use App\Models\Item;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
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
                'price' => $value->price,
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

        return redirect()->route('cashier.index');
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
