@extends('layout.main')

@section('container')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xxl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-8">
                                    <div class="">
                                        <h5 class="font-size-14 mb-3">Keterangan : </h5>
                                        <div class="text-muted mb-3">
                                            <span class="badge bg-success font-size-14 me-1"><i class="mdi mdi-star"></i>
                                                {{ $treatment->status_treatment }}</span>
                                        </div>

                                        <div class="border py-4 rounded">

                                            <div class="px-4" data-simplebar="init" style="max-height: 360px;">
                                                <div class="simplebar-wrapper" style="margin: 0px -24px;">
                                                    <div class="simplebar-height-auto-observer-wrapper">
                                                        <div class="simplebar-height-auto-observer"></div>
                                                    </div>
                                                    <div class="simplebar-mask">
                                                        <div class="simplebar-offset" style="right: -17px; bottom: 0px;">
                                                            <div class="simplebar-content-wrapper"
                                                                style="height: auto; overflow: hidden scroll;">
                                                                <div class="simplebar-content" style="padding: 0px 24px;">
                                                                    <div class="border-bottom pb-3">
                                                                        <p class="text-muted mb-4">{{ $treatment->keterangan_treatment }}</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="simplebar-placeholder" style="width: auto; height: 605px;">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="px-4 mt-2">
                                                <div class="text-end mt-3">
                                                    <a href="{{ url('/cht') }}/{{ $treatment->id }}" class="btn btn-success w-sm text-truncate ms-2">
                                                        <i class="bx bx-send ms-2 align-middle"></i> Pesan sekarang
                                                    </a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="product-desc">
                                        <h5 class="font-size-14 mb-3">Deskripsi : </h5>
                                        <div class="table-responsive">
                                            <table class="table table-nowrap mb-0">
                                                <tbody>
                                                    <tr>
                                                        <th scope="row" style="width: 50%;">Harga :</th>
                                                        <td> Rp. {{ number_format($treatment->harga_treatment,0,',','.') }} </td>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="2">Gambar :</th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="2">
                                                            <img src="/Gambar_upload/treatment/{{ $treatment->gambar_treatment }}" alt="gambar treatment" width="400px">
                                                        </th>
                                                    </tr>
                                                </tbody>
                                            </table>
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
