<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // halaman login
    public function index(){
        return view('auth.login');
    }

    // halaman registrasi
    public function register(){
        return view('auth.register');
    }

    // fungsi aksi login
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);
        
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            if (auth()->user()->status == 0) {
                Auth::logout();

                request()->session()->invalidate();
                request()->session()->regenerateToken();
                return redirect('/login')->with('loginError', 'Maaf, user anda tidak aktif');
            }else{
                return redirect()->intended('/home');
            }
            
        }
        return back()->with('loginError', 'Login gagal!!!');
    }
 
    // funsi aksi registrasi
    public function store(Request $request)
    {
        $vaslidatedData = $request->validate([
            'name' => 'required|max:255',
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5|max:255'
        ]);

        $vaslidatedData['id'] = intval((microtime(true) * 10000));
        $vaslidatedData['password'] = Hash::make($vaslidatedData['password']);
        $vaslidatedData['status'] = 1;
        $vaslidatedData['role'] = 3;
        User::create($vaslidatedData);
        return redirect('login')->with('success', 'Berhasil registrasi, silahkan login');
    }

    public function profil(){
        return view('home.profil', [
            'title' => 'Profil pengguna',
        ]);
    }

    public function update_user(Request $request){
        $rules = $request->validate([
            'name' => 'required',
            'username' => 'required|max:255',
        ]);

        $user = User::find($request->id);
        if($request->name == $user->name && $request->username == $user->username && $request->password == null){
            return redirect('/profil')->with('warning', 'Tidak ada perubahan profil!!');
        }else{
            if ($request->password) {
                $rules['password'] = Hash::make($request->password);
            }
            User::where('id', $request->id)->update($rules);
            
            Auth::logout();
    
            request()->session()->invalidate();
            request()->session()->regenerateToken();
            return redirect('/login')->with('success', 'Data user berhasil diubah!!');
        }
    }

    // fungsi logout
    public function logout()
    {
        Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect('/');
    }
}
