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
                        <h4 class="card-title">treatment</h4>
                        <p class="card-title-desc">Data treatment.</p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="data-treatment" class="table mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="15%">ID transaksi</th>
                                        <th width="15%">Nama user</th>
                                        <th width="15%">Treatment</th>
                                        <th width="20%">Harga</th>
                                        <th width="15%">Tanggal</th>
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

    <div id="modalProses" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" data-bs-scroll="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Proses order treatment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5 id="kode">ID</h5>
                    <p>Anda akan memproses permintaan treatment hewan, ingin menyelesaikannya ?.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary waves-effect waves-light" id="proses">Ya, proses</button>
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
        const table = $('#data-treatment').DataTable({          
            "lengthMenu": [[5, 10, 25, 50, 100, -1],[5, 10, 25, 50, 100, 'All']],
            "pageLength": 10, 
            processing: true,
            serverSide: true,
            responseive: true,
            ajax: {
                url:"{{ url('json_dit') }}",
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
                    return row.user.name
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
                                <a href="{{ url('print_t') }}/`+row.id+`" class="btn btn-sm btn-success">Cetak</a>
                            </div>
                            `                        
                        } else {
                            return `
                            <div class="btn-group">
                                <a href="#" class="btn btn-sm btn-primary proses" data-id="`+row.id+`">Proses</a>
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

        // template sweetalert
        function sweetAlert(icon, title) {
            Swal.fire({
                icon: icon,
                title: title,
            });
        }

        $(document).on('click', '.proses', function(e){
            $('#modalProses').modal('show');
            let id = $(this).data('id');
            $('#kode').html("ID #"+id);
            $('#proses').val(id);
        });

        $(document).on('click', '#proses', function(e){
            let id = $(this).val();
            console.log(id);
            $.ajax({
                type: "POST",
                url: "{{ url('pt') }}/"+id,
                data: {'_token': '{{ csrf_token() }}' },
                dataType: "json",
                success: function(response){
                    $('#modalProses').modal('hide');
                    sweetAlert('success', response.message);
                    table.ajax.reload();
                }
            });
        });
    </script>
@endpush
