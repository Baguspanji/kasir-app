@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row g-5 mb-4">
            <div class="col-md-12">

                <div class="card rounded-4 shadow-lg">
                    <div class="card-body">
                        <div class="row justify-content-end">
                            <div class="col-md-6">
                                <h2 class="fw-bold p-0 m-0">Daftar Item</h2>
                            </div>
                            <div class="col-md-6">
                                @can('is_admin')
                                    <a href="{{ route('item.create') }}" class="btn btn-primary float-end rounded-3">
                                        Tambah Item
                                    </a>
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
                                    {{-- <th scope="col" style="width: 100px;">Gambar</th> --}}
                                    <th scope="col">Kode</th>
                                    <th scope="col">Barang</th>
                                    <th scope="col">Unit</th>
                                    <th scope="col">Harga Beli</th>
                                    <th scope="col">Harga Jual</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @foreach ($datas as $key => $item)
                                    <tr id="table-data">
                                        <th scope="row">{{ ++$key }}</th>
                                        {{-- <td>
                                            @if ($item->image)
                                                <img src="{{ $item->image }}" class="rounded" alt="...">
                                            @endif
                                        </td> --}}
                                        @if ($item->code_1 == null)
                                            <td>-</td>
                                        @else
                                            @php
                                                $code = '';
                                                for ($i = 1; $i <= 10; $i++) {
                                                    if ($item['code_' . $i] != null) {
                                                        $code .= '<li>' . $item['code_' . $i] . '</li>';
                                                    }
                                                }
                                            @endphp
                                            <td>{!! $code !!}</td>
                                        @endif
                                        <td>{{ $item->name }}</td>
                                        <td>{{ Str::ucfirst($item->unit) }}</td>
                                        <td>{{ $item->take_price == 0 ? '-' : rupiah($item->take_price) }}</td>
                                        <td>{{ $item->price == 0 ? '-' : rupiah($item->price) }}</td>
                                        <td>
                                            @if ($item->status)
                                                <a href="{{ route('item.status', $item->id) }}"
                                                    class="btn btn-sm btn-primary rounded-3">Aktif</a>
                                            @else
                                                <a href="{{ route('item.status', $item->id) }}"
                                                    class="btn btn-sm btn-danger rounded-3">Non-aktif</a>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('item.edit', $item->id) }}"
                                                class="btn btn-warning btn-sm rounded-3"><i class="bi bi-pencil-square"></i>
                                                Edit</a>
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
                    "sSearch": "Cari Item"
                }
            });
        });
    </script>
@endpush
