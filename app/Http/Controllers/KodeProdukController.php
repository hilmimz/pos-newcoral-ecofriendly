<?php

namespace App\Http\Controllers;

use App\Models\UkuranProduk;
use Illuminate\Http\Request;

class KodeProdukController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $kode = $request->kode;

        $ukuranProduk = UkuranProduk::where('kode_produk', $kode)->first();

        return response()->json([
            'prod_id' => $ukuranProduk->prod_id,
            'ukuran_id' => $ukuranProduk->ukuran_id
        ]);
    }
}
