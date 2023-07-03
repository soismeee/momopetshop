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
        $barang = Barang::select('id', 'kategori', 'nama_barang', 'harga_barang', 'stok_barang')->get();
        $no = 1;
        foreach ($barang as $item) {
            $data[] = [
                'no' => $no,
                'nama_barang' => $item->nama_barang,
                'kategori' => $item->kategori,
                'masuk' => BarangMasuk::where('barang_id', $item->id)->whereMonth('created_at', date('m', strtotime(request('bulan'))))->sum('jumlah'),
                'keluar' => BarangKeluar::where('barang_id', $item->id)->whereMonth('created_at', date('m', strtotime(request('bulan'))))->sum('jumlah')
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
        $barang = Barang::select('id', 'kategori', 'nama_barang', 'harga_barang', 'stok_barang')->get();
        foreach ($barang as $item) {
            $data[] = [
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
        $hewan = Hewan::select('id', 'nama_hewan', 'harga_hewan', 'jumlah_hewan')->get();
        $no = 1;
        foreach ($hewan as $item) {
            $data[] = [
                'no' => $no,
                'nama_hewan' => $item->nama_hewan,
                'kategori' => $item->kategori,
                'masuk' => HewanMasuk::where('hewan_id', $item->id)->whereMonth('created_at', date('m', strtotime(request('bulan'))))->sum('jumlah'),
                'keluar' => HewanKeluar::where('hewan_id', $item->id)->whereMonth('created_at', date('m', strtotime(request('bulan'))))->sum('jumlah')
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
        $hewan = Hewan::select('id', 'nama_hewan', 'harga_hewan', 'jumlah_hewan')->get();
        foreach ($hewan as $item) {
            $data[] = [
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
}
