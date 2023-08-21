@extends('layouts.main')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Table Riwayat Penjualan</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Riwayat Penjualan</li>
    </ol>
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{session('success')}}
        <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
        </ul>
        <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Daftar Riwayat Penjualan
        </div>
        <div class="card-body d-flex flex-column">
            <!-- Button trigger modal -->
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Metode Pembayaran</th>
                        <th>Total Item Terjual</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Metode Pembayaran</th>
                        <th>Total Item Terjual</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($penjualanspg as $item)
                    @php
                        $total_omzet = 0;
                        $total_item_terjual = 0;    
                    @endphp
                    @foreach ($item->itemterjual as $i => $terjual)
                    @php
                        $total_item_terjual = $total_item_terjual + $terjual->jumlah;
                        $total_omzet = $total_omzet + $terjual->ukuranproduk->product->harga*$terjual->jumlah;
                    @endphp
                    @endforeach
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->tanggal }}</td>
                        <td>{{ $item->waktu }}</td>
                        <td>{{ $item->metodepembayaran->nama }}</td>
                        <td>{{ $total_item_terjual }}</td>
                        <td>@currency($total_omzet)</td>
                        <td>
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#ModalInfoPenjualan-{{ $item->penjualan_spg_id }}">
                                <i class="fa-solid fa-info fa-sm" style="color: #ffffff;"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal hapus barang --}}
{{-- @foreach ($products as $product)
<div class="modal fade" id="ModalHapusBarang-{{ $product->product_id }}" tabindex="-1" role="dialog" aria-labelledby="ModalHapusBarangLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalHapusBarangLabel">Hapus Barang</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apa anda yakin untuk menghapus barang ini?
            </div>
            <form action="{{ route('barang.destroy',$product->product_id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('DELETE')
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger">Hapus</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach --}}

{{-- Modal detail barang --}}
@foreach ($penjualanspg as $item)
<div class="modal fade" id="ModalInfoPenjualan-{{ $item->penjualan_spg_id }}" tabindex="-1" role="dialog" aria-labelledby="ModalInfoPengirimanLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalInfoPengirimanLabel">Detail Pengiriman Barang</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Ukuran</th>
                        <th>Warna</th>
                        <th>Bahan</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $total = 0
                    @endphp
                    @foreach ($item->itemterjual as $i => $terjual)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $terjual->ukuranproduk->product->nama }}</td>
                        <td>{{ $terjual->ukuranproduk->ukuran->nama }}</td>
                        <td>{{ $terjual->ukuranproduk->product->warnabaju->nama }}</td>
                        <td>{{ $terjual->ukuranproduk->product->bahan->nama }}</td>
                        <td> @currency($terjual->ukuranproduk->product->harga) </td>
                        <td>{{ $terjual->jumlah }}</td>
                        <td> @currency($terjual->ukuranproduk->product->harga*$terjual->jumlah) </td>
                        @php
                            $total = $total + $terjual->ukuranproduk->product->harga*$terjual->jumlah
                        @endphp
                        {{-- <td>{{ $pengirimanproduk->jumlah }}</td> --}}
                    </tr>
                    @endforeach
                </tbody>
                <h6>Total Penjualan: @currency($total)</h6>
            </table>
        </div>
    </div>
</div>
@endforeach


@endsection

@section('scripts')
<script type="text/javascript">
    @if (count($errors) > 0)
        $('#ModalTambahBarang').modal('show');
    @endif
</script>
@endsection