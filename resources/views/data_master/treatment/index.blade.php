@extends('layout.main')

@push('css')
    <!-- Sweet Alert-->
    <link href="/assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/assets/css/dataTables.bootstrap5.min.css">

    <!-- Filepond stylesheet -->
  {{-- <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet"> --}}
@endpush

@section('container')
    <div class="page-content">
        <div class="container-fluid">
            <div class="col-xl-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mb-0">Form input Treatment</h4>
                            </div>
                            <div class="card-body">
                                <form id="form-treatment" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" id="id" name="id">
                                    <input type="hidden" id="form" value="tambah">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="formrow-firstname-input" class="form-label">Nama treatment</label>
                                                <input type="text" class="form-control input" placeholder="Masukan nama treatment" name="nama_treatment" id="nama_treatment">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="formrow-password-input" class="form-label">Tarif treatment</label>
                                                <input type="text" class="form-control input" placeholder="Masukan tarif treatment" id="harga_treatment" name="harga_treatment">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="formrow-email-input" class="form-label">Status Treatment</label>
                                                <select name="status_treatment" id="status_treatment" class="form-select">
                                                    <option value="aktif">Aktif</option>
                                                    <option value="non-aktif">Non-Aktif</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="formrow-password-input" class="form-label">Dari pukul</label>
                                                <input type="time" class="form-control input" id="dari" name="dari">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="formrow-password-input" class="form-label">Sampai pukul</label>
                                                <input type="time" class="form-control input" id="sampai" name="sampai">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-8">
                                            <div class="mb-3">
                                                <label for="formrow-inputState" class="form-label">Keterangan treatment</label>
                                                <textarea cols="30" rows="5" class="form-control input" id="keterangan_treatment" name="keterangan_treatment"></textarea>
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label for="formrow-inputZip" class="form-label">Gambar treatment</label>
                                                <input type="file" class="form-control input" id="gambar_treatment" name="gambar_treatment">
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <button type="submit" id="add-data" class="btn btn-primary w-md">Simpan Data</button>
                                    </div>
                                </form>
                            </div>
                            <!-- end card body -->
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Treatment</h4>
                                <p class="card-title-desc">Data treatment hewan.</p>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table mb-0" id="data-treatment">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="5%">No</th>
                                                <th width="20%">Nama treatment</th>
                                                <th width="20%">Tarif</th>
                                                <th width="10%">Status</th>
                                                <th width="10%">Waktu</th>
                                                <th width="30%">Keterangan</th>
                                                <th width="5%">#</th>
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
    <script src="/assets/js/jquery-3.5.1.js"></script>
    <script src="/assets/js/jquery.dataTables.min.js"></script>
    <script src="/assets/js/dataTables.bootstrap5.min.js"></script>
    <!-- Sweet Alerts js -->
    <script src="/assets/libs/sweetalert2/sweetalert2.min.js"></script>
    <script>
        // load data table
        const table = $('#data-treatment').DataTable({          
            "lengthMenu": [[5, 10, 25, 50, 100, -1],[5, 10, 25, 50, 100, 'All']],
            "pageLength": 10, 
            processing: true,
            serverSide: true,
            responseive: true,
            ajax: {
                url:"{{ url('json_dt') }}",
                type:"POST",
                data:function(d){
                    d._token = "{{ csrf_token() }}"
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
                    return row.nama_treatment
                    }
                },
                {
                    "targets": "_all",
                    "defaultContent": "-",
                    "render": function(data, type, row, meta){
                    return "Rp. " +rupiah(row.harga_treatment)
                    }
                },
                {
                    "targets": "_all",
                    "defaultContent": "-",
                    "render": function(data, type, row, meta){
                    return row.status_treatment
                    }
                },
                {
                    "targets": "_all",
                    "defaultContent": "-",
                    "render": function(data, type, row, meta){
                    return row.dari +" - "+ row.sampai
                    }
                },
                {
                    "targets": "_all",
                    "defaultContent": "-",
                    "render": function(data, type, row, meta){
                    return row.keterangan_treatment
                    }
                },
                {
                    "targets": "_all",
                    "defaultContent": "-",
                    "render": function(data, type, row, meta){
                    return `
                    <div class="btn-group">
                        <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit" id="edit-data" data-id="`+row.id+`" class="px-2 text-primary"><i class="bx bx-pencil font-size-18"></i></a>
                        <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" class="px-2 text-danger hapusdata" data-id="`+row.id+`"><i class="bx bx-trash-alt font-size-18"></i></a>
                    </div>
                    `
                    }
                },
            ]
        });

        const rupiah = (number) => {
            return new Intl.NumberFormat("id-ID", {
            style: "decimal",
            currency: "IDR"
            }).format(number);
        }

        var harga_treatment = document.getElementById("harga_treatment");
        harga_treatment.addEventListener("keyup", function(e) {
            harga_treatment.value = convertRupiah(this.value, "Rp. ");
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

        // fungsi mengubah tombol simpan
        function tombolSimpan() {
            $('#add-data').removeClass('disabled');
            $('#add-data').removeClass('btn-warning');
            $('#add-data').addClass('btn-primary');
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
            document.getElementById("form-treatment").reset()
        }

        // template sweetalert
        function sweetAlert(icon, title) {
            Swal.fire({
                icon: icon,
                title: title,
            });
        }

        $('#form-treatment').on('submit', function(e){
            e.preventDefault();
            $('#add-data').addClass('disabled');
            $('#add-data').html(`<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Loading...`);
            let form = $('#form').val();
            let url = '';
            if (form == 'ubah') {
                let id = $('#id').val();
                url = "{{ url('dt_update') }}/"+id
            } else {
                url = "{{ route('dt.index') }}"
            }
            $.ajax({
                url: url,
                method: "POST",
                data: new FormData(this),
                dataType:'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {
                    $('#form').val('tambah');
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
            $('#add-data').text('Ubah data');
            $('#add-data').removeClass('btn btn-primary');
            $('#add-data').addClass('btn btn-warning');
            $.ajax({
                type: "GET",
                url: "{{ route('dt.index') }}/" + id,
                success: function(response) {
                    if (response.status == 401) {
                        sweetAlert('error', response.message);
                    } else {
                        $('.input').removeClass('is-invalid');
                        $('#id').val(response.data.id);
                        $('#nama_treatment').val(response.data.nama_treatment);
                        $('#harga_treatment').val(response.data.harga_treatment);
                        $('#status_treatment').val(response.data.status_treatment);
                        $('#keterangan_treatment').val(response.data.keterangan_treatment);
                        harga_treatment.value = convertRupiah(response.data.harga_treatment, "Rp. ");
                        $('.label-gambar').html('Ubah gambar (biarkan kosong jika tidak ingin mengganti gambar)');
                        $('#form').val('ubah');
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
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {

                if (result.isConfirmed) {
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('dt.index') }}/" + id,
                        data: {
                            '_token': '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function(response) {
                            Swal.fire(
                                'Deleted!',
                                response.message,
                                'success'
                            )
                            table.ajax.reload();
                        }
                    });

                }
            })
        });
    </script>
@endpush