<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{
    public function index()
    {
        $status = request()->query('status') ?? true;
        $keyword = request()->query('keyword') ?? null;

        $datas = Item::where([
            'app_id' => Auth::user()->app_id,
            'status' => $status,
        ])->when(!is_null($keyword),
            fn($q) =>
            $q->where('code', 'like', '%' . $keyword . '%')
                ->orWhere('name', 'like', '%' . $keyword . '%')
        )->orderBy('created_at', 'DESC');

        $response = [
            'message' => 'Berhasil mendapat data item',
            'data' => static::paginate($datas),
        ];

        return response()->json($response, 200);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|string',
            'unit' => 'required|string',
            'take_price' => 'required|numeric',
            'price' => 'required|numeric',
        ]);

        if ($validate->fails()) {
            $response = [
                'message' => 'Gagal menambahkan item',
                'data' => $validate->errors(),
            ];

            return response()->json($response, 422);
        }

        $dataCreated = array_merge($request->all(), [
            'app_id' => Auth::user()->app_id,
            'unit' => $request->per_unit . '/' . $request->unit,
        ]);

        try {
            DB::beginTransaction();
            $data = Item::create($dataCreated);

            DB::commit();
            $response = [
                'message' => 'Berhasil menambahkan item',
                'data' => $data,
            ];

            return response()->json($response, 201);
        } catch (\Throwable$th) {
            DB::rollBack();
            $response = [
                'message' => 'Gagal menambahkan item',
                'data' => $th->getMessage(),
            ];

            return response()->json($response, 500);
        }
    }

    public function show(Item $item)
    {
        $response = [
            'message' => 'Berhasil mendapat data item',
            'data' => $item,
        ];

        return response()->json($response, 200);
    }

    public function update(Request $request, Item $item)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|string',
            'unit' => 'required|string',
            'take_price' => 'required|numeric',
            'price' => 'required|numeric',
        ]);

        if ($validate->fails()) {
            $response = [
                'message' => 'Gagal menambahkan item',
                'data' => $validate->errors(),
            ];

            return response()->json($response, 422);
        }

        $dataUpdated = array_merge($request->all(), [
            'unit' => $request->per_unit . '/' . $request->unit,
        ]);

        try {
            DB::beginTransaction();
            $item->update($dataUpdated);

            DB::commit();
            $response = [
                'message' => 'Berhasil mengubah item',
                'data' => $item,
            ];

            return response()->json($response, 201);
        } catch (\Throwable$th) {
            DB::rollBack();
            $response = [
                'message' => 'Gagal mengubah item',
                'data' => $th->getMessage(),
            ];

            return response()->json($response, 500);
        }
    }

    public function destroy(Item $item)
    {
        $transactions = $item->load('transaction_detail')->transaction_detail;

        if ($transactions->count() > 0) {
            $response = [
                'message' => 'Item memiliki transakasi',
            ];

            return response()->json($response, 400);
        }

        try {
            DB::beginTransaction();
            $item->delete();

            DB::commit();
            $response = [
                'message' => 'Berhasil hapus item',
            ];

            return response()->json($response, 200);
        } catch (\Throwable$th) {
            DB::rollBack();
            $response = [
                'message' => 'Gagal mengubah item',
                'data' => $th->getMessage(),
            ];

            return response()->json($response, 500);
        }

    }

    public function status(Item $item)
    {
        try {
            DB::beginTransaction();
            $item->update([
                'status' => !$item->status,
            ]);

            DB::commit();
            $response = [
                'message' => 'Berhasil mengubah status item',
                'data' => $item,
            ];

            return response()->json($response, 201);
        } catch (\Throwable$th) {
            DB::rollBack();
            $response = [
                'message' => 'Gagal mengubah status item',
                'data' => $th->getMessage(),
            ];

            return response()->json($response, 500);
        }
    }
}
