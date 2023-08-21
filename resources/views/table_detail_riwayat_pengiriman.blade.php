@extends('layouts.main')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Table Riwayat Pengiriman</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Riwayat Pengiriman</li>
    </ol>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Daftar Pengiriman Pending
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
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#ModalAcceptPengiriman-{{ $pengiriman->pengiriman_id }}">
                                <i class="fa-solid fa-check fa-sm" style="color: #ffffff;"></i>
                            </button>
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#ModalHapusPengiriman-{{ $pengiriman->pengiriman_id }}">
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
@endsection

@section('scripts')
<script type="text/javascript">
    @if (count($errors) > 0)
        $('#ModalTambahBarang').modal('show');
    @endif
</script>
@endsection