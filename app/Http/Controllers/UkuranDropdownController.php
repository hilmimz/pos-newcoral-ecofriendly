<?php

namespace App\Http\Controllers;

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
        $product = Product::find($request->id);
        $ukuranFiltered = $product->ukuran;
        
        $ukuran = array();
        foreach ($ukuranFiltered as $key => $value) {
            array_push($ukuran,$value);
        }
        $ukuranNama = array();
        foreach ($ukuran as $key => $value) {
            $ukuranNama[$value->ukuran_id] = $value->nama; 
            // array_push($ukuranNama,$value->ukuran_id);
            // array_push($ukuranNama,$value->nama);
        }
        // dd($ukuranNama);
        return response()->json($ukuranNama);
    }
}
