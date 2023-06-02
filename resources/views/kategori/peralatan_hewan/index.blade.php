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
            <div class="col-xl-10">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Kategori Peralatan Hewan</h4>
                                <p class="card-title-desc">Data kategori peralatan hewan.</p>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="data-kategori" class="table mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="10%">No</th>
                                                <th width="30%">Nama Kategori</th>
                                                <th width="50%">Ket</th>
                                                <th width="10%">#</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mb-0">Form input</h4>
                            </div>
                            <div class="card-body">
                                <form id="form-kategori">
                                    @csrf
                                    <div class="mb-3">
                                        <input type="hidden" name="id" id="id">
                                        <label for="formrow-firstname-input" class="form-label">Nama kategori</label>
                                        <input type="text" class="form-control input" name="nama_kategori" id="nama_kategori" placeholder="Nama Kategori">
                                    </div>
                                    <div class="mb-3">
                                        <label for="formrow-firstname-input" class="form-label">Keterangan</label>
                                        <textarea class="form-control input" name="keterangan_kategori" id="keterangan_kategori" cols="30" rows="5"></textarea>
                                    </div>
                                    <div>
                                        <button type="submit" id="add-data" class="btn btn-primary w-md">Simpan Data</button>
                                        <button type="submit" id="update-data" style="display: none" class="btn btn-warning w-md">Ubah Data</button>
                                    </div>
                                </form>
                            </div>
                            <!-- end card body -->
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
    <script>
        // load data table
        const table = $('#data-kategori').DataTable({          
            "lengthMenu": [[5, 10, 25, 50, 100, -1],[5, 10, 25, 50, 100, 'All']],
            "pageLength": 10, 
            processing: true,
            serverSide: true,
            responseive: true,
            ajax: {
                url:"{{ url('json_dkph') }}",
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
                    return row.nama_kategori
                    }
                },
                {
                    "targets": "_all",
                    "defaultContent": "-",
                    "render": function(data, type, row, meta){
                    return row.keterangan_kategori
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
            document.getElementById("form-kategori").reset()
        }

        // template sweetalert
        function sweetAlert(icon, title) {
            Swal.fire({
                icon: icon,
                title: title,
            });
        }

        $(document).on('click', '#add-data', function(e) {
            e.preventDefault();
            $('#add-data').addClass('disabled');
            $('#add-data').html(`<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Loading...`);
            $.ajax({
                type: "POST",
                url: "{{ route('dkph.index') }}",
                data: $("#form-kategori").serialize(),
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
                url: "{{ route('dkph.index') }}/" + id,
                success: function(response) {
                    if (response.status == 401) {
                        sweetAlert('error', response.message);
                    } else {
                        $('.input').removeClass('is-invalid');
                        $('#id').val(response.data.id);
                        $('#nama_kategori').val(response.data.nama_kategori);
                        $('#keterangan_kategori').val(response.data.keterangan_kategori);
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
                url: "{{ route('dkph.index') }}/" + id,
                data: $("#form-kategori").serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status == 404) {
                        sweetAlert('warning', response.message);
                        tombolUbah();
                    } else if (response.status == 201){
                        sweetAlert('info', response.message);
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
                        url: "{{ route('dkph.index') }}/" + id,
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
