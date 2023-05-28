@extends('layout.main')

@section('container')
<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-xl-8">
                <form action="{{ route('save') }}" method="post">
                    @csrf
                    <div class="card">
                        <div class="card-body">

                            <div class="table-responsive">
                                <table class="table align-middle mb-0 table-nowrap mb-0">

                                    <thead class="table-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Gambar</th>
                                            <th>Kategori</th>
                                            <th style="width: 120px;">harga</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($keranjang->count())
                                        
                                            @foreach ($keranjang as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>
                                                        <div>
                                                            <h5 class="text-truncate font-size-16"><a href="ecommerce-product-detail.html" class="text-dark">{{ $item->nama }}</a></h5>
                                                        
                                                            <p class="mb-0 mt-1">Kategori <span class="fw-medium">{{ $item->kategori }}</span></p>
                                                        </div>
                                                    </td>
                                                    <td><img src="/Gambar_upload/{{ $item->folder }}/{{ $item->gambar }}" alt="" class="avatar-lg rounded p-1"></td>
                                                    <td>{{ $item->kategori }}</td>
                                                    <td>{{ number_format($item->harga,0,',','.') }}</td>
                                                    <td>
                                                        <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="" class="px-2 text-danger" data-bs-original-title="Delete" aria-label="Delete"><i class="bx bx-trash-alt font-size-18"></i></a>
                                                        <input type="hidden" name="kategori[]" id="kategori" value="{{ $item->kategori }}">
                                                        <input type="hidden" name="nama[]" id="nama" value="{{ $item->nama }}">
                                                        <input type="hidden" name="jumlah[]" id="jumlah" value="{{ $item->jumlah }}">
                                                        <input type="hidden" name="harga[]" id="harga" value="{{ $item->harga }}">
                                                        <input type="hidden" name="gambar[]" id="gambar" value="{{ $item->gambar }}">
                                                        <input type="hidden" name="folder[]" id="folder" value="{{ $item->folder }}">
                                                        <input type="hidden" name="keterangan[]" id="keterangan" value="{{ $item->keterangan }}">
                                                    </td>
                                                </tr>
                                                <?php $total_jumlah += $item->jumlah ?>
                                                <?php $total_harga += $item->harga ?>
                                                @endforeach
                                                <input type="hidden" name="total_jumlah" id="total_jumlah" value="{{ $total_jumlah }}">
                                                <input type="hidden" name="total_harga" id="total_harga" value="{{ $total_harga }}">
                                                <input type="hidden" name="total_bayar" id="total_bayar" value="{{ $total_harga }}">
                                        
                                        @else
                                            <tr>
                                                <td colspan="7" class="text-center"><strong>Tidak ada barang yang dimasukan ke keranjang</strong></td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        
                        </div>
                    </div>
                    <!-- end card -->

                    <div class="row my-4">
                        <div class="col-sm-6">
                            <a href="/home" class="btn btn-link text-muted">
                                <i class="mdi mdi-arrow-left me-1"></i> Kembali ke dashboard </a>
                        </div> <!-- end col -->
                        <div class="col-sm-6">
                            <div class="text-sm-end mt-2 mt-sm-0">
                                <button type="submit" class="btn btn-success">
                                    <i class="mdi mdi-cart-outline me-1"></i> Checkout </button>
                            </div>
                        </div> <!-- end col -->
                    </div> <!-- end row-->
                </form>
            </div>

            <div class="col-xl-4">
                <div class="mt-5 mt-lg-0">
                    <div class="card">
                        <div class="card-header bg-transparent border-bottom py-3 px-4">
                            <h5 class="font-size-16 mb-0">Rekapan data <span class="float-end">{{ date('d-m-Y') }}</span></h5>
                        </div>
                        <div class="card-body p-4 pt-2">

                            <div class="table-responsive">
                                <table class="table mb-0">
                                    <tbody>
                                        <tr>
                                            <td>Nama customer :</td>
                                            <td class="text-end">{{ auth()->user()->name }}</td>
                                        </tr>
                                        <tr>
                                            <td>Jumlah barang :</td>
                                            <td class="text-end">{{ $total_jumlah }}</td>
                                        </tr>
                                        <tr class="bg-light">
                                            <th>Total bayar:</th>
                                            <td class="text-end">
                                                <span class="fw-bold">
                                                    Rp. {{ number_format($total_harga,0,',','.') }}
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- end table-responsive -->
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