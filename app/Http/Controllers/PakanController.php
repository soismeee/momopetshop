<?php

namespace App\Http\Controllers;

use App\Models\KategoriBarang;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PakanController extends Controller
{
    public function index()
    {
        return view('data_master.pakan.index', [
            'title' => 'Peralatan Hewan',
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
            $save_kph->kategori = 'pakan';
            $save_kph->nama_barang = $request->nama_barang;
            $save_kph->harga_barang = preg_replace('/[^0-9]/', '', $request->harga_barang);
            $save_kph->stok_barang = $request->stok_barang;
            $save_kph->keterangan_barang = $request->keterangan_barang;
            $save_kph->gambar_barang = $request->file('gambar_barang')->getClientOriginalName();
            $save_kph->save();
            if ($request->hasFile('gambar_barang')) {
                $request->file('gambar_barang')->move('Gambar_upload/barang/', $request->file('gambar_barang')->getClientOriginalName());
            }
            return response()->json([
                'status' => 200,
                'message' => 'Peralatan Hewan baru berhasil di buat',
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Barang::destroy($id);
        return response()->json([
            'status' => 200,
            'message' => 'Data pakan berhasil di hapus',
        ]);
    }
}
