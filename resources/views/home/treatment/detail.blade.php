@extends('layout.main')

@section('container')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xxl-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-8">
                                    <div class="">
                                        <h5 class="font-size-14 mb-3">Keterangan : </h5>
                                        <div class="text-muted mb-3">
                                            <span class="badge bg-success font-size-14 me-1"><i class="mdi mdi-star"></i>
                                                {{ $treatment->status_treatment }}</span>
                                        </div>

                                        <div class="border py-4 rounded">

                                            <div class="px-4" data-simplebar="init" style="max-height: 360px;">
                                                <div class="simplebar-wrapper" style="margin: 0px -24px;">
                                                    <div class="simplebar-height-auto-observer-wrapper">
                                                        <div class="simplebar-height-auto-observer"></div>
                                                    </div>
                                                    <div class="simplebar-mask">
                                                        <div class="simplebar-offset" style="right: -17px; bottom: 0px;">
                                                            <div class="simplebar-content-wrapper"
                                                                style="height: auto; overflow: hidden scroll;">
                                                                <div class="simplebar-content" style="padding: 0px 24px;">
                                                                    <div class="border-bottom pb-3">
                                                                        <p class="text-muted mb-4">{{ $treatment->keterangan_treatment }}</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="simplebar-placeholder" style="width: auto; height: 605px;">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="px-4 mt-2">
                                                <div class="text-end mt-3">
                                                    <a href="#" class="btn btn-primary" id="cekout">Pesan Sekarang</a>
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <form action="{{ url('/cht') }}/{{ $treatment->id }}" method="post">
                                            @csrf
                                            <div class="row pembayaran mt-4" style="display: none">
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
                                            <div class="text-end mt-3">
                                                <button type="submit" class="btn btn-success w-sm text-truncate ms-2 tombol-cekout" style="display: none">
                                                    <i class="bx bx-send ms-2 align-middle"></i> Pesan sekarang
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <div class="col-4">
                                    <div class="product-desc">
                                        <h5 class="font-size-14 mb-3">Deskripsi : </h5>
                                        <div class="table-responsive">
                                            <table class="table table-nowrap mb-0">
                                                <tbody>
                                                    <tr>
                                                        <th scope="row" style="width: 50%;">Harga :</th>
                                                        <td> Rp. {{ number_format($treatment->harga_treatment,0,',','.') }} </td>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="2">Gambar :</th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="2">
                                                            <img src="/Gambar_upload/treatment/{{ $treatment->gambar_treatment }}" alt="gambar treatment" width="400px">
                                                        </th>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
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
        $(document).ready(() => {
            alamat()
        });

        $(document).on('click', '#cekout', function(e){
            $('.pembayaran').show();
            $('.tombol-cekout').show();
        });

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

    </script>
@endpush
