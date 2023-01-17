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

                            {{-- <div class="mb-4">
                                <div class="form-group">
                                    <label>Gambar</label>
                                    <div class="row justify-content-center py-3">
                                        <div class="card shadow-none card-upload mx-1 my-1 col-4" id="btn-upload">
                                            <div class="card-body align-items-center d-flex justify-content-center dropzone"
                                                id="dropzone">
                                                <div class="text-center">
                                                    <p>Drag and Drop</p>
                                                    <label class="btn btn-outline-primary btn-sm">
                                                        Choose File
                                                        <input type="file" class="account-settings-fileinput"
                                                            id="fileInp">
                                                    </label> &nbsp;
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="progress" style="display:none">
                                    <div id="progressBar" class="progress-bar bg-success" role="progressbar"
                                        aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                                        <span class="sr-only">0%</span>
                                    </div>
                                </div>

                                <div class="error"></div>

                                @error('image')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div> --}}

                            <div class="my-4 d-flex justify-content-center">
                                {{-- <input type="hidden" name="image" id="image"> --}}
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

@push('style')
    <style>
        #table_filter input {
            border-radius: 6px;
            padding-left: 10px;
            padding-right: 10px;
        }

        .dataTables_paginate {
            padding-top: 20px;
        }

        .paginate_button {
            margin-left: 10px;
            display: inline;
        }

        img {
            width: 260px;
            /* height: 260px; */
        }

        .card-upload {
            width: 260px;
            height: 260px;
            padding: 10px;
        }

        .child {
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .child-center {
            position: absolute;
        }

        .child-bottom {
            position: absolute;
            bottom: 20px;
        }

        .child-title {
            position: absolute;
            margin-left: auto;
            margin-right: auto;
            left: 0;
            right: 0;
            bottom: 20px;
            text-align: center;
        }

        .parent {
            position: relative;
        }

        .dropzone {
            background-color: rgb(248, 248, 248);
            border: 2px dashed rgba(155, 155, 155, 0.500);
        }

        .dropzone:hover,
        .dropzone-hover {
            background-color: #ddd;
            border-color: #3070a577;
            border-style: solid;
        }

        .account-settings-fileinput {
            position: absolute;
            visibility: hidden;
            width: 1px;
            height: 1px;
            opacity: 0;
        }
    </style>
@endpush

@push('script')
    {{-- <script>
        var i = 0;

        function addfile(file) {
            var value = '' +
                `<div class="parent card shadow-none card-upload path col-4">` +
                '    <div class="card-body align-items-center d-flex justify-content-center dropzone">' +
                `       <img src="${file}"` +
                '           class="img-thumbnail" alt="...">' +
                `       <a class="btn btn-danger btn-sm child" onClick="btn_path()"><i class="bi bi-trash"></i></a>` +
                '    </div>' +
                '</div>' +
                '';
            $(value).insertBefore("#btn-upload");
            $("#btn-upload").hide();
            $("#image").val(file);
        }

        function btn_path(id) {
            var path = $(`#path`).val()
            $(`.path`).remove()
            $("#btn-upload").show();
            $("#image").val('');
        }

        function file_upload(file) {
            var formData = new FormData();
            formData.append("file", file);
            formData.append("type", 'items');
            $.ajax({
                type: 'POST',
                url: "{{ url('api/upload/') }}",
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                success: function(res) {
                    addfile(res);
                    $('.error').empty()
                },
                error: function(res) {
                    var err = eval("(" + res.responseText + ")");
                    err.error.file.forEach(e => {
                        $('.error').append(`<div class="text-danger mt-2">${e}</div>`)
                    });
                    $('.progress').hide();
                },
                xhr: function() {
                    var xhr = new window.XMLHttpRequest();
                    xhr.upload.addEventListener('progress', function(e) {
                        if (e.lengthComputable) {
                            var percent = Math.round((e.loaded / e.total) * 100);
                            $('#progressBar').attr('aria-valuenow', percent).css('width',
                                percent + '%').text(percent + '%');
                            if (percent === 100) {
                                $('.progress').hide();
                            }
                        }
                    });
                    return xhr;
                },
            });
        }
        $("input[type=file]").change(function(event) {
            var file = $("#fileInp")[0].files[0];
            file_upload(file);
        });
        (function() {
            function Init() {
                var fileDrag = document.getElementById('dropzone');
                // Is XHR2 available?
                var xhr = new XMLHttpRequest();
                if (xhr.upload) {
                    // File Drop
                    fileDrag.addEventListener('dragover', fileDragHover, false);
                    fileDrag.addEventListener('dragleave', fileDragHover, false);
                    fileDrag.addEventListener('drop', fileSelectHandler, false);
                }
            }

            function fileDragHover(e) {
                var fileDrag = document.getElementById('dropzone');
                e.stopPropagation();
                e.preventDefault();
                if (e.type === 'dragover') {
                    fileDrag.classList.add("dropzone-hover")
                } else {
                    fileDrag.classList.remove("dropzone-hover")
                }
            }

            function fileSelectHandler(e) {
                // Fetch FileList object
                var files = e.target.files || e.dataTransfer.files;
                // Cancel event and hover styling
                fileDragHover(e);
                // Process all File objectslet type = prompt('Type File Name');
                file_upload(files[0])
            }
            // Check for the various File API support.
            if (window.File && window.FileList && window.FileReader) {
                Init();
            }
        })();
        var files = <?= json_encode(old('image', isset($post['image']) ? $post['image'] : '')) ?>;
        if (files != '' && files != null) {
            addfile(files);
        }
    </script> --}}
@endpush
