<?php

namespace App\Http\Controllers;

use App\Models\Warna;
use Illuminate\Http\Request;

class WarnaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $warnas = Warna::all();
        return view('table_warna', compact('warnas'));
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
            'nama_warna' => 'required'
        ], [
            'nama_warna.required' => 'Nama warna tidak boleh kosong'
        ]);

        Warna::create([
            'nama' => $request->nama_warna,
        ]);

        return redirect()->route('warna.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Warna $warna)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Warna $warna)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $warna)
    {
        //
        $this->validate($request, [
            'nama_warna' => 'required'
        ], [
            'nama_warna.required' => 'Nama warna tidak boleh kosong'
        ]);

        $wrna = Warna::find($warna);
        $wrna->update([
            'nama' => $request->nama_warna,
        ]);

        return redirect()->route('warna.index')->with(['success' => 'Data Berhasil Diperbarui!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($warna)
    {
        //
        Warna::find($warna)->delete();
        return redirect()->route('warna.index')->with(['success' => 'Warna berhasil dihapus!']);
    }
}
