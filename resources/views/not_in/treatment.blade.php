@extends('not_in.main')

@section('container')
    <div class="page-content">
        <div class="container-fluid">
            
            <div class="row">
                <div class="col-xxl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="col-lg-6">
                                    <div class="text-center my-5">
                                        <img src="./assets/images/faq-img.png" class="img-fluid" alt="">
                                    </div>
                                </div>
                            </div>
                            <!-- end row -->
                        </div>
                    </div>
                </div>
            </div>
    
            <div class="row">
                <div class="col-xxl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="font-size-14 mb-3">List treatment yang tersedia : </h5>
                                </div>
                                <div class="row">
                                    @if ($treatment->count())
                                    @foreach ($treatment as $item)   
                                        <div class="col-xl-3 col-lg-6">
                                            <div class="border p-4 rounded mt-4 mt-lg-0">
                                                <i class="bx bxs-paste h2 text-primary mb-0"></i>
                                                <h5 class="font-size-17 mb-0 mt-3">{{ $item->nama_treatment }}</h5>
                                                <p class="mb-2 pt-2">Rp. {{ number_format($item->harga_treatment,0,',','.') }}</p>
                                                <a href="/login" class="btn btn-sm btn-primary">Lihat detail</a>    
                                            </div>
                                        </div>
                                    @endforeach
                                    @else
                                    <h4 class="text-center mt-3 mb-4">Tidak ada data treatment</h4>
                                    @endif
                                </div>
                            </div>
                            <!-- end row -->
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
@endsection