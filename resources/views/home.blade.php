@extends('layouts.main')


@section('content')
<div class="d-flex align-items-center justify-content-center my-auto" style="height: 80vh">
    <div>
        <div class="text-center">
            <img style="max-width: 100%; height: auto" class="rounded" src="{{ asset('/images/logo.jpg') }}"> 
        </div>
        <h1 class="text-center">Selamat Datang {{ Auth::user()->nama }}</h1>
        <h1 class="text-center">Di cabang {{ Session::get('cabang') }}</h1>
    </div>
</div> 
@endsection