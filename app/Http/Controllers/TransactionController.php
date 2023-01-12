<?php

namespace App\Http\Controllers;

use App\Exports\ReportExport;
use App\Models\App;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class TransactionController extends Controller
{
    public function index()
    {
        $datas = Transaction::with([
            'details',
            'details.item',
        ])
            ->where([
                'app_id' => Auth::user()->app_id,
            ])->get();

        return view('transaction.index', compact('datas'));
    }

    // income
    public function income()
    {
        $datas = TransactionDetail::with([
            'item',
            'transaction',
        ])
            ->where([
                'app_id' => Auth::user()->app_id,
            ])->get();

        return view('transaction.income', compact('datas'));
    }

    public function export(Request $request)
    {
        $month = Carbon::createFromDate($request->month ?? now());
        $app = App::findOrFail(Auth::user()->app_id);

        $transaction = TransactionDetail::with([
            'item',
            'transaction',
        ])
            ->whereHas('transaction', function ($query) use ($month) {
                $query->whereBetween('date', [
                    $month->startOfMonth()->format('Y-m-d'),
                    $month->endOfMonth()->format('Y-m-d'),
                ]);
            })
            ->where([
                'app_id' => Auth::user()->app_id,
            ])->get();

        $dataExport = [];
        foreach ($transaction as $key => $value) {
            $dataExport[] = [
                'date' => $value->transaction->date,
                'name' => $value->item->name,
                'quantity' => $value->quantity,
                'price' => $value->price,
                'take_price' => $value->take_price,
                'income' => ($value->quantity * $value->price) - ($value->quantity * $value->take_price),
            ];
        }

        $ex = explode(' ', $month);
        $bulan = bulan(substr($ex[0], 5, 2));
        $tahun = substr($ex[0], 0, 4);

        // return $dataExport;
        $export = new ReportExport($dataExport, $bulan . ' ' . $tahun, $app->address, $app->name);

        // return $export->map($dataExport);
        return Excel::download($export, 'laporan-' . Carbon::now()->format('Y-m-d') . '.xlsx');
    }
}
