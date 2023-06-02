@extends('layout.main')

@section('container')
    <div class="page-content">
        <div class="container-fluid">
            <div class="col-xl-12">
                <div class="row">
                    
                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <div>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar">
                                            <div class="avatar-title rounded bg-soft-primary">
                                                <i class="bx bx-check-shield font-size-24 mb-0 text-primary"></i>
                                            </div>
                                        </div>

                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-0 font-size-15">Total Barang di keranjang</h6>
                                        </div>
                                    </div>

                                    <div>
                                        <h4 class="mt-4 pt-1 mb-0 font-size-22"> {{ $keranjang }} </h4>
                                        <div class="d-flex mt-1 align-items-end overflow-hidden">
                                            <div class="flex-grow-1">
                                                <p class="text-muted mb-0 text-truncate">barang yang berada di keranjang momopetshop</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6">
                        <div class="card">
                            <div class="card-body">
                                <div>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar">
                                            <div class="avatar-title rounded bg-soft-primary">
                                                <i class="bx bx-cart-alt font-size-24 mb-0 text-primary"></i>
                                            </div>
                                        </div>

                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-0 font-size-15">Total Pembelian</h6>
                                        </div>
                                    </div>

                                    <div>
                                        <h4 class="mt-4 pt-1 mb-0 font-size-22">{{ $order }} <span class="text-danger fw-medium font-size-13 align-middle"> </h4>
                                        <div class="d-flex mt-1 align-items-end overflow-hidden">
                                            <div class="flex-grow-1">
                                                <p class="text-muted mb-0 text-truncate">Total pembelian di momopetshop</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
@endsection