<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    
    public function index()
    {
        return view('user.index',[
            'title' => 'Data pengguna'
        ]);
    }

    public function json(){
        $columns = ['id','name','username', 'email', 'role', 'status'];
        $orderBy = $columns[request()->input("order.0.column")];
        $data = User::select('*')->where('role', '!=', 3);

        if(request()->input("search.value")){
            $data = $data->where(function($query){
                $query->whereRaw('name like ? ', ['%'.request()->input("search.value").'%'])
                ->orWhereRaw('username like ? ', ['%'.request()->input("search.value").'%'])
                ->orWhereRaw('email like ? ', ['%'.request()->input("search.value").'%']);
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
            'name' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|unique:users',
            'password' => 'required',
            'role' => 'required',
        ]);

        if ($rules->fails()) {
            return response()->json([
                'status' => 401,
                'message' => 'Data tidak bisa diinputkan',
            ]);
        } else {
            $save_usr = new User();
            $save_usr->id = intval((microtime(true) * 10000));
            $save_usr->name = $request->name;
            $save_usr->username = $request->username;
            $save_usr->email = $request->email;
            $save_usr->password = Hash::make($request->password);
            $save_usr->role = $request->role;
            if($request->status){
                $save_usr->status = $request->status;
            }else{
                $save_usr->status = 0;
            }
            $save_usr->save();
            return response()->json([
                'status' => 200,
                'message' => 'Pengguna baru berhasil di buat',
            ]);
        }
    }

    public function show($id)
    {
        $show_usr = User::find($id);
        if ($show_usr) {
            return response()->json([
                'status' => 200,
                'data' => $show_usr
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
            'name' => 'required',
            'username' => 'required',
            'email' => 'required',
            'role' => 'required'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 401,
                'errors' => 'Data tidak berhasil diambil',
            ]);
        } else {
            $update_usr = User::find($id);

            if($update_usr->name == $request->name && $update_usr->username == $request->username && $update_usr->email == $request->email && $update_usr->role == $request->role)
            {
                return response()->json([
                    'status' => 201,
                    'message' => 'Tidak ada data yang diubah',
                ]);
            }

            if ($update_usr) {
                $update_usr->name = $request->name;
                $update_usr->username = $request->username;
                $update_usr->email = $request->email;
                $update_usr->role = $request->role;
                if($request->status){
                    $update_usr->status = $request->status;
                }
                $update_usr->update();

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
        User::destroy($id);
        return response()->json([
            'status' => 200,
            'message' => 'Data user berhasil di hapus',
        ]);
    }

    ################################################################################################################################

    public function customer(){
        return view('data_master.customer.index', [
            'title' => 'Pelanggan'
        ]);
    }

    public function json_customer(){
        $columns = ['id','name','username', 'email', 'role', 'status'];
        $orderBy = $columns[request()->input("order.0.column")];
        $data = User::select('*')->where('role', '=', 3);

        if(request()->input("search.value")){
            $data = $data->where(function($query){
                $query->whereRaw('name like ? ', ['%'.request()->input("search.value").'%'])
                ->orWhereRaw('username like ? ', ['%'.request()->input("search.value").'%'])
                ->orWhereRaw('email like ? ', ['%'.request()->input("search.value").'%']);
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

    public function update_customer(Request $request, $id){
        $validate = Validator::make($request->all(), [
            'status' => 'required'
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 401,
                'errors' => 'Data tidak berhasil diambil',
            ]);
        } else {
            $update_usr = User::find($id);

            if($update_usr->status == $request->status)
            {
                return response()->json([
                    'status' => 201,
                    'message' => 'Tidak ada data yang diubah',
                ]);
            }

            if ($update_usr) {
                $update_usr->status = $request->status;
                $update_usr->update();

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
}
