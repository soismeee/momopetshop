<?php

namespace App\Http\Controllers;

use App\Models\AlamatPelanggan;
use App\Models\Barang;
use App\Models\BarangKeluar;
use App\Models\DetailTransaksi;
use App\Models\Hewan;
use App\Models\HewanKeluar;
use App\Models\KategoriBarang;
use App\Models\Keranjang;
use App\Models\Transaksi;
use App\Models\TransaksiTreatment;
use App\Models\Treatment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class HomeController extends Controller
{

    // ######################################################################################
    // FUNCTIONS BELUM LOGIN
    public function index(){
        return view('not_in.index', [
            'title' => 'Home',
            'barang' => Barang::paginate(5),
            'barangsejenis' => Barang::paginate(10)
        ]);
    }

    public function hewan(){
        return view('not_in.hewan', [
            'title' => 'Hewan',
            'hewan' => Hewan::all()
        ]);
    }
    
    public function peralatanHewan(){
        return view('not_in.peralatan',[
            'title' => 'Peralatan Hewan',
            'kategori' => KategoriBarang::where('kategori', 'alat')->get(),
            'peralatan' => Barang::with('kategori_barang')->where('kategori', 'alat')->get()
        ]);
    }

    public function pakan(){
        return view('not_in.pakan', [
            'title' => 'Pakan',
            'kategori' => KategoriBarang::where('kategori', 'pakan')->get(),
            'pakan' => Barang::with('kategori_barang')->where('kategori', 'pakan')->get()
        ]);
    }

    public function treatment(){
        return view('not_in.treatment', [
            'title' => 'Treatment',
            'treatment' => Treatment::where('status_treatment', 'aktif')->get()
        ]);
    }
    
    // ######################################################################################
    // FUNCTIONS SUDAH LOGIN
    public function home(){
        $keranjang_customer = Keranjang::where('user_id', auth()->user()->id)->where('status', 0)->count();
        $transkasi_customer = Transaksi::where('user_id', auth()->user()->id)->count();
        if(auth()->user()->role == 3){
            return view('home.index_customer',[
                'title' => 'Dashboard',
                'keranjang' => $keranjang_customer,
                'order' => $transkasi_customer
            ]);
        }else{
            $penjualanperbulan = Transaksi::whereMonth('created_at',date('m'))->whereYear('created_at',date('Y'))->sum('total_harga');
            $penjualanpertahun = Transaksi::whereYear('created_at',date('Y'))->sum('total_harga');
            $pelanggan = User::where('role', 3)->count();
            $treatment = Treatment::get()->count();
            $peralatan = Barang::where('kategori', 'alat')->count();
            $pakan = Barang::where('kategori', 'pakan')->count();
            return view('home.index', [
                'title' => 'Home',
                'perbulan' => $penjualanperbulan,
                'pertahun' => $penjualanpertahun,
                'pelanggan' => $pelanggan,
                'treatment' => $treatment,
                'peralatan' => $peralatan,
                'pakan' => $pakan,
            ]);
        }
    }

    public function in_hewan(){
        return view('home.hewan.hewan', [
            'title' => 'Data hewan',
            'hewan' => Hewan::all()
        ]);
    }

    public function detail_hewan($id){
        $hewan = Hewan::find($id);

        $dateOfBirth = $hewan->tgl_lahir;
        $years = Carbon::parse($dateOfBirth)->age;

        return view('home.hewan.detail', [
            'title' => 'Detail hewan',
            'hewan' => $hewan,
            'umur' => $years,
        ]);
    }

    public function in_peralatan(){
        return view('home.peralatan.peralatan', [
            'title' => 'Data Peralatan',
            'kategori' => KategoriBarang::where('kategori', 'alat')->get(),
            'peralatan' => Barang::where('kategori', 'alat')->get()
        ]);
    }

    public function detail_peralatan($id){
        return view('home.peralatan.detail', [
            'title' => 'Detail peralatan',
            'peralatan' => Barang::find($id)
        ]);
    }

    public function in_pakan(){
        return view('home.pakan.pakan', [
            'title' => 'Data pakan',
            'kategori' => KategoriBarang::where('kategori', 'pakan')->get(),
            'pakan' => Barang::where('kategori', 'pakan')->get()
        ]);
    }

    public function detail_pakan($id){
        return view('home.pakan.detail', [
            'title' => 'Detail pakan',
            'pakan' => Barang::find($id)
        ]);
    }

    public function in_treatment(){
        return view('home.treatment.treatment', [
            'title' => 'Data treatment',
            'treatment' => Treatment::where('status_treatment', 'aktif')->get()
        ]);
    }

    public function detail_treatment($id){
        return view('home.treatment.detail', [
            'title' => 'Detail treatment',
            'treatment' => Treatment::find($id)
        ]);
    }

    // DATA CUSTOMER ADA DI FUNGSI DIBAWAH INI //

    public function checkout_barang(Request $request, $id){
        $peralatan = Barang::find($id);
        $stok = $peralatan->stok_barang;

        $peralatan->stok_barang = $stok-$request->jumlah;
        $peralatan->update();

        $cek = Keranjang::where('user_id', auth()->user()->id)->where('brg_id', $peralatan->id)->where('status', 0)->first();
        if($cek){
            $update = Keranjang::find($cek->id);
            $update->jumlah = $cek->jumlah+$request->jumlah;
            $update->update();
        }else{
            $keranjang = new Keranjang();
            $keranjang->id = intval((microtime(true) * 10000));
            $keranjang->user_id = auth()->user()->id;
            $keranjang->brg_id = $id;
            $keranjang->kategori = $peralatan->kategori;
            $keranjang->nama = $peralatan->nama_barang;
            $keranjang->jumlah = $request->jumlah;
            $keranjang->harga = $peralatan->harga_barang;
            $keranjang->folder = "barang";
            $keranjang->gambar = $peralatan->gambar_barang;
            $keranjang->keterangan = $peralatan->keterangan_barang;
            $keranjang->save();
        }

        // return redirect('ck');
        return response()->json([
            'status' => 200,
            'message' => 'Berhasil memasukan ke dalam keranjang'
        ]);
    }
    
    public function checkout_hewan(Request $request, $id){
        // masih dalam proses pembuatan jalur ketika cekout, apakah akan menggunakan response json atau redirect
        $hewan = Hewan::find($id);
        $jml = $hewan->jumlah_hewan;

        $hewan->jumlah_hewan = $jml-$request->jumlah;
        $hewan->update();
        
        $cek = Keranjang::where('user_id', auth()->user()->id)->where('brg_id', $hewan->id)->where('status', 0)->first();
        if($cek){
            $update = Keranjang::find($cek->id);
            $update->jumlah = $cek->jumlah+$request->jumlah;
            $update->update();
        }else{
            $keranjang = new Keranjang();
            $keranjang->id = intval((microtime(true) * 10000));
            $keranjang->user_id = auth()->user()->id;
            $keranjang->brg_id = $id;
            $keranjang->kategori = "hewan";
            $keranjang->nama = $hewan->nama_hewan;
            $keranjang->jumlah = $request->jumlah;
            $keranjang->harga = $hewan->harga_hewan;
            $keranjang->folder = "hewan";
            $keranjang->gambar = $hewan->gambar_hewan;
            $keranjang->keterangan = $hewan->keterangan_hewan;
            $keranjang->save();
        }

        // return redirect('ck');
        return response()->json([
            'status' => 200,
            'message' => 'Berhasil memasukan ke dalam keranjang'
        ]);

    }

    public function checkout_treatment(Request $request, $id){
        $rules = $request->validate([
            'ac_id' => 'required',
            'metode_bayar' => 'required',
        ]);
        
        $t = Treatment::find($id);

        $tt = new TransaksiTreatment();
        $tt->id = date("YmdHis").intval(microtime(true));
        $tt->user_id = auth()->user()->id;
        $tt->ac_id = $request->ac_id;
        $tt->metode_bayar = $request->metode_bayar;
        $tt->nama_treatment = $t->nama_treatment;
        $tt->harga_treatment = $t->harga_treatment;
        $tt->gambar_treatment = $t->gambar_treatment;
        $tt->keterangan_treatment = $t->keterangan_treatment;
        $tt->tgl_transaksi  = date("Y-m-d");
        $tt->save();

        return redirect('/ctt');
    }

    public function store(Request $request){
        // dd($request);

        $rules = $request->validate([
            'ac_id' => 'required',
            'metode_bayar' => 'required',
        ]);

        $transaksi = new Transaksi();
        $transaksi->id = date("YmdHis").intval(microtime(true));
        $transaksi->user_id = auth()->user()->id;
        $transaksi->total_jumlah = $request->total_jumlah;
        $transaksi->ac_id = $request->ac_id;
        $transaksi->total_harga = $request->total_harga;
        $transaksi->tgl_transaksi = date("Y-m-d");
        $transaksi->total_bayar = $request->total_bayar;
        $transaksi->metode_bayar = $request->metode_bayar;
        $transaksi->save();
        $trans_id = $transaksi->id;

        $nama = $request->nama;
        foreach ($nama as $key => $value) {
            DetailTransaksi::create([
                'trans_id' => $trans_id,
                'kategori' => $request->kategori[$key],
                'nama' => $request->nama[$key],
                'jumlah' => $request->jumlah[$key],
                'harga' => $request->harga[$key],
                'folder' => $request->folder[$key],
                'gambar' => $request->gambar[$key],
                'keterangan' => $request->keterangan[$key],
            ]);
            
            $keranjang = Keranjang::find($request->id[$key]);
            $kategori = $keranjang->kategori;
            if ($kategori == "hewan") {
                HewanKeluar::create([
                    'hewan_id' => $keranjang->brg_id,
                    'jumlah' => $request->jumlah[$key],
                    'harga' => $request->harga[$key]
                ]);
            } else {
                BarangKeluar::create([
                    'barang_id' => $keranjang->brg_id,
                    'kategori' => $request->kategori[$key],
                    'jumlah' => $request->jumlah[$key],
                    'harga' => $request->harga[$key]
                ]);
            }
            Keranjang::where('id', $request->id[$key])->update(['status' => 1]);
            
        }

        return redirect('co');
    }

    public function keranjang(){
        $keranjang = Keranjang::where('user_id', auth()->user()->id)->where('status', 0)->get();
        $jumlah = $keranjang->sum('jumlah');
        return view('home.keranjang.keranjang', [
            'title' => 'Keranjang',
            'keranjang' => Keranjang::where('user_id', auth()->user()->id)->where('status', 0)->count(),
            'jumlah' => $jumlah,
        ]);
    }

    public function json_keranjang(){
        $keranjang = Keranjang::where('user_id', auth()->user()->id)->where('status', 0)->get();
        if($keranjang->count() > 0){
            $no = 1;
            $total_jumlah = 0;
            $total_harga = 0;
            foreach($keranjang as $k){
                $data[] = [
                    'no' => $no,
                    'id' => $k['id'],
                    'kategori' => $k['kategori'],
                    'nama' => $k['nama'],
                    'jumlah' => $k['jumlah'],
                    'harga' => $k['harga'],
                    'folder' => $k['folder'],
                    'gambar' => $k['gambar'],
                    'keterangan' => $k['keterangan'],
                ];
                $total_jumlah += $k['jumlah'];
                $total_harga += $k['harga']*$k['jumlah'];
                $no ++;
            }
            return response()->json([
                'status' => 200,
                'data' => $data,
                'total_harga' => $total_harga,
                'total_jumlah' => $total_jumlah,
                
            ]);
        }else{
            return response()->json([
                'status' => 401,
                'errors' => 'Tidak ada barang di keranjang'
            ]);
        }
    }

    public function destroy_item($id){
        $keranjang = Keranjang::find($id);
        $item = $keranjang->brg_id;
        $kategori = $keranjang->kategori;
        $jml_item = $keranjang->jumlah;

        if($kategori == "hewan"){
            $hewan = Hewan::find($item);
            $jml_hewan = $hewan->jumlah_hewan;

            $hewan->jumlah_hewan = $jml_hewan+$jml_item;
            $hewan->update();
        }else{
            $barang = Barang::find($item);
            $jml_barang = $barang->stok_barang;

            $barang->stok_barang = $jml_barang+$jml_item;
            $barang->update();
        }

        Keranjang::destroy($id);
        return response()->json([
            'status' => 200,
            'message' => 'Data di keranjang berhasil di hapus',
        ]);
    }

    public function transaksi(){
        return view('home.transaksi.transaksi',[
            'title' => 'Transaksi',
        ]);
    }

    public function json_transaksi(){
        $columns = ['id','user_id','total_jumlah', 'total_harga', 'tgl_transaksi', 'total_bayar'];
        $orderBy = $columns[request()->input("order.0.column")];
        $data = Transaksi::select('*')->where('user_id', auth()->user()->id);

        if(request()->input("search.value")){
            $data = $data->where(function($query){
                $query->whereRaw('user_id like ? ', ['%'.request()->input("search.value").'%'])
                ->orWhereRaw('jumlah like ? ', ['%'.request()->input("search.value").'%']);
            });
        }

        $recordsFiltered = $data->get()->count();
        if(request()->input('length') == -1){
            $data = $data->orderBy($orderBy,request()->input("order.0.dir"))->get();
        }else{
            $data = $data->skip(request()->input('start'))->take(request()->input('length'))->orderBy($orderBy,request()->input("order.0.dir"))->get();
        }
        $recordsTotal = $data->count();

        return response()->json([
            'draw' => request()->input('draw'),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data
        ]);
    }

    public function transaksi_treatment(){
        return view('home.transaksi.treatment', [
            'title' => 'Data transaksi treatment',
        ]);
    }

    public function json_transaksi_treatment(){
        $columns = ['id','user_id','total_jumlah', 'total_harga', 'tgl_transaksi', 'total_bayar'];
        $orderBy = $columns[request()->input("order.0.column")];
        $data = TransaksiTreatment::select('*')->where('user_id', auth()->user()->id);

        if(request()->input("search.value")){
            $data = $data->where(function($query){
                $query->whereRaw('user_id like ? ', ['%'.request()->input("search.value").'%'])
                ->orWhereRaw('jumlah like ? ', ['%'.request()->input("search.value").'%']);
            });
        }

        $recordsFiltered = $data->get()->count();
        if(request()->input('length') == -1){
            $data = $data->orderBy($orderBy,request()->input("order.0.dir"))->get();
        }else{
            $data = $data->skip(request()->input('start'))->take(request()->input('length'))->orderBy($orderBy,request()->input("order.0.dir"))->get();
        }
        $recordsTotal = $data->count();

        return response()->json([
            'draw' => request()->input('draw'),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data
        ]);
    }

    public function detail_transaksi($id){
        return view('home.transaksi.detail_transaksi', [
            'title' => 'Detail Transaksi',
            'detailorder' => Transaksi::find($id)
        ]);
    }

    public function json_detailorder($id){
        $keranjang = DetailTransaksi::where('trans_id', $id)->get();
        if($keranjang->count() > 0){
            $no = 1;
            foreach($keranjang as $k){
                $data[] = [
                    'no' => $no,
                    'id' => $k['id'],
                    'kategori' => $k['kategori'],
                    'nama' => $k['nama'],
                    'jumlah' => $k['jumlah'],
                    'harga' => $k['harga'],
                    'folder' => $k['folder'],
                    'gambar' => $k['gambar'],
                    'keterangan' => $k['keterangan'],
                ];
                $no ++;
            }
            return response()->json([
                'status' => 200,
                'data' => $data
                
            ]);
        }else{
            return response()->json([
                'status' => 401,
                'errors' => 'Tidak ada barang di keranjang'
            ]);
        }
    }

    public function destroy_order($id){
        Transaksi::destroy($id);
        return response()->json([
            'status' => 200,
            'message' => 'Data order berhasil di hapus',
        ]);
    }

    public function destroy_order_treatment($id){
        TransaksiTreatment::destroy($id);
        return response()->json([
            'status' => 200,
            'message' => 'Data order treatment berhasil di hapus',
        ]);
    }

    public function detail_order_treatment($id){
        $tr = TransaksiTreatment::find($id);
        if ($tr) {
            return response()->json([
                'status' => 200,
                'data' => $tr
            ]);
        } else {
            return response()->json([
                'status' => 401,
                'errors' => 'Data tidak ditemukan'
            ]);
        }
        
    }

    public function json_alamat_pelanggan($id){
        $alamat = AlamatPelanggan::where('user_id', $id)->count();
        if ($alamat == null){
            return response()->json([
                'status' => 404,
                'errors' => 'Tidak ada alamat di database'
            ]);
        } else {
            $skip = 1;
            $limit = $alamat - $skip;
            return response()->json([
                'status' => 200,
                'data' => AlamatPelanggan::skip($skip)->take($limit)->get(),
                'first' => AlamatPelanggan::where('user_id', $id)->first()
            ]);
        }
        
    }

    public function store_alamat(Request $request){
        $validate = Validator::make($request->all(), [
            'label_alamat' => 'required',
            'nama_customer' => 'required',
            'telepon' => 'required',
            'alamat_lengkap' => 'required',
        ]);

        if($validate->fails()){
            return response()->json([
                'status' => 401,
                'errors' => 'Alamat tidak boleh kosong'
            ]);
        } else {
            $alamat = new AlamatPelanggan();
            $alamat->user_id = auth()->user()->id;
            $alamat->label_alamat = $request->label_alamat;
            $alamat->nama = $request->nama_customer;
            $alamat->telepon = $request->telepon;
            $alamat->alamat_lengkap = $request->alamat_lengkap;
            $alamat->save();

            return response()->json([
                'status' => 200,
                'message' => 'Alamat baru berhasil ditambahkan'
            ]);
        }
    }

    public function upload_buktitf(Request $request){
        $rules = Validator::make($request->all(), [
            'bukti' => 'required',
        ]);

        if ($rules->fails()) {
            return response()->json([
                'status' => 401,
                'message' => 'Data tidak bisa diinputkan',
            ]);
        } else {
            $upload_bukti = Transaksi::find($request->id);
            $upload_bukti->bukti = $request->file('bukti')->getClientOriginalName();
            $upload_bukti->update();

            if ($request->hasFile('bukti')) {
                $request->file('bukti')->move('Gambar_upload/bukti_pembayaran/', $request->file('bukti')->getClientOriginalName());
            }
            return response()->json([
                'status' => 200,
                'message' => 'Bukti pembayaran berhasil dikirim',
            ]);
        }
    }
    
    public function upload_buktitf_treatment(Request $request){
        $rules = Validator::make($request->all(), [
            'bukti' => 'required',
        ]);

        if ($rules->fails()) {
            return response()->json([
                'status' => 401,
                'message' => 'Data tidak bisa diinputkan',
            ]);
        } else {
            $upload_bukti_treatment = TransaksiTreatment::find($request->id);
            $upload_bukti_treatment->bukti = $request->file('bukti')->getClientOriginalName();
            $upload_bukti_treatment->update();

            if ($request->hasFile('bukti')) {
                $request->file('bukti')->move('Gambar_upload/bukti_pembayaran/', $request->file('bukti')->getClientOriginalName());
            }
            return response()->json([
                'status' => 200,
                'message' => 'Bukti pembayaran berhasil dikirim',
            ]);
        }
    }
}
