@extends('layouts.app')

@section('content')
    <main class="container">

        <div class="row mb-4">
            <div class="offset-3 col-md-6 d-flex justify-content-between mb-2">
                <h4>Tambah Barang</h4>
                <div>
                </div>
            </div>

            <div class="offset-3 col-md-6">
                <div class="card mt-2">
                    <div class="card-body">
                        <form action="{{ isset($post) ? route('user.update', $post->id) : route('user.store') }}"
                            method="POST" id="formData">
                            {{ isset($post) ? method_field('PUT') : '' }}
                            @csrf

                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" name="username"
                                    class="form-control @error('username') is-invalid @enderror" id="username"
                                    value="{{ old('username', isset($post->username) ? $post->username : '') }}"
                                    placeholder="Masukkan Nama Kelas" required="">

                                @error('username')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" name="email"
                                    class="form-control @error('email') is-invalid @enderror" id="email"
                                    value="{{ old('email', isset($post->email) ? $post->email : '') }}"
                                    placeholder="Masukkan Email" required="">

                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="name" class="form-label">Nama</label>
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

                            <div class="my-4 d-flex justify-content-center">
                                <button type="submit"
                                    class="btn btn-{{ isset($post) ? 'warning' : 'primary' }} w-50">{{ isset($post) ? 'Update' : 'Simpan' }}</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

    </main>
@endsection

@push('script')
    <script type="text/javascript"></script>
@endpush
