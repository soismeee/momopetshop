@extends('layout.main')
@push('css')
    <link rel="stylesheet" type="text/css" href="/assets/css/choices.min.css">
    <!-- Sweet Alert-->
    <link href="/assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/dataTables.bootstrap5.min.css">
@endpush
@section('container')
    <div class="page-content">
        <div class="container-fluid">
            <div class="col-xl-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mb-0">Tambah stok hewan</h4>
                            </div>
                            <div class="card-body">
                                <form id="form-stokhewan">
                                    @csrf
                                    <input type="hidden" id="id" name="id">
                                    <input type="hidden" id="idhewan" name="idhewan">
                                    <div class="row">
                                        <div class="col-lg-10">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="mb-3" id="hewan">
                                                        <label for="formrow-firstname-input" class="form-label">Nama hewan</label>
                                                        <select class="form-control" data-trigger name="hewan_id" id="hewan_id">
                                                            <option disabled selected>Pilih hewan</option>
                                                            @foreach ($hewan as $item)
                                                                <option value="{{ $item->id }}">{{ $item->nama_hewan }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label for="formrow-firstname-input" class="form-label">Jumlah hewan</label>
                                                        <input type="number" class="form-control input" placeholder="Masukan jumlah hewan" name="jumlah_hewan" id="jumlah_hewan">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-3">
                                                        <label for="formrow-firstname-input" class="form-label">Nominal hewan</label>
                                                        <input type="text" class="form-control input" placeholder="Masukan nominal harga hewan" name="nominal_hewan" id="nominal_hewan" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 mt-4">
                                            <button type="submit" id="add-data" class="btn btn-primary w-md">Simpan Data</button>
                                            <button type="submit" id="update-data" style="display: none" class="btn btn-warning w-md">Ubah Data</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- end card body -->
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                
                                <div class="d-flex justify-content-between">
                                    <div class="col-lg-6 col-md-6 col-sm-12">
                                        <h4 class="card-title">hewan masuk</h4>
                                        <p class="card-title-desc">Data hewan masuk.</p>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-12 text-end">
                                        <input type="hidden" name="bulan" id="bulan" value="{{ date('Y-m') }}">
                                        <form action="{{ url('cph') }}" method="POST">
                                            @csrf
                                            <div class="input-group">
                                                <input type="date" class="form-control" name="awal" id="awal">
                                                <input type="date" class="form-control" name="akhir" id="akhir">
                                                <button type="submit" class="btn btn-primary" id="cetak">Cetak Data</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="data-hewan" class="table mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="5%">No</th>
                                                <th width="20%">Kode hewan</th>
                                                <th width="20%">Nama hewan</th>
                                                <th width="15%">Jumlah</th>
                                                <th width="15%">Nominal</th>
                                                <th width="15%">Tgl Transaksi</th>
                                                <th width="10%">#</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>

                            </div>
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
    <script src="/assets/js/jquery.dataTables.min.js"></script>
    <script src="/assets/js/dataTables.bootstrap5.min.js"></script>
    <!-- Sweet Alerts js -->
    <script src="/assets/libs/sweetalert2/sweetalert2.min.js"></script>

    <!-- choices js -->
    <script src="/assets/js/choices.min.js"></script>

    <!-- init js -->
    <script src="/assets/js/form-advanced.init.js"></script>
    <script>
        $(document).on('change', '#bulan', function(e){
            e.preventDefault();
            table.ajax.reload();
        })
        // load data table
        const table = $('#data-hewan').DataTable({          
            "lengthMenu": [[5, 10, 25, 50, 100, -1],[5, 10, 25, 50, 100, 'All']],
            "pageLength": 10, 
            processing: true,
            serverSide: true,
            responseive: true,
            ajax: {
                url:"{{ url('json_ph') }}",
                type:"POST",
                data:function(d){
                    d._token = "{{ csrf_token() }}"
                    d.bulan = $('#bulan').val()
                }
            },
            columns:[
                {
                    "targets": "_all",
                    "defaultContent": "-",
                    "render": function(data, type, row, meta){
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    "targets": "_all",
                    "defaultContent": "-",
                    "render": function(data, type, row, meta){
                    return row.kode_hewan
                    }
                },
                {
                    "targets": "_all",
                    "defaultContent": "-",
                    "render": function(data, type, row, meta){
                        return row.nama_hewan
                    }
                },
                {
                    "targets": "_all",
                    "defaultContent": "-",
                    "render": function(data, type, row, meta){
                    return row.jml_hewan
                    }
                },
                {
                    "targets": "_all",
                    "defaultContent": "-",
                    "render": function(data, type, row, meta){
                    return rupiah(row.nominal_hewan)
                    }
                },
                {
                    "targets": "_all",
                    "defaultContent": "-",
                    "render": function(data, type, row, meta){
                        var tanggal = new Date(row.created_at)
                        return tanggal.getDate()+"/"+tanggal.getMonth()+"/"+tanggal.getFullYear()
                    }
                },
                {
                    "targets": "_all",
                    "defaultContent": "-",
                    "render": function(data, type, row, meta){
                    return `
                    <div class="btn-group">
                        <a href="javascript:void(0);" title="Edit" id="edit-data" data-id="`+row.id+`" class="btn btn-sm btn-primary">Edit</a>
                        <a href="javascript:void(0);" title="Delete" class="btn btn-sm btn-danger hapusdata" data-id="`+row.id+`">Hapus</a>
                    </div>
                    `
                    }
                },
            ]
        });

        // fungsi mengubah tombol simpan
        function tombolSimpan() {
            $('#add-data').removeClass('disabled');
            $('#add-data').html('Simpan Data');
        }

        // fungsi untuk mengubah tombol ubah
        function tombolUbah(){
            $('#update-data').removeClass('disabled');
            $('#update-data').html('Ubah Data');
        }

        // fungsi reload table dan reset form input
        function reloadReset(){
            table.ajax.reload();
            document.getElementById("form-stokhewan").reset()
        }

        // template sweetalert
        function sweetAlert(icon, title) {
            Swal.fire({
                icon: icon,
                title: title,
            });
        }

        const rupiah = (number) => {
            return new Intl.NumberFormat("id-ID", {
            style: "decimal",
            currency: "IDR"
            }).format(number);
        }

        var nominal_hewan = document.getElementById("nominal_hewan");
        nominal_hewan.addEventListener("keyup", function(e) {
            nominal_hewan.value = convertRupiah(this.value, "Rp. ");
        });

        let jumlah = document.getElementById("jumlah_hewan");
        jumlah.addEventListener("keyup", function (e) {
            let nilai = jumlah.value;
            if(!nilai){jumlah.value = null;}
        });

        function convertRupiah(angka, prefix) {
            var number_string = angka.replace(/[^,\d]/g, "").replace(/,/g,'').toString(),
                split = number_string.split(","),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? "." : "";
                rupiah += separator + ribuan.join(".");
            }

            rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
            return prefix == undefined ? rupiah : rupiah ? prefix + rupiah : "";
        }

        $(document).on('change', '#hewan_id', function(e){
            e.preventDefault()
            let idchange = $(this).val();
            $.ajax({
                type: "GET",
                url: "{{ url('gdh') }}/" + idchange,
                success: function(response) {
                    if (response.status == 401) {
                        sweetAlert('error', response.message);
                    } else {
                        nominal_hewan.value = convertRupiah(response.data.harga_beli, "Rp. ");
                    }
                }
            });
        })

        $(document).on('click', '#add-data', function(e) {
            e.preventDefault();
            $('#add-data').addClass('disabled');
            $('#add-data').html(`<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Loading...`);
            $.ajax({
                type: "POST",
                url: "{{ url('sph') }}",
                data: $("#form-stokhewan").serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == 401) {
                        $('.input').addClass('is-invalid');
                        tombolSimpan()
                    } else {
                        $('.input').removeClass('is-invalid');
                        sweetAlert('success', response.message);
                        reloadReset();
                        tombolSimpan();
                    }
                }
            });
        });

        $(document).on('click', '#edit-data', function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            $('#update-data').show();
            $('#add-data').hide();
            $.ajax({
                type: "GET",
                url: "{{ route('ph') }}/" + id,
                success: function(response) {
                    if (response.status == 401) {
                        sweetAlert('error', response.message);
                    } else {
                        $('.input').removeClass('is-invalid');
                        $('#id').val(response.data.id);
                        $('#idhewan').val(response.data.hewan_id);
                        $('#hewan').html(`<label for="barang_id" class="form-label">Nama hewan</label><br><input type="text" class="form-control" value="`+response.data.nama_hewan+`" disabled>`)
                        $('#jumlah_hewan').val(response.data.jumlah_hewan);
                        nominal_hewan.value = convertRupiah(response.data.nominal_hewan, "Rp. ");
                    }
                }
            });
        });

        $(document).on('click', '#update-data', function(e) {
            e.preventDefault();
            $('#update-data').addClass('disabled');
            $('#update-data').html(`<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Loading...`);
            let id = $('#id').val();
            $.ajax({
                type: "PUT",
                url: "{{ route('ph') }}/" + id,
                data: $("#form-stokhewan").serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == 401) {
                        sweetAlert('warning', response.errors);
                        tombolUbah();
                    } else {
                        $('#update-data').hide();
                        $('#add-data').show();
                        sweetAlert('success', response.message);
                        reloadReset();
                        tombolUbah();
                    }
                }
            });
        });

        $(document).on('click', '.hapusdata', function(e) {
            let id = $(this).data('id');
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Anda akan menghapus data ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Delete!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "DELETE",
                        url: "{{ url('dtph') }}/" + id,
                        data: {'_token': '{{ csrf_token() }}'},
                        dataType: 'json',
                        success: function(response) {
                            Swal.fire('Terhapus!',response.message,'success');
                            table.ajax.reload();
                        }
                    });
                }
            })
        });
    </script>
@endpush
