@extends('layouts.main')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Table Daftar Penjual</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
        <li class="breadcrumb-item active">Daftar Penjual</li>
    </ol>
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{session('success')}}
        <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Daftar Penjual Aktif
        </div>
        <div class="card-body d-flex flex-column">
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary align-self-end mb-2" data-toggle="modal" data-target="#ModalTambahPenjual">Tambah Penjual</button>
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Created At</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($users_active as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->nama }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->created_at->toDateString() }}</td>
                        <td>
                            <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#ModalEditPenjual-{{ $user->user_id }}">
                                <i class="fa-solid fa-pen-to-square fa-sm" style="color: #ffffff;"></i>
                            </button>
                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#ModalNonaktifkanPenjual-{{ $user->user_id }}">
                                <i class="fa-solid fa-arrow-down fa-sm" style="color: #ffffff;"></i>
                            </button>
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#ModalUpdatePasswordPejual-{{ $user->user_id }}">
                                <i class="fa-solid fa-key fa-sm" style="color: #ffffff;"></i>
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
            Daftar Penjual Tidak Aktif
        </div>
        <div class="card-body d-flex flex-column">
            <table id="datatablesSimple2">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Inactivated At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Inactivated At</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach ($users_inactive as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->nama }}</td>
                        <td>{{ $user->username }}</td>
                        <td>
                            @if ($user->inactivated_at == null)
                                null
                            @else
                            {{ $user->inactivated_at }}
                            @endif
                            </td>
                        <td>
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#ModalAktifkanPenjual-{{ $user->user_id }}">
                                <i class="fa-solid fa-check fa-sm" style="color: #ffffff;"></i>
                            </button>
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#ModalHapusPenjual-{{ $user->user_id }}">
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

<!-- Modal -->
<div class="modal fade" id="ModalTambahPenjual" tabindex="-1" role="dialog" aria-labelledby="ModalTambahPenjualLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="ModalTambahPenjualLabel">Tambah Penjual</h5>
        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        {{-- Form --}}
            <form action="{{ route('daftarpenjual.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group mb-4">
                    <label for="nama_penjual">Nama</label>
                    <input type="text" class="form-control" name="nama_penjual" placeholder="Masukkan nama penjual">
                    @error('nama_penjual')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group mb-4">
                    <label for="username_penjual">Username</label>
                    <input type="text" class="form-control" name="username_penjual" placeholder="Masukkan username penjual">
                    @error('username_penjual')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group mb-4">
                    <label for="password_penjual">Password</label>
                    <input type="password" class="form-control" name="password_penjual" placeholder="Masukkan password penjual">
                    @error('password_penjual')
                        <div class="alert alert-danger mt-2">
                            {{ $message }}
                        </div>
                    @enderror
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

@foreach ($users_active as $user)
    <div class="modal fade" id="ModalEditPenjual-{{ $user->user_id }}" tabindex="-1" role="dialog" aria-labelledby="ModalEditPenjualLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="ModalEditPenjualLabel">Edit Penjual</h5>
            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            {{-- Form --}}
                <form action="{{ route('daftarpenjual.update',$user->user_id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-4">
                        <label for="nama_penjual">Nama</label>
                        <input type="text" class="form-control" id="nama_penjual" name="nama_penjual" placeholder="Masukkan nama penjual" value="{{ $user->nama }}">
                    </div>
                    <div class="form-group mb-4">
                        <label for="username_penjual">Username</label>
                        <input type="text" class="form-control" id="username_penjual" name="username_penjual" placeholder="Masukkan username penjual" value="{{ $user->username }}">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
        </div>
    </div>
@endforeach

@foreach ($users_active as $user)
<div class="modal fade" id="ModalNonaktifkanPenjual-{{ $user->user_id }}" tabindex="-1" role="dialog" aria-labelledby="ModalNonaktifkanPenjualLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalNonaktifkanPenjualLabel">Nonaktifkan Penjual</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apa anda yakin untuk menonaktifkan penjual ini?
            </div>
            <form action="{{ route('daftarpenjual.inactivate',$user->user_id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-footer">
                    <button type="submit" class="btn btn-warning">Nonaktifkan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@foreach ($users_active as $user)
<div class="modal fade" id="ModalUpdatePasswordPejual-{{ $user->user_id }}" tabindex="-1" role="dialog" aria-labelledby="ModalUpdatePasswordPejualLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalUpdatePasswordPejualLabel">Perbarui Password Penjual</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('daftarpenjual.updatepassword',$user->user_id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-4">
                        <label for="nama_penjual">Password baru</label>
                        <input type="text" class="form-control" id="password_baru_penjual" name="password_baru_penjual" placeholder="Masukkan password baru penjual">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

{{-- @foreach ($users_active as $user)
<div class="modal fade" id="ModalUpdatePassword-{{ $user->user_id }}" tabindex="-1" role="dialog" aria-labelledby="ModalUpdatePasswordLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalUpdatePasswordPenjualLabel">Ubah Password Penjual</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group mb-4">
                        <label for="nama_penjual">Password baru</label>
                        <input type="text" class="form-control" id="password_baru_penjual" name="password_baru_penjual" placeholder="Masukkan password baru penjual">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
        </div>
    </div>
</div>
@endforeach --}}

@foreach ($users_inactive as $user)
<div class="modal fade" id="ModalAktifkanPenjual-{{ $user->user_id }}" tabindex="-1" role="dialog" aria-labelledby="ModalAktifkanPenjualLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalAktifkanPenjualLabel">Aktifkan Penjual</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apa anda yakin untuk mengaktifkan penjual ini?
            </div>
            <form action="{{ route('daftarpenjual.activate',$user->user_id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Aktifkan</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach
@foreach ($users_inactive as $user)
<div class="modal fade" id="ModalHapusPenjual-{{ $user->user_id }}" tabindex="-1" role="dialog" aria-labelledby="ModalHapusPenjualLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalHapusPenjualLabel">Hapus Penjual</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apa anda yakin untuk menghapus penjual ini?
            </div>
            <form action="{{ route('daftarpenjual.destroy',$user->user_id) }}" method="POST" enctype="multipart/form-data">
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
        $('#ModalTambahPenjual').modal('show');
    @endif
</script>
@endsection