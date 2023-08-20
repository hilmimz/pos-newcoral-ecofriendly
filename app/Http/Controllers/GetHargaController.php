<?php

namespace App\Http\Controllers;

use App\Models\UkuranProduk;
use Illuminate\Http\Request;

class GetHargaController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $ukuranproduk = UkuranProduk::where('prod_id',$request->prod_id)->where('ukuran_id',$request->ukuran_id)->first();
        $harga = $ukuranproduk->product->harga;
        return response()->json($harga);
    }
}
