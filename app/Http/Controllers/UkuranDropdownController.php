<?php

namespace App\Http\Controllers;

use App\Models\CabangStok;
use App\Models\Product;
use App\Models\UkuranProduk;
use Illuminate\Http\Request;

class UkuranDropdownController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {   
        // $cabang_stok = CabangStok::where('cab_id',$request->session()->get('cabang_id'))->get();
        $ukuran_produk = UkuranProduk::
            join('cabang_stok','cabang_stok.ukuran_produk','=','ukuran_produk.ukuran_produk_id')
            ->join('ukuran','ukuran.ukuran_id','=','ukuran_produk.ukuran_id')
            ->where('cab_id',$request->session()->get('cabang_id'))
            ->where('prod_id',$request->id)
            ->get();
        // dd($ukuran_produk);
        // $produk_cabang = array();
        // foreach ($cabang_stok as $key => $value) {
        //     array_push($produk_cabang,$value->get_ukuran_produk->where('prod_id',$request->id)->get());
        // }
        // $product = Product::find($request->id);
        // dd($produk_cabang);
        // $ukuranFiltered = $produk_cabang->ukuran;
        
        // $ukuran = array();
        // foreach ($ukuranFiltered as $key => $value) {
        //     array_push($ukuran,$value);
        // }
        $ukuranNama = array();
        foreach ($ukuran_produk as $key => $value) {
            $ukuranNama[$value->ukuran_id] = $value->nama; 
            // array_push($ukuranNama,$value->ukuran_id);
            // array_push($ukuranNama,$value->nama);
        }
        // dd($ukuranNama);
        return response()->json($ukuranNama);
    }
}
