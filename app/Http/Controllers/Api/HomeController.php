<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\App;
use App\Models\TermsCondition;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    // index
    public function index()
    {
        $app = App::where([
            'id' => Auth::user()->app_id,
            'status' => true,
        ])->first();

        $response = [
            'message' => 'Berhasil mendapat data dashboard',
            'data' => $app,
        ];

        return response()->json($response, 200);
    }

    public function getTNC()
    {
        $bills = TermsCondition::all();

        $response = [
            'message' => 'Berhasil mendapat syarat dan ketentuan',
            'data' => $bills,
        ];

        return response()->json($response, 200);
    }
}
