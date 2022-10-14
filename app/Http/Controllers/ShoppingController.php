<?php

namespace App\Http\Controllers;

use App\Models\CostShop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShoppingController extends Controller
{
    public function index()
    {
        $items = CostShop::where([
            'app_id' => Auth::user()->app_id,
        ])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('shopping.index', compact('items'));
    }

    public function create()
    {
        return view('shopping.form');
    }

    public function store(Request $request)
    {
        //
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
