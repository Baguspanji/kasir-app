@extends('auth.app')

@section('content')
    <section class="vh-100">
        <div class="container-fluid h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-md-9 col-lg-6 col-xl-5">
                    <img src="{{ asset('assets/images/dummy-image.png') }}" class="img-fluid" alt="Background"
                        style="width: 80%;">
                </div>
                <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="d-flex flex-row align-items-center justify-content-center justify-content-lg-start">
                            {{-- <img src="{{ asset('assets/images/dummy-image.png') }}" class="logo-img"
                                style="width: 120px; margin-right: 10px;"> --}}
                            <span class="logo-title fw-bolder primary ">{{ config('app.name', 'Laravel') }}<br>
                                <p>{{ config('app.name', 'Laravel') }} hadir untuk membantu jalannya transaksi toko</p>
                            </span>
                        </div>

                        <div class="divider d-flex align-items-center mb-4">
                            <p class="text-center text-primary fw-bold mx-3 mb-0">Masuk</p>
                        </div>

                        <!-- Username input -->
                        <div class="form-outline mb-4">
                            <label class="form-label" for="form3Example3">
                                <IconUser :size="18" /> Email
                            </label>
                            <input type="email" name="email" class="form-control  @error('email') is-invalid @enderror"
                                id="email" value="{{ old('email') }}" required autocomplete="email" autofocus
                                placeholder="Masukkan Email">
                        </div>

                        <!-- Password input -->
                        <div class="form-outline mb-3">
                            <label class="form-label" for="form3Example4">
                                <IconKey :size="18" /> Password
                            </label>
                            <input type="password" name="password"
                                class="form-control  @error('password') is-invalid @enderror" id="password"
                                value="{{ old('password') }}" required autofocus placeholder="Masukkan Password">

                        </div>


                        <div class="text-center w-100 mt-4 pt-2">
                            <button type="submit" class="btn btn-primary w-100"
                                style="padding-left: 2.5rem; padding-right: 2.5rem;">
                                <IconLogin :size="18" /> Login
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <div
            class="d-flex flex-column flex-md-row text-center text-md-start justify-content-center py-4 px-4 px-xl-5 bg-primary">
            <!-- Copyright -->
            <div class="text-white mb-3 mb-md-0 footer-creator">
                Powered By Jong java Technology.
            </div>
            <!-- Copyright -->
        </div>
    </section>
@endsection

@push('style')
    <style>
        body {
            background: white !important;
            font-size: 13px;
        }

        .divider:after,
        .divider:before {
            content: "";
            flex: 1;
            height: 1px;
            background: #eee;
        }

        .h-custom {
            height: calc(100% - 69px);
        }

        @media (max-width: 450px) {
            .h-custom {
                height: 100%;
            }
        }

        .logo-img {
            width: 5vw;
        }

        .logo-title {
            font-size: 2vw;
            color: var(--primary-color);
            /* margin-left: .75rem; */
            margin-top: -2px;
            font-weight: 800;
        }

        .logo-title p {
            font-size: 14px;
            margin-top: -10px;
            color: var(--secondary-color);
        }

        .form-label,
        button,
        .footer-creator {
            font-size: 13px;
        }

        input,
        input::placeholder {
            font-size: 13px;
        }
    </style>
@endpush
