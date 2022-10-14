@extends('layouts.app')

@section('content')
    <main class="container">

        <div class="row mb-4">
            <div class="col-md-12 d-flex justify-content-between mb-2">
                <h4>Tambah Pembelanjaan</h4>
                <div>
                    {{-- <a class="btn btn-primary" href="{{ route('shopping.create') }}">Tambah Data</a> --}}
                </div>
            </div>

            <div class="col-md-12">
                <div class="card mt-2">
                    <div class="card-body">
                    </div>
                </div>
            </div>
        </div>
        </div>

    </main>
@endsection

@push('script')
    <script type="text/javascript"></script>
@endpush
