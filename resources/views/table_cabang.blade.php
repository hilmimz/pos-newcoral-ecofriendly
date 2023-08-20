@extends('layouts.main')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Table Daftar Cabang</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
        <li class="breadcrumb-item active">Daftar Cabang</li>
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
            Daftar Cabang
        </div>
        <div class="card-body d-flex flex-column">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary align-self-end mb-2" data-toggle="modal" data-target="#ModalTambahCabang">Tambah Cabang</button>
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
                    @foreach ($cabangs as $cabang)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $cabang->nama }}</td>
                        <td>
                            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#ModalEditCabang-{{ $cabang->cabang_id }}">
                                <i class="fa-solid fa-pen-to-square fa-sm" style="color: #ffffff;"></i>
                            </button>
                            <a href="{{ route('cabang.show',$cabang->cabang_id) }}">
                                <button type="button" class="btn btn-info">
                                    <i class="fa-solid fa-circle-info" style="color: #ffffff;"></i>
                                </button>
                            </a>
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#ModalHapusCabang-{{ $cabang->cabang_id }}">
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

{{-- Modal tambah cabang --}}
<div class="modal fade" id="ModalTambahCabang" tabindex="-1" role="dialog" aria-labelledby="ModalTambahCabangLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="ModalTambahCabangLabel">Tambah Cabang</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        {{-- Form --}}
            <form action="{{ route('cabang.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group mb-4">
                    <label for="nama_cabang">Nama Cabang</label>
                    <input type="text" class="form-control" name="nama_cabang" placeholder="Masukkan nama cabang">
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

{{-- Modal edit cabang --}}
@foreach ($cabangs as $cabang)
    <div class="modal fade" id="ModalEditCabang-{{ $cabang->cabang_id }}" tabindex="-1" role="dialog" aria-labelledby="ModalEditCabangLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="ModalEditCabangLabel">Edit Cabang</h5>
            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            {{-- Form --}}
                <form action="{{ route('cabang.update',$cabang->cabang_id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-4">
                        <label for="nama_cabang">Nama Cabang</label>
                        <input type="text" class="form-control" name="nama_cabang" placeholder="Masukkan nama cabang" value="{{ $cabang->nama }}">
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

{{-- Modal hapus cabang --}}
@foreach ($cabangs as $cabang)
<div class="modal fade" id="ModalHapusCabang-{{ $cabang->cabang_id }}" tabindex="-1" role="dialog" aria-labelledby="ModalHapusCabangLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalHapusCabangLabel">Hapus Cabang</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apa anda yakin untuk menghapus cabang ini?
            </div>
            <form action="{{ route('cabang.destroy',$cabang->cabang_id) }}" method="POST" enctype="multipart/form-data">
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
        $('#ModalTambahCabang').modal('show');
    @endif
</script>
@endsection