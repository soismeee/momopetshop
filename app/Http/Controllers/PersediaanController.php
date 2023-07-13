<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\Hewan;
use App\Models\HewanMasuk;
use App\Models\TransaksiBarangMasuk;
use App\Models\TransaksiHewanMasuk;
use Illuminate\Http\Request;

class PersediaanController extends Controller
{
    public function barang(){
        return view('persediaan.barang', [
            'title' => 'Persediaan barang',
            'barang' => Barang::select('id','kode_barang','nama_barang', 'kategori','harga_barang')->get()
        ]);
    }

    public function json_barang(){
        $monthbarang = substr(request('bulan'), 5);
        $yearbarang = substr(request('bulan'), 0,4);

        $columns = ['id','barang_id','kode_barang','kategori', 'nama_barang', 'jumlah_barang', 'nominal_barang'];
        $orderBy = $columns[request()->input("order.0.column")];
        $data = TransaksiBarangMasuk::select('id','barang_id','kode_barang','kategori', 'nama_barang', 'jumlah_barang', 'nominal_barang')->whereMonth('created_at', $monthbarang)->whereYear('created_at', $yearbarang);

        if(request()->input("search.value")){
            $data = $data->where(function($query){
                $query->whereRaw('kode_barang like ? ', ['%'.request()->input("search.value").'%'])
                ->orWhereRaw('nama_barang like ? ', ['%'.request()->input("search.value").'%']);
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

    public function store_barang(Request $request){
        // dd($request);
        $barang = Barang::find($request->barang_id);

        $stok_barang = $barang->stok_barang;
        $barang->stok_barang = $stok_barang + $request->jumlah_barang;
        $barang->update();
        
        $barang_masuk = new BarangMasuk();
        $barang_masuk->barang_id = $barang->id;
        $barang_masuk->kategori = $barang->kategori;
        $barang_masuk->harga = $barang->harga_barang;
        $barang_masuk->jumlah = $request->jumlah_barang;
        $barang_masuk->save();

        $tbm = new TransaksiBarangMasuk();
        $tbm->barang_id = $barang->id;
        $tbm->kode_barang = $barang->kode_barang;
        $tbm->kategori = $barang->kategori;
        $tbm->nama_barang = $barang->nama_barang;
        $tbm->jumlah_barang = $request->jumlah_barang;
        $tbm->nominal_barang = preg_replace('/[^0-9]/', '', $request->nominal_barang);
        $tbm->save();

        if ($barang) {
            return response()->json([
                'status' => 200,
                'message' => 'Berhasil menginput stok barang',
            ]);
        } else {
            return response()->json([
                'status' => 401,
                'errors' => 'Stok tidak berhasil ditambahkan'
            ]);
        }
        
    }

    public function get_barang($id)
    {
        $show_pb = TransaksiBarangMasuk::find($id);
        if ($show_pb) {
            return response()->json([
                'status' => 200,
                'data' => $show_pb
            ]);
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'data tidak ditemukan'
            ]);
        }
    }

    public function update_barang(Request $request, $id){
        $tbm = TransaksiBarangMasuk::find($id);
        $barang = Barang::find($request->idbarang);

        // menambahkan history pada table barang masuk
        // update stok barang terbaru 
        $bmin = new BarangMasuk();
        $bmin->barang_id = $barang->id;
        $bmin->kategori = $barang->kategori;
        $bmin->harga = $barang->harga_barang;
        $bmin->jumlah = $request->jumlah_barang;
        $bmin->save();

        // update stok barang lama 
        $bmin = new BarangMasuk();
        $bmin->barang_id = $barang->id;
        $bmin->kategori = $barang->kategori;
        $bmin->harga = $barang->harga_barang;
        $bmin->jumlah = $tbm->jumlah_barang;
        $bmin->save();

        // update stok pada master barang
        $stok_barang = $barang->stok_barang;
        $barang->stok_barang = $stok_barang + $request->jumlah_barang - $tbm->jumlah_barang;
        $barang->update();
        
        // update transaksi barang masuk
        $tbm->nominal_barang = preg_replace('/[^0-9]/', '', $request->nominal_barang);
        $tbm->jumlah_barang = $request->jumlah_barang;
        $tbm->update();

        if ($tbm) {
            return response()->json([
                'status' => 200,
                'message' => 'Data berhasil diubah',
            ]);
        } else {
            return response()->json([
                'status' => 401,
                'errors' => 'Data tidak berhasil diubah',
            ]);
        }
    }

    public function cetak_laporan_barang(Request $request){
        $month = substr(request('bulan'), 5);
        $year = substr(request('bulan'), 0,4);

        $data = TransaksiBarangMasuk::select('id','barang_id','kode_barang','kategori', 'nama_barang', 'jumlah_barang', 'nominal_barang')->whereMonth('created_at', $month)->whereYear('created_at', $year)->get();
        
        return view('persediaan.cetak.persediaan_barang', [
            'title' => 'Cetak Laporan',
            'bulan' => $request->bulan,
            'data' => $data 
        ]);
    }

    // #############################################################################################################################################
    public function hewan(){
        return view('persediaan.hewan', [
            'title' => 'Persediaan hewan',
            'hewan' => Hewan::select('id','kode_hewan','nama_hewan', 'harga_hewan')->get()
        ]);
    }

    public function json_hewan(){
        $monthhewan = substr(request('bulan'), 5);
        $yearhewan = substr(request('bulan'), 0,4);

        $columns = ['id','hewan_id','kode_hewan', 'nama_hewan', 'jumlah_hewan', 'nominal_hewan'];
        $orderBy = $columns[request()->input("order.0.column")];
        $data = TransaksiHewanMasuk::select('id','hewan_id','kode_hewan', 'nama_hewan', 'jumlah_hewan', 'nominal_hewan')->whereMonth('created_at', $monthhewan)->whereYear('created_at', $yearhewan);

        if(request()->input("search.value")){
            $data = $data->where(function($query){
                $query->whereRaw('kode_hewan like ? ', ['%'.request()->input("search.value").'%'])
                ->orWhereRaw('nama_hewan like ? ', ['%'.request()->input("search.value").'%']);
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

    public function store_hewan(Request $request){
        // dd($request);
        $hewan = Hewan::find($request->hewan_id);

        $jumlah_hewan = $hewan->jumlah_hewan;
        $hewan->jumlah_hewan = $jumlah_hewan + $request->jumlah_hewan;
        $hewan->update();
        
        $hewan_masuk = new HewanMasuk();
        $hewan_masuk->hewan_id = $hewan->id;
        $hewan_masuk->harga = $hewan->harga_hewan;
        $hewan_masuk->jumlah = $request->jumlah_hewan;
        $hewan_masuk->save();

        $tbm = new TransaksiHewanMasuk();
        $tbm->hewan_id = $hewan->id;
        $tbm->kode_hewan = $hewan->kode_hewan;
        $tbm->nama_hewan = $hewan->nama_hewan;
        $tbm->jumlah_hewan = $request->jumlah_hewan;
        $tbm->nominal_hewan = preg_replace('/[^0-9]/', '', $request->nominal_hewan);
        $tbm->save();

        if ($hewan) {
            return response()->json([
                'status' => 200,
                'message' => 'Berhasil menginput stok hewan',
            ]);
        } else {
            return response()->json([
                'status' => 401,
                'errors' => 'Stok tidak berhasil ditambahkan'
            ]);
        }
    }

    public function get_hewan($id)
    {
        $show_ph = TransaksiHewanMasuk::find($id);
        if ($show_ph) {
            return response()->json([
                'status' => 200,
                'data' => $show_ph
            ]);
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'data tidak ditemukan'
            ]);
        }
    }

    public function update_hewan(Request $request, $id){
        $tbm = TransaksiHewanMasuk::find($id);
        $hewan = Hewan::find($request->idhewan);

        // menambahkan history pada table hewan masuk
        // update stok hewan terbaru 
        $bmin = new hewanMasuk();
        $bmin->hewan_id = $hewan->id;
        $bmin->harga = $hewan->harga_hewan;
        $bmin->jumlah = $request->jumlah_hewan;
        $bmin->save();

        // update stok hewan lama 
        $bmin = new hewanMasuk();
        $bmin->hewan_id = $hewan->id;
        $bmin->harga = $hewan->harga_hewan;
        $bmin->jumlah = $tbm->jumlah_hewan;
        $bmin->save();

        // update stok pada master hewan
        $jumlah_hewan = $hewan->jumlah_hewan;
        $hewan->jumlah_hewan = $jumlah_hewan + $request->jumlah_hewan - $tbm->jumlah_hewan;
        $hewan->update();
        
        // update transaksi hewan masuk
        $tbm->nominal_hewan = preg_replace('/[^0-9]/', '', $request->nominal_hewan);
        $tbm->jumlah_hewan = $request->jumlah_hewan;
        $tbm->update();

        if ($tbm) {
            return response()->json([
                'status' => 200,
                'message' => 'Data berhasil diubah',
            ]);
        } else {
            return response()->json([
                'status' => 401,
                'errors' => 'Data tidak berhasil diubah',
            ]);
        }
    }

    public function cetak_laporan_hewan(Request $request){
        $month = substr(request('bulan'), 5);
        $year = substr(request('bulan'), 0,4);

        $data = TransaksiHewanMasuk::select('id','hewan_id','kode_hewan', 'nama_hewan', 'jumlah_hewan', 'nominal_hewan')->whereMonth('created_at', $month)->whereYear('created_at', $year)->get();
        
        return view('persediaan.cetak.persediaan_hewan', [
            'title' => 'Cetak Laporan',
            'bulan' => $request->bulan,
            'data' => $data 
        ]);
    }
}