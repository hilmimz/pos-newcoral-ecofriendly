<?php

use App\Http\Controllers\DaftarPenjualController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InputPenjualanController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\RiwayatPenjualanController;
use App\Http\Controllers\StokBarangController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\BahanController;
use App\Http\Controllers\WarnaController;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GetHargaController;
use App\Http\Controllers\KodeProdukController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PengirimanController;
use App\Http\Controllers\RiwayatPengirimanController;
use App\Http\Controllers\TerimaBarangController;
use App\Http\Controllers\UkuranDropdownController;
use App\Models\Pengiriman;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('home');
});

Route::middleware(['guest'])->group(function () {

Route::get('login', [LoginController::class, 'index'])->name('login');

Route::post('login', [LoginController::class, 'authenticate'])->name('login.authenticate');

});

Route::middleware(['auth'])->group(function () {

    Route::post('logout', [LoginController::class, 'logout'])->name('login.logout');

    Route::resource('home', HomeController::class);

    Route::match(['get'], 'inputpenjualan/cetak_pdf',[InputPenjualanController::class, 'cetak_pdf'])->name('inputpenjualan.cetak_Pdf');
    // Route::get('/inputpenjualan/cetak_pdf', 'InputPenjualanController@cetak_pdf');
    Route::resource('inputpenjualan', InputPenjualanController::class);

    Route::resource('riwayatpenjualan', RiwayatPenjualanController::class);

    // Route::post('api/fetch-states', [PengirimanController::class, 'fetchState']);
    // Route::match('pengiriman/ukuran/{id}',PengirimanController::class,'fetchUkuran')->name('pengiriman.fetchUkuran');
    Route::get('ukuran-dropdown', UkuranDropdownController::class);
    Route::get('kode-produk', KodeProdukController::class);
    Route::get('get-harga', GetHargaController::class);

    Route::resource('terimabarang', TerimaBarangController::class);
    Route::match(['put', 'patch'], 'terimabarang/konfirmasi/{daftarpenjual}',[TerimaBarangController::class, 'konfirmasi'])->name('terimabarang.konfirmasi');

});

Route::middleware(['admin'])->group(function () {

    Route::match(['put', 'patch'], 'daftarpenjual/inactivate/{daftarpenjual}',[DaftarPenjualController::class, 'inactivate'])->name('daftarpenjual.inactivate');
    Route::match(['put', 'patch'], 'daftarpenjual/activate/{daftarpenjual}',[DaftarPenjualController::class, 'activate'])->name('daftarpenjual.activate');
    Route::match(['put', 'patch'], 'daftarpenjual/updatepassword/{daftarpenjual}',[DaftarPenjualController::class, 'updatepassword'])->name('daftarpenjual.updatepassword');
    Route::resource('daftarpenjual', DaftarPenjualController::class);

    Route::resource('penjualan', PenjualanController::class);

    Route::resource('stokbarang', StokBarangController::class);

    Route::resource('barang', BarangController::class);

    Route::resource('bahan', BahanController::class);

    Route::resource('warna', WarnaController::class);

    Route::resource('cabang', CabangController::class);
    Route::match(['put', 'patch'], 'cabang/updatestok/{cabang}',[CabangController::class, 'updatestok'])->name('cabang.update_stok');

    Route::resource('kategori', CategoryController::class);

    Route::resource('pengiriman', PengirimanController::class);
    Route::resource('riwayatpengiriman', RiwayatPengirimanController::class);
    Route::match(['put', 'patch'], 'riwayatpengiriman/konfirmasi/{daftarpenjual}',[RiwayatPengirimanController::class, 'konfirmasi'])->name('riwayatpengiriman.konfirmasi');

});