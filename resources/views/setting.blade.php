@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row g-5 mb-4">
            <div class="col-md-12">
                <div class="card rounded-4 shadow-lg">
                    <div class="card-body">
                        <div class="row justify-content-between">
                            <div class="col-md-6">
                                <h2 class="fw-bold p-0 m-0">Pengaturan Kasir</h2>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card rounded-4 shadow-lg mt-2">
                    <div class="card-body">
                        <form action="{{ route('setting.update') }}" method="POST" id="formData">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Toko</label>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror" id="name"
                                    value="{{ old('name', isset($post->name) ? $post->name : '') }}"
                                    placeholder="Masukkan Nama Toko">

                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">Alamat</label>
                                <input type="text" name="address"
                                    class="form-control @error('address') is-invalid @enderror" id="address"
                                    value="{{ old('address', isset($post->address) ? $post->address : '') }}"
                                    placeholder="Masukkan Alamat" required="">

                                @error('address')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label">No. HP</label>
                                <input type="text" name="phone"
                                    class="form-control @error('phone') is-invalid @enderror" id="phone"
                                    value="{{ old('phone', isset($post->phone) ? $post->phone : '') }}"
                                    placeholder="Masukkan No. HP" required="">

                                @error('phone')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="pr_name" class="form-label">Penanggun Jawab</label>
                                <input type="text" name="pr_name"
                                    class="form-control @error('pr_name') is-invalid @enderror" id="pr_name"
                                    value="{{ old('pr_name', isset($post->pr_name) ? $post->pr_name : '') }}"
                                    placeholder="Masukkan Penanggun Jawab" required="">

                                @error('pr_name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="open_time" class="form-label">Jam Buka</label>
                                <input type="text" name="open_time"
                                    class="form-control @error('open_time') is-invalid @enderror" id="open_time"
                                    value="{{ old('open_time', isset($post->open_time) ? $post->open_time : '') }}"
                                    placeholder="Masukkan Jam Buka" required="">

                                @error('open_time')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="struk_message" class="form-label">Pesan Struk</label>
                                <input type="text" name="struk_message"
                                    class="form-control @error('struk_message') is-invalid @enderror" id="struk_message"
                                    value="{{ old('struk_message', isset($post->struk_message) ? $post->struk_message : '') }}"
                                    placeholder="Masukkan Pesan Struk" required="">

                                @error('struk_message')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3 row">
                                <label for="message" class="form-label">Pesan</label>
                                <div class="col-11">
                                    <input type="text" name="message"
                                        class="form-control @error('message') is-invalid @enderror" id="message"
                                        value="{{ old('message', isset($post->message) ? $post->message : '') }}"
                                        placeholder="Masukkan Pesan">

                                    @error('message')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="col-1">
                                    <button type="button" class="btn btn-primary float-end" id="addMessage"><i
                                            class="bi bi-plus-lg"></i></button>
                                </div>
                            </div>

                            @error('messages')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                            <div class="mb-3">
                                <table class="table table-bordered" id="tableMessage">
                                    <thead>
                                        <tr>
                                            <th scope="col">Pesan</th>
                                            <th scope="col" class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>

                            <div class="my-4 d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary w-50">Simpan</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endsection

    @push('script')
        <script type="text/javascript">
            var messages = @json(isset($post) ? $post->messages : []);

            messages.forEach(function(message) {
                addMessage(message);
            });

            $('#addMessage').click(function() {
                var message = $('#message').val();

                addMessage(message);
                $('#message').val('');
            });

            $(document).on('click', '.deleteMessage', function() {
                $(this).closest('tr').remove();
            });

            function addMessage(message) {
                var html = '';
                html += '<tr>';
                html += '<td>' + message + '</td>';
                html += '<input type="hidden" name="messages[]" value="' + message + '">';
                html +=
                    '<td class="text-center"><button type="button" class="btn btn-danger btn-sm deleteMessage"><i class="bi bi-trash"></i></button></td>';
                html += '</tr>';
                $('#tableMessage tbody').append(html);
            }
        </script>
    @endpush
