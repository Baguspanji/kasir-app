@extends('layouts.app')

@section('content')
    <main class="container">

        <div class="row mb-4">
            <div class="col-md-12 d-flex justify-content-between mb-2">
                <h4>Update Profile</h4>
                <div>
                </div>
            </div>

            <div class="offset-3 col-md-6">
                <div class="card mt-2">
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

                            <div class="mb-3 row">
                                <label for="message" class="form-label">Pesan</label>
                                <div class="col-10">
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

                                <div class="col-2">
                                    <button type="button" class="btn btn-primary" id="addMessage"><i
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
                                            <th scope="col">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
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
                '<td><button type="button" class="btn btn-danger btn-sm deleteMessage"><i class="bi bi-trash"></i></button></td>';
            html += '</tr>';
            $('#tableMessage tbody').append(html);
        }
    </script>
@endpush
