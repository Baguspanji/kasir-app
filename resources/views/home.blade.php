@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row g-4 mb-6 px-10">

            <div class="col-md-12">
                <div class="card mt-2 text-center border border-2 border-primary rounded-4">
                    <div class="card-body py-10 px-10">
                        @foreach ($app->messages as $message)
                            <p class="fs-4">{{ $message }}</p>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card mt-2 text-center border border-2 border-primary rounded-4">
                    <div class="card-body py-10 px-10 d-flex align-content-center">
                        <div class="text-start w-100">
                            <span>Total Item</span>
                            <h2>12</h2>
                        </div>
                        <div class="p-2">
                            <i class="bi bi-box-seam-fill pdi border border-2 border-primary-icon rounded-4"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card mt-2 text-center border border-2 border-secondary rounded-4">
                    <div class="card-body py-10 px-10 d-flex align-content-center">
                        <div class="text-start w-100">
                            <span>Total Transaksi</span>
                            <h2>230</h2>
                        </div>
                        <div class="p-2">
                            <i
                                class="bi bi-file-earmark-ruled-fill pdi border border-2 border-secondary-icon rounded-4"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card mt-2 text-center border border-2 border-purple rounded-4">
                    <div class="card-body py-10 px-10 d-flex align-content-center">
                        <div class="text-start w-100">
                            <span>Total Transaksi Harian</span>
                            <h2>40</h2>
                        </div>
                        <div class="p-2">
                            <i class="bi bi-file-earmark-ruled-fill pdi border border-2 border-purple-icon rounded-4"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card mt-2 text-center border border-2 border-green rounded-4">
                    <div class="card-body py-10 px-10 d-flex align-content-center">
                        <div class="text-start w-100">
                            <span>Total Pendapatan Harian</span>
                            <h2 style="font-size: 18pt; margin-top: 12px;">Rp. 200.000</h2>
                        </div>
                        <div class="p-2">
                            <i class="bi bi-file-earmark-ruled-fill pdi border border-2 border-green-icon rounded-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .border-primary {
            border-color: #F6B17A !important;
            background-color: #fff !important;
        }

        .border-primary-icon {
            border-color: #F6B17A !important;
            background-color: #F6B17A !important;
        }

        .border-secondary {
            border-color: #80BCBD !important;
            background-color: #fff !important;
        }

        .border-secondary-icon {
            border-color: #73dee0 !important;
            background-color: #73dee0 !important;
        }

        .border-purple {
            border-color: #cc8ad1 !important;
            background-color: #fff !important;
        }

        .border-purple-icon {
            border-color: #cc8ad1 !important;
            background-color: #cc8ad1 !important;
        }

        .border-green {
            border-color: #8fd18a !important;
            background-color: #fff !important;
        }

        .border-green-icon {
            border-color: #8fd18a !important;
            background-color: #8fd18a !important;
        }

        .card-body i {
            font-size: 30pt;
        }

        .card-body h2 {
            font-size: 30pt;
            font-weight: 800;
        }

        .card-body span {
            font-size: 12pt;
            font-weight: 600;
            padding: 0;
            max-width: 0;
        }

        .pdi {
            padding: 6px 13px;
            color: #fff;
        }
    </style>
@endpush
