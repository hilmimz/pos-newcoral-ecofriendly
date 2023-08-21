@extends('layouts.main')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Input Penjualan</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('home.index') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Input Penjualan</li>
    </ol>
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{session('success')}}
        <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
    @endif
        <label for="barcode-input">Kode Barang: </label>
        <input type="text" id="barcode-input" class="form-control mb-2" autofocus> 
        <table class="table table-bordered mb-4" id="dynamicTable2">  
            <tr>
                <th style="width:40%">Nama Produk</th>
                <th>Ukuran Produk</th>
                <th>Jumlah Produk</th>
                <th>Action</th>
            </tr>
            <tr>
                <td>
                    <select class="form-select" aria-label="Pilih nama produk" name="id" id="id" style="width: 100%">
                        <option value="">==Pilih Produk==</option>
                        @foreach ($products as $product)
                        <option value="{{ $product->product_id }}">{{ $product->nama }} | {{ $product->warnabaju->nama }} | {{ $product->bahan->nama }}</option>
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
            </tr>
        </table>
    <h5>Daftar barang</h5>
    <form action="{{ route('inputpenjualan.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="nama_produk">Metode Pembayaran</label>
            <select class="form-select mb-2" aria-label="Pilih cabang tujuan" name="metode_pembayaran">
                @foreach ($metode_pembayarans as $metode_pembayaran)
                <option value="{{ $metode_pembayaran->metode_pembayaran_id }}">{{ $metode_pembayaran->nama }}</option>
                @endforeach
            </select>
        <table class="table table-bordered mt-2" id="dynamicTable">  
            <tr>
                <th style="width:35%">Nama Produk</th>
                <th>Ukuran Produk</th>
                <th style="width: 15%">Jumlah Produk</th>
                <th style="width: 15%">Harga</th>
                <th style="width: 15%">Total</th>
                <th>Action</th>
            </tr>
        </table>
        <h5>Total Harga:</h5>
        <div id="total_harga"></div>
        <button type="submit" class="btn btn-primary mt-3" name="kirim" id="kirim" disabled>Input</button>
    </form>
    
</div>


@endsection

@section('scripts')
<script type="text/javascript">
    $(document).ready(function() {
        var i = 0;
        // var nama_bool = false;
        // var ukuran_bool = false;
        // var jumlah_bool = false;
        var total_harga = 0;

        function getHarga(prod_id, ukuran_id, handleData) {
        $.ajax({
            url: "{{ URL::to('get-harga') }}",
            type: 'GET',
            data: {
            prod_id: prod_id,
            ukuran_id: ukuran_id
            },
            success: function (data) {
                handleData(data)
            }
        });
        }

        function jq( myid ) {
            let id = "#" + myid.replace( /(:|\.|\[|\]|,|=|@)/g, "\\$1" );
            console.log(id);
            return id;
        }

        $('#barcode-input').keypress(function(e) {
            if (e.key === 'Enter') {
                $.ajax({
                    url: "{{ URL::to('kode-produk') }}",
                    type: 'GET',
                    data: {
                        kode: $(this).val()
                    },
                    success: function(data) {
                        var id = data.prod_id;
                        var url = "{{ URL::to('ukuran-dropdown') }}"
                        var name = "ukuran";
                        $('#id').val(id).trigger('change');
                        setTimeout(function() {
                            onChangeSelect(url,id,name,data.ukuran_id);
                        }, 500);
                        $('#jumlah').val(1).trigger('focus');
                    }
                });
                $('#barcode-input').val('');
            }
        });

        $("#add").click(function(){
            var id_produk = $('#id').val();
            var nama_produk = $('#id option:selected').text();
            var ukuran_produk = $('#ukuran').val();
            var nama_ukuran = $('#ukuran option:selected').text();
            var jumlah_produk = $('#jumlah').val();
    
            // console.log(nama_produk);
            $(document).ready(function() {
                $('.form-select').select2();
            });
            getHarga(id_produk,ukuran_produk, function(harga){
    
            // $("#dynamicTable").append('<tr><td><select class="form-select" aria-label="Pilih nama produk" name="addmore['+i+'][id_produk]" id="addmore['+i+'][id_produk]" style="width: 100%"><option>==Pilih Ukuran==</option>@foreach ($products as $product)<option value="{{ $product->product_id }}">{{ $product->nama }}</option>@endforeach</select></td><td><select class="form-select" aria-label="Pilih nama produk" name="addmore['+i+'][ukuran_produk]" id="addmore['+i+'][ukuran_produk]" style="width: 100%"><option>==Pilih Ukuran==</option></select></td><td><input type="text" name="addmore['+i+'][jumlah_produk]" placeholder="Masukkan jumlah" class="form-control" /></td><td><button type="button" class="btn btn-danger remove-tr">Remove</button></td></tr>');
            
                $("#dynamicTable").append('<tr><td><select class="form-select" name="addmore['+i+'][nama_produk]" id="addmore['+i+'][nama_produk]" style="width: 100%" required disabled="disabled"><option value="'+id_produk+'">'+nama_produk+'</option></select><input type="hidden" name="addmore['+i+'][nama_produk]" id="addmore['+i+'][nama_produk]" value="'+id_produk+'" /></td><td><select class="form-select" name="addmore['+i+'][ukuran_produk]" id="addmore['+i+'][ukuran_produk]" style="width: 100%" required disabled="disabled"><option value="'+ukuran_produk+'">'+nama_ukuran+'</option></select><input type="hidden" name="addmore['+i+'][ukuran_produk]" id="addmore['+i+'][ukuran_produk]" value="'+ukuran_produk+'" /></td> <td><input type="text" name="addmore['+i+'][jumlah_produk] id="addmore['+i+'][jumlah_produk]" readonly="readonly" value="'+jumlah_produk+'"></td> <td><input type="text" name="addmore['+i+'][harga_produk]" readonly="readonly" value="'+harga+'"></td> <td><input type="text" class="total-harga-item" name="addmore['+i+'][total]" id="addmore['+i+'][total]" readonly="readonly" value="'+jumlah_produk*harga+'"></td> <td><button type="button" class="btn btn-danger remove-tr">Remove</button></td></tr>');
                ++i;
                disableKirim(i);

                calculateTotalHarga();
                
            });
            $('#barcode-input').trigger('focus');
        });
    
        $(document).on('click', '.remove-tr', function(){
            --i;
            $(this).parents('tr').remove();
            disableKirim(i);
            calculateTotalHarga();
        });
        
        $("#cek").click(function () { 
                    var idfield = jq("addmore[1][total]")
                    var tes = $(idfield).val();
                    console.log(tes);
                })

        function disableKirim(i){
            if (i>0) {
                $('#kirim').prop('disabled', false);
            } else {
                $('#kirim').prop('disabled', true);
            }
        }

        function calculateTotalHarga() {
            var total = 0;
            $('.total-harga-item').each(function() {
                total += Number($(this).val());
            });
            $('#total_harga').text(total);
        }

        function onChangeSelect(url, id, name, ukuranId) {
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
            // console.log(data)
            if (typeof(ukuranId) !== 'undefined') {
                $('#' + name).val(ukuranId).trigger('change');
            }
            }
        });
        }

        $('#id').change(function() {
            var id = $(this).val();
            var url = "{{ URL::to('ukuran-dropdown') }}"
            var name = "ukuran";
            onChangeSelect(url,id,name);
            });

            $('#id, #ukuran, #jumlah').on('input change', function() {
                var nama_bool = $('#id').val() !== '';
                var ukuran_bool = $('#ukuran').val() !== '';
                var jumlah_bool = $('#jumlah').val() !== '' && $('#jumlah').val() > 0;
                if (nama_bool && ukuran_bool && jumlah_bool) {
                    $('#add').prop('disabled', false);
                } else {
                    $('#add').prop('disabled', true);
                }
            });

            /*$('#id').on('input change', function() {
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
            });*/
        });
        
        
</script>
<script>
    $(document).ready(function() {
        $('.form-select').select2();
    });
</script>
@endsection