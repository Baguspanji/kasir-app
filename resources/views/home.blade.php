@extends('layouts.app')

@section('content')
    <main class="container">

        <div class="row g-5 mb-4">
            <div class="col-md-12">

                <div class="card mt-2 text-center">
                    <div class="card-header">
                        <h3>Pemberitahuan</h3>
                    </div>
                    <div class="card-body">
                        @foreach ($app->messages as $message)
                            <p class="fs-4">{{ $message }}</p>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        </div>

    </main>
@endsection
