@extends('layouts.app')

@section('content')
    <main class="container">

        <div class="row mb-4">
            <div class="col-md-12 d-flex justify-content-between mb-2">
                <h4>Pembelanjaan</h4>
                <div>
                    <a class="btn btn-primary" href="{{ route('shopping.create') }}">Tambah Data</a>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card mt-2">
                    <div class="card-body">
                        <table class="table" id="dt">
                            <thead class="text-center">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Tanggal</th>
                                    <th scope="col">Barang</th>
                                    <th scope="col">Harga</th>
                                    <th scope="col">Keterangan</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @foreach ($datas as $key => $item)
                                    <tr id="table-data">
                                        <th scope="row">{{ ++$key }}</th>
                                        <td>{{ tanggalDate($item->date) }}</td>
                                        <td>
                                            @foreach ($item->details as $value)
                                                <li>{{ $value->item->name }} -
                                                    {{ rupiah($value->price) }} -
                                                    {{ $value->quantity }}/{{ $value->item->unit }}</li>
                                            @endforeach
                                        </td>
                                        <td>{{ rupiah($item->price) }}</td>
                                        <td>{{ $item->description ?? '-' }}</td>
                                        <td>
                                            <a href="{{ route('shopping.edit', $item->id) }}" class="btn btn-warning btn-sm"
                                                id="addStokBtn"><i class="bi bi-pencil-square"></i> Edit</a>
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
