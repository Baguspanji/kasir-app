<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\TransactionDetailItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CashierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cashier.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'quantity' => 'required|array',
            'price' => 'required|array',
            'id' => 'required|array',
        ]);

        $items = Item::where([
            'app_id' => Auth::user()->app_id,
        ])->get();

        $price = 0;
        $transaction = Transaction::create([
            'app_id' => Auth::user()->app_id,
            'name' => $request->name,
            'price' => $price,
            'date' => now()->format('Y-m-d'),
            'created_by' => Auth::user()->name,
        ]);

        foreach ($request->price as $key => $value) {
            $price += $value;

            $detail = TransactionDetail::create([
                'app_id' => Auth::user()->app_id,
                'transaction_id' => $transaction->id,
                'price' => $value,
                'item_id' => $request->id[$key],
                'quantity' => $request->quantity[$key],
            ]);

            $needs = [];
            foreach ($items as $data) {
                if ($data->id == $request->id[$key]) {
                    foreach ($data->needs as $need) {
                        $needs[] = [
                            'transaction_detail_id' => $detail->id,
                            'quantity' => $need['quantity'] * $request->quantity[$key],
                            'item_id' => $need['item_id'],
                            'created_at' => now(),
                        ];
                    }
                }
            }

            TransactionDetailItem::insert($needs);
        }

        $transaction->update(['price' => $price]);

        return redirect()->route('cashier.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
