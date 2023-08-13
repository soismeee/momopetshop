<?php

namespace App\Http\Controllers;

use App\Models\Hewan;
use App\Models\HewanMasuk;
use App\Models\TransaksiHewanMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class HewanController extends Controller
{
    public function index()
    {
        return view('data_master.hewan.index', [
            'title' => 'Data Hewan'
        ]);
    }

    public function json(){
        $columns = ['id','nama_kategori','keterangan_kategori'];
        $orderBy = $columns[request()->input("order.0.column")];
        $data = Hewan::select('*');

        if(request()->input("search.value")){
            $data = $data->where(function($query){
                $query->whereRaw('nama_hewan like ? ', ['%'.request()->input("search.value").'%'])
                ->orWhereRaw('keterangan like ? ', ['%'.request()->input("search.value").'%']);
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
            'nama_hewan' => 'required',
            'kode_hewan' => 'required|unique:hewans',
            'jenis_hewan' => 'required',
            'jkel' => 'required',
            'tgl_lahir' => 'required',
            'berat_hewan' => 'required',
            'harga_hewan' => 'required',
            'harga_beli' => 'required',
            'jumlah_hewan' => 'required',
            'keterangan_hewan' => 'required',
        ]);

        if ($rules->fails()) {
            return response()->json([
                'status' => 401,
                'message' => 'Data tidak bisa diinputkan',
            ]);
        } else {
            $save_dh = new Hewan();
            $save_dh->id = Str::uuid()->toString();
            $save_dh->kode_hewan = $request->kode_hewan;
            $save_dh->nama_hewan = $request->nama_hewan;
            $save_dh->jenis_hewan = $request->jenis_hewan;
            $save_dh->jkel = $request->jkel;
            $save_dh->tgl_lahir = $request->tgl_lahir;
            $save_dh->berat_hewan = $request->berat_hewan;
            // $save_dh->tinggi_hewan = $request->tinggi_hewan;
            $save_dh->harga_hewan = preg_replace('/[^0-9]/', '', $request->harga_hewan);
            $save_dh->harga_beli = preg_replace('/[^0-9]/', '', $request->harga_beli);
            $save_dh->jumlah_hewan = $request->jumlah_hewan;
            $save_dh->keterangan_hewan = $request->keterangan_hewan;
            $save_dh->gambar_hewan = $request->file('gambar_hewan')->getClientOriginalName();
            $save_dh->save();

            $tbm = new TransaksiHewanMasuk();
            $tbm->hewan_id = $save_dh->id;
            $tbm->kode_hewan = $request->kode_hewan;
            $tbm->nama_hewan = $request->nama_hewan;
            $tbm->jumlah_hewan = $request->jumlah_hewan;
            $tbm->nominal_hewan = preg_replace('/[^0-9]/', '', $request->harga_beli);
            $tbm->save();

            $hewan_id = $save_dh->id;
            $hewan_masuk = new HewanMasuk();
            $hewan_masuk->hewan_id = $hewan_id;
            $hewan_masuk->jumlah = $request->jumlah_hewan;
            $hewan_masuk->harga = preg_replace('/[^0-9]/', '', $request->harga_hewan);
            $hewan_masuk->save();

            if ($request->hasFile('gambar_hewan')) {
                $request->file('gambar_hewan')->move('Gambar_upload/hewan/', $request->file('gambar_hewan')->getClientOriginalName());
            }



            return response()->json([
                'status' => 200,
                'message' => 'Hewan baru berhasil di masukan ke aplikasi',
            ]);
        }
    }

    public function show($id)
    {
        $show_dh = Hewan::find($id);
        if ($show_dh) {
            return response()->json([
                'status' => 200,
                'data' => $show_dh
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
            'nama_hewan' => 'required',
            'jkel' => 'required',
            'tgl_lahir' => 'required',
            'berat_hewan' => 'required',
            'harga_hewan' => 'required',
            'jumlah_hewan' => 'required',
            'keterangan_hewan' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 401,
                'errors' => 'Data tidak berhasil diambil',
            ]);
        } else {
            $update_dh = Hewan::find($id);

            if($request->hasFile('gambar_hewan') == null &&
            $update_dh->nama_hewan == $request->nama_hewan &&
            $update_dh->jkel == $request->jkel &&
            $update_dh->tgl_lahir == $request->tgl_lahir &&
            $update_dh->berat_hewan == $request->berat_hewan &&
            $update_dh->jumlah_hewan == $request->jumlah_hewan &&
            $update_dh->harga_beli == $request->harga_beli &&
            $update_dh->keterangan_hewan == $request->keterangan_hewan
            )
            {
                return response()->json([
                    'status' => 201,
                    'message' => 'Tidak ada data yang diubah',
                ]);
            }

            if ($update_dh) {
                if ($request->hasFile('gambar_hewan')) {
                    $request->file('gambar_hewan')->move('Gambar_upload/hewan/', $request->file('gambar_hewan')->getClientOriginalName());
                    $update_dh->gambar_hewan = $request->file('gambar_hewan')->getClientOriginalName();
                }

                $update_dh->nama_hewan = $request->nama_hewan;
                $update_dh->jenis_hewan = $request->jenis_hewan;
                $update_dh->jkel = $request->jkel;
                $update_dh->tgl_lahir = $request->tgl_lahir;
                $update_dh->berat_hewan = $request->berat_hewan;
                // $update_dh->tinggi_hewan = $request->tinggi_hewan;
                $update_dh->harga_hewan = preg_replace('/[^0-9]/', '', $request->harga_hewan);
                $update_dh->harga_beli = preg_replace('/[^0-9]/', '', $request->harga_beli);
                $update_dh->jumlah_hewan = $request->jumlah_hewan;
                $update_dh->keterangan_hewan = $request->keterangan_hewan;
                $update_dh->update();

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
        Hewan::destroy($id);
        return response()->json([
            'status' => 200,
            'message' => 'Data hewan berhasil di hapus',
        ]);
    }

    public function add_stok(Request $request){
        $id = $request->id;
        $hewan = Hewan::find($id);
        $stok = $hewan->jumlah_hewan;

        $hewan->jumlah_hewan = $stok+$request->jumlah;
        $hewan->update();
        
        $hewan_masuk = new HewanMasuk();
        $hewan_masuk->hewan_id = $id;
        $hewan_masuk->harga = $hewan->harga_hewan;
        $hewan_masuk->jumlah = $request->jumlah;
        $hewan_masuk->save();

        if ($hewan) {
            return response()->json([
                'status' => 200,
                'message' => 'Berhasil menambahkan jumlah hewan'
            ]);
        } else {
            return response()->json([
                'status' => 401,
                'errors' => 'Gagal menambahkan jumlah hewan'
            ]);
        }
        

    }
}
