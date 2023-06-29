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
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Transaksi treatment</h4>
                        <p class="card-title-desc">Data Transaksi Treatment.</p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="data-kategori" class="table mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="10%">ID Pembelian</th>
                                        <th width="10%">Treatment</th>
                                        <th width="15%">Total</th>
                                        <th width="15%">Tanggal</th>
                                        <th width="15%">Metode Bayar</th>
                                        <th width="10%">Status</th>
                                        <th width="5%">#</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
    </div>

    <!-- sample modal content -->
    <div id="modalBuktiTF" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-scroll="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Upload Bukti Transfer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="form-uploadbukti">
                    @csrf
                    <div class="modal-body">
                        <label class="form-label">Upload bukti transfer</label>
                        <input type="hidden" id="id" name="id">
                        <input type="file" class="form-control" name="bukti" id="bukti">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary waves-effect waves-light">Kirim Bukti Transfer </button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div id="modalDetail" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-scroll="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Detail transaksi treatment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="card-body">
                    <h4 class="card-title" id="idpembelian">#</h4>
                    <h5>Nama : {{ auth()->user()->name }}</h5>
                    <h5 id="totalpembayaran">Total Pembayaran : Rp. 0</h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary waves-effect" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
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
                url:"{{ url('json_ctt') }}",
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
                        return row.id
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
                    return rupiah(row.harga_treatment)
                    }
                },
                {
                    "targets": "_all",
                    "defaultContent": "-",
                    "render": function(data, type, row, meta){
                    return row.tgl_transaksi
                    }
                },
                {
                    "targets": "_all",
                    "defaultContent": "-",
                    "render": function(data, type, row, meta){
                        if (row.metode_bayar == "tunai") {
                            return '<span class="badge badge-pill badge-soft-primary font-size-12">Tunai</span>';
                        } else {
                            if (row.bukti == null) {
                                return `<span class="badge badge-pill badge-soft-dark font-size-12">Transfer</span> <button class="btn btn-sm btn-dark buktitf" data-id="`+row.id+`">Bukti TF</button>`;  
                            } else {
                                return `<span class="badge badge-pill badge-soft-dark font-size-12">Transfer, bukti terlampir</span>`;  
                            }
                        }
                    }
                },
                {
                    "targets": "_all",
                    "defaultContent": "-",
                    "render": function(data, type, row, meta){
                        if (row.status == 1) {
                            return '<span class="badge badge-pill badge-soft-success font-size-12">Selesai</span>';
                        } else {
                            return '<span class="badge badge-pill badge-soft-danger font-size-12">Proses</span>';
                        }
                    }
                },
                {
                    "targets": "_all",
                    "defaultContent": "-",
                    "render": function(data, type, row, meta){
                    if (row.status == 1) {
                        return `
                        <div class="btn-group">
                            <a href="#" title="Edit" data-id="`+row.id+`" class="btn btn-sm btn-primary px-2 show">Lihat</a>
                         </div>
                        `
                    } else {
                        return `
                        <div class="btn-group">
                            <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete" class="btn btn-sm btn-danger hapusdata" data-id="`+row.id+`">Hapus</a>
                        </div>
                        `
                    }
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

        $(document).on('click', '.buktitf', function(e){
            let id = $(this).data('id');
            $('#id').val(id)
            $('#modalBuktiTF').modal('show')
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
                        url: "{{ url('/cdtt') }}/" + id,
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

        $(document).on('click', '.show', function(e){
            let id = $(this).data('id');
            $.ajax({
                type: "GET",
                url: "{{ url('sdt') }}/"+id,
                dataType: "json",
                success: function(response){
                    $('#idpembelian').html('ID: #'+response.data.id);
                    $('#totalpembayaran').html("Total Pembayaran : Rp. "+rupiah(response.data.harga_treatment));
                    $('#modalDetail').modal('show');
                }
            });
        });

        $('#form-uploadbukti').on('submit', function(e){
            e.preventDefault();
            $.ajax({
                url: "{{ url('/ubtft') }}",
                method: "POST",
                data: new FormData(this),
                dataType:'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {
                    console.log(response);
                    if (response.status == 401) {
                        alert('Bukti TF tidak dapat dikirim')   
                    } else {
                        $('#modalBuktiTF').modal('hide')
                        table.ajax.reload();
                    }
                }
            });
        });
    </script>
@endpush
