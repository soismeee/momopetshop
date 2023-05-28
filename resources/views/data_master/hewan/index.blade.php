@extends('layout.main')
@push('css')
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
                                <h4 class="card-title mb-0">Form input data hewan</h4>
                            </div>
                            <div class="card-body">
                                <form id="form-hewan" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" id="id" name="id">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="formrow-firstname-input" class="form-label">Nama Hewan</label>
                                                <input type="text" class="form-control input" placeholder="Masukan nama barang" name="nama_hewan" id="nama_hewan">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="formrow-firstname-input" class="form-label">Jenis Kelamin</label>
                                                <select name="jkel" id="jkel" class="form-select input">
                                                    <option value="Jantan">Jantan</option>
                                                    <option value="Betina">Betina</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="formrow-firstname-input" class="form-label">Tanggal lahir (mengetahui umur)</label>
                                                <input type="date" class="form-control input" placeholder="Masukan tanggal lahir" name="tgl_lahir" id="tgl_lahir">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="berat_hewan" class="form-label">Berat hewan</label>
                                                <input type="number" class="form-control input" placeholder="Berat Hewan" id="berat_hewan" name="berat_hewan">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="tinggi_hewan" class="form-label">Tinggi hewan</label>
                                                <input type="number" class="form-control input" placeholder="Tinggi Hewan" id="tinggi_hewan" name="tinggi_hewan">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="harga" class="form-label">Harga Hewan</label>
                                                <input type="text" class="form-control input" placeholder="harga hewan" id="harga_hewan" name="harga_hewan">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="jumlah" class="form-label">Jumlah</label>
                                                <input type="number" class="form-control input" placeholder="Masukan jumlah hewan" id="jumlah_hewan" name="jumlah_hewan">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-8">
                                            <div class="mb-3">
                                                <label for="formrow-inputState" class="form-label">Keterangan </label>
                                                <textarea cols="30" rows="5" class="form-control input" id="keterangan_hewan" name="keterangan_hewan"></textarea>
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label for="formrow-inputZip" class="form-label label-gambar">Gambar </label>
                                                <input type="file" class="form-control input" id="gambar_hewan" name="gambar_hewan">
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <button type="submit" id="add-data" class="btn btn-primary w-md">Simpan Data</button>
                                        <button type="button" id="update-data" style="display: none" class="btn btn-warning w-md">Ubah Data</button>
                                    </div>
                                </form>
                            </div>
                            <!-- end card body -->
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Hewan</h4>
                                <p class="card-title-desc">Data Hewan</p>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table mb-0" id="data-peralatan-hewan">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="5%">No</th>
                                                <th width="20%">Nama Hewan</th>
                                                <th width="20%">Harga</th>
                                                <th width="10%">Jumlah</th>
                                                <th width="30%">Ket</th>
                                                <th width="10%">Gambar</th>
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
    @endsection
    @push('js')
        <script src="/assets/js/jquery-3.5.1.js"></script>
        <script src="/assets/js/jquery.dataTables.min.js"></script>
        <script src="/assets/js/dataTables.bootstrap5.min.js"></script>
        <!-- Sweet Alerts js -->
        <script src="/assets/libs/sweetalert2/sweetalert2.min.js"></script>
        <script>

            // load data table
            const table = $('#data-peralatan-hewan').DataTable({          
                "lengthMenu": [[5, 10, 25, 50, 100, -1],[5, 10, 25, 50, 100, 'All']],
                "pageLength": 10, 
                processing: true,
                serverSide: true,
                responseive: true,
                ajax: {
                    url:"{{ url('json_dh') }}",
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
                        return row.nama_hewan
                        }
                    },
                    {
                        "targets": "_all",
                        "defaultContent": "-",
                        "render": function(data, type, row, meta){
                        return "Rp. " +rupiah(row.harga_hewan)
                        }
                    },
                    {
                        "targets": "_all",
                        "defaultContent": "-",
                        "render": function(data, type, row, meta){
                        return row.jumlah_hewan
                        }
                    },
                    {
                        "targets": "_all",
                        "defaultContent": "-",
                        "render": function(data, type, row, meta){
                        return row.keterangan_hewan
                        }
                    },
                    {
                        "targets": "_all",
                        "defaultContent": "-",
                        "render": function(data, type, row, meta){
                            return `<img src="/Gambar_upload/hewan/`+row.gambar_hewan+`" height="50px">`
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

            let harga_hewan = document.getElementById("harga_hewan");
            harga_hewan.addEventListener("keyup", function(e) {
                harga_hewan.value = convertRupiah(this.value, "Rp. ");
            });

            function convertRupiah(angka, prefix) {
                var number_string = angka.replace(/[^,\d]/g, "").toString(),
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
                document.getElementById("form-hewan").reset()
            }

            // template sweetalert
            function sweetAlert(icon, title) {
                Swal.fire({
                    icon: icon,
                    title: title,
                });
            }

            $('#form-hewan').on('submit', function(e){
                e.preventDefault();
                $('#add-data').addClass('disabled');
                $('#add-data').html(`<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Loading...`);
                $.ajax({
                    url: "{{ route('dh.index') }}",
                    method: "POST",
                    data: new FormData(this),
                    dataType:'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response) {
                        console.log(response);
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
                    url: "{{ route('dh.index') }}/" + id,
                    success: function(response) {
                        if (response.status == 401) {
                            sweetAlert('error', response.message);
                        } else {
                            $('.input').removeClass('is-invalid');
                            $('#id').val(response.data.id);
                            $('#nama_hewan').val(response.data.nama_hewan);
                            $('#jkel').val(response.data.jkel);
                            $('#tgl_lahir').val(response.data.tgl_lahir);
                            $('#berat_hewan').val(response.data.berat_hewan);
                            $('#tinggi_hewan').val(response.data.tinggi_hewan);
                            $('#jumlah_hewan').val(response.data.jumlah_hewan);
                            $('#keterangan_hewan').val(response.data.keterangan_hewan);
                            harga_hewan.value = convertRupiah(response.data.harga_hewan, "Rp. ");
                            $('.label-gambar').html('Ubah gambar (biarkan kosong jika tidak ingin mengganti gambar)')
                        }
                    }
                });
            });

            $(document).on('click', '#update-data', function(e) {
                e.preventDefault();
                $('#update-data').addClass('disabled');
                $('#update-data').html(`<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Loading...`);
                let id = $('#id').val();

                let formData = new FormData($("#form-hewan")[0]);
                console.log(formData);
                // $.ajax({
                //     type: "PUT",
                //     url: "{{ route('dh.index') }}/" + id,
                //     data: formData,
                //     dataType: 'json',
                //     success: function(response) {
                //         if (response.status == 404) {
                //             sweetAlert('warning', response.message);
                //             tombolUbah();
                //         } else if (response.status == 201){
                //             sweetAlert('info', response.message);
                //             tombolUbah();
                //         } else {
                //             $('#update-data').hide();
                //             $('#add-data').show();
                //             sweetAlert('success', response.message);
                //             reloadReset();
                //             tombolUbah();
                //         }
                //     }
                // });
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
                            url: "{{ route('dh.index') }}/" + id,
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