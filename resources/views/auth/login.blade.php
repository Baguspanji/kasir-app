@extends('auth.app')

@section('content')
    <div class="container py-5" style="margin-top: 100px;">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <h3>{{ __('Login') }} {{ config('app.name', 'Laravel') }}</h3>

                <div class="card rounded shadow">
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <input type="email" name="email"
                                    class="form-control  @error('email') is-invalid @enderror" id="email"
                                    value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password"
                                    class="form-control  @error('password') is-invalid @enderror" id="password"
                                    value="{{ old('password') }}" required autofocus>

                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="row mt-5 justify-content-center">
                                <div class="col-md-8">
                                    <button type="submit" class="btn btn-primary w-100">
                                        {{ __('Login') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
