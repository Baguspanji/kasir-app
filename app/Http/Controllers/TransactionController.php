<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index()
    {
        $datas = Transaction::with([
            'details',
            'details.item',
        ])
            ->Where([
                'app_id' => Auth::user()->app_id,
            ])->get();

        return view('transaction.index', compact('datas'));
    }

    // income
    public function income()
    {
        $datas = TransactionDetail::with([
            'item',
            'transaction'
        ])
            ->Where([
                'app_id' => Auth::user()->app_id,
            ])->get();

        return view('transaction.income', compact('datas'));
    }
}
