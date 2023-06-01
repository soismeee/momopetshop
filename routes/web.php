<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HewanController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\KategoriPakanController;
use App\Http\Controllers\KategoriPHController;
use App\Http\Controllers\PakanController;
use App\Http\Controllers\PeralatanHewanController;
use App\Http\Controllers\TreatmentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


// route home page
route::get('/', [HomeController::class, 'index']);
route::get('/ph', [HomeController::class, 'peralatanHewan'])->name('ph');
route::get('/h', [HomeController::class, 'hewan'])->name('h');
route::get('/p', [HomeController::class, 'pakan'])->name('p');
route::get('/t', [HomeController::class, 'treatment'])->name('t');

// route login dan registrasi
route::get('/login', [AuthController::class, 'index'])->name('login')->middleware('guest');
route::get('/register', [AuthController::class, 'register'])->name('register');
route::post('/aksilogin', [AuthController::class, 'authenticate'])->name('aksilogin');
route::post('/registration', [AuthController::class, 'store'])->name('registration');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ROUTE TELAH LOGIN //
route::get('/home', [HomeController::class, 'home'])->name('home')->middleware('auth');

// route menu customer 
route::get('/ck', [HomeController::class, 'keranjang'])->name('ck')->middleware('auth');
route::get('/co', [HomeController::class, 'transaksi'])->name('co')->middleware('auth');
route::post('json_ct', [HomeController::class, 'json_transaksi'])->name('json_ct')->middleware('auth');

// route menu produk customer
route::get('/ch', [HomeController::class, 'in_hewan'])->name('ch')->middleware('auth');
route::get('/cph', [HomeController::class, 'in_peralatan'])->name('cph')->middleware('auth');
route::get('/cp', [HomeController::class, 'in_pakan'])->name('cp')->middleware('auth');
route::get('/ct', [HomeController::class, 'in_treatment'])->name('ct')->middleware('auth');


// ROUTE DATA PENGGUNA //
route::resource('usr', UserController::class)->middleware('auth');
route::post('/json_usr', [UserController::class, 'json'])->middleware('auth');


// ROUTE KATEGORI //
//route kategori peralatan hewan
route::resource('/dkph', KategoriPHController::class)->middleware('auth');
route::post('/json_dkph', [KategoriPHController::class, 'json'])->middleware('auth');

//route kategori pakan
route::resource('/dkp', KategoriPakanController::class)->middleware('auth');
route::post('/json_dkp', [KategoriPakanController::class, 'json'])->middleware('auth');


// ROUTE DATA MASTER //
// route customers
route::get('/dc', [UserController::class, 'customer'])->name('dc')->middleware('auth');
route::post('/json_cus', [UserController::class, 'json_customer'])->name('json_cus')->middleware('auth');
route::put('/udc/{id}', [UserController::class, 'update_customer'])->name('udc')->middleware('auth');
route::get('/cb/{id}', [HomeController::class, 'checkout_barang'])->name('cb')->middleware('auth');
route::get('/che/{id}', [HomeController::class, 'checkout_hewan'])->name('che')->middleware('auth');

route::post('/save', [HomeController::class, 'store'])->name('save')->middleware('auth');

// data hewan
route::resource('/dh', HewanController::class)->middleware('auth');
route::post('/json_dh', [HewanController::class, 'json'])->middleware('auth');
route::post('dh_update/{id}', [HewanController::class, 'update'])->middleware('auth');

// peralatan hewan
route::resource('/dph', PeralatanHewanController::class)->middleware('auth');
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

// ROUTE MANAJEMEN ADMIN DAN KARYAWAN //
// route invoice
route::get('/do', [InvoiceController::class, 'orders'])->name('do')->middleware('auth');
route::post('/json_do', [InvoiceController::class, 'json_orders'])->name('json_do')->middleware('auth');

route::get('/dit', [InvoiceController::class, 'treatment'])->name('dit')->middleware('auth');
