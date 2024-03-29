<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\Transaksi;
use App\Models\TransaksiTreatment;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    // FUNCTION UNTUK TRAKSAKSI BARANG DAN HEWAN
    public function orders(){
        return view('invoice.orders', [
            'title' => 'Data Order',
        ]);
    }

    public function json_orders(){
        $columns = ['id','user_id','total_jumlah', 'total_harga', 'tgl_transaksi', 'total_bayar'];
        $orderBy = $columns[request()->input("order.0.column")];
        $data = Transaksi::select('*')->with('user')->orderBy('created_at', 'desc');

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

    public function show($id){
        return view('invoice.show',[
            'title' => 'Detail invoice',
            'order' => Transaksi::find($id)
        ]);
    }

    public function list_detailorder($id){
        $detail = DetailTransaksi::where('trans_id', $id)->get();
        if($detail->count() > 0){
            $no = 1;
            foreach ($detail as $key) {
                $data[] = [
                    'no' => $no,
                    'id' => $key->id,
                    'nama' => $key->nama,
                    'kategori' => $key->kategori,
                    'jumlah' => $key->jumlah,
                    'harga' => $key->harga,
                    'folder' => $key->folder,
                    'gambar' => $key->gambar,
                    'keterangan' => $key->keterangan,
                    
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
                'errors' => 'Data tidak ditemukan'
            ]);
        }
    }

    public function proses(Request $request, $id){
        if ($request->total_bayar == null) {
            $bayar = $request->total_harga;
        } else {
            $bayar = $request->total_bayar;
        }
        
        $data = [
            'status' => 1,
            'total_bayar' => $bayar,
        ];

        Transaksi::where('id', $id)->update($data);
        return response()->json([
            'status' => 200,
            'message' => 'Berhasil melakukan transaksi'
        ]);
    }

    public function print($id){
        return view('invoice.print', [
            'title' => 'Struk',
            'transaksi' => Transaksi::find($id),
            'detail' => DetailTransaksi::where('trans_id', $id)->get()
        ]);
    }
    
    public function print_treatment($id){
        return view('invoice.print_treatment', [
            'title' => 'Struk treatment',
            'transaksi' => TransaksiTreatment::find($id)
        ]);
    }

    public function laporan_order(){
        return view('laporan.laporan_barang', [
            'title' => 'Laporan Penjualan barang',
        ]);
    }
    
    public function laporan_treatment(){
        return view('laporan.laporan_treatment', [
            'title' => 'Laporan treatment',
        ]);
    }

    public function print_laporan_penjualan(Request $request){
        $rules = $request->validate([
            'awal' => 'required',
            'akhir' => 'required',
        ]);

        $awal = $rules['awal'];
        $akhir = $rules['akhir'];

        $transaksi = Transaksi::with('user')->whereBetween('tgl_transaksi',[$awal,$akhir])->get();
        $total = $transaksi->sum('total_harga');
        return view('laporan.print_laporan_penjualan', [
            'title' => 'Laporan Penjualan Penjualan',
            'orders' => $transaksi,
            'awal' => $awal,
            'akhir' => $akhir,
            'total_penjualan' => $total
        ]);
    }

    // FUNCTION UNTUK TRAKSAKSI TREATMENT
    
    public function treatment(){
        return view('invoice.treatment', [
            'title' => 'Data treatment',
        ]);
    }

    public function json_treatment(){
        $columns = ['id','user_id','nama_treatment'];
        $orderBy = $columns[request()->input("order.0.column")];
        $data = TransaksiTreatment::select('*')->with('user')->orderBy('created_at', 'desc');

        if(request()->input("search.value")){
            $data = $data->where(function($query){
                $query->whereRaw('user_id like ? ', ['%'.request()->input("search.value").'%'])
                ->orWhereRaw('nama_treatment like ? ', ['%'.request()->input("search.value").'%']);
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

    public function proses_treatment(Request $request, $id){
        TransaksiTreatment::where('id', $id)->update(['status' => 1]);
        return response()->json([
            'status' => 200,
            'message' => 'Data berhasil diproses'
        ]);
    }

    public function print_laporan_treatment(Request $request){
        $rules = $request->validate([
            'awal' => 'required',
            'akhir' => 'required',
        ]);

        $awal = $rules['awal'];
        $akhir = $rules['akhir'];

        $transaksi = TransaksiTreatment::with('user')->whereBetween('tgl_transaksi',[$awal,$akhir])->get();
        $total = $transaksi->sum('harga_treatment');
        return view('laporan.print_laporan_treatment', [
            'title' => 'Laporan Transaksi Treatment',
            'treatment' => $transaksi,
            'awal' => $awal,
            'akhir' => $akhir,
            'total_transaksi' => $total
        ]);
    }
}
