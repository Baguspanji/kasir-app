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
        $date = request()->date ?? null;

        $datas = Transaction::with([
            'details',
            'details.item',
        ])
            ->where([
                'app_id' => Auth::user()->app_id,
            ])
            ->when($date, function ($query) use ($date) {
                $query->whereBetween('date', [
                    Carbon::createFromDate($date)->startOfMonth()->format('Y-m-d'),
                    Carbon::createFromDate($date)->endOfMonth()->format('Y-m-d'),
                ]);
            })
            ->orderBy('created_at', 'desc')
            ->get();

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
            ])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('transaction.income', compact('datas'));
    }

    public function export(Request $request)
    {
        $date = Carbon::createFromDate($request->date ?? now());
        $type = $request->type ?? 'daily';
        $app = App::findOrFail(Auth::user()->app_id);

        $transaction = TransactionDetail::with([
            'item',
            'transaction',
        ])
            ->when($type == 'daily', function ($query) use ($date) {
                $query->whereHas('transaction', function ($query) use ($date) {
                    $query->whereDate('date', $date->format('Y-m-d'));
                });
            })
            ->when($type == 'monthly', function ($query) use ($date) {
                $query->whereHas('transaction', function ($query) use ($date) {
                    $query->whereBetween('date', [
                        $date->startOfMonth()->format('Y-m-d'),
                        $date->endOfMonth()->format('Y-m-d'),
                    ]);
                });
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

        if ($type == 'daily') {
            $ex = explode(' ', $date);
            $tanggal = substr($ex[0], 8, 2);
            $bulan = $tanggal . ' ' . bulan(substr($ex[0], 5, 2));
            $tahun = substr($ex[0], 0, 4);
        } else {
            $ex = explode(' ', $date);
            $bulan = bulan(substr($ex[0], 5, 2));
            $tahun = substr($ex[0], 0, 4);
        }

        // return $dataExport;
        $export = new ReportExport($dataExport, $bulan . ' ' . $tahun, $app->address, $app->name);

        // return $export->map($dataExport);
        return Excel::download($export, 'laporan-' . Carbon::now()->format('Y-m-d') . '.xlsx');
    }
}
