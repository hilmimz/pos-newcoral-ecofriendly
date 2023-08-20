<?php

namespace App\Http\Controllers;

use App\Models\CabangStok;
use App\Models\Pengiriman;
use App\Models\PengirimanProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatPengirimanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        $pengirimans = Pengiriman::with('ukuranproduk')->get();
        // $peng = Pengiriman::join('pengiriman_produk','pengiriman_produk.pengiriman_id','=','pengiriman.pengiriman_id')
        //                         ->join('ukuran_produk','pengiriman_produk.ukuran_produk_id','=','ukuran_produk.ukuran_produk_id')
        //                         ->join('cabang','pengiriman.cab_id','=','cabang.cabang_id')
        //                         ->join('products','ukuran_produk.prod_id','=','products.product_id')
        //                         ->join('ukuran','ukuran_produk.ukuran_id','=','ukuran.ukuran_id')
        //                         ->get();
        // $peng_arr = [];
        // foreach ($peng as $key => $value) {
        //     $peng_arr[$value->pengiriman_id][] = $value;
        // }
        // dd($peng_arr);
        $pending_pengirimans = $pengirimans->where('status',0);
        $sukses_pengirimans = $pengirimans->where('status',1);
        $pengiriman_produks = PengirimanProduk::all();
        return view('table_riwayat_pengiriman',compact('pengirimans','pengiriman_produks','pending_pengirimans','sukses_pengirimans'));
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
    public function store(Request $request, $riwayatpengiriman)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Pengiriman $pengiriman, $riwayatpengiriman)
    {
        $pengirimans = Pengiriman::all();
        $pending_pengirimans = $pengirimans->where('status',0);
        $sukses_pengirimans = $pengirimans->where('status',1);
        $pengiriman_produks = PengirimanProduk::all();
        return view('table_detail_riwayat_pengiriman',compact('pengirimans','pengiriman_produks','pending_pengirimans','sukses_pengirimans'));
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
    public function destroy(Pengiriman $pengiriman,$riwayatpengiriman)
    {
        $pengiriman::find($riwayatpengiriman)->delete();
        return redirect()->route('riwayatpengiriman.index')->with(['success' => 'Pengiriman berhasil dihapus!']);
    }

    public function konfirmasi($riwayatpengiriman)
    {
        $pengiriman=Pengiriman::find($riwayatpengiriman);
        $pengiriman->update([
            'status' => 1,
            'penerima' => Auth::user()->user_id
        ]);
        foreach ($pengiriman->pengirimanproduk as $key => $value) {
            // Cek apakah barang sudah ada
            $cabangstok = CabangStok::where('ukuran_produk',$value->ukuran_produk_id)->first();
            if ($cabangstok) {
                $cabangstok->update(['stok' => $cabangstok->stok + $value->jumlah]);
            } else {
                CabangStok::create([
                    'stok' => $value->jumlah,
                    'ukuran_produk' => $value->ukuran_produk_id,
                    'cab_id' => $value->pengiriman->cab_id
                ]);
            }
        }
        return redirect()->route('riwayatpengiriman.index')->with(['success' => 'Pengiriman berhasil dikonfirmasi!']);
    }
}
