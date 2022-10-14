@extends('layouts.app')

@section('content')
    <main class="container">

        <div class="row mb-4">
            <div
                class="{{ isset($request['type']) && $request['type'] != 'sell' ? 'offset-3 col-md-6' : 'col-md-12' }} d-flex justify-content-between mb-2">
                <h4>Tambah Barang</h4>
                <div>
                    @if (isset($request['type']) && $request['type'] == 'sell')
                        <button type="button" class="btn btn-{{ isset($post) ? 'warning' : 'primary' }}"
                            id="formSubmit">{{ isset($post) ? 'Update' : 'Simpan' }}</button>
                    @endif
                </div>
            </div>

            <div class="{{ isset($request['type']) && $request['type'] != 'sell' ? 'offset-3' : '' }} col-md-6">
                <div class="card mt-2">
                    <div class="card-body">
                        <form action="{{ isset($post) ? route('item.update', $post->id) : route('item.store') }}"
                            method="POST" id="formData">
                            {{ isset($post) ? method_field('PUT') : '' }}
                            @csrf

                            <input type="hidden" name="type"
                                value="{{ isset($request['type']) ? $request['type'] : 'sell' }}">

                            <div class="mb-3">
                                <label for="category_id" class="form-label">Kategori</label>
                                <select class="form-select @error('category_id') is-invalid @enderror" id="category_id"
                                    name="category_id">
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($categories as $item)
                                        @if (old('category_id', isset($post->category_id) ? $post->category_id : '') == $item->id)
                                            <option value="{{ $item->id }}" selected>{{ $item->name }}
                                            </option>
                                        @else
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endif
                                    @endforeach
                                </select>

                                @error('category_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror" id="name"
                                    value="{{ old('name', isset($post->name) ? $post->name : '') }}"
                                    placeholder="Masukkan Nama Kelas" required="">

                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="unit" class="form-label">Unit</label>
                                <select class="form-select @error('unit') is-invalid @enderror" id="unit"
                                    name="unit">
                                    <option value="">Pilih Unit</option>
                                    @php
                                        $units = [
                                            [
                                                'value' => 'gram',
                                                'name' => 'Gram',
                                            ],
                                            [
                                                'value' => 'pcs',
                                                'name' => 'Pcs',
                                            ],
                                        ];
                                    @endphp
                                    @foreach ($units as $item)
                                        @if (old('name', isset($post->unit) ? $post->unit : '') == $item['value'])
                                            <option value="{{ $item['value'] }}" selected>{{ $item['name'] }}</option>
                                        @else
                                            <option value="{{ $item['value'] }}">{{ $item['name'] }}</option>
                                        @endif
                                    @endforeach
                                </select>

                                @error('unit')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            @if (isset($request['type']) && $request['type'] == 'sell')
                                <div class="mb-3">
                                    <label for="price" class="form-label">Harga</label>
                                    <input type="text" name="price"
                                        class="form-control @error('price') is-invalid @enderror" id="price"
                                        value="{{ old('price', isset($post->price) ? $post->price : '') }}"
                                        placeholder="Masukkan Nama Kelas" required="">

                                    @error('price')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <div class="row justify-content-between">
                                        <div class="col-9">
                                            <label for="items" class="form-label">Detail Barang</label>
                                            <select class="form-select" id="items">
                                                <option value="">Pilih Barang</option>
                                                @foreach ($items as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }} -
                                                        {{ Str::ucfirst($item->unit) }}</option>
                                                @endforeach
                                            </select>
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

                                <div id="items_data"></div>
                            @endif

                            @if (isset($request['type']) && $request['type'] == 'storage')
                                <div class="my-4 d-flex justify-content-center">
                                    <button type="submit"
                                        class="btn btn-{{ isset($post) ? 'warning' : 'primary' }} w-50">{{ isset($post) ? 'Update' : 'Simpan' }}</button>
                                </div>
                            @endif

                        </form>
                    </div>
                </div>
            </div>

            @if (isset($request['type']) && $request['type'] == 'sell')
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
            @endif
        </div>

    </main>
@endsection

@push('script')
    <script type="text/javascript">
        var no = 0;
        $('#addDetail').on('click', function() {
            var $option = $('#items').find('option:selected');
            var $quantity = $('#quantity');

            var value = $option.val();
            var text = $option.text();
            var qty = $quantity.val();
            if (value != '' && qty != '') {
                addItem(value, text, qty);
            }
        })

        function addItem(value, text, qty) {
            no++
            var item =
                `<tr class="item-${no}">` +
                `    <td>${text}</td>` +
                `    <td>${qty}</td>` +
                `    <th scope="row">` +
                `        <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeItem(${no}, ${value})">` +
                '            <i class="bi bi-x-lg"></i>' +
                '        </button>' +
                `    </th>` +
                `</tr>`;

            var itemData =
                `<input type="hidden" name="item_details[]" class="item-${no}" value="${value}">` +
                `<input type="hidden" name="quantity_details[]" class="item-${no}" value="${qty}">`;

            $('#item_details').append(item);
            $('#items_data').append(itemData);
            $(`#items option[value=${value}]`).hide();
            $('#items').val('').change();
            $('#items option[value=""]').attr('selected', 'selected');
            $('#quantity').val('');
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
                addItem(e.id, e.name, e.quantity);
            });
        }
    </script>
@endpush
