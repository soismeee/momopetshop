<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HewanController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\KategoriHewanController;
use App\Http\Controllers\KategoriPakanController;
use App\Http\Controllers\KategoriPHController;
use App\Http\Controllers\PakanController;
use App\Http\Controllers\PeralatanHewanController;
use App\Http\Controllers\PersediaanController;
use App\Http\Controllers\StokOpnameController;
use App\Http\Controllers\TreatmentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


// route home page
route::get('/', [HomeController::class, 'index'])->middleware('guest');
route::get('/ph', [HomeController::class, 'peralatanHewan'])->name('ph')->middleware('guest');
route::get('/h', [HomeController::class, 'hewan'])->name('h')->middleware('guest');
route::get('/p', [HomeController::class, 'pakan'])->name('p')->middleware('guest');
route::get('/t', [HomeController::class, 'treatment'])->name('t')->middleware('guest');

// route login dan registrasi
route::get('/login', [AuthController::class, 'index'])->name('login')->middleware('guest');
route::get('/register', [AuthController::class, 'register'])->name('register');
route::post('/aksilogin', [AuthController::class, 'authenticate'])->name('aksilogin');
route::post('/registration', [AuthController::class, 'store'])->name('registration');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ROUTE TELAH LOGIN //
route::get('/home', [HomeController::class, 'home'])->name('home')->middleware('auth');
route::get('/profil', [AuthController::class, 'profil'])->name('profil')->middleware('auth');
route::post('/chusr', [AuthController::class, 'update_user'])->name('chusr')->middleware('auth');

// route menu customer 
route::get('/ck', [HomeController::class, 'keranjang'])->name('ck')->middleware('auth');
route::get('/co', [HomeController::class, 'transaksi'])->name('co')->middleware('auth');
route::get('/ctt', [HomeController::class, 'transaksi_treatment'])->name('ctt')->middleware('auth');
route::post('json_ct', [HomeController::class, 'json_transaksi'])->name('json_ct')->middleware('auth');
route::post('json_ctt', [HomeController::class, 'json_transaksi_treatment'])->name('json_ctt')->middleware('auth');

// route menu produk customer
route::get('/ch', [HomeController::class, 'in_hewan'])->name('ch')->middleware('auth');
route::get('/cdh/{id}', [HomeController::class, 'detail_hewan'])->name('cdh')->middleware('auth');
route::get('/cph', [HomeController::class, 'in_peralatan'])->name('cph')->middleware('auth');
route::get('/cdph/{id}', [HomeController::class, 'detail_peralatan'])->name('cdph')->middleware('auth');
route::get('/cp', [HomeController::class, 'in_pakan'])->name('cp')->middleware('auth');
route::get('/cdp/{id}', [HomeController::class, 'detail_pakan'])->name('cdp')->middleware('auth');
route::get('/ct', [HomeController::class, 'in_treatment'])->name('ct')->middleware('auth');
route::get('/cdte/{id}', [HomeController::class, 'detail_treatment'])->name('cdte')->middleware('auth');

route::post('/sac', [HomeController::class, 'store_alamat'])->name('sac')->middleware('auth');
route::post('/save', [HomeController::class, 'store'])->name('save')->middleware('auth');
route::post('/ubtf', [HomeController::class, 'upload_buktitf'])->name('ubtf')->middleware('auth');
route::post('/ubtft', [HomeController::class, 'upload_buktitf_treatment'])->name('ubtft')->middleware('auth');
route::get('/json_k', [HomeController::class, 'json_keranjang'])->name('json_k')->middleware('auth');
route::get('/jap/{id}', [HomeController::class, 'json_alamat_pelanggan'])->name('jap')->middleware('auth');
route::delete('/di/{id}', [HomeController::class, 'destroy_item'])->name('di')->middleware('auth');


// ROUTE CUSTOMER
route::get('/dc', [UserController::class, 'customer'])->name('dc')->middleware('auth');
route::get('/cb/{id}', [HomeController::class, 'checkout_barang'])->name('cb')->middleware('auth');
route::get('/che/{id}', [HomeController::class, 'checkout_hewan'])->name('che')->middleware('auth');
route::get('/dtc/{id}', [HomeController::class, 'detail_transaksi'])->name('dtc')->middleware('auth');
route::get('/json_co/{id}', [HomeController::class, 'json_detailorder'])->name('json_co')->middleware('auth');
route::get('/sdt/{id}', [HomeController::class, 'detail_order_treatment'])->name('json_co')->middleware('auth');
route::put('/udc/{id}', [UserController::class, 'update_customer'])->name('udc')->middleware('auth');
route::post('/cht/{id}', [HomeController::class, 'checkout_treatment'])->name('cht')->middleware('auth');
route::post('/json_cus', [UserController::class, 'json_customer'])->name('json_cus')->middleware('auth');
route::delete('/cdt/{id}', [HomeController::class, 'destroy_order'])->name('cdt')->middleware('auth');
route::delete('/cdtt/{id}', [HomeController::class, 'destroy_order_treatment'])->name('cdtt')->middleware('auth');

// ROUTE MASTER PENGGUNA //
route::resource('usr', UserController::class)->middleware('auth');
route::post('/json_usr', [UserController::class, 'json'])->middleware('auth');

// ROUTE KATEGORI //
//route kategori peralatan hewan
route::resource('/dkph', KategoriPHController::class)->middleware('auth');
route::post('/json_dkph', [KategoriPHController::class, 'json'])->middleware('auth');

//route kategori pakan
route::resource('/dkp', KategoriPakanController::class)->middleware('auth');
route::post('/json_dkp', [KategoriPakanController::class, 'json'])->middleware('auth');

// route kategori hewan
route::resource('/dkh', KategoriHewanController::class)->middleware('auth');
route::post('json_dkh', [KategoriHewanController::class, 'json'])->middleware('auth');

// ROUTE DATA MASTER //
// data hewan
route::resource('/dh', HewanController::class)->middleware('auth');
route::post('/json_dh', [HewanController::class, 'json'])->middleware('auth');
route::post('dh_update/{id}', [HewanController::class, 'update'])->middleware('auth');
route::post('/adth', [HewanController::class, 'add_stok'])->middleware('auth');

// peralatan hewan
route::resource('/dph', PeralatanHewanController::class)->middleware('auth');
route::post('/adtap', [PeralatanHewanController::class, 'add_stok'])->middleware('auth');
route::post('/json_dph', [PeralatanHewanController::class, 'json'])->middleware('auth');
route::post('dph_update/{id}', [PeralatanHewanController::class, 'update'])->middleware('auth');
route::post('/upload', [PeralatanHewanController::class, 'upload'])->middleware('auth');
route::delete('/deleteupload', [PeralatanHewanController::class, 'destroyUpload'])->middleware('auth');

// pakan
route::resource('/dp', PakanController::class)->middleware('auth');
route::post('/json_dp', [PakanController::class, 'json'])->middleware('auth');
route::post('dp_update/{id}', [PakanController::class, 'update'])->middleware('auth');

// treatment
route::resource('/dt', TreatmentController::class)->middleware('auth');
route::post('/json_dt', [TreatmentController::class, 'json'])->middleware('auth');
route::post('dt_update/{id}', [TreatmentController::class, 'update'])->middleware('auth');

// ROUTE MANAJEMEN ADMIN DAN KARYAWAN //
// route invoice
route::get('/do', [InvoiceController::class, 'orders'])->name('do')->middleware('auth');
route::get('/dit', [InvoiceController::class, 'treatment'])->name('dit')->middleware('auth');
route::get('/dio/{id}', [InvoiceController::class, 'show'])->name('dio')->middleware('auth');
route::get('/json_ol/{id}', [InvoiceController::class, 'list_detailorder'])->name('json_ol')->middleware('auth');
route::get('/print/{id}', [InvoiceController::class, 'print'])->name('print')->middleware('auth');
route::get('/print_t/{id}', [InvoiceController::class, 'print_treatment'])->name('print_t')->middleware('auth');
route::post('/json_do', [InvoiceController::class, 'json_orders'])->name('json_do')->middleware('auth');
route::post('/json_dit', [InvoiceController::class, 'json_treatment'])->name('json_dit')->middleware('auth');
route::post('/proses/{id}', [InvoiceController::class, 'proses'])->name('proses')->middleware('auth');
route::post('/pt/{id}', [InvoiceController::class, 'proses_treatment'])->name('pt')->middleware('auth');

// route opname
route::get('/sopp', [StokOpnameController::class, 'opname_alat_pakan'])->name('sopp')->middleware('auth');
route::get('/json_sopp', [StokOpnameController::class, 'json_sopp'])->name('json_sopp')->middleware('auth');
route::get('/csopp', [StokOpnameController::class, 'cetak_sopp'])->name('csopp')->middleware('auth');
route::post('/esb/{id}', [StokOpnameController::class, 'update_barang'])->name('esb')->middleware('auth');
route::post('/esh/{id}', [StokOpnameController::class, 'update_hewan'])->name('esh')->middleware('auth');
route::post('/sopp/{id}', [StokOpnameController::class, 'show_sopp'])->middleware('auth');

route::get('/soh', [StokOpnameController::class, 'opname_hewan'])->name('soh')->middleware('auth');
route::get('/json_soh', [StokOpnameController::class, 'json_soh'])->name('json_soh')->middleware('auth');
route::get('/csoh', [StokOpnameController::class, 'cetak_soh'])->name('csoh')->middleware('auth');
route::post('/soh/{id}', [StokOpnameController::class, 'show_soh'])->middleware('auth');

// route persediaan
route::get('pb', [PersediaanController::class, 'barang'])->name('pb')->middleware('auth');
route::get('pb/{id}', [PersediaanController::class, 'get_barang'])->middleware('auth');
route::get('gdb/{id}', [PersediaanController::class, 'get_data_barang'])->middleware('auth');
route::put('pb/{id}', [PersediaanController::class, 'update_barang'])->middleware('auth');
route::post('cpb', [PersediaanController::class, 'cetak_laporan_barang'])->name('cpb')->middleware('auth');
route::post('json_pb', [PersediaanController::class, 'json_barang'])->name('json_pb')->middleware('auth');
route::post('spb', [PersediaanController::class, 'store_barang'])->name('spb')->middleware('auth');
route::delete('dpb/{id}', [PersediaanController::class, 'destroy_barang'])->name('dpb')->middleware('auth');

route::get('ph', [PersediaanController::class, 'hewan'])->name('ph')->middleware('auth');
route::get('ph/{id}', [PersediaanController::class, 'get_hewan'])->middleware('auth');
route::get('gdh/{id}', [PersediaanController::class, 'get_data_hewan'])->middleware('auth');
route::put('ph/{id}', [PersediaanController::class, 'update_hewan'])->middleware('auth');
route::post('cph', [PersediaanController::class, 'cetak_laporan_hewan'])->name('cph')->middleware('auth');
route::post('json_ph', [PersediaanController::class, 'json_hewan'])->name('json_ph')->middleware('auth');
route::post('sph', [PersediaanController::class, 'store_hewan'])->name('sph')->middleware('auth');
route::delete('dtph/{id}', [PersediaanController::class, 'destroy_hewan'])->name('dtph')->middleware('auth');

// route laporan
route::get('/lo', [InvoiceController::class, 'laporan_order'])->name('lo')->middleware('auth');
route::get('/lt', [InvoiceController::class, 'laporan_treatment'])->name('lt')->middleware('auth');

route::post('/clo', [InvoiceController::class, 'print_laporan_penjualan'])->name('clo')->middleware('auth');
route::post('/clt', [InvoiceController::class, 'print_laporan_treatment'])->name('clt')->middleware('auth');