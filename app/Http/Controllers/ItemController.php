<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
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

        if ($request['type'] == 'sell') {
            $itemData = Item::where([
                'app_id' => Auth::user()->app_id,
                'type' => $request['type'],
            ])
                ->orderBy('created_at', 'desc')
                ->get();

            $items = Item::where([
                'app_id' => Auth::user()->app_id,
                'type' => 'storage',
            ])->get();

            $datas = [];
            foreach ($itemData as $data) {
                $details = [];
                foreach ($data->needs as $need) {
                    foreach ($items as $value) {
                        if ($need['item_id'] == $value->id) {
                            $value->quantity = $need['quantity'];
                            $details[] = $value;
                        }
                    }
                }

                $data->details = $details;
                $datas[] = $data;
            }
        } elseif ($request['type'] == 'storage') {
            $itemData = Item::with(['cost_shops', 'transaction_detail_items'])
                ->where([
                    'app_id' => Auth::user()->app_id,
                    'type' => $request['type'],
                ])
                ->orderBy('created_at', 'desc')
                ->get();

            $datas = [];
            foreach ($itemData as $data) {
                $stock = 0;
                foreach ($data->cost_shops as $cost) {
                    $stock += $cost->quantity;
                }

                foreach ($data->transaction_detail_items as $cost) {
                    $stock -= $cost->quantity;
                }

                $data->stock = $stock;
                $datas[] = $data;
            }
        }

        return view('item.index', compact('datas', 'request'));
    }

    public function ajax()
    {
        $datas = Item::where([
            'app_id' => Auth::user()->app_id,
            'type' => 'sell',
            'status' => true,
        ])
            ->orderBy('name', 'asc')
            ->get();

        return response()->json([
            'data' => $datas,
        ]);
    }

    public function ajaxById($id)
    {
        $data = Item::where([
            'id' => $id,
            'app_id' => Auth::user()->app_id,
        ])
            ->first();

        return response()->json([
            'data' => $data,
        ]);
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

        $dataCreated = array_merge($request->all(), [
            'app_id' => Auth::user()->app_id,
        ]);

        if (isset($request->item_details)) {
            $item_details = [];
            foreach ($request->item_details as $key => $value) {
                $item_details[] = [
                    'item_id' => $value,
                    'quantity' => $request->quantity_details[$key],
                ];
            }

            $dataCreated = array_merge($dataCreated, [
                'needs' => $item_details,
            ]);
        }

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
        $request = [
            'type' => request()->type ?? 'sell',
        ];

        $post = Item::where([
            'id' => $id,
            'app_id' => Auth::user()->app_id,
        ])->first();

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

        $details = [];
        foreach ($post->needs as $value) {
            foreach ($items as $key => $item) {
                if ($item->id == $value['item_id']) {
                    $item->quantity = $value['quantity'];
                    $details[] = $item;
                }
            }
        }

        $post->details = $details;

        return view('item.form', compact('request', 'categories', 'items', 'post'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string',
            'unit' => 'required|in:gram,pcs',
            'price' => 'numeric',
            'type' => 'required|in:sell,storage',
        ]);

        $data = Item::where([
            'id' => $id,
            'app_id' => Auth::user()->app_id,
        ])->first();

        $dataEdited = $request->all();

        if (isset($request->item_details)) {
            $item_details = [];
            foreach ($request->item_details as $key => $value) {
                $item_details[] = [
                    'item_id' => $value,
                    'quantity' => $request->quantity_details[$key],
                ];
            }

            $dataEdited = array_merge($dataEdited, [
                'needs' => $item_details,
            ]);
        }

        $data->update($dataEdited);

        Session::flash('success', 'Berhasil update data!');
        return redirect()->route('item.index', ['type' => $request['type']]);
    }

    public function destroy($id)
    {
        //
    }

    public function status($id)
    {
        $data = Item::where([
            'id' => $id,
            'app_id' => Auth::user()->app_id,
        ])->first();
        $data->status = $data->status == 1 ? 0 : 1;
        $data->save();

        Session::flash('success', 'Berhasil mengubah data!');
        return redirect()->back();
    }
}
