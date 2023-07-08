@extends('layout.main')
@push('css')
    <!-- Sweet Alert-->
    <link href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('container')
<div class="page-content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-7">
                <div class="mt-5 mt-lg-0">
                    <div class="card">
                        <div class="card-header bg-transparent border-bottom py-3 px-4">
                            <h5 class="font-size-16 mb-0">Detail transaksi <span class="float-end">ID #{{ $order->id }}</span></h5>
                        </div>
                        <div class="card-body p-4 pt-2">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="row">
                                        <div class="col-md-3 mb-2">    
                                            Customer
                                        </div>
                                        <div class="col-md-9 mb-2">                                    
                                            : {{ $order->user->name }}
                                        </div>
                                        <div class="col-md-3 mb-2">    
                                            Metode Bayar
                                        </div>
                                        <div class="col-md-9 mb-2">                                    
                                            : {{ $order->metode_bayar }}    
                                        </div>
                                        <div class="col-md-3 mb-2">    
                                            Tanggal
                                        </div>
                                        <div class="col-md-9 mb-2">                                    
                                            : {{ date("d/m/Y", strtotime($order->tgl_transaksi)) }}    
                                        </div>
                                        <div class="col-md-3 mb-2">    
                                            Jumlah baranng
                                        </div>
                                        <div class="col-md-9 mb-2">                                    
                                            : {{ $order->total_jumlah }}
                                        </div>
                                        <div class="col-md-3 mb-2">    
                                            Total bayar
                                        </div>
                                        <div class="col-md-9 mb-2">                                    
                                            : Rp. {{ number_format($order->total_harga,0,',','.') }}    
                                        </div>
                                        <div class="col-md-3 mb-2">    
                                            uang bayar
                                        </div>
                                        <div class="col-md-9 mb-2">                                    
                                            @if ($order->metode_bayar == "transfer")
                                                <p class="text-mute">: Rp. {{ number_format($order->total_harga,0,',','.') }}</p>
                                                <input type="hidden" class="form-control" name="uang" id="uang" value="{{ $order->total_harga }}">    
                                            @else
                                                <input type="text" class="form-control" name="uang" id="uang">    
                                            @endif
                                        </div>
                                        <div class="col-md-3 mb-2">    
                                            uang kembalian
                                        </div>
                                        <div class="col-md-9 mb-2">                                    
                                            : <strong>Rp.</strong> <strong id="kembalian">0</strong>
                                            <input type="hidden" name="total_bayar" id="total_bayar">
                                            <input type="hidden" name="total_harga" id="total_harga" value="{{ $order->total_harga }}">
                                        </div>
                                    </div>    
                                </div>
                                <div class="col-lg-4">
                                    <h5>Bukti Transfer :</h5>
                                    @if ($order->metode_bayar == "transfer")
                                        @if ($order->bukti == null)
                                            <strong class="text-danger">Pelanggan belum mengirim bukti pembayaran</strong>
                                        @else
                                            <img src="/Gambar_upload/bukti_pembayaran/{{ $order->bukti }}" width="100px">
                                        @endif
                                    @else
                                    <strong>Pelanggan membayar dengan uang tunai</strong>
                                    @endif
                                </div>                           
                            </div>
                            <!-- end table-responsive -->
                        </div>
                    </div>
                </div>
                <div class="row my-4">
                    <div class="col-sm-6">
                        <a href="{{ url('do') }}" class="btn btn-link text-muted">
                            <i class="mdi mdi-arrow-left me-1"></i> Kembali ke invoice
                        </a>
                    </div> <!-- end col -->
                    <div class="col-sm-6">
                        <div class="text-sm-end mt-2 mt-sm-0">
                            {{-- @if ($order->status == 1) --}}
                            <a href="{{ url('/print') }}/{{ $order->id }}" target="_blank" class="btn btn-warning" style="display: none" id="cetak"><i class="mdi mdi-printer me-1"></i>Cetak Struk</a>
                            {{-- @else --}}
                            @if ($order->metode_bayar == 'tunai')
                            <button type="button" class="btn btn-success" id="proses">
                                <i class="mdi mdi-cart-outline me-1"></i> Selesaikan pesanan
                            </button>
                            @else
                            <button type="button" class="btn btn-primary" id="proses2">
                                <i class="mdi mdi-cart-outline me-1"></i> Selesaikan pesanan
                            </button>
                            @endif
                            {{-- @endif --}}
                        </div>
                    </div> <!-- end col -->
                </div> <!-- end row-->
            </div>

            <div class="col-xl-5">
                <div class="card">
                    <div class="card-body">
                        <h6>List barang pada transaksi</h6>
                        <div class="table-responsive">
                            <table class="table align-middle mb-0 table-nowrap mb-0 table-keranjang">
                                <thead class="table-light">
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th style="width: 120px;">harga</th>
                                        <th>Gambar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td colspan="6" class="text-center" id="loading">
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
                <!-- end card -->
            </div>
        </div>
    </div>
    <!-- container-fluid -->
</div>
<!-- End Page-content -->
@endsection

@push('js')
    <script src="{{ asset('assets/js/jquery-3.5.1.js') }}"></script>
    <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>

    <script>

        let uang = document.getElementById("uang");
        uang.addEventListener("keyup", function(e) {
            let harga = "{{ $order->total_harga }}"
            let cash = uang.value;
            var cash2 = cash.toUpperCase();
            var duit = cash2.replace(/[^\w\s]/gi, '');
            var duit2 = duit.replace(/\s/g, '');
            var duit3 = duit2.replace(/[^0-9]/, '');
            var duit4 = duit3.substr(1);
            let kembalian = duit4 - harga
            uang.value = convertRupiah(this.value, "Rp. ");
            $('#total_bayar').val(kembalian)
            $('#kembalian').html(rupiah(kembalian));
        });

        const rupiah = (number) => {
            return new Intl.NumberFormat("id-ID", {
            style: "decimal",
            currency: "IDR"
            }).format(number);
        }

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

        function tabel(){
            $.ajax({
                type: "GET",
                url: "{{ url('json_ol') }}/{{ $order->id }}",
                success: function (response){
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
                            <tr>
                                <td>`+params.no+`</td>
                                <td>
                                    <div>
                                        <h5 class="text-truncate font-size-16">`+params.nama+`</h5>
                                        <p class="mb-0 mt-1">Kategori <span class="fw-medium">`+params.kategori+`</span></p>
                                    </div>
                                </td>
                                <td>`+rupiah(params.harga)+`</td>
                                <td><img src="/Gambar_upload/`+params.folder+`/`+params.gambar+`" alt="" class="avatar-lg rounded p-1"></td>
                            </tr>
                            `
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

        function kirimdata(id){
            $.ajax({
                type: "POST",
                url: "{{ url('proses') }}/" + id,
                data: {'_token': '{{ csrf_token() }}', 'total_bayar': $('#total_bayar').val(), 'total_harga': $('#total_harga').val()},
                dataType: 'json',
                success: function(response) {
                    sweetAlert('success', response.message);
                    $('#proses').hide();
                    $('#proses2').hide();
                    $('#cetak').show();
                }
            });
        }

        $(document).ready(function () {
            tabel()
        });

        $(document).on('click', '#proses', function(e){
            let id = "{{ $order->id }}"
            let total_bayar = "{{ $order->total_bayar }}"
            let cas = $('#uang').val();
            if (!cas) {
                sweetAlert('warning', 'Masukan jumlah uang yang dibayarkan')
            }else{
                var cas2 = cas.toUpperCase();
                var dt = cas2.replace(/[^\w\s]/gi, '');
                var dt2 = dt.replace(/\s/g, '');
                var dt3 = dt2.replace(/[^0-9]/, '');
                var dt4 = dt3.substr(1);
                let hasil = parseInt(dt4) - parseInt(total_bayar);
                if(hasil < 0){
                    sweetAlert('warning', 'Uang pembayaran kurang')
                }else{
                    kirimdata(id);
                }
            }
        });

        $(document).on('click', '#proses2', function(e){
            let id = "{{ $order->id }}"
            kirimdata(id);
        });

    </script>
@endpush