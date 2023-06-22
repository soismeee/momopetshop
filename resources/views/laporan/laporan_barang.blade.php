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
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4 class="card-title">Laporan Penjualan barang</h4>
                                <p class="card-title-desc">Data penjualan barang</p>
                            </div>
                            <form action="{{ route('clo') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-auto">
                                        <label for="form-label">Dari tanggal</label>
                                        <input type="date" class="form-control" name="awal" id="awal" placeholder="Tanggal awal">
                                    </div>
                                    <div class="col-auto">
                                        <label for="form-label">Sampai tanggal</label>
                                        <input type="date" class="form-control" name="akhir" id="akhir" placeholder="Tanggal akhir">
                                    </div>
                                    <div class="col-auto">
                                        <button class="btn btn-md btn-primary mt-4">Cetak laporan</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table mb-0" id="data-peralatan-hewan">
                                <thead class="table-light">
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="20%">ID</th>
                                        <th width="10%">Customer</th>
                                        <th width="15%">Total barang</th>
                                        <th width="15%">Total bayar</th>
                                        <th width="15%">Tanggal transaksi</th>
                                        <th width="10%">Status</th>
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
    <script src="/assets/js/jquery-3.5.1.js"></script>
    <script src="/assets/js/jquery.dataTables.min.js"></script>
    <script src="/assets/js/dataTables.bootstrap5.min.js"></script>
    <!-- Sweet Alerts js -->
    <script src="/assets/libs/sweetalert2/sweetalert2.min.js"></script>
    <script>
        // load data table
        const table = $('#data-peralatan-hewan').DataTable({
            "lengthMenu": [
                [5, 10, 25, 50, 100, -1],
                [5, 10, 25, 50, 100, 'All']
            ],
            "pageLength": 10,
            processing: true,
            serverSide: true,
            responseive: true,
            ajax: {
                url: "{{ url('json_do') }}",
                type: "POST",
                data: function(d) {
                    d._token = "{{ csrf_token() }}"
                }
            },
            columns: [{
                    "targets": "_all",
                    "defaultContent": "-",
                    "render": function(data, type, row, meta) {
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    "targets": "_all",
                    "defaultContent": "-",
                    "render": function(data, type, row, meta) {
                        return row.id
                    }
                },
                {
                    "targets": "_all",
                    "defaultContent": "-",
                    "render": function(data, type, row, meta) {
                        return row.user.name
                    }
                },
                {
                    "targets": "_all",
                    "defaultContent": "-",
                    "render": function(data, type, row, meta) {
                        return row.total_jumlah
                    }
                },
                {
                    "targets": "_all",
                    "defaultContent": "-",
                    "render": function(data, type, row, meta) {
                        return "Rp. " + rupiah(row.total_harga)
                    }
                },
                {
                    "targets": "_all",
                    "defaultContent": "-",
                    "render": function(data, type, row, meta) {
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
