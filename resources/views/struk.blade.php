<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	{{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> --}}
</head>
<body>
	<style type="text/css">
		* {
		margin: 0;
		padding: 0;
		}
		table tr td,
		table tr th{
			font-size: 6pt;
		}
		table{
			border-collapse: separate; 
  			border-spacing: 0.5em;
		}
		#page td {
		padding: 0; 
		margin: 0;
		}
		body {
			font-family: sans-serif !important;
		}
		h5 {
			margin:0;
		}
	</style>
	<center>
		{{-- <img style="width: 10px" src="{{ url('images/logo_bnw.png') }}">  --}}
		<img src="data:image/png;base64, {{ $image }}" alt="logo" style="width: 250px"/>
		<h4 style="display: inline-block">Newcoral Ecofriendly</h4>
		<br>
		{{-- <h5>Newcoral.id</h5> --}}
		<div style="text-align: left;font-size: 6pt">
			<p>Tanggal	: {{ now()->toDateTimeString() }}</p>
			<p>Cabang: {{ Session::get('cabang') }}</p>
			<p>Kasir: {{ Auth::user()->nama }}</p>
		</div>
	
		<hr>
	<table style="width: 100%">
		<tbody style="width: 100%">
			@php $i=0 @endphp
			@foreach($produk as $p)
			@php $i++ @endphp
			<tr style="padding-bottom: 1.4em">
				<td style="width: 72%;text-align: justify">{{$p['nama_produk']}} | Warna: {{ $p['warna_produk'] }} | Bahan: {{ $p['bahan_produk'] }}</td>
				<td style="width: 5%">{{$p['jumlah']}}</td>
				<td style="width: 23%;text-align: right">@currency($p['harga_produk'])</td>
			</tr>
			@endforeach
		</tbody>
	</table>
	<hr>
	<div style="text-align: left;font-size: 6pt;">
		<p style="display: inline">Total Item: </p>
		<p style="display: inline; text-align: right">{{ $total_item }}</p>
		<br>
		<br>
		<p style="display: inline">Total Harga: </p>
		<p style="display: inline; text-align: right">@currency($total_harga)</p>
		<br>
		<br>
		<p style="display: inline">Metode Pembayaran: </p>
		<p style="display: inline; text-align: right">{{ $pembayaran }}</p>
	</div>
	<hr>
	<div style="font-size: 6pt">
		<p>Terima Kasih Atas Kunjungan Anda</p>
		<p>Follow IG @newcoral.id</p>
		<p>linktr.ee/newcoral</p>
	</div>
</center>
 
</body>
</html>