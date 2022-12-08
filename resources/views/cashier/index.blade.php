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
                                <th>name</th>
                                <th>gender</th>
                                <th>email</th>
                                <th>address</th>
                            </tr>
                        </thead>
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
                    <form id="formSubmit" action="{{ route('cashier.store') }}" method="POST">
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
                                        <th scope="col">Banyak</th>
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

                            <button type="submit" class="btn btn-success btn-sm float-end"><i class="bi bi-cash"></i>
                                Proses</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>

    </main>
@endsection

@push('style')
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
@endpush

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
                //   paginate: {
                //     previous: "<",
                //     next: ">"
                //   },
                // },
                columns: [{
                        render: function(data, type, row, meta) {
                            var html =
                                '<div class="card shadow">' +
                                '  <img src="./assets/images/dummy-image.jpg" class="card-img-top">' +
                                '  <div class="card-body">' +
                                `    <div class="card-text">${row.name}</div>` +
                                // '    <div class="card-text">Porsi Besar</div>' +
                                '    <div class="d-flex justify-content-between">' +
                                `      <span class="card-text">${rupiah(row.price)}</span>` +
                                `      <button type="button" class="btn btn-primary btn-sm float-end" onclick="addCart(${row.id})"><i class="bi bi-cart-plus"></i></button>` +
                                '    </div>' +
                                '  </div>' +
                                '</div>';
                            return html;
                        }
                    },
                    {
                        data: "name",
                        visible: false
                    }
                ],
            });

            dt.on('draw', function(data) {
                $('#dt tbody').addClass('row');
                $('#dt tbody tr').addClass('col-md-3 col-sm-12');
            });

            $("#dt thead").hide();
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
            var total = parseInt($('#total-value').val()) + price;

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
    </script>
@endpush
