@extends('layouts.app')

@section('content')
    <main class="container">

        <div class="row g-5 mb-4">
            <div class="col-md-12">

                @can('is_admin')
                    <form class="row justify-content-end" action="{{ route('transaction.export') }}" method="GET">
                        <div class="col-md-2">
                            <input class="form-control bg-white" type="month" name="month" id="month">
                        </div>
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-primary float-end">
                                <i class="bi bi-plus-lg"></i> Export
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
                                        <td>{{ rupiah($item->price * $item->quantity - $item->take_price * $item->quantity) }}
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

    </main>
@endsection

@push('script')
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
@endpush
