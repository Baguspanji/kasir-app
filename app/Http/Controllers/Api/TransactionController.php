<?php

namespace App\Http\Controllers\Api;

use App\Exports\ReportExport;
use App\Http\Controllers\Controller;
use App\Models\App;
use App\Models\Item;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class TransactionController extends Controller
{
    public function index()
    {
        $datas = Transaction::with([
            'details',
            'details.item',
        ])->Where([
            'app_id' => Auth::user()->app_id,
        ])->orderBy('created_at', 'DESC');

        $response = [
            'message' => 'Berhasil mendapat data item',
            'data' => static::paginate($datas),
        ];

        return response()->json($response, 200);
    }

    public function store(Request $request)
    {
        $valiate = Validator::make($request->all(), [
            'name' => 'string',
            'amount_paid' => 'numeric',
            'items' => 'required|array',
            'items.*.id' => 'required|exists:items,id',
            'items.*.quantity' => 'required|numeric',
            'items.*.price' => 'required|numeric',
        ]);

        if ($valiate->fails()) {
            $response = [
                'message' => 'Gagal menambahkan item',
                'data' => $valiate->errors(),
            ];

            return response()->json($response, 422);
        }

        $items = Item::where([
            'app_id' => Auth::user()->app_id,
        ])
            ->whereIn('id', collect($request->items)->pluck('id'))
            ->get();

        try {
            DB::beginTransaction();
            $total_take_price = 0;
            $total_price = 0;
            $transaction = Transaction::create([
                'app_id' => Auth::user()->app_id,
                'name' => $request->name,
                'total_take_price' => $total_take_price,
                'total_price' => $total_price,
                'amount_paid' => $request->amount_paid ?? 0,
                'date' => now()->format('Y-m-d'),
                'created_by' => Auth::user()->name,
            ]);

            foreach ($items as $value) {
                $key = array_search($value->id, collect($request->items)->pluck('id')->toArray());

                $total_take_price += $value->take_price * $request->items[$key]['quantity'];
                $total_price += $request->items[$key]['price'] * $request->items[$key]['quantity'];

                $detailCreated[] = [
                    'app_id' => Auth::user()->app_id,
                    'transaction_id' => $transaction->id,
                    'take_price' => $value->take_price,
                    'price' => $request->items[$key]['price'],
                    'item_id' => $value->id,
                    'quantity' => $request->items[$key]['quantity'],
                    'created_at' => now(),
                ];
            }

            $transaction->update([
                'total_take_price' => $total_take_price,
                'total_price' => $total_price,
            ]);

            $transaction->details()->createMany($detailCreated);
            $transaction->details = $detailCreated;

            DB::commit();
            $response = [
                'message' => 'Berhasil menambahkan transaksi',
                'data' => $transaction,
            ];

            return response()->json($response, 201);
        } catch (\Exception$e) {
            DB::rollBack();
            $response = [
                'message' => 'Gagal menambahkan transaksi',
                'data' => $e->getMessage(),
            ];

            return response()->json($response, 500);
        }
    }

    public function show(Transaction $transaction)
    {
        $transaction->load([
            'details',
            'details.item',
        ]);

        $response = [
            'message' => 'Berhasil mendapat data item',
            'data' => $transaction,
        ];

        return response()->json($response, 200);
    }

    public function update(Request $request, Transaction $transaction)
    {
        $valiate = Validator::make($request->all(), [
            'name' => 'string',
            'amount_paid' => 'numeric',
            'items' => 'required|array',
            'items.*.id' => 'required|exists:items,id',
            'items.*.quantity' => 'required|numeric',
            'items.*.price' => 'required|numeric',
        ]);

        if ($valiate->fails()) {
            $response = [
                'message' => 'Gagal menambahkan item',
                'data' => $valiate->errors(),
            ];

            return response()->json($response, 422);
        }

        $items = Item::where([
            'app_id' => Auth::user()->app_id,
        ])
            ->whereIn('id', collect($request->items)->pluck('id'))
            ->get();

        try {
            DB::beginTransaction();
            TransactionDetail::where([
                'app_id' => Auth::user()->app_id,
                'transaction_id' => $transaction->id,
            ])->delete();

            $total_take_price = 0;
            $total_price = 0;
            $transaction->update([
                'app_id' => Auth::user()->app_id,
                'name' => $request->name,
                'total_take_price' => $total_take_price,
                'total_price' => $total_price,
                'amount_paid' => $request->amount_paid ?? 0,
                'date' => now()->format('Y-m-d'),
                'created_by' => Auth::user()->name,
            ]);

            foreach ($items as $value) {
                $key = array_search($value->id, collect($request->items)->pluck('id')->toArray());

                $total_take_price += $value->take_price * $request->items[$key]['quantity'];
                $total_price += $request->items[$key]['price'] * $request->items[$key]['quantity'];

                $detailCreated[] = [
                    'app_id' => Auth::user()->app_id,
                    'transaction_id' => $transaction->id,
                    'take_price' => $value->take_price,
                    'price' => $request->items[$key]['price'],
                    'item_id' => $value->id,
                    'quantity' => $request->items[$key]['quantity'],
                    'created_at' => now(),
                ];
            }

            $transaction->update([
                'total_take_price' => $total_take_price,
                'total_price' => $total_price,
            ]);

            $transaction->details()->createMany($detailCreated);
            $transaction->details = $detailCreated;

            DB::commit();
            $response = [
                'message' => 'Berhasil update transaksi',
                'data' => $transaction,
            ];

            return response()->json($response, 201);
        } catch (\Exception$e) {
            DB::rollBack();
            $response = [
                'message' => 'Gagal update transaksi',
                'data' => $e->getMessage(),
            ];

            return response()->json($response, 500);
        }
    }

    public function destroy(Transaction $transaction)
    {
        //
    }

    public function income()
    {
        $datas = TransactionDetail::with([
            'item',
            'transaction',
        ])->Where([
            'app_id' => Auth::user()->app_id,
        ])->orderBy('created_at', 'DESC');

        $response = [
            'message' => 'Berhasil mendapat data item',
            'data' => static::paginate($datas),
        ];

        return response()->json($response, 200);
    }

    public function incomeById(TransactionDetail $transactionDetail)
    {
        $transactionDetail->load([
            'item',
            'transaction',
        ]);

        $response = [
            'message' => 'Berhasil mendapat data item',
            'data' => $transactionDetail,
        ];

        return response()->json($response, 200);
    }

    public function export(Request $request)
    {
        $valiate = Validator::make($request->all(), [
            'date' => 'date',
            'type' => 'in:daily,monthly',
        ]);

        if ($valiate->fails()) {
            $response = [
                'message' => 'Gagal menambahkan item',
                'data' => $valiate->errors(),
            ];

            return response()->json($response, 422);
        }

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
        if (!Storage::exists('public\export')) {
            Storage::makeDirectory('public\export');
        }

        $name = 'laporan-' . Carbon::now()->format('Y-m-d') . '.xlsx';
        $ecel = Excel::store($export, $name, 'export');

        if (!$ecel) {
            $response = [
                'message' => 'Gagal mendapat data item',
                'data' => null,
            ];

            return response()->json($response, 500);
        }

        return response()->download(storage_path('app/public/export/' . $name));
    }
}
