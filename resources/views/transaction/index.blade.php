@extends('layouts.app')

@section('content')
    <main class="container">

        <div class="row g-5 mb-4">
            <div class="col-md-12">

                <div class="card mt-2">
                    <div class="card-body">
                        <table class="table" id="dt">
                            <thead class="text-center">
                                <tr>
                                    <th scope="col">#</th>
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
                                        <td>{{ $item->name ?? '-' }}</td>
                                        <td>{{ $item->total_price == 0 ? '-' : rupiah($item->total_price) }}</td>
                                        <td>
                                            @foreach ($item->details as $detail)
                                                <li>
                                                    {{ $detail->item->name }} - {{ $detail->quantity }}
                                                </li>
                                            @endforeach
                                        </td>
                                        <td></td>
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
