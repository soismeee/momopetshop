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
                        <div class="row">
                            @if ($treatment->count())
                                @foreach ($treatment as $item)                            
                                    <div class="col-xl-4 col-sm-6">
                                        <div class="card">
                                            <div class="card-body overflow-hidden position-relative">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0">
                                                        <div class="avatar-sm">
                                                            <span class="avatar-title rounded-circle bg-primary text-white font-size-16">
                                                                <i class="bx bx-question-mark"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1 ms-3">
                                                        <h5 class="font-size-17">{{ $item->nama_treatment }}</h5>
                                                        <p class="text-muted mt-2 mb-0">{{ $item->keterangan_treatment }} <br />
                                                        Tarif Rp. {{ number_format($item->harga_treatment,0,',','.') }}
                                                        </p>

                                                        <div class="mt-3 pt-1">
                                                            <a href="" class="text-primary fw-semibold"> <u>Lihat lebih lanjnut </u> <i class="mdi mdi-arrow-right ms-1 align-middle"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end card body -->
                                        </div>
                                        <!-- end card -->
                                    </div>
                                @endforeach
                            @else
                                <h4 class="text-center mt-3 mb-4">Tidak ada data treatment</h4>
                            @endif
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