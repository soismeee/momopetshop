<?php

namespace App\Http\Controllers;

use App\Models\KategoriBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class KategoriPHController extends Controller
{
    
    public function index()
    {
        return view('kategori.peralatan_hewan.index', [
            'title' => 'Kategori Peralatan Hewan',
        ]);
    }

    public function json(){
        $columns = ['id','nama_kategori','keterangan_kategori'];
        $orderBy = $columns[request()->input("order.0.column")];
        $data = KategoriBarang::select('*')->where('kategori', 'alat');

        if(request()->input("search.value")){
            $data = $data->where(function($query){
                $query->whereRaw('nama_kategori like ? ', ['%'.request()->input("search.value").'%'])
                ->orWhereRaw('keterangan_kategori like ? ', ['%'.request()->input("search.value").'%']);
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
        $rules = Validator::make($request->all(), [
            'nama_kategori' => 'required',
            'keterangan_kategori' => 'required',
        ]);

        if ($rules->fails()) {
            return response()->json([
                'status' => 401,
                'message' => 'Data tidak bisa diinputkan',
            ]);
        } else {
            $save_kph = new KategoriBarang();
            $save_kph->id = Str::uuid()->toString();
            $save_kph->kategori = "alat";
            $save_kph->nama_kategori = $request->nama_kategori;
            $save_kph->keterangan_kategori = $request->keterangan_kategori;
            $save_kph->save();
            return response()->json([
                'status' => 200,
                'message' => 'Kategori Peralatan Hewan baru berhasil di buat',
            ]);
        }
    }

    public function show($id)
    {
        $show_kph = KategoriBarang::find($id);
        if ($show_kph) {
            return response()->json([
                'status' => 200,
                'data' => $show_kph
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
            'nama_kategori' => 'required',
            'keterangan_kategori' => 'required'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 401,
                'errors' => 'Data tidak berhasil diambil',
            ]);
        } else {
            $update_kph = KategoriBarang::find($id);

            if($update_kph->nama_kategori == $request->nama_kategori && $update_kph->keterangan_kategori == $request->keterangan_kategori)
            {
                return response()->json([
                    'status' => 201,
                    'message' => 'Tidak ada data yang diubah',
                ]);
            }

            if ($update_kph) {
                $update_kph->nama_kategori = $request->nama_kategori;
                $update_kph->keterangan_kategori = $request->keterangan_kategori;
                $update_kph->update();

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
        KategoriBarang::destroy($id);
        return response()->json([
            'status' => 200,
            'message' => 'Data Kategori berhasil di hapus',
        ]);
    }
}
