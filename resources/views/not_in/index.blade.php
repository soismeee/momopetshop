@extends('not_in.main')

@section('container')
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-xxl-12">
                    <div class="row">
                        <div class="col-xl-7">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-start mb-2">
                                        <div class="flex-grow-1">
                                            <h5 class="card-title">Produk terbaru</h5>
                                        </div>
                                    </div>
                                    @if ($barang->count())
                                        <div class="row align-items-center">
                                            <div class="col-md-5">
                                                <div class="popular-product-img p-2">
                                                    <img src="/Gambar_upload/barang/{{ $barang[0]->gambar_barang }}"
                                                        alt="">
                                                </div>
                                            </div>
                                            <div class="col-md-7">
                                                <span class="badge badge-soft-primary font-size-10 text-uppercase ls-05">
                                                    {{ $barang[0]->kategori_barang->nama_kategori }}</span>
                                                <h5 class="mt-2 font-size-16"><a href=""
                                                        class="text-dark">{{ $barang[0]->nama_barang }}</a>
                                                </h5>
                                                <p class="text-muted">Keterangan produk.</p>

                                                <div class="row g-0 mt-3 pt-1 align-items-end">
                                                    <div class="col-4">
                                                        <div class="mt-1">
                                                            <h4 class="font-size-16">{{ $barang[0]->stok_barang }}</h4>
                                                            <p class="text-muted mb-1">Stok produk</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="mt-1">
                                                            <h4 class="font-size-16">Rp.
                                                                {{ number_format($barang[0]->harga_barang, 0, ',', '.') }}
                                                            </h4>
                                                            <p class="text-muted mb-1">Harga Produk</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="mt-1">
                                                            <a href="/login" class="btn btn-primary btn-sm mb-1">Buy
                                                                Now</a>
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
                                                        <div class="simplebar-content-wrapper"
                                                            style="height: auto; overflow: hidden scroll;">
                                                            <div class="simplebar-content" style="padding: 0px 24px;">

                                                                @foreach ($barang->skip(1) as $item)
                                                                    <div class="popular-product-box rounded my-2">
                                                                        <div class="d-flex align-items-center">
                                                                            <div class="flex-shrink-0">
                                                                                <div class="avatar-md">
                                                                                    <div
                                                                                        class="product-img avatar-title img-thumbnail bg-soft-primary border-0">
                                                                                        <img src="/Gambar_upload/barang/{{ $item->gambar_barang }}"
                                                                                            class="img-fluid"
                                                                                            alt="">
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="flex-grow-1 ms-3 overflow-hidden">
                                                                                <h5 class="mb-1 text-truncate">
                                                                                    <a href=""
                                                                                        class="font-size-15 text-dark">{{ $item->nama_barang }}</a>
                                                                                </h5>
                                                                                <p
                                                                                    class="text-muted fw-semibold mb-0 text-truncate">
                                                                                    Stok {{ $item->stok_barang }}</p>
                                                                            </div>
                                                                            <div class="flex-shrink-0 text-end ms-3">
                                                                                <h5 class="mb-1"><a href="/login"
                                                                                        class="font-size-15 text-dark">Rp.
                                                                                        {{ number_format($item->harga_barang, 0, ',', '.') }}</a>
                                                                                </h5>
                                                                                <p class="text-muted fw-semibold mb-0">158
                                                                                    Terjual
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="simplebar-placeholder" style="width: auto; height: 456px;">
                                                </div>
                                            </div>
                                            <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                                                <div class="simplebar-scrollbar"
                                                    style="transform: translate3d(0px, 0px, 0px); display: none;"></div>
                                            </div>
                                            <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
                                                <div class="simplebar-scrollbar"
                                                    style="height: 92px; transform: translate3d(0px, 113px, 0px); display: block;">
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <h3 class="text-center mb-3">Tidak ada produk</h3>
                                    @endif

                                </div>
                            </div>
                        </div>
                        <div class="col-xl-5">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-start mb-2">
                                        <div class="flex-grow-1">
                                            <h5 class="card-title">Produk sejenis</h5>
                                        </div>
                                    </div>

                                    <div class="mx-n4 px-4" data-simplebar="init" style="max-height: 421px;">
                                        <div class="simplebar-wrapper" style="margin: 0px -24px;">
                                            <div class="simplebar-height-auto-observer-wrapper">
                                                <div class="simplebar-height-auto-observer"></div>
                                            </div>
                                            <div class="simplebar-mask">
                                                <div class="simplebar-offset" style="right: -17px; bottom: 0px;">
                                                    <div class="simplebar-content-wrapper"
                                                        style="height: auto; overflow: hidden scroll;">
                                                        <div class="simplebar-content" style="padding: 0px 24px;">
                                                            @foreach ($barangsejenis->skip(1) as $bs)
                                                                <div class="border-bottom loyal-customers-box pt-2">
                                                                    <div class="d-flex align-items-center">
                                                                        <img src="/Gambar_upload/barang/{{ $bs->gambar_barang }}"
                                                                            class="rounded-circle avatar img-thumbnail"
                                                                            alt="{{ $bs->nama_barang }}">
                                                                        <div class="flex-grow-1 ms-3 overflow-hidden">
                                                                            <h5 class="font-size-15 mb-1 text-truncate">
                                                                                {{ $bs->nama_barang }}</h5>
                                                                            <p class="text-muted text-truncate mb-0">Rp.
                                                                                {{ number_format($bs->harga_barang, 0, ',', '.') }}
                                                                            </p>
                                                                        </div>
                                                                        <div class="flex-shrink-0">
                                                                            <h5
                                                                                class="font-size-14 mb-0 text-truncate w-xs bg-light p-2 rounded text-center">
                                                                                {{ $bs->stok_barang }}</h5>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="simplebar-placeholder" style="width: auto; height: 432px;">
                                            </div>
                                        </div>
                                        <div class="simplebar-track simplebar-horizontal" style="visibility: hidden;">
                                            <div class="simplebar-scrollbar"
                                                style="transform: translate3d(0px, 0px, 0px); display: none;">
                                            </div>
                                        </div>
                                        <div class="simplebar-track simplebar-vertical" style="visibility: visible;">
                                            <div class="simplebar-scrollbar"
                                                style="height: 410px; transform: translate3d(0px, 0px, 0px); display: block;">
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
