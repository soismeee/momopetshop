@extends('layout.main')
@push('css')
    <!-- Sweet Alert-->
    <link href="/assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
@endpush

@section('container')
<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-xl-10">
                    <div class="card">
                        <div class="card-body">

                            <div class="table-responsive">
                                <table class="table align-middle mb-0 table-nowrap mb-0 table-keranjang">

                                    <thead class="table-light">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Gambar</th>
                                            <th>Kategori</th>
                                            <th style="width: 120px;">harga</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td colspan="6" class="text-center" id="loading">
                                                <div class="spinner-border" role="status">
                                                    <span class="visually-hidden">Loading...</span>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        
                        </div>
                    </div>
                    <!-- end card -->
            </div>
        </div>
        
    </div>
    <!-- container-fluid -->
</div>
<!-- End Page-content -->
@endsection

@push('js')
    <script src="/assets/js/jquery-3.5.1.js"></script>
    <script src="/assets/libs/sweetalert2/sweetalert2.min.js"></script>

    <script>
        const rupiah = (number) => {
            return new Intl.NumberFormat("id-ID", {
            style: "decimal",
            currency: "IDR"
            }).format(number);
        }

        $(document).ready(function () {
            tabel()
        });

        function tabel(){
            let id = "{{ $detailorder->id }}"
            $.ajax({
                type: "GET",
                url: "{{ url('json_co') }}/"+id,
                success: function (response){
                    $('#loading').hide()
                    if(response.status == 401) {
                        let datakosong =
                        `<tr class="text-center">
                            <td colspan="6">`+response.errors+`</td>
                        </tr>`
                        $('table tbody').append(datakosong);
                    }else{
                        var data = response.data
                        let record = '';
                        data.forEach((params) => {
                            let body = `
                            <tr>
                                <td>`+params.no+`</td>
                                <td><h5 class="text-truncate font-size-16">`+params.nama+`</h5></td>
                                <td><img src="/Gambar_upload/`+params.folder+`/`+params.gambar+`" alt="" class="avatar-lg rounded p-1"></td>
                                <td>`+params.kategori+`</td>
                                <td>`+rupiah(params.harga)+`</td>
                            </tr>
                            `
                            record += body
                        })
                        $('table tbody').append(record);
                        $('#total_jumlah').val(response.total_jumlah);
                        $('#total_harga').val(response.total_harga);
                        $('#total_bayar').val(response.total_harga);
                        $('#tombol').removeClass('disabled');
                    }
                }
            });
        }

    </script>
@endpush