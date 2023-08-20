@extends('layouts.main')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Table Stok Barang {{ $cabang_nama }}</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
        <li class="breadcrumb-item active">Stok Barang</li>
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
            Daftar Stok Barang
        </div>
        <div class="card-body d-flex flex-column">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Warna</th>
                        <th>Bahan</th>
                        <th>Ukuran</th>
                        <th>Stok</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Warna</th>
                        <th>Bahan</th>
                        <th>Ukuran</th>
                        <th>Stok</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($cabang_stoks as $cabang_stok)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $cabang_stok->get_ukuran_produk->product->nama }}</td>
                        <td>{{ $cabang_stok->get_ukuran_produk->product->category->nama }}</td>
                        <td>{{ $cabang_stok->get_ukuran_produk->product->warnabaju->nama }}</td>
                        <td>{{ $cabang_stok->get_ukuran_produk->product->bahan->nama }}</td>
                        <td>{{ $cabang_stok->get_ukuran_produk->ukuran->nama }}</td>
                        <td>{{ $cabang_stok->stok }}</td>
                        <td>
                            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#ModalEditStok-{{ $cabang_stok->cabang_stok_id }}">
                                <i class="fa-solid fa-pen-to-square fa-sm" style="color: #ffffff;"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal tambah warna --}}
{{-- <div class="modal fade" id="ModalTambahWarna" tabindex="-1" role="dialog" aria-labelledby="ModalTambahWarnaLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="ModalTambahWarnaLabel">Tambah Warna</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body"> --}}
        {{-- Form --}}
            {{-- <form action="{{ route('warna.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group mb-4">
                    <label for="nama_warna">Nama Warna</label>
                    <input type="text" class="form-control" name="nama_warna" placeholder="Masukkan nama warna">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" >Save changes</button>
                </div>
            </form>
        </div>
    </div>
    </div>
</div> --}}

{{-- Modal edit warna --}}
@foreach ($cabang_stoks as $cabang_stok)
    <div class="modal fade" id="ModalEditStok-{{ $cabang_stok->cabang_stok_id }}" tabindex="-1" role="dialog" aria-labelledby="ModalEditStokLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="ModalEditStokLabel">Edit Stok</h5>
            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            {{-- Form --}}
                <form action="{{ route('cabang.update_stok',$cabang_stok->cabang_stok_id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-4">
                        <label for="stok">Jumlah Stok</label>
                        <input type="text" class="form-control" name="stok" placeholder="Masukkan jumlah stok" value="{{ $cabang_stok->stok }}">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" >Save changes</button>
                    </div>
                </form>
            </div>
        </div>
        </div>
    </div>
@endforeach

{{-- Modal hapus warna --}}
{{-- @foreach ($warnas as $warna)
<div class="modal fade" id="ModalHapusWarna-{{ $warna->warna_id }}" tabindex="-1" role="dialog" aria-labelledby="ModalHapusWarnaLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalHapusWarnaLabel">Hapus Warna</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apa anda yakin untuk menghapus warna ini?
            </div>
            <form action="{{ route('warna.destroy',$warna->warna_id) }}" method="POST" enctype="multipart/form-data">
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
@endsection

@section('scripts')
<script type="text/javascript">
    @if (count($errors) > 0)
        $('#ModalTambahWarna').modal('show');
    @endif
</script>
@endsection