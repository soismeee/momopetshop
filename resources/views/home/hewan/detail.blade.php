@extends('layout.main')

@push('css')
    <!-- swiper css -->
    <link rel="stylesheet" href="/assets/libs/swiper/swiper-bundle.min.css">
    <link href="/assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
@endpush

@section('container')
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-xxl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-4">
                                    <div class="product-detail mt-3" dir="ltr">

                                        <div class="swiper product-thumbnail-slider rounded border overflow-hidden position-relative swiper-container-initialized swiper-container-horizontal swiper-container-pointer-events">
                                            <div class="swiper-wrapper" id="swiper-wrapper-4da7a7c52708d996" aria-live="polite" style="transform: translate3d(0px, 0px, 0px);">
                                                <div class="swiper-slide rounded swiper-slide-active" role="group" aria-label="1 / 5" style="width: 354px; margin-right: 24px;">
                                                   <div class="p-3">
                                                        <div class="product-img bg-light rounded p-3">
                                                            <img src="/Gambar_upload/hewan/{{ $hewan->gambar_hewan }}" class="img-fluid d-block">
                                                        </div>
                                                   </div>
                                                </div>
                                            </div>
                                        <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span></div>

                                        <div class="mt-4">
                                            <div thumbsslider="" class="swiper product-nav-slider mt-2 overflow-hidden swiper-container-initialized swiper-container-horizontal swiper-container-pointer-events swiper-container-free-mode swiper-container-thumbs">
                                                <div class="swiper-wrapper" id="swiper-wrapper-d58a8e2a1fd81d47" aria-live="polite" style="transform: translate3d(0px, 0px, 0px);">
                                                </div>
                                            <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span></div>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-xl-8">
                                    <div class="mt-3 mt-xl-3 ps-xl-5">
                                        <h4 class="font-size-20 mb-3"><a href="" class="text-dark">{{ $hewan->nama_hewan }}</a></h4>

                                        <div class="text-muted mt-2">
                                            <span class="badge bg-success font-size-14 me-1">Gender : {{ $hewan->jkel }}</span>
                                        </div>

                                        <h2 class="text-primary mt-4 py-2 mb-0">Rp. {{ number_format($hewan->harga_hewan,0,',','.') }}</h2>


                                        <div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mt-3">
                                                        <h5 class="font-size-14">Keterangan :</h5>
                                                        <p>{{ $hewan->keterangan_hewan }} <br />
                                                        Tanggal lahir : {{ date('d/m/Y', strtotime($hewan->tgl_lahir)) }} <br />
                                                        Umur : {{ $umur }} <br />
                                                        Berat Hewan : {{ $hewan->berat_hewan }}
                                                    </p>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="mt-3">
                                                        <h5 class="font-size-14">Jumlah Hewan :</h5>
                                                        <p>{{ $hewan->jumlah_hewan }}</p>
                                                    </div>
                                                    <div class="mt-3">
                                                        <h5 class="font-size-14">Berat Hewan :</h5>
                                                        <p>{{ $hewan->berat_hewan }}</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-6 col-sm-8">
                                                    <div class="row text-center mt-4 pt-1">
                                                        <div class="col-sm-5">
                                                            <div class="d-grid">
                                                                <input type="number" min="1" class="form-control mt-2" name="jumlah" id="jumlah" placeholder="Qty">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-7">
                                                            <div class="d-grid">
                                                                <a href="#" id="keranjang" class="btn btn-primary waves-effect waves-light mt-2 me-1">
                                                                    <i class="bx bx-cart me-2"></i> Masukan keranjang
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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

@push('js')
<script src="/assets/js/jquery-3.5.1.js"></script>
<script src="/assets/libs/swiper/swiper-bundle.min.js"></script>
<script src="/assets/js/pages/ecommerce-product-detail.init.js"></script>
<script src="/assets/libs/sweetalert2/sweetalert2.min.js"></script>

<script>
    let jumlah = document.getElementById("jumlah");
    jumlah.addEventListener("keyup", function (e) {
        let nilai = jumlah.value;
        if(!nilai){jumlah.value = null;}
        let stok = "{{ $hewan->jumlah_hewan }}"
        var a = parseInt(stok);
        var b = parseInt(jumlah.value);
        if (a < b) {
            alert("Permintaan melebihi stok barang"); 
            jumlah.value = null;    
        }
    });

    $(document).on('click', '#keranjang', function(e){
        let jml = $('#jumlah').val();
        if (jml) {
            // alert('masukan jumlah hewan yang ingin dibeli')
            $.ajax({
                type: "GET",
                url: "/che/{{ $hewan->id }}",
                data: {'jumlah': $('#jumlah').val(), '_token': '{{ csrf_token() }}'},
                dataType: "JSON",
                success: function(response){
                    window.location.href = "/ck";
                }
            });
        }else{
            Swal.fire({
                icon: 'warning',
                title: "jumlah pesanan harus diisi!",
            });
        }        
    });
</script>
@endpush