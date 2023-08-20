<?php

namespace App\Http\Controllers;

use App\Models\Pengiriman;
use App\Models\PengirimanProduk;
use App\Models\Product;
use App\Models\UkuranProduk;
use App\Models\Cabang;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PengirimanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        $ukuranProduk = UkuranProduk::all();
        $cabangs = Cabang::all();
        return view('pengiriman_barang',compact('products','ukuranProduk','cabangs'));
    }

    public function fetchUkuran($id)
    {
        $ukurans = UkuranProduk::where("prod_id",$id);
        return json_encode($ukurans);
    }

    // public function fetchState(Request $request)
    // {
    //     $data['states'] = UkuranProduk::where("country_id", $request->country_id)
    //                             ->get(["name", "id"]);
    //     dd($data['states']);
    //     return response()->json($data);
    // }

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
        $request->validate([
            'addmore.*.nama_produk' => 'required',
            'addmore.*.ukuran_produk' => 'required',
            'addmore.*.jumlah_produk' => 'required | integer',
            'cabang_tujuan' => 'required'
        ]);

        $id = Pengiriman::create([
            'cab_id'      => $request->cabang_tujuan,
            'tanggal_pengiriman'  => Carbon::now()
        ])->pengiriman_id;

        foreach ($request->addmore as $key => $value) {

            $ukuran_id = UkuranProduk::where('prod_id', $value['nama_produk'])->where('ukuran_id',$value['ukuran_produk'])->pluck('ukuran_produk_id')->first();
            PengirimanProduk::create([
                'pengiriman_id' => $id,
                'ukuran_produk_id' => $ukuran_id,
                'jumlah' => $value['jumlah_produk']
            ]);
        };
     
        return redirect()->route('pengiriman.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Pengiriman $pengiriman)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pengiriman $pengiriman)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pengiriman $pengiriman)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pengiriman $pengiriman)
    {
        //
    }
}
