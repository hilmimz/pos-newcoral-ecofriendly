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
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Storage;

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
        $produk_dibeli = array();
        foreach ($request->addmore as $key => $value) {
            $ukuran_id = UkuranProduk::where('prod_id', $value['nama_produk'])->where('ukuran_id',$value['ukuran_produk'])->pluck('ukuran_produk_id')->first();
            if (array_key_exists($ukuran_id, $produk_dibeli)) {
                $produk_dibeli[$ukuran_id] = $produk_dibeli[$ukuran_id] + $value['jumlah_produk'];
            }
            else {
                $produk_dibeli[$ukuran_id] = (int)$value['jumlah_produk'];
            }
        }
        foreach ($produk_dibeli as $key => $value) {
            $cabang_stok = CabangStok::where('ukuran_produk',$key)->where('cab_id',$request->session()->get('cabang_id'))->first();
            if ($cabang_stok->stok < $value) {
                return Redirect::back()->withErrors(['msg' => 'Jumlah produk yang dibeli melebihi stok']);
            }
        }
        $detail_produk_dibeli = array();
        foreach ($produk_dibeli as $key => $value) {
            $detail = array();
            $product = UkuranProduk::find($key);
            $detail['nama_produk'] = $product->product->nama;
            $detail['bahan_produk'] = $product->product->bahan->nama;
            $detail['warna_produk'] = $product->product->warnabaju->nama;
            $detail['jumlah'] = $value;
            $detail['harga_produk'] = $product->product->harga;
            $detail['total_harga_produk'] = $product->product->harga * $value;
            $detail_produk_dibeli[$product->product->product_id] = $detail;
        }

        $user_id = Auth::user()->user_id;
        $cabang_id = $request->session()->get('cabang_id');
        if ($request->jenis_penjualan == 'spg') {
            $id = PenjualanSPG::create([
                'metode_pembayaran' => $request->metode_pembayaran,
                'spg_id' => $user_id,
                'tanggal' => Carbon::now(),
                'waktu' => Carbon::now()->format('H:i:m'),
                'cabang_id' => $cabang_id
            ])->penjualan_spg_id;
        }
        elseif ($request->jenis_penjualan == 'fo') {
            $id = PenjualanSPG::create([
                'metode_pembayaran' => $request->metode_pembayaran,
                'spg_id' => $user_id,
                'tanggal' => Carbon::now(),
                'waktu' => Carbon::now()->format('H:i:m'),
                'cabang_id' => $cabang_id,
                'is_fo' => 1
            ])->penjualan_spg_id;
        }

        foreach ($produk_dibeli as $key => $value) {
            $ukuran_id = $key;
            $jumlah = $value;
            $item_terjual = ItemTerjual::create([
                'jumlah' => $jumlah,
                'ukuran_produk' => $ukuran_id,
                'penjualan_id' => $id
            ]);
            $cabang_stok = CabangStok::where('ukuran_produk',$ukuran_id)->where('cab_id',$request->session()->get('cabang_id'))->first();
            $cabang_stok->update([
                'stok' => $cabang_stok->stok - $jumlah
            ]);
        }

        //Generate PDF
        $total_harga = 0;
        $total_item = 0;
        foreach ($detail_produk_dibeli as $key => $value) {
            $total_harga = $total_harga + $value['total_harga_produk'];
            $total_item = $total_item + $value['jumlah'];
        }
        $now = Carbon::now();
        $image = base64_encode(file_get_contents(public_path('/images/logo_bnw.png')));
        $pembayaran = MetodePembayaran::where('metode_pembayaran_id',$request->metode_pembayaran)->pluck('nama')->first();
        $pdf = Pdf::loadview('struk', with([
            'produk' => $detail_produk_dibeli,
            'now' => $now,
            'pembayaran' => $pembayaran,
            'total_harga' => $total_harga,
            'total_item' =>$total_item,
            'image' => $image
        ]));
        // $request->session()->flash('success', 'Data berhasil disimpan');
        $request->session()->put('produk.struk', $detail_produk_dibeli);
        $request->session()->put('total_harga.struk', $total_harga);
        $request->session()->put('total_item.struk', $total_item);
        $request->session()->put('pembayaran.struk', $pembayaran);
        return redirect()->route('inputpenjualan.index')->with(['success' => 'Penjualan Berhasil Diinput!']);
        //Download with storage laravel
        // $pdf->setOptions(['dpi' => 150, 'isRemoteEnabled' => true])
        // ->setPaper([0,0,140,935.43]);
        // $content = $pdf->download()->getOriginalContent();
        // $filepath = '/pdf/Invoice-'.$request->session()->get('cabang').'-'.Auth::user()->nama.'.pdf';
        // Storage::put($filepath,$content);
        // return Storage::download($filepath);

        //Download with DomPDF
        // $filename = 'Invoice-'.$request->session()->get('cabang').'-'.Auth::user()->nama.'-'.$now.'.pdf';
        // return $pdf->setOptions(['dpi' => 150, 'isRemoteEnabled' => true])
        // ->setPaper([0,0,140,935.43])
        // ->download($filename,array('Attachment'=>0));
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

    public function cetak_pdf(Request $request)
    {   
        $produk = $request->session()->get('produk.struk');
        $total_harga = $request->session()->get('total_harga.struk');
        $total_item =$request->session()->get('total_item.struk');
        $pembayaran = $request->session()->get('pembayaran.struk');
        $total_harga = 0;
        foreach ($produk as $key => $value) {
            $total_harga = $total_harga + $value['total_harga_produk'];
        }
        // $product = Product::all();
        $now = Carbon::now();
        $image = base64_encode(file_get_contents(public_path('/images/logo_bnw.png')));
        $pdf = Pdf::loadview('struk', with([
            'produk' => $produk,
            'now' => $now,
            'pembayaran' => $pembayaran,
            'total_harga' => $total_harga,
            'total_item' =>$total_item,
            'image' => $image
        ]));
        $filename = 'Invoice-'.$request->session()->get('cabang').'-'.Auth::user()->nama.'-'.$now.'.pdf';
        return $pdf->setOptions(['dpi' => 150, 'isRemoteEnabled' => true])
        ->setPaper([0,0,140,935.43])->stream($filename);
    }
}
