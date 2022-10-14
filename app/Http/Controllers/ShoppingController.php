<?php

namespace App\Http\Controllers;

use App\Models\CostShop;
use App\Models\CostShopDetail;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ShoppingController extends Controller
{
    public function index()
    {
        $datas = CostShop::with(['details', 'details.item'])
            ->where([
                'app_id' => Auth::user()->app_id,
            ])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('shopping.index', compact('datas'));
    }

    public function create()
    {
        $items = Item::where([
            'app_id' => Auth::user()->app_id,
            'type' => 'storage',
        ])
            ->orderBy('name', 'asc')
            ->get();

        return view('shopping.form', compact('items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'catedescriptiongory_id' => 'string',
            'item_details' => 'required|array',
            'quantity_details' => 'required|array',
            'price_details' => 'required|array',
        ]);

        $details = [];
        $prices = 0;
        foreach ($request->price_details as $key => $value) {
            $prices += $value;

            $details[] = [
                'app_id' => Auth::user()->app_id,
                'price' => $value,
                'item_id' => $request->item_details[$key],
                'quantity' => $request->quantity_details[$key],
                'created_at' => now(),
            ];
        }

        $dataCreated = array_merge($request->all(), [
            'app_id' => Auth::user()->app_id,
            'date' => now()->format('Y-m-d'),
            'price' => $prices,
            'details' => $details,
        ]);

        $data = CostShop::create($dataCreated);
        foreach ($details as $key => $detail) {
            $details[$key]['cost_shop_id'] = $data->id;
        }
        CostShopDetail::insert($details);

        Session::flash('success', 'Berhasil membuat data!');
        return redirect()->route('shopping.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $post = CostShop::with(['details', 'details.item'])
            ->where([
                'id' => $id,
                'app_id' => Auth::user()->app_id,
            ])
            ->orderBy('created_at', 'desc')
            ->first();

        $items = Item::where([
            'app_id' => Auth::user()->app_id,
            'type' => 'storage',
        ])
            ->orderBy('name', 'asc')
            ->get();

        return view('shopping.form', compact('items', 'post'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'catedescriptiongory_id' => 'string',
            'item_details' => 'required|array',
            'quantity_details' => 'required|array',
            'price_details' => 'required|array',
        ]);

        CostShopDetail::where([
            'cost_shop_id' => $id,
            'app_id' => Auth::user()->app_id,
        ])->delete();

        $details = [];
        $prices = 0;
        foreach ($request->price_details as $key => $value) {
            $prices += $value;

            $details[] = [
                'app_id' => Auth::user()->app_id,
                'price' => $value,
                'item_id' => $request->item_details[$key],
                'quantity' => $request->quantity_details[$key],
                'created_at' => now(),
            ];
        }

        $dataUpdate = array_merge($request->all(), [
            'price' => $prices,
            'details' => $details,
        ]);

        CostShop::where([
            'id' => $id,
            'app_id' => Auth::user()->app_id,
        ])
            ->first()
            ->update($dataUpdate);

        foreach ($details as $key => $detail) {
            $details[$key]['cost_shop_id'] = $id;
        }

        CostShopDetail::insert($details);

        Session::flash('success', 'Berhasil update data!');
        return redirect()->route('shopping.index');
    }

    public function destroy($id)
    {
        //
    }
}
