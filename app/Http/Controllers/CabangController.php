<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\CabangStok;
use Illuminate\Http\Request;

class CabangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $cabangs = Cabang::all();
        return view('table_cabang', compact('cabangs'));
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
        //
        $this->validate($request, [
            'nama_cabang' => 'required'
        ], [
            'nama_cabang.required' => 'Nama cabang tidak boleh kosong'
        ]);

        Cabang::create([
            'nama' => $request->nama_cabang,
        ]);

        return redirect()->route('cabang.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    /**
     * Display the specified resource.
     */
    public function show($cabang)
    {
        $cabang_stoks = CabangStok::where('cab_id',$cabang)->get();
        $cabang_nama = Cabang::where('cabang_id',$cabang)->pluck('nama')->first();
        // foreach ($cabang_stoks as $key => $value) {
        //     dd($value->get_ukuran_produk);
        // }
        // dd($cabang_stoks);
        return view('table_stok_barang',compact('cabang_stoks','cabang_nama'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cabang $cabang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $cabang)
    {
        //
        $this->validate($request, [
            'nama_cabang' => 'required'
        ], [
            'nama_cabang.required' => 'Nama cabang tidak boleh kosong'
        ]);

        $cbang = Cabang::find($cabang);
        $cbang->update([
            'nama' => $request->nama_cabang,
        ]);

        return redirect()->route('cabang.index')->with(['success' => 'Data Berhasil Diperbarui!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($cabang)
    {
        //
        Cabang::find($cabang)->delete();
        return redirect()->route('cabang.index')->with(['success' => 'Cabang berhasil dihapus!']);
    }

    public function updatestok(Request $request, $cabang)
    {
        $this->validate($request, [
            'stok' => 'required | integer'
        ]);
        $cabangstok = CabangStok::find($cabang);
        $cabangstok->update([
            'stok' => $request->stok
        ]);
        return redirect()->route('cabang.show',['cabang' => $cabangstok->cab_id])->with(['success' => 'Stok berhasil diperbarui!']);
    }
}
