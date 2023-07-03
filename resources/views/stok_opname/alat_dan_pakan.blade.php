@extends('layout.main')
@push('css')
    <!-- Sweet Alert-->
    <link href="/assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
@endpush
@section('container')
    <div class="page-content">
        <div class="container-fluid">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <div class="col-lg-8 col-md-8 col-sm-12">
                                <h4 class="card-title">Opname stok barang</h4>
                                <p class="card-title-desc">Data stok barang.</p>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 text-end">
                                <form action="{{ url('csopp') }}" method="GET">
                                    @csrf
                                    <div class="input-group">
                                        <input type="month" class="form-control" name="bulan" id="bulan" value="{{ date('Y-m') }}">
                                        <button type="submit" class="btn btn-primary" id="cetak">Cetak Opname</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0" id="opname-barang">

                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Barang</th>
                                        <th>Kategori</th>
                                        <th>Barang Masuk</th>
                                        <th>Barang Keluar</th>
                                        <th>Stok</th>
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
            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
    </div>
@endsection

@push('js')
    <!-- BEGIN PAGE LEVEL SCRIPTS -->
    <script src="/assets/js/jquery-3.5.1.js"></script>
    <!-- Sweet Alerts js -->
    <script src="/assets/libs/sweetalert2/sweetalert2.min.js"></script>
    <script>
        
        $(document).ready(() => {
            let bulan = $('#bulan').val();
            tabel(bulan);
        });

        $(document).on('change', '#bulan', function(e){
            e.preventDefault();
            $('#loading').show()
            $('table tbody').empty();
            tabel($(this).val());
        });

        function tabel(bulan) {
            $.ajax({
                url: "{{ url('json_sopp') }}",
                type: "GET",
                data: {'bulan': bulan },
                dataType: 'json',
                success: function(response) {
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
                            <tr >
                                <td>`+params.no+`</td>
                                <td>`+params.nama_barang+`</td>
                                <td>`+params.kategori+`</td>
                                <td>`+params.masuk+`</td>
                                <td>`+params.keluar+`</td>
                                <td>`+(parseInt(params.masuk)-parseInt(params.keluar))+`</td>
                            </tr>`
                            record += body
                        })
                        $('table tbody').append(record);
                    }
                }
            });
        }
    </script>
@endpush
