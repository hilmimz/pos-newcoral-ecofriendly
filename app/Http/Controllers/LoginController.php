<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\UsersModel;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(){
        $cabangs = Cabang::all();
        return view('login',compact('cabangs'));
    }

    public function authenticate(Request $request){
        $request->validate([
            'username' => 'required',
            'password' => 'required',
            'cabang' => 'required'
        ]);

        $credentials = [
            'username' => $request->username,
            'password' => $request->password
        ];

        // Login untuk SPG
        if(Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $cabang_nama = Cabang::find($request->cabang)->pluck('nama')->first();
            $request->session()->put('cabang',$cabang_nama);
            $request->session()->put('cabang_id',$request->cabang);
 
            return redirect()->intended('home');
        }

        return back()->with('LoginError', 'Tidak Berhasil Login');
    }

    public function logout(Request $request){
        Auth::logout();
 
        $request->session()->invalidate();
 
        $request->session()->regenerateToken();
 
        return redirect('login');
    }
}
