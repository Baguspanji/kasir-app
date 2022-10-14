<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use App\Models\ItemDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ItemController extends Controller
{
    public function index()
    {
        $request = [
            'type' => request()->type ?? 'sell',
        ];

        $datas = Item::with([
            'details',
        ])
            ->where([
                'app_id' => Auth::user()->app_id,
                'type' => $request['type'],
            ])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('item.index', compact('datas', 'request'));
    }

    public function create()
    {
        $request = [
            'type' => request()->type ?? 'sell',
        ];

        $items = [];
        if ($request['type'] == 'sell') {
            $items = Item::where([
                'app_id' => Auth::user()->app_id,
                'type' => 'storage',
            ])
                ->orderBy('name', 'asc')
                ->get();
        }

        $categories = Category::where([
            'app_id' => Auth::user()->app_id,
        ])
            ->orderBy('name', 'asc')
            ->get();

        return view('item.form', compact('request', 'categories', 'items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string',
            'unit' => 'required|in:gram,pcs',
            'price' => 'numeric',
            'type' => 'required|in:sell,storage',
        ]);

        $item_details = [];
        foreach ($request->item_details as $key => $value) {
            $item_details[] = [
                'app_id' => Auth::user()->app_id,
                'item_id' => $value,
                'needs' => $request->quantity_details[$key],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        $dataCreated = array_merge($request->all(), [
            'app_id' => Auth::user()->app_id,
            'item_details' => $item_details,
        ]);

        ItemDetail::insert($item_details);
        Item::create($dataCreated);

        Session::flash('success', 'Berhasil membuat data!');
        return redirect()->route('item.index', ['type' => $request['type']]);
    }

    public function show($id)
    {
        //
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
