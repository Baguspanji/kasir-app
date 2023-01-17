@extends('layouts.app')

@section('content')
    <main class="container">
        <div class="row g-5 mb-4">
            <div class="col-md-8">
                <div class="row pt-2 mb-4 mt-3 px-5">
                    <div class="input-group">
                        <input class="form-control" id="search" type="search" placeholder="Cari Barang" aria-label="Search">
                        <span class="input-group-text" id="icon"><i class="bi bi-search"></i></span>
                    </div>
                </div>

                <div id="produk" class="row g-5">
                    <table id="dt" class="table w-100">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Unit</th>
                                <th>Harga</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>

            <div class="col-md-4">
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> Ada yang error saat membuat pesanan.<br><br>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="position-sticky" style="top: 2rem;">
                    <form id="formSubmit">
                        @csrf

                        <div class="p-4 pb-5 bg-light rounded">
                            <div class="row justify-content-between">
                                <div class="col-4">
                                    <h4>Keranjang</h4>
                                </div>
                                <div class="col-6">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" value="{{ old('name', isset($post->name) ? $post->name : '') }}"
                                        placeholder="Pemesan">
                                </div>
                            </div>
                            <table class="table">
                                <thead class="text-center">
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Barang</th>
                                        <th scope="col">Qty</th>
                                        <th scope="col">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <tr class="cart-total">
                                        <td colspan="3" class="fw-bold">Total</td>
                                        <td id="total">Rp. 0</td>
                                        <input type="hidden" id="total-value" value="0">
                                    </tr>
                                </tbody>
                            </table>

                            <div class="row justify-content-between">
                                <div class="col-6">
                                    <input type="number" class="form-control @error('amount_paid') is-invalid @enderror"
                                        name="amount_paid"
                                        value="{{ old('amount_paid', isset($post->amount_paid) ? $post->amount_paid : '') }}"
                                        placeholder="Bayar">
                                </div>
                                <div class="col-4">
                                    <button type="submit" class="btn btn-success btn-sm float-end mt-1"><i
                                            class="bi bi-cash"></i>
                                        Proses</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>

    </main>
@endsection

{{-- @push('style')
    <style>
        #dt.dataTable.no-footer {
            border-bottom: unset;
        }

        #dt tbody td {
            display: block;
            border: unset;
        }

        #dt>tbody>tr>td {
            border-top: unset;
        }

        .dataTables_paginate {
            display: flex;
            align-items: center;
        }

        .dataTables_paginate a {
            padding: 0 10px;
        }

        img {
            height: 180px;
        }
    </style>
@endpush --}}

@push('script')
    <script type="text/javascript">
        $('#total-value').val(0);
        $(document).ready(function() {
            var dt = $('#dt').DataTable({
                ajax: "{{ route('item.ajax') }}",
                bInfo: false,
                pageLength: 12,
                lengthChange: false,
                deferRender: true,
                processing: true,
                // language: {
                //     paginate: {
                //         previous: "",
                //         next: ">"
                //     },
                // },
                columns: [{
                        data: 'code',
                        name: 'code'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'unit',
                        name: 'unit'
                    },
                    {
                        data: 'price',
                        name: 'price',
                        render: function(data, type, row) {
                            return rupiah(row.price);
                        }
                    },
                    {
                        data: 'id',
                        name: 'id',
                        render: function(data, type, row) {
                            return '<button class="btn btn-sm btn-primary" onclick="addCart(' + row
                                .id + ')"><i class="bi bi-cart-plus"></i></button>';
                        }
                    },
                ]
            });

            // $("#dt thead").hide();
            $('#dt_filter').hide();

            $('#search').keyup(function() {
                dt.search($(this).val()).draw();
            });

        });

        function addCart(id) {
            $.ajax({
                url: "{{ url('ajax/item') }}" + '/' + id,
            }).done(function(response) {
                var res = response.data

                addToCart(res.id, res.name, res.price)
            });
        }

        function addToCart(id, name, price) {
            var qty = $('.qty-' + id).val()
            var total = parseInt($('#total-value').val()) + parseInt(price);

            if (qty != null) {
                $('.qty-' + id).val(++qty)
                $('#price-' + id).val(qty * price)
                $('.price-' + id).html(rupiah(qty * price))

                $('#total').html(rupiah(total));
                $('#total-value').val(total);
            } else {
                var item =
                    `<tr class="item-${id}">` +
                    `    <td>` +
                    `        <button type="button" class="btn btn-sm btn-danger" onclick="removeItem(${id})">` +
                    '           <i class="bi bi-trash"></i>' +
                    '        </button>' +
                    `    </td>` +
                    `    <td>${name}</td>` +
                    '    <td>' +
                    `        <input type="number" name="quantity[]" min="1" class="form-control input-qty qty-${id}" onchange="quantity(${id})" value="1">` +
                    `        <input type="hidden" name="price[]" id="price-${id}" value="${price}">` +
                    `        <input type="hidden" name="id[]" value="${id}">` +
                    '    </td>' +
                    `    <td class="price-${id}">${rupiah(price)}</td>` +
                    '</tr>';

                $(item).insertBefore('.cart-total');
                $('#total').html(rupiah(total));
                $('#total-value').val(total);
            }
        }

        function quantity(id) {
            var qty = $('.qty-' + id).val()
            var total = parseInt($('#total-value').val())

            // total setelah dikurangi
            total = total - parseInt($('#price-' + id).val())

            $.ajax({
                url: "{{ url('ajax/item') }}" + '/' + id,
            }).done(function(response) {
                var res = response.data

                var price_now = res.price * qty
                $('#price-' + id).val(price_now)
                $('.price-' + id).html(rupiah(price_now))

                // total setelah ditambah
                total = total + price_now
                $('#total').html(rupiah(total));
                $('#total-value').val(total);
            });

        }

        function removeItem(id) {
            var price = $('#price-' + id).val()
            var total = parseInt($('#total-value').val()) - price;

            $('#total').html(rupiah(total));
            $('#total-value').val(total);

            $(`.item-${id}`).remove()
        }

        function clearItem() {
            var cartTotal = $('.cart-total')
            cartTotal.siblings().remove()
            $('#total').html(rupiah(0));
            $('#total-value').val(0);
        }

        $('#formSubmit').submit(function(e) {
            e.preventDefault();

            var form = $(this);
            var token = $('meta[name="csrf-token"]').attr('content');
            form.append('<input type="hidden" name="_token" value="' + token + '">');
            var url = '{{ route('cashier.store') }}';

            $.ajax({
                type: "POST",
                url: url,
                data: form.serialize(),
                success: function(response) {
                    var res = response

                    getData(res.data)
                },
                error: function(xhr) {
                    var res = xhr.responseJSON
                    if ($.isEmptyObject(res) == false) {}
                }
            });
        });

        function getData(id) {
            $.ajax({
                url: "{{ url('cashier') }}" + '/' + id,
            }).done(function(response) {
                var res = response.data

                print(res)
            });
        }

        function print(response) {
            // ajax json
            $.ajax({
                url: "http://localhost:8005",
                type: "POST",
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                data: response,
                success: function(response) {
                    var res = response
                    console.log(res);
                }
            });
        }
    </script>
@endpush
