<?php

namespace App\Http\Controllers;
use App\Models\Pengiriman;
use App\Models\PengirimanProduk;
use App\Models\Product;
use App\Models\UkuranProduk;
use App\Models\Cabang;
use App\Models\CabangStok;
use App\Models\ItemTerjual;
use App\Models\MetodePembayaran;
use App\Models\PenjualanSPG;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class InputPenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::join('ukuran_produk','ukuran_produk.prod_id','=','products.product_id')
            ->join('cabang_stok','cabang_stok.ukuran_produk','=','ukuran_produk.ukuran_produk_id')
            ->where('cab_id',$request->session()->get('cabang_id'))
            ->where('stok','>',0)
            ->get();
        // dd($products);
        $ukuranProduk = UkuranProduk::all();
        $cabangs = Cabang::all();
        $metode_pembayarans = MetodePembayaran::all();
        return view('input_penjualan',compact('products','ukuranProduk','cabangs','metode_pembayarans'));
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
        $request->validate([
            'addmore.*.nama_produk' => 'required',
            'addmore.*.ukuran_produk' => 'required',
            'addmore.*.jumlah_produk' => 'required | integer',
            'metode_pembayaran' => 'required'
        ]);
        foreach ($request->addmore as $key => $value) {
            $ukuran_id = UkuranProduk::where('prod_id', $value['nama_produk'])->where('ukuran_id',$value['ukuran_produk'])->pluck('ukuran_produk_id')->first();
            $cabang_stok = CabangStok::where('ukuran_produk',$ukuran_id)->where('cab_id',$request->session()->get('cabang_id'))->first();
            if ($cabang_stok->stok < $value['jumlah_produk']) {
                return Redirect::back()->withErrors(['msg' => 'Jumlah produk yang dibeli melebihi stok']);
            }
        }
        $user_id = Auth::user()->user_id;
        $cabang_id = $request->session()->get('cabang_id');
        $id = PenjualanSPG::create([
            'metode_pembayaran' => $request->metode_pembayaran,
            'spg_id' => $user_id,
            'tanggal' => Carbon::now(),
            'waktu' => Carbon::now()->format('H:i:m'),
            'cabang_id' => $cabang_id
        ])->penjualan_spg_id;

        foreach ($request->addmore as $key => $value) {
            $ukuran_id = UkuranProduk::where('prod_id', $value['nama_produk'])->where('ukuran_id',$value['ukuran_produk'])->pluck('ukuran_produk_id')->first();
            $item_terjual = ItemTerjual::create([
                'jumlah' => $value['jumlah_produk'],
                'ukuran_produk' => $ukuran_id,
                'penjualan_id' => $id
            ]);
            $cabang_stok = CabangStok::where('ukuran_produk',$ukuran_id)->where('cab_id',$request->session()->get('cabang_id'))->first();
            $cabang_stok->update([
                'stok' => $cabang_stok->stok - $value['jumlah_produk']
            ]);
        }
        return redirect()->route('inputpenjualan.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
