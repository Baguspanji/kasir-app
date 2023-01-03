<?php

namespace App\Http\Controllers;

use App\Models\Item;
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
        return view('item.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'unit' => 'required|string',
            'take_price' => 'required|numeric',
            'price' => 'required|numeric',
        ]);

        $dataCreated = array_merge($request->all(), [
            'app_id' => Auth::user()->app_id,
            'unit' => $request->per_unit . '/' . $request->unit,
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
        $post = Item::where([
            'id' => $id,
            'app_id' => Auth::user()->app_id,
        ])->first();

        $explode = explode('/', $post->unit);

        $post->per_unit = count($explode) < 1 ? $explode[0] : 1;
        $post->unit = count($explode) < 1 ? $explode[1] : $post->unit;

        return view('item.form', compact('post'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'unit' => 'required|string',
            'take_price' => 'required|numeric',
            'price' => 'required|numeric',
        ]);

        $data = Item::where([
            'id' => $id,
            'app_id' => Auth::user()->app_id,
        ])->first();

        $dataEdited = array_merge($request->all(), [
            'unit' => $request->per_unit . '/' . $request->unit,
        ]);

        $data->update($dataEdited);

        Session::flash('success', 'Berhasil update data!');
        return redirect()->route('item.index');
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
