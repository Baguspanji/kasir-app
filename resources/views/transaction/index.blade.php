@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row g-5 mb-4">
            <div class="col-md-12">
                <div class="card rounded-4 shadow-lg">
                    <div class="card-body">
                        <div class="row justify-content-between">
                            <div class="col-md-6">
                                <h2 class="fw-bold p-0 m-0">Daftar Transaksi</h2>
                            </div>
                            <div class="col-md-4 d-flex justify-content-between">
                                @can('is_admin')
                                    <form action="{{ route('transaction.index') }}" method="GET" id="search-date">
                                        <input class="form-control bg-white w-100" type="month" name="date" id="date">
                                    </form>
                                    <button type="button" class="btn btn-primary w-50"
                                        onclick="document.getElementById('search-date').submit();">
                                        <i class="bi bi-database"></i> Lihat
                                    </button>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card rounded-4 shadow-lg mt-2">
                    <div class="card-body">
                        <table class="table table-bordered nowrap py-3" id="dt">
                            <thead class="text-center">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Tanggal</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Total Pembelian</th>
                                    <th scope="col">Detail Barang</th>
                                    <th scope="col">Aksi</th>

                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @foreach ($datas as $key => $item)
                                    <tr id="table-data">
                                        <th scope="row">{{ ++$key }}</th>
                                        <td>{{ tanggalDate($item->date) }}</td>
                                        <td>{{ $item->name ?? '-' }}</td>
                                        <td>{{ $item->total_price == 0 ? '-' : rupiah($item->total_price) }}</td>
                                        <td>
                                            @foreach ($item->details as $detail)
                                                @php
                                                    $per_unit = explode('/', $detail->item->unit)[0];
                                                    $unit = explode('/', $detail->item->unit)[1];
                                                @endphp
                                                <li>
                                                    {{ $detail->item->name }} -
                                                    {{ $detail->quantity * (int) $per_unit }}/{{ $unit }}
                                                </li>
                                            @endforeach
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-primary"
                                                onclick="getData({{ $item->id }})">Cetak
                                                Struk</button>
                                            {{-- <a class="btn btn-sm btn-info text-white"
                                                href="{{ route('transaction.share', $item->id) }}">Share
                                                Struk</a> --}}
                                        </td>
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
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

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

        function getData(id) {
            $.ajax({
                url: "{{ url('cashier') }}" + '/' + id + '/print',
            }).done(function(response) {
                var res = response.data

                print(res)
            });

            // delay
            // setTimeout(function() {
            //     // reload page
            //     location.reload();
            // }, 5000);
        }

        function print(response) {
            axios.post('http://localhost:8005', response, {
                    headers: {
                        "Content-Type": "application/json",
                        'Access-Control-Allow-Origin': 'http://localhost:8005',
                    }
                })
                .then((res) => {
                    const notyf = new Notyf({
                        position: {
                            x: 'right',
                            y: 'top',
                        },
                        types: [{
                            type: 'info',
                            background: '#0948B3',
                            icon: {
                                className: 'bi bi-check-circle-fill',
                                tagName: 'span',
                                color: '#fff'
                            },
                            dismissible: false
                        }]
                    });
                    notyf.open({
                        type: 'success',
                        message: 'Berhasil Mencetak Struk'
                    });

                    console.log(res)
                })
                .catch((err) => {
                    const notyf = new Notyf({
                        position: {
                            x: 'right',
                            y: 'top',
                        },
                        types: [{
                            type: 'error',
                            background: '#FA5252',
                            icon: {
                                className: 'bi bi-x-circle',
                                tagName: 'span',
                                color: '#fff'
                            },
                            dismissible: false
                        }]
                    });
                    notyf.open({
                        type: 'error',
                        message: 'Gagal Mencetak Struk'
                    });

                    console.log(err)
                });
        }
    </script>
@endpush
