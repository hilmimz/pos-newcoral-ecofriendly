@extends('layouts.main')

@section('content')
<div class="container-fluid px-4">
    @foreach ($pengirimans as $pengiriman)
    {{-- @foreach ($pengiriman->ukuranproduk as $ukuranproduk)
        {{ $ukuranproduk->product->nama }}
    @endforeach --}}
    @endforeach
    <h1 class="mt-4">Table Riwayat Pengiriman</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
        <li class="breadcrumb-item active">Riwayat Pengiriman</li>
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
            Daftar Pengiriman Ongoing
        </div>
        <div class="card-body d-flex flex-column">
            <!-- Button trigger modal -->
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Cabang Tujuan</th>
                        <th>Tanggal Pengiriman</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Cabang Tujuan</th>
                        <th>Tanggal Pengiriman</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($pending_pengirimans as $pengiriman)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $pengiriman->cabang->nama }}</td>
                        <td>{{ $pengiriman->tanggal_pengiriman }}</td>
                        <td>
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#ModalTerimaPengiriman-{{ $pengiriman->pengiriman_id }}">
                                <i class="fa-solid fa-check fa-sm" style="color: #ffffff;"></i>
                            </button>
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#ModalHapusPengiriman-{{ $pengiriman->pengiriman_id }}">
                                <i class="fa-solid fa-trash-can fa-sm" style="color: #ffffff;"></i>
                            </button>
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#ModalInfoPengiriman-{{ $pengiriman->pengiriman_id }}">
                                <i class="fa-solid fa-info fa-sm" style="color: #ffffff;"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Riwayat Pengiriman
        </div>
        <div class="card-body d-flex flex-column">
            <!-- Button trigger modal -->
            <table id="datatablesSimple2">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Cabang Tujuan</th>
                        <th>Tanggal Pengiriman</th>
                        <th>Penerima</th>
                        <th style="width: 20%">Keterangan Penerimaan</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Cabang Tujuan</th>
                        <th>Tanggal Pengiriman</th>
                        <th>Penerima</th>
                        <th style="width: 20%">Keterangan Penerimaan</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($sukses_pengirimans as $pengiriman)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $pengiriman->cabang->nama }}</td>
                        <td>{{ $pengiriman->tanggal_pengiriman }}</td>
                        <td>{{ $pengiriman->user->nama }}</td>
                        <td widt>{{ $pengiriman->keterangan_penerimaan }}</td>
                        <td>
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#ModalInfoPengiriman-{{ $pengiriman->pengiriman_id }}">
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

{{-- Modal hapus pengiriman --}}
@foreach ($pengirimans as $pengiriman)
<div class="modal fade" id="ModalHapusPengiriman-{{ $pengiriman->pengiriman_id }}" tabindex="-1" role="dialog" aria-labelledby="ModalHapusPengirimanLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalHapusPengirimanLabel">Hapus Barang</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apa anda yakin untuk menghapus pengiriman ini?
            </div>
            <form action="{{ route('riwayatpengiriman.destroy',$pengiriman->pengiriman_id) }}" method="POST" enctype="multipart/form-data">
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
@endforeach

{{-- Modal terima pengiriman --}}
@foreach ($pengirimans as $pengiriman)
<div class="modal fade" id="ModalTerimaPengiriman-{{ $pengiriman->pengiriman_id }}" tabindex="-1" role="dialog" aria-labelledby="ModalTerimaPengirimanLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalTerimaPengirimanLabel">Konfirmasi Pengiriman</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Konfirmasi pengiriman ini?
            </div>
            <form action="{{ route('riwayatpengiriman.konfirmasi',$pengiriman->pengiriman_id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Konfirmasi</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

{{-- Modal detail barang --}}
@foreach ($pengirimans as $pengiriman)
<div class="modal fade" id="ModalInfoPengiriman-{{ $pengiriman->pengiriman_id }}" tabindex="-1" role="dialog" aria-labelledby="ModalInfoPengirimanLabel" aria-hidden="true">
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
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pengiriman->pengirimanproduk as $i => $pengirimanproduk)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $pengirimanproduk->ukuranproduk->product->nama }}</td>
                        <td>{{ $pengirimanproduk->ukuranproduk->ukuran->nama }}</td>
                        <td>{{ $pengirimanproduk->ukuranproduk->product->warnabaju->nama }}</td>
                        <td>{{ $pengirimanproduk->ukuranproduk->product->bahan->nama }}</td>
                        <td>{{ $pengirimanproduk->jumlah }}</td>
                    </tr>
                    @endforeach
                </tbody>
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