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
                                <h4 class="card-title mb-0">Form input pakan</h4>
                            </div>
                            <div class="card-body">
                                <form id="form-peralatan-hewan" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="formrow-firstname-input" class="form-label">Nama barang</label>
                                        <input type="text" class="form-control" placeholder="Masukan nama barang" name="nama_barang" id="nama_barang">
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="formrow-email-input" class="form-label">Kategori Barang</label>
                                                <select name="kp_id" id="kp_id" class="form-select">
                                                    @foreach ($kategori as $item)
                                                        <option value="{{ $item->id }}">{{ $item->nama_kategori }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="formrow-email-input" class="form-label">Harga Barang</label>
                                                <input type="text" class="form-control" placeholder="harga barang" id="harga_barang" name="harga_barang">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="formrow-password-input" class="form-label">Stok</label>
                                                <input type="number" class="form-control" placeholder="Masukan stok barang" id="stok_barang" name="stok_barang">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-8">
                                            <div class="mb-3">
                                                <label for="formrow-inputState" class="form-label">Keterangan barang</label>
                                                <textarea cols="30" rows="5" class="form-control" id="keterangan_barang" name="keterangan_barang"></textarea>
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-4">
                                            <div class="mb-3">
                                                <label for="formrow-inputZip" class="form-label">Gambar barang</label>
                                                {{-- <input type="file" class="filepond" id="gambar_barang" name="gambar_barang"> --}}
                                                <input type="file" class="form-control" id="gambar_barang" name="gambar_barang">
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
                                <h4 class="card-title">Pakan</h4>
                                <p class="card-title-desc">Data Pakan.</p>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table mb-0" id="data-peralatan-hewan">
                                        <thead class="table-light">
                                            <tr>
                                                <th width="5%">No</th>
                                                <th width="20%">Nama</th>
                                                <th width="20%">Harga</th>
                                                <th width="10%">Stok</th>
                                                <th width="40%">Ket</th>
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
                    url:"{{ url('json_dp') }}",
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
                        return row.nama_barang
                        }
                    },
                    {
                        "targets": "_all",
                        "defaultContent": "-",
                        "render": function(data, type, row, meta){
                        return "Rp. " +rupiah(row.harga_barang)
                        }
                    },
                    {
                        "targets": "_all",
                        "defaultContent": "-",
                        "render": function(data, type, row, meta){
                        return row.stok_barang
                        }
                    },
                    {
                        "targets": "_all",
                        "defaultContent": "-",
                        "render": function(data, type, row, meta){
                        return row.keterangan_barang
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

            var harga_barang = document.getElementById("harga_barang");
            harga_barang.addEventListener("keyup", function(e) {
                harga_barang.value = convertRupiah(this.value, "Rp. ");
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
                document.getElementById("form-peralatan-hewan").reset()
            }

            // template sweetalert
            function sweetAlert(icon, title) {
                Swal.fire({
                    icon: icon,
                    title: title,
                });
            }

            $('#form-peralatan-hewan').on('submit', function(e){
                e.preventDefault();
                $('#add-data').addClass('disabled');
                $('#add-data').html(`<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Loading...`);
                $.ajax({
                    url: "{{ route('dp.index') }}",
                    method: "POST",
                    data: new FormData(this),
                    dataType:'JSON',
                    contentType: false,
                    cache: false,
                    processData: false,
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
                            url: "{{ route('dp.index') }}/" + id,
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