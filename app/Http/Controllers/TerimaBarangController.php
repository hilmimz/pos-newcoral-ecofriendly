<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\CabangStok;
use App\Models\Pengiriman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TerimaBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $cabang_id = $request->session()->get('cabang_id');
        $pengirimans = Pengiriman::where('cab_id',$cabang_id)->where('status',0)->get();
        // dd($pengirimans);
        return view('terima_barang',compact('pengirimans'));
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

    public function konfirmasi(Request $request, $terimabarang)
    {
        // dd($request->keterangan);
        $pengiriman=Pengiriman::find($terimabarang);
        // foreach ($pengiriman->pengirimanproduk as $key => $value) {
        //     dd($value->jumlah);
        // }
        $pengiriman->update([
            'status' => 1,
            'penerima' => Auth::user()->user_id,
            'keterangan_penerimaan' => $request->keterangan
        ]);
        $cabang_id = $pengiriman->cab_id;
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

        return redirect()->route('terimabarang.index')->with(['success' => 'Barang berhasil dikonfirmasi!']);
    }
}
