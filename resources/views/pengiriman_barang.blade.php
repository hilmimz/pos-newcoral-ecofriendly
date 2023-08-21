@extends('layouts.main')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Pengiriman Produk</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Pengiriman Produk</li>
    </ol>
    @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
    @endif
            <a href="{{ route('riwayatpengiriman.index') }}">
                <button class="btn btn-info mb-3"><i class="fa-solid fa-clock-rotate-left"></i> Riwayat Pengiriman</button>
            </a>
        <table class="table table-bordered mb-4" id="dynamicTable2">  
            <tr>
                <th style="width:40%">Nama Produk</th>
                <th>Ukuran Produk</th>
                <th>Jumlah Produk</th>
                <th>Action</th>
            </tr>
            <tr>
                <form>
                    <td>
                        <select class="form-select" aria-label="Pilih nama produk" name="id" id="id" style="width: 100%">
                            <option value="">==Pilih Produk==</option>
                            @foreach ($products as $product)
                            <option value="{{ $product->product_id }}">{{ $product->nama }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select class="form-select" name="ukuran" id="ukuran" required>
                            <option value="">==Pilih Ukuran==</option>
                        </select>
                    </td> 
                    <td><input type="number" name="jumlah" id="jumlah" placeholder="Masukkan jumlah" class="form-control" /></td>  
                    <td><button type="button" name="add" id="add" class="btn btn-success" disabled>Add</button></td>  
                </form>
            </tr>
        </table>
    <h5>Daftar barang yang akan dikirim</h5>
    <form action="{{ route('pengiriman.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="nama_produk">Cabang Tujuan</label>
            <select class="form-select mb-2" aria-label="Pilih cabang tujuan" name="cabang_tujuan">
                @foreach ($cabangs as $cabang)
                <option value="{{ $cabang->cabang_id }}">{{ $cabang->nama }}</option>
                @endforeach
            </select>
        <table class="table table-bordered mt-2" id="dynamicTable">  
            <tr>
                <th style="width:40%">Nama Produk</th>
                <th>Ukuran Produk</th>
                <th>Jumlah Produk</th>
                <th>Action</th>
            </tr>
        </table>
        <button type="submit" class="btn btn-primary mt-3" name="kirim" id="kirim" disabled>Kirim</button>
    </form>
    
</div>


@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        var i = 0;
        var nama_bool = false;
        var ukuran_bool = false;
        var jumlah_bool = false;

        $("#add").click(function(){
            var id_produk = $('#id').val();
            var nama_produk = $('#id option:selected').text();
            var ukuran_produk = $('#ukuran').val();
            var nama_ukuran = $('#ukuran option:selected').text();
            var jumlah_produk = $('#jumlah').val();
    
            console.log(nama_produk);
            $(document).ready(function() {
                $('.form-select').select2();
            });
    
            // $("#dynamicTable").append('<tr><td><select class="form-select" aria-label="Pilih nama produk" name="addmore['+i+'][id_produk]" id="addmore['+i+'][id_produk]" style="width: 100%"><option>==Pilih Ukuran==</option>@foreach ($products as $product)<option value="{{ $product->product_id }}">{{ $product->nama }}</option>@endforeach</select></td><td><select class="form-select" aria-label="Pilih nama produk" name="addmore['+i+'][ukuran_produk]" id="addmore['+i+'][ukuran_produk]" style="width: 100%"><option>==Pilih Ukuran==</option></select></td><td><input type="text" name="addmore['+i+'][jumlah_produk]" placeholder="Masukkan jumlah" class="form-control" /></td><td><button type="button" class="btn btn-danger remove-tr">Remove</button></td></tr>');
            $("#dynamicTable").append('<tr><td><select class="form-select" name="addmore['+i+'][nama_produk]" id="addmore['+i+'][nama_produk]" style="width: 100%" required disabled="disabled"><option value="'+id_produk+'">'+nama_produk+'</option></select><input type="hidden" name="addmore['+i+'][nama_produk]" id="addmore['+i+'][nama_produk]" value="'+id_produk+'" /></td><td><select class="form-select" name="addmore['+i+'][ukuran_produk]" id="addmore['+i+'][ukuran_produk]" style="width: 100%" required disabled="disabled"><option value="'+ukuran_produk+'">'+nama_ukuran+'</option></select><input type="hidden" name="addmore['+i+'][ukuran_produk]" id="addmore['+i+'][ukuran_produk]" value="'+ukuran_produk+'" /></td> <td><input type="text" name="addmore['+i+'][jumlah_produk]" readonly="readonly" value="'+jumlah_produk+'"></td>  <td><button type="button" class="btn btn-danger remove-tr">Remove</button></td></tr>');
            ++i;
            disableKirim(i);
        });
    
        $(document).on('click', '.remove-tr', function(){
            --i;
            $(this).parents('tr').remove();
            disableKirim(i);
        });

        function disableKirim(i){
            if (i>0) {
                $('#kirim').prop('disabled', false);
            } else {
                $('#kirim').prop('disabled', true);
            }
        }

        function onChangeSelect(url, id, name) {
        // send ajax request to get the cities of the selected province and append to the select tag
        $.ajax({
            url: url,
            type: 'GET',
            data: {
            id: id
            },
            success: function (data) {
            $('#' + name).empty();
            $('#' + name).append('<option value="">==Pilih Ukuran==</option>');
            $.each(data, function (key, value) {
                $('#' + name).append('<option value="' + key + '">' + value + '</option>');
            });
            }
        });
        }
        $('#id').change(function() {
            var id = $(this).val();
            var url = "{{ URL::to('ukuran-dropdown') }}"
            var name = "ukuran";
            onChangeSelect(url,id,name);
            });

            $('#id').on('input change', function() {
                if($(this).val() != '') {
                    nama_bool = true;
                } else {
                    nama_bool = false;
                }
                if (nama_bool && ukuran_bool && jumlah_bool) {
                    $('#add').prop('disabled', false);
                } else {
                    $('#add').prop('disabled', true);
                }
            });

            $('#ukuran').on('input change', function() {
                if($(this).val() != '') {
                    ukuran_bool = true;
                } else {
                    ukuran_bool = false;
                }
                if (nama_bool && ukuran_bool && jumlah_bool) {
                    $('#add').prop('disabled', false);
                } else {
                    $('#add').prop('disabled', true);
                }
            });

            $('#jumlah').on('input change', function() {
                if($(this).val() != '') {
                    jumlah_bool = true;
                } else {
                    jumlah_bool = false;
                }
                if (nama_bool && ukuran_bool && jumlah_bool) {
                    $('#add').prop('disabled', false);
                } else {
                    $('#add').prop('disabled', true);
                }
            });
        });
        
        
</script>
<script>
    $(document).ready(function() {
        $('.form-select').select2();
    });
</script>
@endsection