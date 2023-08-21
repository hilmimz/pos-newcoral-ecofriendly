@extends('layouts.main')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Table Daftar Bahan</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Daftar Bahan</li>
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
            Daftar Bahan
        </div>
        <div class="card-body d-flex flex-column">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary align-self-end mb-2" data-toggle="modal" data-target="#ModalTambahBahan">Tambah Bahan</button>
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($bahans as $bahan)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $bahan->nama }}</td>
                        <td>
                            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#ModalEditBahan-{{ $bahan->bahan_id }}">
                                <i class="fa-solid fa-pen-to-square fa-sm" style="color: #ffffff;"></i>
                            </button>
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#ModalHapusBahan-{{ $bahan->bahan_id }}">
                                <i class="fa-solid fa-trash-can fa-sm" style="color: #ffffff;"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Modal tambah bahan --}}
<div class="modal fade" id="ModalTambahBahan" tabindex="-1" role="dialog" aria-labelledby="ModalTambahBahanLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="ModalTambahBahanLabel">Tambah Bahan</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        {{-- Form --}}
            <form action="{{ route('bahan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group mb-4">
                    <label for="nama_bahan">Nama Bahan</label>
                    <input type="text" class="form-control" name="nama_bahan" placeholder="Masukkan nama bahan">
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

{{-- Modal edit bahan --}}
@foreach ($bahans as $bahan)
    <div class="modal fade" id="ModalEditBahan-{{ $bahan->bahan_id }}" tabindex="-1" role="dialog" aria-labelledby="ModalEditBahanLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="ModalEditBahanLabel">Edit Bahan</h5>
            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            {{-- Form --}}
                <form action="{{ route('bahan.update',$bahan->bahan_id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-4">
                        <label for="nama_bahan">Nama Bahan</label>
                        <input type="text" class="form-control" name="nama_bahan" placeholder="Masukkan nama bahan" value="{{ $bahan->nama }}">
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

{{-- Modal hapus bahan --}}
@foreach ($bahans as $bahan)
<div class="modal fade" id="ModalHapusBahan-{{ $bahan->bahan_id }}" tabindex="-1" role="dialog" aria-labelledby="ModalHapusBahanLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalHapusBahanLabel">Hapus Bahan</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apa anda yakin untuk menghapus bahan ini?
            </div>
            <form action="{{ route('bahan.destroy',$bahan->bahan_id) }}" method="POST" enctype="multipart/form-data">
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
@endsection

@section('scripts')
<script type="text/javascript">
    @if (count($errors) > 0)
        $('#ModalTambahBahan').modal('show');
    @endif
</script>
@endsection