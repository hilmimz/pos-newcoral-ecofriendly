<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Warna;
use App\Models\Bahan;
use App\Models\Ukuran;
use App\Models\UkuranProduk;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        $warnas = Warna::all();
        $bahans = Bahan::all();
        $categories = Category::all();
        $ukurans = Ukuran::all();
        
        return view('table_barang',compact('products','warnas','bahans','categories','ukurans'));
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
            'nama_barang'      => 'required',
            'warna_barang'  => 'required',
            'kategori_barang'  => 'required',
            'bahan_barang'    => 'required',
            'ukuran_barang'   => 'required',
            'harga_barang'    => 'required|integer|min:0'
        ],[
            'nama_barang.required'      => 'Nama barang tidak boleh kosong',
            'warna_barang.required'  => 'Warna barang tidak boleh kosong',
            'kategori_barang.required'  => 'Kategori barang tidak boleh kosong',
            'bahan_barang.required'    => 'Bahan barang tidak boleh kosong',
            'ukuran_barang.required'    => 'Ukuran barang tidak boleh kosong',
            'harga_barang.required'    => 'Harga barang tidak boleh kosong',
            'harga_barang.integer'    => 'Harga barang tidak valid',
            'harga_barang.min:0'    => 'Harga barang tidak valid'
        ]);
        // dd($request->nama_barang);

        $id = Product::create([
            'nama'      => $request->nama_barang,
            'warna'  => $request->warna_barang,
            'cat_id'  => $request->kategori_barang,
            'bahan_id'    => $request->bahan_barang,
            'harga'    => $request->harga_barang
        ])->product_id;
        foreach ($request->ukuran_barang as $key => $value) {
            $kode_produk = rand(1000000,9999999);
            // Cek apakah kode produk unik
            while ($this->is_unique($kode_produk) == false) {
                $kode_produk = rand(1000000,9999999);
            }
            UkuranProduk::create([
                'prod_id'      => $id,
                'ukuran_id'    => $value,
                'kode_produk'   => $kode_produk
            ]);
        }

        return redirect()->route('barang.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product, $id)
    {
        $this->validate($request, [
            'nama_barang'      => 'required',
            'warna_barang'  => 'required',
            'kategori_barang'  => 'required',
            'bahan_barang'    => 'required',
            'ukuran_barang'   => 'required',
            'harga_barang'    => 'required|integer|min:0'
        ],[
            'nama_barang.required'      => 'Nama barang tidak boleh kosong',
            'warna_barang.required'  => 'Warna barang tidak boleh kosong',
            'kategori_barang.required'  => 'Kategori barang tidak boleh kosong',
            'bahan_barang.required'    => 'Bahan barang tidak boleh kosong',
            'ukuran_barang.required'    => 'Ukuran barang tidak boleh kosong',
            'harga_barang.required'    => 'Harga barang tidak boleh kosong',
            'harga_barang.integer'    => 'Harga barang tidak valid',
            'harga_barang.min:0'    => 'Harga barang tidak valid'
        ]);

        $prod = Product::find($id);
        $prod->update([
            'nama'      => $request->nama_barang,
            'warna'  => $request->warna_barang,
            'cat_id'  => $request->kategori_barang,
            'bahan_id'    => $request->bahan_barang,
            'harga'    => $request->harga_barang
        ]);
        UkuranProduk::where('prod_id',$id)->delete();
        foreach ($request->ukuran_barang as $key => $value) {
            UkuranProduk::create([
                'prod_id'      => $id,
                'ukuran_id'    => $value
            ]);
        }
        

        return redirect()->route('barang.index')->with(['success' => 'Data Berhasil Diperbarui!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product, $id)
    {
        Product::find($id)->delete();
        return redirect()->route('barang.index')->with(['success' => 'Barang berhasil dihapus!']);
    }

    private function is_unique($kode){
        $cek = UkuranProduk::where('kode_produk',$kode)->first();
        if ($cek) {
            return false;
        } else {
            return true;
        }
    }
}
