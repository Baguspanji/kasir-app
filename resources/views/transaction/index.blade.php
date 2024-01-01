@extends('layouts.app')

@section('content')
    <main class="container">

        <div class="row g-5 mb-4">
            <div class="col-md-12">

                @can('is_admin')
                    <form class="row justify-content-end" action="{{ route('transaction.index') }}" method="GET">
                        <div class="col-md-2">
                            <input class="form-control bg-white" type="month" name="date" id="date">
                        </div>
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-primary float-end">
                                <i class="bi bi-database"></i> Lihat
                            </button>
                        </div>
                    </form>
                @endcan

                <div class="card mt-2">
                    <div class="card-body">
                        <table class="table" id="dt">
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

    </main>
@endsection

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
            });

            $('#addStokBtn').click(function() {
                $('#addStok').modal('show');
            })
        });
    </script>

    <script>
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
