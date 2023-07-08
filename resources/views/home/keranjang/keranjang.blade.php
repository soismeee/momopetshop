@extends('layout.main')
@push('css')
    <!-- Sweet Alert-->
    <link href="/assets/libs/sweetalert2/sweetalert2.min.css" rel="stylesheet" type="text/css" />
@endpush

@section('container')
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-xl-8">
                    <form action="{{ route('save') }}" method="post">
                        @csrf
                        <input type="hidden" name="total_jumlah" id="total_jumlah">
                        <input type="hidden" name="total_harga" id="total_harga">
                        <input type="hidden" name="total_bayar" id="total_bayar">
                        <div class="card">
                            <div class="card-body">

                                <div class="table-responsive">
                                    <table class="table align-middle mb-0 table-nowrap mb-0 table-keranjang">

                                        <thead class="table-light">
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Gambar</th>
                                                <th>Kategori</th>
                                                <th>Jumlah</th>
                                                <th style="width: 120px;">harga</th>
                                                <th style="width: 120px;">Total</th>
                                                <th>#</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td colspan="8" class="text-center" id="loading">
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

                        <div class="row my-4">
                            <div class="col-sm-6">
                                <a href="/home" class="btn btn-link text-muted">
                                    <i class="mdi mdi-arrow-left me-1"></i> Kembali ke dashboard </a>
                            </div> <!-- end col -->
                            <div class="col-sm-6">
                                <div class="text-sm-end mt-2 mt-sm-0">
                                    @if ($keranjang == 0)
                                        <button class="btn btn-dark" disabled>Tidak ada barang</button>
                                    @else
                                    <a href="#" class="btn btn-primary" id="cekout">Cekout</a>
                                    @endif
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row-->

                        <div class="row pembayaran" style="display: none">
                            <div class="card">
                                <div class="card-body">
                                    <ol class="activity-checkout mb-0 px-4 mt-2">
                                        <li class="checkout-item">
                                            <div class="avatar checkout-icon p-1">
                                                <div class="avatar-title rounded-circle bg-primary">
                                                    <h5 class="text-white font-size-16 mb-0">I</h5>
                                                </div>
                                            </div>
                                            <div class="feed-item-list">
                                                <div>
                                                    <h5 class="font-size-16 mb-1">Informasi alamat</h5>
                                                    <p class="text-muted text-truncate mb-4">Masukan alamat anda, lewat tahap ini jika sudah ada alamat yang tertera pada aplikasi</p>
                                                    <div class="mb-3">
                                                        <div>
                                                            <div class="row">
                                                                <div class="col-lg-4">
                                                                    <div class="mb-3">
                                                                        <label class="form-label" for="label_alamat">Label alamat</label>
                                                                        <input type="text" class="form-control input" name="label_alamat" id="label_alamat" placeholder="Bisa berupa rumah atau kantor">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <div class="mb-3">
                                                                        <label class="form-label" for="nama_customer">Nama</label>
                                                                        <input type="text" class="form-control input" name="nama_customer" id="nama_customer" value="{{ auth()->user()->name }}" placeholder="Masukan nama customer">
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-4">
                                                                    <div class="mb-3">
                                                                        <label class="form-label" for="telepon">Telepon</label>
                                                                        <input type="text" class="form-control input" name="telepon" id="telepon" placeholder="Masukan nomor telepon">
                                                                    </div>
                                                                </div>
                                                            </div>
    
                                                            <div class="mb-3">
                                                                <label class="form-label" for="alamat_lengkap">Alamat lengkap</label>
                                                                <textarea class="form-control input" name="alamat_lengkap" id="alamat_lengkap" rows="3" placeholder="Masukan alamat lengkap"></textarea>
                                                            </div>
                                                            <div class="d-flex justify-content-end mb-3">
                                                                <button type="button" class="btn btn-md btn-primary" id="add-alamat">Simpan Alamat</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="checkout-item">
                                            <div class="avatar checkout-icon p-1">
                                                <div class="avatar-title rounded-circle bg-primary">
                                                    <h5 class="text-white font-size-16 mb-0">A</h5>
                                                </div>
                                            </div>
                                            <div class="feed-item-list">
                                                <div>
                                                    <h5 class="font-size-16 mb-1">Alamat Pengiriman</h5>
                                                    <p class="text-muted text-truncate mb-4">Data alamat pengiriman customer</p>
                                                    <div class="mb-3">
                                                        <div class="row" id="list_alamat">
                                                            @error('ac_id')
                                                                <div class="text-danger">
                                                                    <strong>Masukan informasi alamat terlebih dahulu.</strong>
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="checkout-item pb-2">
                                            <div class="avatar checkout-icon p-1">
                                                <div class="avatar-title rounded-circle bg-primary">
                                                    <h5 class="text-white font-size-16 mb-0">P</h5>
                                                </div>
                                            </div>
                                            <div class="feed-item-list">
                                                <div>
                                                    <h5 class="font-size-16 mb-1">Metode Pembayaran</h5>
                                                    <p class="text-muted text-truncate mb-4">Pembayaran dapat dilakukan sebagai berikut</p>
                                                </div>
                                                <div>
                                                    <h5 class="font-size-14 mb-3">Pilih pembayaran :</h5>
                                                    <div class="row">
                                                        <div class="col-lg-6 col-sm-6">
                                                            <div>
                                                                <label class="card-radio-label">
                                                                    <input type="radio" name="metode_bayar" id="pay-methodoption3" class="card-radio-input" value="tunai" checked="">
                
                                                                    <span class="card-radio py-3 text-center text-truncate">
                                                                        <i class="bx bx-money d-block h2 mb-3"></i>
                                                                        <span>Tunai</span>
                                                                    </span>
                                                                </label>
                                                            </div>
                                                        </div>
                
                                                        <div class="col-lg-6 col-sm-6">
                                                            <div data-bs-toggle="collapse">
                                                                <label class="card-radio-label">
                                                                    <input type="radio" name="metode_bayar" id="pay-methodoption1" class="card-radio-input" value="transfer">
                                                                    <span class="card-radio py-3 text-center text-truncate">
                                                                        <i class="bx bx-credit-card d-block h2 mb-3"></i>
                                                                        Transfer
                                                                    </span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ol>
                                </div>
                            </div>
                        </div>

                        <div class="row my-4 tombol-cekout" style="display: none">
                            <div class="text-sm-end mt-2 mt-sm-0">                            
                                <button type="submit" class="btn btn-success disabled" id="tombol">
                                    <i class="mdi mdi-cart-outline me-1"></i> Selesaikan pembelian
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-xl-4">
                    <div class="mt-5 mt-lg-0">
                        <div class="card">
                            <div class="card-header bg-transparent border-bottom py-3 px-4">
                                <h5 class="font-size-16 mb-0">Rekapan data <span class="float-end">{{ date('d/m/Y') }}</span></h5>
                            </div>
                            <div class="card-body p-4 pt-2">
                                <div class="row">
                                    <div class="col-md-5">
                                        Nama customer
                                    </div>
                                    <div class="col-md-7">
                                        : {{ Auth::user()->name }}
                                    </div>
                                    <div class="col-md-5">
                                        Jumlah Barang
                                    </div>
                                    <div class="col-md-7">
                                        : {{ $jumlah }}
                                    </div>
                                    <div class="col-md-5">
                                        Total harga
                                    </div>
                                    <div class="col-md-7" id="view-total">
                                        
                                    </div>
                                </div>
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
    <script src="/assets/libs/sweetalert2/sweetalert2.min.js"></script>

    <script>
        const rupiah = (number) => {
            return new Intl.NumberFormat("id-ID", {
            style: "decimal",
            currency: "IDR"
            }).format(number);
        }

        $(document).ready(() => {
            tabel()
            alamat()
        });

        function tabel(){
            $.ajax({
                type: "GET",
                url: "{{ url('json_k') }}",
                success: function (response){
                    $('#loading').hide()
                    if(response.status == 401) {
                        let datakosong =
                        `<tr class="text-center">
                            <td colspan="8">`+response.errors+`</td>
                        </tr>`
                        $('table tbody').append(datakosong);
                    }else{
                        var data = response.data
                        let record = '';
                        data.forEach((params) => {
                            let body = `
                            <tr >
                                <td>`+params.no+`</td>
                                <td>
                                    <div>
                                        <h5 class="text-truncate font-size-16">`+params.nama+`</h5>
                                        <p class="mb-0 mt-1">Kategori <span class="fw-medium">`+params.kategori+`</span></p>
                                        <input type="hidden" name="id[]" id="id" value="`+params.id+`">
                                        <input type="hidden" name="kategori[]" id="kategori" value="`+params.kategori+`">
                                        <input type="hidden" name="nama[]" id="nama" value="`+params.nama+`">
                                        <input type="hidden" name="jumlah[]" id="jumlah" value="`+params.jumlah+`">
                                        <input type="hidden" name="harga[]" id="harga" value="`+params.harga+`">
                                        <input type="hidden" name="gambar[]" id="gambar" value="`+params.gambar+`">
                                        <input type="hidden" name="folder[]" id="folder" value="`+params.folder+`">
                                        <input type="hidden" name="keterangan[]" id="keterangan" value="`+params.keterangan+`">
                                    </div>
                                </td>
                                <td><img src="/Gambar_upload/`+params.folder+`/`+params.gambar+`" alt="" class="avatar-lg rounded p-1"></td>
                                <td>`+params.kategori+`</td>
                                <td>`+params.jumlah+`</td>
                                <td>`+rupiah(params.harga)+`</td>
                                <td>`+rupiah(params.harga*params.jumlah)+`</td>
                                <td>
                                    <a href="javascript:void(0);" class="px-2 text-danger hapusdata" data-id="`+params.id+`" aria-label="Delete"><i class="bx bx-trash-alt font-size-18"></i></a>
                                </td>
                            </tr>
                            `
                            record += body
                        })
                        $('table tbody').append(record);
                        $('#total_jumlah').val(response.total_jumlah);
                        $('#total_harga').val(response.total_harga);
                        $('#total_bayar').val(response.total_harga);
                        $('#view-total').html("Rp. "+rupiah(response.total_harga))
                        $('#tombol').removeClass('disabled');
                    }
                }
            });
        }

        // untuk alamat 
        function alamat(){
            let id = "{{ auth()->user()->id }}"
            $.ajax({
                type: "GET",
                url: "{{ url('jap') }}/"+id,
                success: function (response){
                    if(response.status == 404) {
                        let datakosong =
                        `
                        <h5>`+response.errors+`</h5>
                        `
                        $('#list_alamat').append(datakosong);
                    }else{
                        console.log(response.first);
                        let datafirst = `
                            <div class="col-lg-4 col-sm-6">
                                <div data-bs-toggle="collapse">
                                    <label class="card-radio-label mb-0">
                                        <input type="radio" name="ac_id" id="ac_id" class="card-radio-input" value="`+response.first.id+`" checked>
                                        <div class="card-radio text-truncate p-3">
                                            <span class="fs-14 mb-4 d-block">`+response.first.label_alamat+`</span>
                                            <span class="fs-14 mb-2 d-block">`+response.first.nama+`</span>
                                            <span class="text-muted fw-normal text-wrap mb-1 d-block">`+response.first.alamat_lengkap+`</span>
                                            <span class="text-muted fw-normal d-block">`+response.first.telepon+`</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        `
                        let record = '';
                        record += datafirst;
                        var data = response.data;
                        data.forEach((params) => {
                            let body = `
                            <div class="col-lg-4 col-sm-6">
                                <div data-bs-toggle="collapse">
                                    <label class="card-radio-label mb-0">
                                        <input type="radio" name="ac_id" id="ac_id" class="card-radio-input" value="`+params.id+`">
                                        <div class="card-radio text-truncate p-3">
                                            <span class="fs-14 mb-4 d-block">`+params.label_alamat+`</span>
                                            <span class="fs-14 mb-2 d-block">`+params.nama+`</span>
                                            <span class="text-muted fw-normal text-wrap mb-1 d-block">`+params.alamat_lengkap+`</span>
                                            
                                            <span class="text-muted fw-normal d-block">`+params.telepon+`</span>
                                        </div>
                                    </label>
                                    
                                </div>
                            </div>
                            `
                            record += body
                        })
                        $('#list_alamat').append(record);
                    }
                }
            });
        }

        $('#add-alamat').on('click', function(e){
            e.preventDefault();
            $('#add-alamat').addClass('disabled');
            $('#add-alamat').html(`<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Loading...`);
            let data = {'label_alamat': $('#label_alamat').val(), 'nama_customer': $('#nama_customer').val(), 'telepon': $('#telepon').val(), 'alamat_lengkap': $('#alamat_lengkap').val(), '_token': '{{ csrf_token() }}'}
            $.ajax({
                url: "{{ url('sac') }}",
                method: "POST",
                data: data,
                dataType:'JSON',
                success: function(response) {
                    console.log(response);
                    if (response.status == 401) {
                        $('.input').addClass('is-invalid');
                        $('#add-alamat').removeClass('disabled');
                        $('#add-alamat').removeClass('btn-warning');
                        $('#add-alamat').addClass('btn-primary');
                        $('#add-alamat').html('Simpan Data');
                    } else {
                        $('.input').removeClass('is-invalid');
                        $('#add-alamat').removeClass('disabled');
                        $('#add-alamat').removeClass('btn-warning');
                        $('#add-alamat').addClass('btn-primary');
                        $('#add-alamat').html('Simpan Data');
                        $('#list_alamat').empty();
                        alamat()
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
                        url: "{{ url('di') }}/" + id,
                        data: {'_token': '{{ csrf_token() }}'},
                        dataType: 'json',
                        success: function(response) {
                            Swal.fire(
                                'Deleted!',
                                response.message,
                                'success'
                            )
                            $('table tbody').empty();
                            $('table tfoot').empty();
                            tabel();
                        }
                    });

                }
            })
        });

        $(document).on('click', '#cekout', function(e){
            $('.pembayaran').show();
            $('.tombol-cekout').show();
        });

        $(document).on('click', '.card-radio-input', function(e){
            let value = $(this).val();
            console.log(value);
        });
    </script>
@endpush