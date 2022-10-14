@extends('layouts.app')

@section('content')
    <main class="container">

        <div class="row g-5 mb-4">
            <div class="col-md-12">

                <div class="row justify-content-end">
                    <div class="col-md-6">
                        @can('is_admin')
                            <a href="{{ route('item.create', ['type' => isset($request['type']) ? $request['type'] : '']) }}"
                                class="btn btn-primary float-end">
                                <i class="bi bi-plus-lg"></i> Tambah Data
                            </a>
                        @endcan
                    </div>
                </div>

                <div class="card mt-2">
                    <div class="card-body">
                        <table class="table" id="dt">
                            <thead class="text-center">
                                <tr>
                                    <th scope="col">#</th>
                                    {{-- <th scope="col" style="width: 100px;">Gambar</th> --}}
                                    {{-- <th scope="col">Kode</th> --}}
                                    <th scope="col">Barang</th>
                                    @if (isset($request['type']) && $request['type'] != 'sell')
                                        <th scope="col">Stok</th>
                                    @endif
                                    <th scope="col">Satuan</th>
                                    @if (isset($request['type']) && $request['type'] == 'sell')
                                        <th scope="col">Harga</th>
                                        <th scope="col">Detail</th>
                                    @endif
                                    @if (isset($request['type']) && $request['type'] == 'sell')
                                        <th scope="col">Status</th>
                                    @endif
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @foreach ($datas as $key => $item)
                                    <tr id="table-data">
                                        <th scope="row">{{ ++$key }}</th>
                                        {{-- <td>
                                            <img src="{{ asset('assets/images/bakso.jpg') }}" class="rounded"
                                                alt="...">
                                        </td> --}}
                                        {{-- <td>{{ $item->code ?? '-' }}</td> --}}
                                        <td>{{ $item->name }}</td>
                                        @if (isset($request['type']) && $request['type'] != 'sell')
                                            <td>{{ $item->stock }}</td>
                                        @endif
                                        <td>{{ Str::ucfirst($item->unit) }}</td>
                                        @if (isset($request['type']) && $request['type'] == 'sell')
                                            <td>{{ $item->price == 0 ? '-' : rupiah($item->price) }}</td>
                                            <td>
                                                @foreach ($item->details as $detail)
                                                    <li>{{ $detail->name }} - {{ $detail->quantity }}/{{ $detail->unit }}
                                                    </li>
                                                @endforeach
                                            </td>
                                        @endif
                                        @if (isset($request['type']) && $request['type'] == 'sell')
                                            <td>
                                                @if ($item->status)
                                                    <a href="{{ route('item.status', $item->id) }}"
                                                        class="btn btn-sm btn-primary">Aktif</a>
                                                @else
                                                    <a href="{{ route('item.status', $item->id) }}"
                                                        class="btn btn-sm btn-danger">Aktif</a>
                                                @endif
                                            </td>
                                        @endif
                                        <td>
                                            <a href="{{ route('item.edit', [$item->id, 'type' => isset($request['type']) ? $request['type'] : '']) }}"
                                                class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i> Edit</a>
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
