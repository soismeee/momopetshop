<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function orders(){
        return view('invoice.orders', [
            'title' => 'Data Order',
        ]);
    }

    public function json_orders(){
        $columns = ['id','user_id','total_jumlah', 'total_harga', 'tgl_transaksi', 'total_bayar'];
        $orderBy = $columns[request()->input("order.0.column")];
        $data = Transaksi::select('*')->with('user');

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

    public function treatment(){
        return view('invoice.treatment', [
            'title' => 'Data treatment',
        ]);
    }
}
