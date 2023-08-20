@extends('layouts.main')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Table Daftar Barang</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
        <li class="breadcrumb-item active">Daftar Barang</li>
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
            Daftar Barang Aktif
        </div>
        <div class="card-body d-flex flex-column">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary align-self-end mb-2" data-toggle="modal" data-target="#ModalTambahBarang">Tambah Barang</button>
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Bahan</th>
                        <th>Warna</th>
                        <th>Ukuran</th>
                        <th>Harga</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Bahan</th>
                        <th>Warna</th>
                        <th>Ukuran</th>
                        <th>Harga</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($products as $product)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $product->nama }}</td>
                        <td>{{ $product->category->nama }}</td>
                        <td>{{ $product->bahan->nama }}</td>
                        <td>{{ $product->warnabaju->nama }}</td>
                        <td>
                            @foreach ($product->ukuran as $item)
                                {{ $item->nama }}
                            @endforeach
                        </td>
                        <td>@currency($product->harga)</td>
                        <td>
                            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#ModalEditBarang-{{ $product->product_id }}">
                                <i class="fa-solid fa-pen-to-square fa-sm" style="color: #ffffff;"></i>
                            </button>
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#ModalHapusBarang-{{ $product->product_id }}">
                                <i class="fa-solid fa-trash-can fa-sm" style="color: #ffffff;"></i>
                            </button>
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#ModalBarcodeBarang-{{ $product->product_id }}">
                                <i class="fa-solid fa-barcode fa-sm" style="color: #ffffff;"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal tambah barang --}}
<div class="modal fade" id="ModalTambahBarang" tabindex="-1" role="dialog" aria-labelledby="ModalTambahBarangLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="ModalTambahBarangLabel">Tambah Barang</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        {{-- Form --}}
            <form action="{{ route('barang.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group mb-4">
                    <label for="nama_barang">Nama Barang</label>
                    <input type="text" class="form-control" name="nama_barang" placeholder="Masukkan nama barang">
                </div>
                <div class="form-group mb-4">
                    <label for="warna_barang">Warna</label>
                    <select class="form-select" aria-label="Pilih warna barang" name="warna_barang">
                        @foreach ($warnas as $warna)
                        <option value="{{ $warna->warna_id }}">{{ $warna->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-4">
                    <label for="kategori_barang">Kategori</label>
                    <select class="form-select" aria-label="Pilih kategori barang" name="kategori_barang">
                        @foreach ($categories as $category)
                        <option value="{{ $category->categories_id }}">{{ $category->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-4">
                    <label for="bahan_barang">Bahan</label>
                    <select class="form-select" aria-label="Pilih bahan barang" name="bahan_barang">
                        @foreach ($bahans as $bahan)
                        <option value="{{ $bahan->bahan_id }}">{{ $bahan->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-4">
                    <label for="password_barang">Ukuran</label><br>
                    @foreach ($ukurans as $ukuran)
                    <input type="checkbox" name="ukuran_barang[]" value="{{ $ukuran->ukuran_id }}"> {{ $ukuran->nama }} <br/>
                    @endforeach
                </div>
                <div class="form-group mb-4">
                    <label for="password_barang">Harga</label>
                    <input type="text" class="form-control" name="harga_barang" placeholder="Masukkan harga barang">
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

{{-- Modal edit barang --}}
@foreach ($products as $product)
    <div class="modal fade" id="ModalEditBarang-{{ $product->product_id }}" tabindex="-1" role="dialog" aria-labelledby="ModalEditBarangLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="ModalEditBarangLabel">Edit Barang</h5>
            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            {{-- Form --}}
                <form action="{{ route('barang.update',$product->product_id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-4">
                        <label for="nama_barang">Nama Barang</label>
                        <input type="text" class="form-control" name="nama_barang" placeholder="Masukkan nama barang" value="{{ $product->nama }}">
                    </div>
                    <div class="form-group mb-4">
                        <label for="warna_barang">Warna</label>
                        <select class="form-select" aria-label="Pilih warna barang" name="warna_barang">
                            @foreach ($warnas as $warna)
                            <option value="{{ $warna->warna_id }}" {{ ($product->warna == $warna->warna_id) ? "selected" : "" }}>{{ $warna->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-4">
                        <label for="kategori_barang">Kategori</label>
                        <select class="form-select" aria-label="Pilih kategori barang" name="kategori_barang">
                            @foreach ($categories as $category)
                            <option value="{{ $category->categories_id }}" {{ ($product->cat_id == $category->categories_id) ? "selected" : "" }}>{{ $category->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-4">
                        <label for="bahan_barang">Bahan</label>
                        <select class="form-select" aria-label="Pilih bahan barang" name="bahan_barang">
                            @foreach ($bahans as $bahan)
                            <option value="{{ $bahan->bahan_id }}" {{ ($product->bahan_id == $bahan->bahan_id) ? "selected" : "" }}>{{ $bahan->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-4">
                        <label for="password_barang">Ukuran</label><br>
                        @foreach ($ukurans as $ukuran)
                        <input type="checkbox" name="ukuran_barang[]" value="{{ $ukuran->ukuran_id }}" @foreach ($product->ukuran as $item) {{ ($ukuran->ukuran_id == $item->pivot->ukuran_id) ? "checked" : "" }} @endforeach> {{ $ukuran->nama }} <br/>
                        @endforeach
                    </div>
                    <div class="form-group mb-4">
                        <label for="password_barang">Harga</label>
                        <input type="text" class="form-control" name="harga_barang" placeholder="Masukkan harga barang" value="{{ $product->harga }}">
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
{{-- @endforeach --}}
@endforeach

{{-- Modal hapus barang --}}
@foreach ($products as $product)
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
@endforeach

@foreach ($products as $product)
<div class="modal fade" id="ModalBarcodeBarang-{{ $product->product_id }}" tabindex="-1" role="dialog" aria-labelledby="ModalBarcodeBarangLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalBarcodeBarangLabel">Barcode Barang</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h4>{{ $product->nama }}</h4>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Ukuran</th>
                            <th>Kode Produk</th>
                            <th>Barcode</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($product->ukuranproduk as $ukuranproduk)
                        <tr>
                            <td>{{ $ukuranproduk->ukuran->nama }}</td>
                            <td>{{ $ukuranproduk->kode_produk }}</td>
                            <td><img src="data:image/png;base64,{!! DNS1D::getBarcodePNG($ukuranproduk->kode_produk, 'C128') !!}" alt="barcode"   /></td>
                        </tr>
                        @endforeach
                    </tbody>
                  </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
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