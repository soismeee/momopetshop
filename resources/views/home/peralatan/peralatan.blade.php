@extends('layout.main')

@section('container')
<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-xxl-12">
                <div class="card">
                    <div class="card-body">
                        <div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div>
                                        <h5>Peralatan hewan</h5>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-inline float-md-end">
                                        <div class="search-box ms-2">
                                            <div class="position-relative">
                                                <input type="text" class="form-control bg-light border-light rounded" placeholder="Search...">
                                                <i class="bx bx-search search-icon"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <ul class="nav nav-tabs nav-tabs-custom mt-3 mb-2 ecommerce-sortby-list">
                                <li class="nav-item">
                                    <a class="nav-link disabled fw-medium" href="#" tabindex="-1" aria-disabled="true">Kategori:</a>
                                  </li>
                                  @foreach ($kategori as $k)
                                  <li class="nav-item">
                                      <a href="#" class="nav-link" data-id>{{ $k->nama_kategori }}</a>
                                  </li>
                                  @endforeach
                            </ul>

                              <!-- Tab panes -->
                                <div class="tab-content p-3 text-muted">
                                    
                                    <div class="tab-pane active" id="popularity" role="tabpanel">
                                        <div class="row">
                                            @if ($peralatan->count())
                                                @foreach ($peralatan as $alat)
                                                    
                                                <div class="col-xl-4 col-sm-6">
                                                    <div class="product-box rounded p-3 mt-4">
                                                        <div class="product-img bg-light p-3 rounded">
                                                            <img src="/Gambar_upload/barang/{{ $alat->gambar_barang }}" alt="" class="img-fluid mx-auto d-block">
                                                        </div>
                                                        <div class="product-content pt-3">
                                                            <p class="text-muted font-size-13 mb-0">{{ $alat->kategori_barang->nama_kategori }}</p>
                                                            <h5 class="mt-1 mb-0"><a href="{{ url('/cdph') }}/{{ $alat->id }}" class="text-dark font-size-16">{{ $alat->nama_barang }}</a></h5>
                                                            <a href="{{ url('cb')}}/{{ $alat->id }}" class="product-buy-icon bg-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Add To Cart">
                                                                <i class="mdi mdi-cart-outline text-white font-size-16"></i>
                                                            </a>
                                                            <h5 class="font-size-20 text-primary mt-3 mb-0">Rp. {{ number_format($alat->harga_barang,0,',','.') }} </h5>     
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            @else
                                                <h4 class="text-center mt-3">Data tidak ditemukan</h4>
                                            @endif
                                        </div>
                                        <!-- end row -->
                                    </div>
                                </div>

                            {{-- <div class="row mt-4">
                                <div class="col-sm-6">
                                    <div>
                                        <p class="mb-sm-0">Page 2 of 84</p>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="float-sm-end">
                                        <ul class="pagination pagination-rounded mb-sm-0">
                                            <li class="page-item disabled">
                                                <a href="#" class="page-link"><i class="mdi mdi-chevron-left"></i></a>
                                            </li>
                                            <li class="page-item active">
                                                <a href="#" class="page-link">1</a>
                                            </li>
                                            <li class="page-item">
                                                <a href="#" class="page-link">2</a>
                                            </li>
                                            <li class="page-item">
                                                <a href="#" class="page-link">3</a>
                                            </li>
                                            <li class="page-item">
                                                <a href="#" class="page-link">4</a>
                                            </li>
                                            <li class="page-item">
                                                <a href="#" class="page-link">5</a>
                                            </li>
                                            <li class="page-item">
                                                <a href="#" class="page-link"><i class="mdi mdi-chevron-right"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div> --}}
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

@push('js')
    <script src="/assets/js/jquery-3.5.1.js"></script>
@endpush