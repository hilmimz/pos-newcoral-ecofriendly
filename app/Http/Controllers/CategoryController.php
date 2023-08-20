<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $kategoris = Category::all();
        return view('table_kategori', compact('kategoris'));
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
            'nama_kategori' => 'required'
        ], [
            'nama_kategori.required' => 'Nama kategori tidak boleh kosong'
        ]);

        Category::create([
            'nama' => $request->nama_kategori,
        ]);

        return redirect()->route('kategori.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $kategori)
    {
        //
        $this->validate($request, [
            'nama_kategori' => 'required'
        ], [
            'nama_kategori.required' => 'Nama kategori tidak boleh kosong'
        ]);

        $bhn = Category::find($kategori);
        $bhn->update([
            'nama' => $request->nama_kategori,
        ]);

        return redirect()->route('kategori.index')->with(['success' => 'Data Berhasil Diperbarui!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($kategori)
    {
        //
        Category::find($kategori)->delete();
        return redirect()->route('kategori.index')->with(['success' => 'kategori berhasil dihapus!']);
    }
}
