@extends('layouts.app')

@section('content')
    <main class="container">

        <div class="row mb-4">
            <div class="col-md-12 d-flex justify-content-between mb-2">
                <h4>Tambah Barang</h4>
                <div>
                </div>
            </div>

            <div class="offset-3 col-md-6">
                <div class="card mt-2">
                    <div class="card-body">
                        <form action="{{ isset($post) ? route('item.update', $post->id) : route('item.store') }}"
                            method="POST" id="formData">
                            {{ isset($post) ? method_field('PUT') : '' }}
                            @csrf

                            {{-- Kode --}}
                            <div class="mb-3">
                                <label for="code" class="form-label">Kode Barang</label>
                                <input type="text" name="code"
                                    class="form-control @error('code') is-invalid @enderror" id="code"
                                    value="{{ old('code', isset($post->code) ? $post->code : '') }}"
                                    placeholder="Masukkan Kode Barang">

                                @error('code')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Barang</label>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror" id="name"
                                    value="{{ old('name', isset($post->name) ? $post->name : '') }}"
                                    placeholder="Masukkan Nama Barang" required="">

                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3 row">
                                <div class="col-2">
                                    <label for="per_unit" class="form-label">Per</label>
                                    <input type="text" name="per_unit"
                                        class="form-control @error('per_unit') is-invalid @enderror" id="per_unit"
                                        value="{{ old('per_unit', isset($post->per_unit) ? $post->per_unit : '') }}"
                                        placeholder="Masukkan Per Unit">

                                    @error('per_unit')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-10">
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
                                                [
                                                    'value' => 'liter',
                                                    'name' => 'Liter',
                                                ],
                                                [
                                                    'value' => 'kodi',
                                                    'name' => 'Kodi',
                                                ],
                                                [
                                                    'value' => 'pack',
                                                    'name' => 'Pack',
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
                            </div>

                            <div class="mb-3">
                                <label for="take_price" class="form-label">Harga Beli</label>
                                <input type="text" name="take_price"
                                    class="form-control @error('take_price') is-invalid @enderror" id="take_price"
                                    value="{{ old('take_price', isset($post->take_price) ? $post->take_price : '') }}"
                                    placeholder="Masukkan Harga Beli" required="">

                                @error('take_price')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="price" class="form-label">Harga Jual</label>
                                <input type="text" name="price"
                                    class="form-control @error('price') is-invalid @enderror" id="price"
                                    value="{{ old('price', isset($post->price) ? $post->price : '') }}"
                                    placeholder="Masukkan Harga Jual" required="">

                                @error('price')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="my-4 d-flex justify-content-center">
                                <button type="submit"
                                    class="btn btn-{{ isset($post) ? 'warning' : 'primary' }} w-50">{{ isset($post) ? 'Update' : 'Simpan' }}</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </main>
@endsection

@push('script')
    <script type="text/javascript">
        // set per_unit 1
        $('#per_unit').val(1);
    </script>
@endpush
