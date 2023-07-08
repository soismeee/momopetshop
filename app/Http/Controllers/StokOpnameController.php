<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\BarangKeluar;
use App\Models\BarangMasuk;
use App\Models\Hewan;
use App\Models\HewanKeluar;
use App\Models\HewanMasuk;
use Illuminate\Http\Request;

class StokOpnameController extends Controller
{
    public function opname_alat_pakan(){
        return view('stok_opname.alat_dan_pakan', [
            'title' => 'Stok opname peralatan hewan',
        ]);
    }

    public function json_sopp(){
        $barang = Barang::select('id', 'kode_barang', 'kategori', 'nama_barang', 'harga_barang', 'stok_barang')->orderBy('kategori', 'asc')->get();
        $no = 1;
        foreach ($barang as $b) {
            $data[] = [
                'no' => $no,
                'id' => $b->id,
                'kode_barang' => $b->kode_barang,
                'nama_barang' => $b->nama_barang,
                'kategori' => $b->kategori,
                'masuk' => BarangMasuk::where('barang_id', $b->id)->whereMonth('created_at', date('m', strtotime(request('bulan'))))->sum('jumlah'),
                'keluar' => BarangKeluar::where('barang_id', $b->id)->whereMonth('created_at', date('m', strtotime(request('bulan'))))->sum('jumlah')
            ];
            $no++;
        }
        if ($barang) {
            return response()->json([
                'status' => 200,
                'data' => $data
            ]);
        } else {
            return response()->json([
                'status' => 401,
                'errors' => "tidak ada barang"
            ]);
        }   
    }

    public function cetak_sopp(){
        $barang = Barang::select('id', 'kode_barang','kategori', 'nama_barang', 'harga_barang', 'stok_barang')->get();
        foreach ($barang as $item) {
            $data[] = [
                'kode_barang' => $item->kode_barang,
                'nama_barang' => $item->nama_barang,
                'kategori' => $item->kategori,
                'masuk' => BarangMasuk::where('barang_id', $item->id)->whereMonth('created_at', date('m', strtotime(request('bulan'))))->sum('jumlah'),
                'keluar' => BarangKeluar::where('barang_id', $item->id)->whereMonth('created_at', date('m', strtotime(request('bulan'))))->sum('jumlah')
            ];
        }

        return view('stok_opname.print_alatdanpakan', [
            'title' => 'Cetak SO alat dan pakan',
            'sopp' => $data,
            'bulan' => request('bulan')
        ]);
    }

    public function opname_hewan(){
        return view('stok_opname.hewan', [
            'title' => 'Stok opname pakan',
        ]);
    }

    public function json_soh(){
        $hewan = Hewan::select('id', 'kode_hewan','nama_hewan', 'harga_hewan', 'jumlah_hewan')->get();
        $no = 1;
        foreach ($hewan as $h) {
            $data[] = [
                'no' => $no,
                'id' => $h->id,
                'kode_hewan' => $h->kode_hewan,
                'nama_hewan' => $h->nama_hewan,
                'kategori' => $h->kategori,
                'masuk' => HewanMasuk::where('hewan_id', $h->id)->whereMonth('created_at', date('m', strtotime(request('bulan'))))->sum('jumlah'),
                'keluar' => HewanKeluar::where('hewan_id', $h->id)->whereMonth('created_at', date('m', strtotime(request('bulan'))))->sum('jumlah')
            ];
            $no++;
        }
        if ($hewan) {
            return response()->json([
                'status' => 200,
                'data' => $data
            ]);
        } else {
            return response()->json([
                'status' => 401,
                'errors' => "tidak ada hewan"
            ]);
        }   
    }

    public function cetak_soh(){
        $hewan = Hewan::select('id', 'kode_hewan','nama_hewan', 'harga_hewan', 'jumlah_hewan')->get();
        foreach ($hewan as $item) {
            $data[] = [
                'kode_hewan' => $item->kode_hewan,
                'nama_hewan' => $item->nama_hewan,
                'kategori' => $item->kategori,
                'masuk' => HewanMasuk::where('hewan_id', $item->id)->whereMonth('created_at', date('m', strtotime(request('bulan'))))->sum('jumlah'),
                'keluar' => HewanKeluar::where('hewan_id', $item->id)->whereMonth('created_at', date('m', strtotime(request('bulan'))))->sum('jumlah')
            ];
        }

        return view('stok_opname.print_hewan', [
            'title' => 'Cetak SO hewan',
            'soh' => $data,
            'bulan' => request('bulan')
        ]);
    }

    public function update_barang(Request $request, $id){
        $barang = Barang::find($id);
        $stok_barang = $barang->stok_barang;
        $barang->stok_barang = $stok_barang + $request->jumlah;
        $barang->update();
        
        $barang_masuk = new BarangMasuk();
        $barang_masuk->barang_id = $id;
        $barang_masuk->kategori = $barang->kategori;
        $barang_masuk->harga = $barang->harga_barang;
        $barang_masuk->jumlah = $request->jumlah;
        $barang_masuk->save();

        if($barang){
            return response()->json([
                'status' => 200,
                'message' => 'Berhasil mengedit stok barang'
            ]);
        }else{
            return response()->json([
                'status' => 401,
                'errors' => 'Tidak berhasil mengedit stok barang'
            ]);
        }
    }

    public function update_hewan(Request $request, $id){
        $hewan = Hewan::find($id);
        $jumlah_hewan = $hewan->jumlah_hewan;
        $hewan->jumlah_hewan = $jumlah_hewan + $request->jumlah;
        $hewan->update();
        
        $hewan_masuk = new HewanMasuk();
        $hewan_masuk->hewan_id = $id;
        $hewan_masuk->harga = $hewan->harga_hewan;
        $hewan_masuk->jumlah = $request->jumlah;
        $hewan_masuk->save();

        if($hewan){
            return response()->json([
                'status' => 200,
                'message' => 'Berhasil mengedit stok hewan'
            ]);
        }else{
            return response()->json([
                'status' => 401,
                'errors' => 'Tidak berhasil mengedit stok hewan'
            ]);
        }
    }
}
