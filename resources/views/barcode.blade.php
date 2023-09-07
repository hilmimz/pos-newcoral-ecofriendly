<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<body>
	<style>
		table.table tbody tr td,
		table.table thead tr th,
		table.table thead {
		border-left: 1px solid rgb(177, 177, 177);
		border-right: 1px solid rgb(177, 177, 177);
		}
	</style>
	<h4 style="text-align: center">{{ $ukuran_produk->product->nama }} | {{ $ukuran_produk->product->warnabaju->nama }} | {{ $ukuran_produk->product->bahan->nama }} | {{ $ukuran_produk->ukuran->nama }}</h4>
	@php
		$i = 0;
	@endphp
	<table class="table">
		<tbody>
	@while ($i <= 7)
		@php
			$i = $i+1;
		@endphp
			  <tr>
				<td style="width: 50%">
					<div style="text-align: center">
						<p style="font-size: 50%" class="mb-0 mx-2">{{ $ukuran_produk->product->nama }} | {{ $ukuran_produk->product->warnabaju->nama }} | {{ $ukuran_produk->product->bahan->nama }} | {{ $ukuran_produk->ukuran->nama }} </p>
						<img style="width: 60%" src="data:image/png;base64,{!! DNS1D::getBarcodePNG($ukuran_produk->kode_produk, 'C128') !!}" alt="barcode"   />
						<p style="font-size: 50%" class="mt-0">{{ $ukuran_produk->kode_produk }}</p>
					</div>
				</td>
				<td style="width: 50%">
					<div style="text-align: center">
						<p style="font-size: 50%" class="mb-0 mx-2">{{ $ukuran_produk->product->nama }} | {{ $ukuran_produk->product->warnabaju->nama }} | {{ $ukuran_produk->product->bahan->nama }} | {{ $ukuran_produk->ukuran->nama }} </p>
						<img style="width: 60%" src="data:image/png;base64,{!! DNS1D::getBarcodePNG($ukuran_produk->kode_produk, 'C128') !!}" alt="barcode"   />
						<p style="font-size: 50%" class="mt-0">{{ $ukuran_produk->kode_produk }}</p>
					</div>
				</td>
				<td style="width: 50%">
					<div style="text-align: center">
						<p style="font-size: 50%" class="mb-0 mx-2">{{ $ukuran_produk->product->nama }} | {{ $ukuran_produk->product->warnabaju->nama }} | {{ $ukuran_produk->product->bahan->nama }} | {{ $ukuran_produk->ukuran->nama }} </p>
						<img style="width: 60%" src="data:image/png;base64,{!! DNS1D::getBarcodePNG($ukuran_produk->kode_produk, 'C128') !!}" alt="barcode"   />
						<p style="font-size: 50%" class="mt-0">{{ $ukuran_produk->kode_produk }}</p>
					</div>
				</td>
			  </tr>
		{{-- <p>{{ $ukuran_produk->product->nama }} | {{ $ukuran_produk->product->bahan->nama }} | {{ $ukuran_produk->product->warnabaju->nama }} | {{ $ukuran_produk->ukuran->nama }} </p>
		<img src="data:image/png;base64,{!! DNS1D::getBarcodePNG($ukuran_produk->kode_produk, 'C128') !!}" alt="barcode"   /> --}}
	@endwhile
		</tbody>
	</table>
</body>
</html>