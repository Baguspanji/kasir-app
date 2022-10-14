@extends('layouts.app')

@section('content')
    <main class="container">

        <div class="row mb-4">
            <div class="col-md-12 d-flex justify-content-between mb-2">
                <h4>Tambah Barang</h4>
                <div>
                    <button type="button" class="btn btn-{{ isset($post) ? 'warning' : 'primary' }}"
                        id="formSubmit">{{ isset($post) ? 'Update' : 'Simpan' }}</button>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card mt-2">
                    <div class="card-body">
                        <form action="{{ isset($post) ? route('shopping.update', $post->id) : route('shopping.store') }}"
                            method="POST" id="formData">
                            {{ isset($post) ? method_field('PUT') : '' }}
                            @csrf

                            <div class="mb-3">
                                <div class="row justify-content-between">
                                    <div class="col-6">
                                        <label for="items" class="form-label">Barang</label>
                                        <select class="form-select" id="items">
                                            <option value="">Pilih Barang</option>
                                            @foreach ($items as $item)
                                                <option value="{{ $item->id }}">{{ $item->name }} -
                                                    {{ Str::ucfirst($item->unit) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-3">
                                        <label for="items" class="form-label">Harga</label>
                                        <input type="number" class="form-control" id="price">
                                    </div>
                                    <div class="col-2">
                                        <label for="items" class="form-label">Banyak</label>
                                        <input type="number" class="form-control" id="quantity">
                                    </div>
                                    <div class="col-1">
                                        <label for="items" class="form-label text-white">____</label>
                                        <div class="d-flex justify-content-end">
                                            <button type="button" id="addDetail"
                                                class="btn btn-outline-primary btn-sm text-center px-2 py-0"><i
                                                    class="bi bi-plus m-0" style="font-size: 1.7em;"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Keterangan</label>
                                <textarea type="text" name="description" class="form-control @error('description') is-invalid @enderror"
                                    id="description" rows="3">{{ old('description', isset($post->description) ? $post->description : '') }}</textarea>

                                @error('description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div id="items_data"></div>

                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card  mt-2">
                    <div class="card-body">
                        <div class="mb-4">
                            <label class="my-1 mb-2">List Detail Barang</label>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">Barang</th>
                                            <th scope="col">Harga</th>
                                            <th scope="col">Qty</th>
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="item_details">
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>
@endsection

@push('script')
    <script type="text/javascript">
        var no = 0;
        $('#addDetail').on('click', function() {
            var $option = $('#items').find('option:selected');
            var $price = $('#price');
            var $quantity = $('#quantity');

            var value = $option.val();
            var text = $option.text();
            var price = $price.val();
            var qty = $quantity.val();
            if (value != '' && qty != '') {
                addItem(value, text, price, qty);
            }
        })

        function addItem(value, text, price, qty) {
            no++
            var item =
                `<tr class="item-${no}">` +
                `    <td>${text}</td>` +
                `    <td>${rupiah(price)}</td>` +
                `    <td>${qty}</td>` +
                `    <th scope="row">` +
                `        <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeItem(${no}, ${value})">` +
                '            <i class="bi bi-x-lg"></i>' +
                '        </button>' +
                `    </th>` +
                `</tr>`;

            var itemData =
                `<input type="hidden" name="item_details[]" class="item-${no}" value="${value}">` +
                `<input type="hidden" name="quantity_details[]" class="item-${no}" value="${qty}">` +
                `<input type="hidden" name="price_details[]" class="item-${no}" value="${price}">`;

            $('#item_details').append(item);
            $('#items_data').append(itemData);
            $(`#items option[value=${value}]`).hide();
            $('#items').val('').change();
            $('#items option[value=""]').attr('selected', 'selected');
            $('#quantity').val('');
            $('#price').val('');
        }

        function removeItem(id, value) {
            var path = $(`.item-${id}`).remove()
            $(`#items option[value=${value}]`).show();
        }

        $('#formSubmit').on('click', function() {
            var $formData = $('#formData');
            $formData.submit()
        })
        details
        var details = <?= json_encode(old('details', isset($post['details']) ? $post['details'] : '')) ?>;

        if (details != '' && details != null) {
            details.forEach(e => {
                addItem(e.item.id, e.item.name, e.price, e.quantity);
            });
        }
    </script>
@endpush
