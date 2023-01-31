<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ItemController extends Controller
{
    public function index()
    {
        $datas = Item::where([
            'app_id' => Auth::user()->app_id,
        ])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('item.index', compact('datas'));
    }

    public function ajax()
    {
        $datas = Item::where([
            'app_id' => Auth::user()->app_id,
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
        $units = Unit::where([
            'app_id' => Auth::user()->app_id,
            'status' => true,
        ])->get();

        return view('item.form', compact('units'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code_1' => 'nullable|string',
            'code_2' => 'nullable|string',
            'code_3' => 'nullable|string',
            'code_4' => 'nullable|string',
            'code_5' => 'nullable|string',
            'code_6' => 'nullable|string',
            'code_7' => 'nullable|string',
            'code_8' => 'nullable|string',
            'code_9' => 'nullable|string',
            'code_10' => 'nullable|string',
            'name' => 'required|string',
            'description' => 'nullable|string',
            'unit' => 'required|string',
            'take_price' => 'required|numeric',
            'price' => 'required|numeric',
        ]);

        $dataCreated = array_merge($request->all(), [
            'app_id' => Auth::user()->app_id,
            'unit' => ($request->per_unit ?? '1') . '/' . strtolower($request->unit),
        ]);

        Item::create($dataCreated);

        Session::flash('success', 'Berhasil membuat data!');
        return redirect()->route('item.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $units = Unit::where([
            'app_id' => Auth::user()->app_id,
            'status' => true,
        ])->get();

        $post = Item::where([
            'id' => $id,
            'app_id' => Auth::user()->app_id,
        ])->first();

        $explode = explode('/', $post->unit);

        $post->per_unit = count($explode) > 1 ? $explode[0] : 1;
        $post->unit = count($explode) > 1 ? $explode[1] : $post->unit;

        return view('item.form', compact('post', 'units'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'code_1' => 'nullable|string',
            'code_2' => 'nullable|string',
            'code_3' => 'nullable|string',
            'code_4' => 'nullable|string',
            'code_5' => 'nullable|string',
            'code_6' => 'nullable|string',
            'code_7' => 'nullable|string',
            'code_8' => 'nullable|string',
            'code_9' => 'nullable|string',
            'code_10' => 'nullable|string',
            'name' => 'required|string',
            'description' => 'nullable|string',
            'unit' => 'required|string',
            'take_price' => 'required|numeric',
            'price' => 'required|numeric',
        ]);

        $data = Item::where([
            'id' => $id,
            'app_id' => Auth::user()->app_id,
        ])->first();

        $dataEdited = array_merge($request->all(), [
            'unit' => ($request->per_unit ?? '1') . '/' . strtolower($request->unit),
        ]);

        $data->update($dataEdited);

        Session::flash('success', 'Berhasil update data!');
        return redirect()->route('item.index');
    }

    public function destroy($id)
    {
        $item = Item::where([
            'id' => $id,
            'app_id' => Auth::user()->app_id,
        ])->first();

        $transactions = $item->load('transaction_detail')->transaction_detail;
        if ($transactions->count() > 0) {
            Session::flash('error', 'Item memiliki transakasi!');
            return redirect()->back();
        } else {
            $item->delete();
            Session::flash('success', 'Berhasil menghapus data!');
            return redirect()->back();
        }
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
