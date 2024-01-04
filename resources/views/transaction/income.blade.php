@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row g-5 mb-4">
            <div class="col-md-12">
                <div class="card rounded-4 shadow-lg">
                    <div class="card-body">
                        <div class="row justify-content-between">
                            <div class="col-md-6">
                                <h2 class="fw-bold p-0 m-0">Daftar Pendapatan</h2>
                            </div>
                            <div class="col-md-4 d-flex justify-content-between">
                                @can('is_admin')
                                    <form action="{{ route('transaction.export') }}" method="GET" id="search-date"
                                        class="d-flex">
                                        <select class="form-select" name="type" id="type" style="width: 160px">
                                            <option value="daily">Harian</option>
                                            <option value="monthly">Bulanan</option>
                                        </select>
                                        <input class="form-control bg-white" type="date" name="date" id="date">
                                    </form>
                                    <button type="button" class="btn btn-primary"
                                        onclick="document.getElementById('search-date').submit();">
                                        <i class="bi bi-database"></i> Export
                                    </button>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card rounded-4 shadow-lg mt-2">
                    <div class="card-body">
                        <table class="table table-bordered py-2" id="dt">
                            <thead class="text-center">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Tanggal</th>
                                    <th scope="col">Nama Barang</th>
                                    <th scope="col">Qty</th>
                                    <th scope="col">Harga Beli</th>
                                    <th scope="col">Harga Jual</th>
                                    <th scope="col">Laba</th>
                                    {{-- <th scope="col">Aksi</th> --}}

                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @foreach ($datas as $key => $item)
                                    <tr id="table-data">
                                        <th scope="row">{{ ++$key }}</th>
                                        <td>{{ tanggalDate($item->transaction->date) }}</td>
                                        <td>{{ $item->item->name ?? '-' }} - {{ $item->item->unit ?? '-' }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>{{ rupiah($item->take_price) }}</td>
                                        <td>{{ rupiah($item->price) }}</td>
                                        <td>{{ rupiah(($item->price * $item->quantity) - ($item->take_price * $item->quantity)) }}
                                        </td>
                                        {{-- <td></td> --}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



@push('style')
    <style>
        .table thead th {
            font-weight: 600;
        }
    </style>
    <style>
        .table tbody td {
            vertical-align: middle;
        }
    </style>
@endpush

@push('script')
    <script type="text/javascript">
        $(document).ready(function() {
            var dt = $('#dt').DataTable({
                bInfo: false,
                pageLength: 10,
                lengthChange: false,
                deferRender: true,
                processing: true,
                oLanguage: {
                    "sSearch": "Cari Transaksi"
                }
            });
        });

        $('#type').on('change', function() {
            if (this.value == 'daily') {
                $('#date').attr('type', 'date');
            } else {
                $('#date').attr('type', 'month');
            }
        });
    </script>
@endpush
