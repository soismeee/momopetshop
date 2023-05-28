<?php

namespace App\Http\Controllers;

use App\Models\Treatment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class TreatmentController extends Controller
{
    public function index()
    {
        return view('data_master.treatment.index', [
            'title' => 'Peralatan Hewan',
        ]);
    }

    public function json(){
        $columns = ['id','nama_treatment','keterangan_treatment'];
        $orderBy = $columns[request()->input("order.0.column")];
        $data = Treatment::select('*');

        if(request()->input("search.value")){
            $data = $data->where(function($query){
                $query->whereRaw('nama_treatment like ? ', ['%'.request()->input("search.value").'%'])
                ->orWhereRaw('keterangan_treatment like ? ', ['%'.request()->input("search.value").'%'])
                ->orWhereRaw('harga_treatment like ? ', ['%'.request()->input("search.value").'%']);
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
            'nama_treatment' => 'required',
            'harga_treatment' => 'required',
            'status_treatment' => 'required',
            'keterangan_treatment' => 'required',
        ]);

        if ($rules->fails()) {
            return response()->json([
                'status' => 401,
                'message' => 'Data tidak bisa diinputkan',
            ]);
        } else {
            $save_kph = new Treatment();
            $save_kph->id = Str::uuid()->toString();
            $save_kph->nama_treatment = $request->nama_treatment;
            $save_kph->harga_treatment = preg_replace('/[^0-9]/', '', $request->harga_treatment);
            $save_kph->status_treatment = $request->status_treatment;
            $save_kph->keterangan_treatment = $request->keterangan_treatment;
            $save_kph->gambar_treatment = $request->file('gambar_treatment')->getClientOriginalName();
            $save_kph->save();
            if ($request->hasFile('gambar_treatment')) {
                $request->file('gambar_treatment')->move('Gambar_upload/treatment/', $request->file('gambar_treatment')->getClientOriginalName());
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
        Treatment::destroy($id);
        return response()->json([
            'status' => 200,
            'message' => 'Data treatment berhasil di hapus',
        ]);
    }
}
