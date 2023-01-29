<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Support\Facades\Auth;

class UnitController extends Controller
{
    public function index()
    {
        $datas = Unit::where([
            'app_id' => Auth::user()->app_id,
            'status' => true,
        ])->orderBy('created_at', 'DESC');

        $response = [
            'message' => 'Berhasil mendapat data item',
            'data' => static::paginate($datas),
        ];

        return response()->json($response, 200);
    }
}
