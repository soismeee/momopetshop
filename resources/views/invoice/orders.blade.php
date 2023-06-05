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
                        <h4 class="card-title">Transaksi</h4>
                        <p class="card-title-desc">Data Transaksi.</p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="data-orders" class="table mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th width="10%">No</th>
                                        <th width="15%">ID Pembelian</th>
                                        <th width="15%">Nama customer</th>
                                        <th width="10%">Tanggal</th>
                                        <th width="10%">Jumlah</th>
                                        <th width="20%">Total</th>
                                        <th width="10%">Status</th>
                                        <th width="10%">#</th>
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
        const table = $('#data-orders').DataTable({          
            "lengthMenu": [[5, 10, 25, 50, 100, -1],[5, 10, 25, 50, 100, 'All']],
            "pageLength": 10, 
            processing: true,
            serverSide: true,
            responseive: true,
            ajax: {
                url:"{{ url('json_do') }}",
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
                    return row.tgl_transaksi
                    }
                },
                {
                    "targets": "_all",
                    "defaultContent": "-",
                    "render": function(data, type, row, meta){
                    return row.total_jumlah
                    }
                },
                {
                    "targets": "_all",
                    "defaultContent": "-",
                    "render": function(data, type, row, meta){
                    return rupiah(row.total_harga)
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
                                <a href="{{ url('/print') }}/`+row.id+`" target="_blank" class="btn btn-sm btn-success">Cetak</a>
                            </div>
                            `                        
                        } else {
                            return `
                            <div class="btn-group">
                                <a href="{{ url('dio') }}/`+row.id+`" class="btn btn-sm btn-primary">Detail</a>
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

    </script>
@endpush
