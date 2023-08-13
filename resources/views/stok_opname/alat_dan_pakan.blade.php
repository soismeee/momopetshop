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
                            <div class="col-lg-7 col-md-7 col-sm-12">
                                <h4 class="card-title">Opname stok barang</h4>
                                <p class="card-title-desc">Data stok barang.</p>
                            </div>
                            <div class="col-lg-5 col-md-5 col-sm-12 text-end">
                                <input type="hidden" name="bulan" id="bulan" value="{{ date('Y-m') }}">
                                <form action="{{ url('csopp') }}" method="GET">
                                    @csrf
                                    <div class="input-group">
                                        <select name="kategori" id="kategori" class="form-select">
                                            <option value="All">All</option>
                                            <option value="pakan">Pakan</option>
                                            <option value="alat">Peralatan</option>
                                        </select>
                                        <input type="date" class="form-control" name="awal" id="awal">
                                        <input type="date" class="form-control" name="akhir" id="akhir" readonly>
                                        <button type="submit" class="btn btn-primary" id="cetak">Cetak Opname</button>
                                    </div>
                                </form>
                                {{-- <form action="{{ url('csopp') }}" method="GET">
                                    @csrf
                                    <div class="input-group">
                                        <input type="month" class="form-control" name="bulan" id="bulan" value="{{ date('Y-m') }}">
                                        <button type="submit" class="btn btn-primary" id="cetak">Cetak Opname</button>
                                    </div>
                                </form> --}}
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0" id="opname-barang">

                                <thead>
                                    <tr class="text-center">
                                        <th width="5%">#</th>
                                        <th width="10%">Kode</th>
                                        <th width="20%">Nama Barang</th>
                                        <th width="10%">Kategori</th>
                                        <th width="15%">Barang Masuk</th>
                                        <th width="15%">Barang Keluar</th>
                                        <th width="10%">Stok</th>
                                        <th width="15%">Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="8" class="text-center" id="loading">
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

        <!-- sample modal content -->
        <div id="modalStok" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-scroll="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Modal edit stok</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="col-12">
                            <label for="form-label">Edit Stok</label>
                            <input type="hidden" name="id" id="id">
                            <input type="number" class="form-control" name="jumlah_stok" id="jumlah_stok">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Batal</button>
                        <button class="btn btn-primary waves-effect waves-light" id="update_stok">Edit Stok</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        
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

        $(document).on('change', '#awal', function(e){
            e.preventDefault();
            $('#akhir').removeAttr('readonly');
            $('.tgl_awal').val(this.value);
        });
        
        $(document).on('change', '#akhir', function(e){
            e.preventDefault();
            $('.tgl_akhir').val(this.value);
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
                                <td>`+params.kode_barang+`</td>
                                <td>`+params.nama_barang+`</td>
                                <td>`+params.kategori+`</td>
                                <td>`+params.masuk+`</td>
                                <td>`+params.keluar+`</td>
                                <td>`+(parseInt(params.masuk)-parseInt(params.keluar))+`</td>
                                <td>
                                    <center>
                                        <form action="{{ url('/sopp') }}/`+params.id+`" method="POST">
                                            @csrf
                                            <div class="btn-group">
                                                <a href="#" class="btn btn-sm btn-primary" id="edit-stok" data-id="`+params.id+`">Edit stok</a>
                                                <input type="hidden" name="tgl_awal" class="tgl_awal">        
                                                <input type="hidden" name="tgl_akhir" class="tgl_akhir">        
                                                <button type="submit" class="btn btn-sm btn-info">History stok</button>
                                            </div>
                                        </form>
                                    </center>
                                </td>
                            </tr>`
                            record += body
                        })
                        $('table tbody').append(record);
                    }
                }
            });
        }

        // template sweetalert
        function sweetAlert(icon, title) {
            Swal.fire({
                icon: icon,
                title: title,
            });
        }

        $(document).on('click', '#edit-stok', function(e){
            let id = $(this).data('id');
            $('#id').val(id);
            $('#modalStok').modal('show');
        });
        
        $(document).on('click', '#update_stok', function(e){
            if(!$('#jumlah_stok').val()){ return sweetAlert('error', 'Jumlah stok harus diisi!!!') }
            let idstok = $('#id').val();
            let bulanstok = $('#bulan').val();
            let datastok = { 'jumlah': $('#jumlah_stok').val(), '_token': '{{ csrf_token() }}' };
            $.ajax({
                url: "{{ url('/esb') }}/"+idstok,
                type: 'POST',
                data: datastok,
                dataType: 'json',
                success: function(response) {
                    if (response.status == 401) {
                        sweetAlert('error', response.errors);
                    } else {
                        $('#loading').show()
                        $('table tbody').empty();
                        $('#modalStok').modal('hide');  
                        $('#jumlah_stok').val(null);
                        tabel(bulanstok);
                    }
                }
            });
        });
    </script>
@endpush
