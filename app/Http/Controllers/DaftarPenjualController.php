<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\UsersModel;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class DaftarPenjualController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users_active = UsersModel::where('is_active', 1)->where('is_admin',0)->get();
        $users_inactive = UsersModel::where('is_active', 0)->where('is_admin',0)->get();
        // dd($users_active);
        return view('table_daftar_penjual', compact('users_active','users_inactive'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nama_penjual'      => 'required',
            'username_penjual'  => 'required|min:3',
            'password_penjual'  => 'required|min:8'
        ],[
            'nama_penjual.required'      => 'Nama penjual tidak boleh kosong',
            'username_penjual.required'  => 'Username penjual tidak boleh kosong',
            'password_penjual.required'  => 'Password penjual tidak boleh kosong'
        ]);

        UsersModel::create([
            'nama'      => $request->nama_penjual,
            'username'  => $request->username_penjual,
            'password'  => Hash::make($request->password_penjual)
        ]);

        return redirect()->route('daftarpenjual.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(UsersModel $usersModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UsersModel $usersModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UsersModel $usersModel, $daftarpenjual)
    { 
        $this->validate($request, [
            'nama_penjual'      => 'required',
            'username_penjual'  => 'required|min:3'
        ],[
            'nama_penjual.required'      => 'Nama penjual tidak boleh kosong',
            'username_penjual.required'  => 'Username penjual tidak boleh kosong'
        ]);
        
        $usersModel = UsersModel::find($daftarpenjual);
        $currentTime = Carbon::now()->format('Y-m-d');
        $usersModel->update(['nama'=>$request->nama_penjual,'username'=>$request->username_penjual,'updated_at'=>$currentTime]);

        return redirect()->route('daftarpenjual.index')->with(['success' => 'Data Berhasil Diperbarui!']);
    }

    public function inactivate(UsersModel $usersModel, Request $request, $daftarpenjual)
    {  
        if ($usersModel::where('user_id',$daftarpenjual)->update(['is_active' => 0,'inactivated_at' => Carbon::now()->format('Y-m-d')])) {
            return redirect()->route('daftarpenjual.index')->with(['success' => 'Penjual berhasil dinonaktifkan!']);
        }
        else{
            return redirect()->route('daftarpenjual.index')->with(['failed' => 'Gagal dinonaktifkan!']);
        }
    }

    public function activate(UsersModel $usersModel, Request $request, $daftarpenjual)
    {  
        if ($usersModel::where('user_id',$daftarpenjual)->update(['is_active' => 1,'inactivated_at' => null])) {
            return redirect()->route('daftarpenjual.index')->with(['success' => 'Penjual berhasil diaktifkan!']);
        }
        else{
            return redirect()->route('daftarpenjual.index')->with(['failed' => 'Gagal diaktifkan!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UsersModel $usersModel, $daftarpenjual)
    {
        $usersModel::find($daftarpenjual)->delete();
        return redirect()->route('daftarpenjual.index')->with(['success' => 'Penjual berhasil dihapus!']);
    }

    public function updatepassword(UsersModel $usersModel, Request $request ,$daftarpenjual)
    {
        $user = $usersModel::find($daftarpenjual);

        $user->update(['password'=>Hash::make($request->password_baru_penjual)]);
        return redirect()->route('daftarpenjual.index')->with(['success' => 'Data Berhasil Diperbarui!']);
    }
}
