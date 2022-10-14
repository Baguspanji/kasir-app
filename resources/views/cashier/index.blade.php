@extends('layouts.app')

@section('content')
    <main class="container">
        <!-- <div class="row mb-2">
                <div class="col-md-6">
                  <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                    <div class="col p-4 d-flex flex-column position-static">
                      <strong class="d-inline-block mb-2 text-primary">World</strong>
                      <h3 class="mb-0">Featured post</h3>
                      <div class="mb-1 text-muted">Nov 12</div>
                      <p class="card-text mb-auto">This is a wider card with supporting text below as a natural lead-in to additional content.</p>
                      <a href="#" class="stretched-link">Continue reading</a>
                    </div>
                    <div class="col-auto d-none d-lg-block">
                      <svg class="bd-placeholder-img" width="200" height="250" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"/><text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text></svg>

                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
                    <div class="col p-4 d-flex flex-column position-static">
                      <strong class="d-inline-block mb-2 text-success">Design</strong>
                      <h3 class="mb-0">Post title</h3>
                      <div class="mb-1 text-muted">Nov 11</div>
                      <p class="mb-auto">This is a wider card with supporting text below as a natural lead-in to additional content.</p>
                      <a href="#" class="stretched-link">Continue reading</a>
                    </div>
                    <div class="col-auto d-none d-lg-block">
                      <svg class="bd-placeholder-img" width="200" height="250" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"/><text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text></svg>

                    </div>
                  </div>
                </div>
              </div> -->

        <div class="row g-5 mb-4">
            <div class="col-md-8">
                <div class="row pt-2 mb-4 mt-3 px-5">
                    <div class="input-group">
                        <input class="form-control" id="search" type="search" placeholder="Cari Barang"
                            aria-label="Search">
                        <span class="input-group-text" id="icon"><i class="bi bi-search"></i></span>
                    </div>
                </div>

                <div id="produk" class="row g-5">

                    <table id="dt" class="table w-100">
                        <thead>
                            <tr>
                                <th>nama</th>
                                <th>gender</th>
                                <th>email</th>
                                <th>address</th>
                            </tr>
                        </thead>
                    </table>
                </div>

            </div>

            <div class="col-md-4">
                <div class="position-sticky" style="top: 2rem;">
                    <div class="p-4 pb-5 bg-light rounded">
                        <h4>Keranjang</h4>
                        <table class="table">
                            <thead class="text-center">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Barang</th>
                                    <th scope="col">Banyak</th>
                                    <th scope="col">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <tr>
                                    <td><a href="#" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></a></td>
                                    <td>Oreo</td>
                                    <td><input type="number" class="form-control input-qty" value="12"></td>
                                    <td>Rp. 24.000</td>
                                </tr>
                                <tr>
                                    <td><a href="#" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></a></td>
                                    <td>Bakso</td>
                                    <td><input type="number" class="form-control input-qty" value="2"></td>
                                    <td>Rp. 24.000</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="fw-bold">Total</td>
                                    <td>Rp. 48.000</td>
                                </tr>
                            </tbody>
                        </table>

                        <a href="#" class="btn btn-success btn-sm float-end"><i class="bi bi-cash"></i> Proses</a>
                    </div>
                </div>

            </div>
        </div>
        {{-- </div> --}}

    </main>
@endsection

@push('style')
    <style>
        #dt.dataTable.no-footer {
            border-bottom: unset;
        }

        #dt tbody td {
            display: block;
            border: unset;
        }

        #dt>tbody>tr>td {
            border-top: unset;
        }

        .dataTables_paginate {
            display: flex;
            align-items: center;
        }

        .dataTables_paginate a {
            padding: 0 10px;
        }

        img {
            height: 180px;
        }
    </style>
@endpush

@push('script')
    <script type="text/javascript">
        $(document).ready(function() {
            var dt = $('#dt').DataTable({
                ajax: "https://jsonplaceholder.typicode.com/posts",
                bInfo: false,
                pageLength: 12,
                lengthChange: false,
                deferRender: true,
                processing: true,
                // language: {
                //   paginate: {
                //     previous: "<",
                //     next: ">"
                //   },
                // },
                columns: [{
                        render: function(data, type, row, meta) {
                            var html =
                                '<div class="card shadow">' +
                                '  <img src="./assets/images/bakso.jpg" class="card-img-top">' +
                                '  <div class="card-body">' +
                                '    <div class="card-text">' + row.title + '</div>' +
                                '    <div class="card-text">Porsi Besar</div>' +
                                '    <div class="d-flex justify-content-between">' +
                                '      <span class="card-text">Rp. 12.000</span>' +
                                '      <a href="#" class="btn btn-primary btn-sm float-end"><i class="bi bi-cart-plus"></i></a>' +
                                '    </div>' +
                                '  </div>' +
                                '</div>';
                            return html;
                        }
                    },
                    {
                        data: "nama",
                        visible: false
                    }
                ],
            });

            dt.on('draw', function(data) {
                $('#dt tbody').addClass('row');
                $('#dt tbody tr').addClass('col-md-3 col-sm-12');
            });

            $("#dt thead").hide();
            $('#dt_filter').hide();

            $('#search').keyup(function() {
                dt.search($(this).val()).draw();
            });

        });
    </script>
@endpush
I