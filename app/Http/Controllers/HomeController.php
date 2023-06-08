<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\DetailTransaksi;
use App\Models\Hewan;
use App\Models\KategoriBarang;
use App\Models\Keranjang;
use App\Models\Transaksi;
use App\Models\TransaksiTreatment;
use App\Models\Treatment;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

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
            'treatment' => Treatment::all()
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
        return view('home.hewan.detail', [
            'title' => 'Detail hewan',
            'hewan' => Hewan::find($id)
        ]);
    }

    public function in_peralatan(){
        return view('home.peralatan.peralatan', [
            'title' => 'Data Peralatan',
            'kategori' => KategoriBarang::where('kategori', 'alat')->get(),
            'peralatan' => Barang::with('kategori_barang')->where('kategori', 'alat')->get()
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
            'pakan' => Barang::with('kategori_barang')->where('kategori', 'pakan')->get()
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
            'treatment' => Treatment::all()
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

    public function checkout_treatment($id){

        $t = Treatment::find($id);

        $tt = new TransaksiTreatment();
        $tt->id = date("YmdHis").intval(microtime(true));
        $tt->user_id = auth()->user()->id;
        $tt->nama_treatment = $t->nama_treatment;
        $tt->harga_treatment = $t->harga_treatment;
        $tt->gambar_treatment = $t->gambar_treatment;
        $tt->keterangan_treatment = $t->keterangan_treatment;
        $tt->tgl_transaksi  = date("Y-m-d");
        $tt->save();

        return redirect('/co');
    }

    public function store(Request $request){
        // dd($request);

        $transaksi = new Transaksi();
        $transaksi->id = date("YmdHis").intval(microtime(true));
        $transaksi->user_id = auth()->user()->id;
        $transaksi->total_jumlah = $request->total_jumlah;
        $transaksi->total_harga = $request->total_harga;
        $transaksi->tgl_transaksi = date("Y-m-d");
        $transaksi->total_bayar = $request->total_bayar;
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

            Keranjang::where('id', $request->id[$key])->update(['status' => 1]);
        }

        return redirect('co');
    }

    public function keranjang(){
        $keranjang = Keranjang::where('user_id', auth()->user()->id)->where('status', 0)->get();
        $jumlah = $keranjang->sum('jumlah');
        $harga = $keranjang->sum('harga');
        return view('home.keranjang.keranjang', [
            'title' => 'Keranjang',
            'keranjang' => Keranjang::where('user_id', auth()->user()->id)->where('status', 0)->count(),
            'jumlah' => $jumlah,
            'harga' => $harga,
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
                $total_harga += $k['harga'];
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
}
