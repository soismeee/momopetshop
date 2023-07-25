<?php

namespace App\Http\Controllers;

use App\Models\KategoriBarang;
use App\Models\Barang;
use App\Models\BarangMasuk;
use App\Models\TransaksiBarangMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PakanController extends Controller
{
    public function index()
    {
        return view('data_master.pakan.index', [
            'title' => 'Pakan Hewan',
            'kategori' => KategoriBarang::where('kategori', 'pakan')->get()
        ]);
    }

    public function json(){
        $columns = ['id','nama_barang','keterangan_barang'];
        $orderBy = $columns[request()->input("order.0.column")];
        $data = Barang::select('*')->with('kategori_barang')->where('kategori', 'pakan');

        if(request()->input("search.value")){
            $data = $data->where(function($query){
                $query->whereRaw('nama_barang like ? ', ['%'.request()->input("search.value").'%'])
                ->orWhereRaw('keterangan_barang like ? ', ['%'.request()->input("search.value").'%'])
                ->orWhereRaw('harga_barang like ? ', ['%'.request()->input("search.value").'%'])
                ->orWhereRaw('stok_barang like ? ', ['%'.request()->input("search.value").'%']);
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

    public function store(Request $request)
    {
        // dd($request);
        $rules = Validator::make($request->all(), [
            'kp_id' => 'required',
            'kode_barang' => 'required|unique:barangs',
            'nama_barang' => 'required',
            'harga_barang' => 'required',
            'stok_barang' => 'required',
            'keterangan_barang' => 'required',
        ]);

        if ($rules->fails()) {
            return response()->json([
                'status' => 401,
                'message' => 'Data tidak bisa diinputkan',
            ]);
        } else {
            $save_kph = new Barang();
            $save_kph->id = Str::uuid()->toString();
            $save_kph->kb_id = $request->kp_id;
            $save_kph->kode_barang = $request->kode_barang;
            $save_kph->kategori = 'pakan';
            $save_kph->nama_barang = $request->nama_barang;
            $save_kph->harga_barang = preg_replace('/[^0-9]/', '', $request->harga_barang);
            $save_kph->harga_beli = preg_replace('/[^0-9]/', '', $request->harga_beli);
            $save_kph->stok_barang = $request->stok_barang;
            $save_kph->keterangan_barang = $request->keterangan_barang;
            $save_kph->gambar_barang = $request->file('gambar_barang')->getClientOriginalName();
            $save_kph->save();

            $tbm = new TransaksiBarangMasuk();
            $tbm->barang_id = $save_kph->id;
            $tbm->kode_barang = $request->kode_barang;
            $tbm->kategori = 'pakan';
            $tbm->nama_barang = $request->nama_barang;
            $tbm->jumlah_barang = $request->stok_barang;
            $tbm->nominal_barang = preg_replace('/[^0-9]/', '', $request->harga_beli);
            $tbm->save();
            
            if ($request->hasFile('gambar_barang')) {
                $request->file('gambar_barang')->move('Gambar_upload/barang/', $request->file('gambar_barang')->getClientOriginalName());
            }
            $barang_id = $save_kph->id;
            $barang_masuk = new BarangMasuk();
            $barang_masuk->barang_id = $barang_id;
            $barang_masuk->kategori = "pakan";
            $barang_masuk->jumlah = $request->stok_barang;
            $barang_masuk->harga = preg_replace('/[^0-9]/', '', $request->harga_barang);
            $barang_masuk->save();

            return response()->json([
                'status' => 200,
                'message' => 'Peralatan Hewan baru berhasil di buat',
            ]);
        }
    }
    
    public function show($id)
    {
        $show_ph = Barang::find($id);
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

    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            'nama_barang' => 'required',
            'kp_id' => 'required',
            'harga_barang' => 'required',
            'stok_barang' => 'required',
            'keterangan_barang' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 401,
                'errors' => 'Data tidak berhasil diambil',
            ]);
        } else {
            $update_db = Barang::find($id);


            if( $request->hasFile('gambar_barang') == null &&
            $update_db->nama_barang == $request->nama_barang &&
            $update_db->kb_id == $request->kp_id &&
            $update_db->stok_barang == $request->stok_barang &&
            $update_db->harga_beli == $request->harga_beli &&
            $update_db->keterangan_barang == $request->keterangan_barang)
            {
                return response()->json([
                    'status' => 201,
                    'message' => 'Tidak ada data yang diubah',
                ]);
            }

            if ($update_db) {
                if ($request->hasFile('gambar_barang')) {
                    $request->file('gambar_barang')->move('Gambar_upload/barang/', $request->file('gambar_barang')->getClientOriginalName());
                    $update_db->gambar_barang = $request->file('gambar_barang')->getClientOriginalName();
                }

                $update_db->nama_barang = $request->nama_barang;
                $update_db->kb_id = $request->kp_id;
                $update_db->stok_barang = $request->stok_barang;
                $update_db->harga_barang = preg_replace('/[^0-9]/', '', $request->harga_barang);
                $update_db->harga_beli = preg_replace('/[^0-9]/', '', $request->harga_beli);
                $update_db->keterangan_barang = $request->keterangan_barang;
                $update_db->update();

                return response()->json([
                    'status' => 200,
                    'message' => 'Data berhasil diubah',
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Data tidak bisa di ubah',
                ]);
            }
        }
    }

    public function destroy($id)
    {
        Barang::destroy($id);
        return response()->json([
            'status' => 200,
            'message' => 'Data pakan berhasil di hapus',
        ]);
    }
}
