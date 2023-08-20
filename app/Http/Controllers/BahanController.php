<?php

namespace App\Http\Controllers;

use App\Models\Bahan;
use Illuminate\Http\Request;

class BahanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bahans = Bahan::all();
        return view('table_bahan', compact('bahans'));
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
            'nama_bahan' => 'required'
        ], [
            'nama_bahan.required' => 'Nama bahan tidak boleh kosong'
        ]);

        Bahan::create([
            'nama' => $request->nama_bahan,
        ]);

        return redirect()->route('bahan.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Bahan $bahan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bahan $bahan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $bahan)
    {
        $this->validate($request, [
            'nama_bahan' => 'required'
        ], [
            'nama_bahan.required' => 'Nama bahan tidak boleh kosong'
        ]);

        $bhn = Bahan::find($bahan);
        $bhn->update([
            'nama' => $request->nama_bahan,
        ]);

        return redirect()->route('bahan.index')->with(['success' => 'Data Berhasil Diperbarui!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($bahan)
    {
        //
        Bahan::find($bahan)->delete();
        return redirect()->route('bahan.index')->with(['success' => 'Bahan berhasil dihapus!']);
    }
}
