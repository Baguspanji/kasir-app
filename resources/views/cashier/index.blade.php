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

        <!-- Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Keranjang</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formUpdate">
                            <input type="hidden" name="id-update" id="idUpdate">
                            <div class="mb-3">
                                <label for="nameUpdate" class="form-label">Nama Barang</label>
                                <input type="text" name="name-update" class="form-control" id="nameUpdate" readonly>
                            </div>

                            <div class="mb-3 row">
                                <div class="col-6">
                                    <label for="qtyUpdate" class="form-label">Qty</label>
                                    <input type="number" name="qty-update" class="form-control" id="qtyUpdate">
                                </div>
                                <div class="col-6">
                                    <label for="priceUpdate" class="form-label">Harga</label>
                                    <input type="number" name="price-Update" class="form-control" id="priceUpdate">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-warning" id="updateCart">Update</button>
                    </div>
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
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

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
                        name: 'code',
                        render: function(data, type, row) {
                            var code = ''
                            if (row.code_1 != null) {
                                code = '<li>' + row.code_1 + '</li>'
                            }

                            if (row.code_2 != null) {
                                code = code + '<li>' + row.code_2 + '</li>'
                            }

                            if (row.code_3 != null) {
                                code = code + '<li>' + row.code_3 + '</li>'
                            }

                            if (row.code_4 != null) {
                                code = code + '<li>' + row.code_4 + '</li>'
                            }

                            if (row.code_5 != null) {
                                code = code + '<li>' + row.code_5 + '</li>'
                            }

                            if (row.code_6 != null) {
                                code = code + '<li>' + row.code_6 + '</li>'
                            }

                            if (row.code_7 != null) {
                                code = code + '<li>' + row.code_7 + '</li>'
                            }

                            if (row.code_8 != null) {
                                code = code + '<li>' + row.code_8 + '</li>'
                            }

                            if (row.code_9 != null) {
                                code = code + '<li>' + row.code_9 + '</li>'
                            }

                            if (row.code_10 != null) {
                                code = code + '<li>' + row.code_10 + '</li>'
                            }

                            return code
                        }
                    },
                    {
                        data: 'name',
                        name: 'name',
                        render: function(data, type, row) {
                            var description = ''
                            if (row.description != null) {
                                description = '(' + row.description + ')'
                            }
                            return row.name + description
                        }
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
                            return `<button class="btn btn-sm btn-primary btn-${row.id}" onclick="addCart(${row.id})"><i class="bi bi-cart-plus"></i></button>`;
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
            var item =
                `<tr class="item-${id} cart-data">` +
                `    <td>` +
                `        <button type="button" class="btn btn-sm btn-danger" onclick="removeItem(${id})">` +
                '           <i class="bi bi-trash"></i>' +
                '        </button>' +
                `        <button type="button" class="btn btn-sm btn-warning" onclick="editItem(this)" data-id="${id}">` +
                '           <i class="bi bi-pencil"></i>' +
                '        </button>' +
                `    </td>` +
                `    <td id="name-${id}">${name}</td>` +
                `    <td class="qty-${id}">1</td>` +
                `    <td class="price-${id}">${rupiah(price)}</td>` +
                `    <input type="hidden" name="quantity[]" id="qty-${id}" value="1">` +
                `    <input type="hidden" name="price[]" id="price-${id}" value="${price}">` +
                `    <input type="hidden" name="id[]" value="${id}">` +
                '</tr>';

            $(item).insertBefore('.cart-total');
            $('.btn-' + id).hide();
        }

        function editItem(el) {
            var id = $(el).data('id')

            var name = $('#name-' + id).html()
            var qty = $('#qty-' + id).val()
            var price = $('#price-' + id).val()

            var form = $('#formUpdate')
            form.find('#idUpdate').val(id)
            form.find('#nameUpdate').val(name)
            form.find('#qtyUpdate').val(qty)
            form.find('#priceUpdate').val(price / qty)

            $('#editModal').modal('show')
        }

        $('#updateCart').on('click', function() {
            var form = $('#formUpdate')
            var id = form.find('#idUpdate').val()
            var qty = form.find('#qtyUpdate').val()
            var price = form.find('#priceUpdate').val()

            var priceQty = parseInt(price) * parseInt(qty)

            $('#qty-' + id).val(qty)
            $('#price-' + id).val(price)
            $('.qty-' + id).html(qty)
            $('.price-' + id).html(rupiah(priceQty))

            $('#editModal').modal('hide')
            sumTotal()
        })

        function sumTotal() {
            var AllPrice = $('.cart-data').find('input[name="price[]"]')
            var total = 0

            AllPrice.each(function() {
                total += parseInt($(this).val())
            })

            $('#total').html(rupiah(total));
            $('#total-value').val(total);
        }

        function removeItem(id) {
            $(`.item-${id}`).remove()
            $('.btn-' + id).show()

            sumTotal()
        }

        function clearItem() {
            var cartTotal = $('.cart-total')
            cartTotal.siblings().remove()
            $('#total').html(rupiah(0));
            $('#total-value').val(0);

            $('.btn-primary').show()
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

                    // var win = window.open('{{ url('cashier') }}/' + res.data, '_blank');
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
                url: "{{ url('cashier') }}" + '/' + id + '/print',
            }).done(function(response) {
                var res = response.data

                print(res)
            });

            // delay
            setTimeout(function() {
                // reload page
                location.reload();
            }, 5000);
        }

        function print(response) {
            axios.post('http://localhost:8005', response, {
                    headers: {
                        "Content-Type": "application/json",
                        'Access-Control-Allow-Origin': 'http://localhost:8005',
                    }
                })
                .then((res) => {
                    console.log(res)
                })
                .catch((err) => {
                    console.log(err)
                });
        }
    </script>
@endpush
