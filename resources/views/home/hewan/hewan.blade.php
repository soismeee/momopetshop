@extends('layout.main')
@push('css')
    <link href="/assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
@endpush

@section('container')
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-xxl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-start mb-2">
                                <div class="flex-grow-1">
                                    <h5 class="card-title">Hewan terbaru</h5>
                                </div>
                            </div>
                            @if($hewan->count())

                            <div class="row align-items-center">
                                <div class="col-md-5">
                                    <div class="popular-product-img p-2">
                                        <img src="/Gambar_upload/hewan/{{ $hewan[0]->gambar_hewan }}" alt="">
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <span class="badge badge-soft-primary font-size-10 text-uppercase ls-05">
                                        Hewan peliharaan</span>
                                    <h5 class="mt-2 font-size-16"><a href="{{ url('/cdh') }}/{{ $hewan[0]->id }}" class="text-dark">{{ $hewan[0]->nama_hewan }}</a>
                                    </h5>
                                    <p class="text-muted">Keterangan hewan.</p>

                                    <div class="row g-0 mt-3 pt-1 align-items-end">
                                        <div class="col-4">
                                            <div class="mt-1">
                                                <p class="text-muted mb-1">Jenis kelamin</p>
                                                <h4 class="font-size-16">{{ $hewan[0]->jkel }}</h4>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="mt-1">
                                                <p class="text-muted mb-1">Harga </p>
                                                <h4 class="font-size-16">Rp. {{ number_format($hewan[0]->harga_hewan, 0,',','.') }}</h4>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="mt-1">
                                                <a href="#" class="btn btn-primary btn-sm mb-1 buy" data-id="{{ $hewan[0]->id }}">Buy Now</a>
                                                {{-- <a href="{{ url('che') }}/{{ $hewan[0]->id }}" class="btn btn-primary btn-sm mb-1">Buy Now</a> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                                                    
                            <div class="mx-n4 px-4" data-simplebar="init" style="max-height: 205px;">
                                <div class="simplebar-wrapper" style="margin: 0px -24px;">
                                    <div class="simplebar-height-auto-observer-wrapper">
                                        <div class="simplebar-height-auto-observer"></div>
                                    </div>
                                    <div class="simplebar-mask">
                                        <div class="simplebar-offset" style="right: -17px; bottom: 0px;">
                                            <div class="simplebar-content-wrapper" style="height: auto; overflow: hidden scroll;">
                                                <div class="simplebar-content" style="padding: 0px 24px;">
                                                    
                                                    @foreach ($hewan->skip(1) as $item)                                                                
                                                    <div class="popular-product-box rounded my-2">
                                                        <div class="d-flex align-items-center">
                                                            <div class="flex-shrink-0">
                                                                <div class="avatar-md">
                                                                    <div class="product-img avatar-title img-thumbnail bg-soft-primary border-0">
                                                                        <img src="/Gambar_upload/hewan/{{ $item->gambar_hewan }}" class="img-fluid" alt="">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="flex-grow-1 ms-3 overflow-hidden">
                                                                <h5 class="mb-1 text-truncate">
                                                                    <a href="{{ url('cdh') }}/{{ $item->id }}" class="font-size-15 text-dark">{{ $item->nama_hewan }}</a>
                                                                </h5>
                                                                <p class="text-muted fw-semibold mb-0 text-truncate"> Stok {{ $item->jumlah_hewan }}</p>
                                                            </div>
                                                            <div class="flex-shrink-0 text-end ms-3">
                                                                <h5 class="mb-1"><a href="#" class="font-size-15 text-dark">Rp. {{ number_format($item->harga_hewan, 0,',','.') }}</a></h5>
                                                                <a href="#" class="btn btn-sm btn-primary buy" data-id="{{ $item->id }}">Buy Now</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="simplebar-placeholder" style="width: auto; height: 456px;"></div>
                                </div>
                                <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                                    <div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); display: none;"></div>
                                </div>
                                <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
                                    <div class="simplebar-scrollbar" style="height: 92px; transform: translate3d(0px, 113px, 0px); display: block;">
                                    </div>
                                </div>
                            </div>

                            @else
                            <h3 class="text-center mb-3">Tidak ada hewan</h3>
                            @endif

                        </div>
                    </div>
                </div>

            </div>

        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
@endsection

@push('js')
    <script src="/assets/js/jquery-3.5.1.js"></script>
    <!-- Sweet Alerts js -->
    <script src="/assets/libs/sweetalert2/sweetalert2.min.js"></script>
    <script>

        $(document).on('click', '.buy', function(e){
            let id = $(this).data('id');
            $.ajax({
                type: "GET",
                url: "{{ url('che') }}/"+id,
                data: {'jumlah': 1, '_token': '{{ csrf_token() }}'},
                dataType: "JSON",
                success: function(response){
                    Swal.fire({
                        icon: 'success',
                        title: response.message,
                    });
                }
            });        
        });
    </script>
@endpush
