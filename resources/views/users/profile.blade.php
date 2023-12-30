@extends('index') @section('title', 'Profile') @section('content') 

<div class="row shadow-lg p-3 mb-2 bg-body-tertiary rounded d-flex mt-5">
    <div class="border rounded p-2">
        <h2 class="text-secondary text-center pb-5"><u>Data Diri</u> </h2>
        <p><span class="fw-bold">Nama Lengkap   : </span> {{auth()->user()->name}}</p>
        <p><span class="fw-bold">Alamat Email  : </span> {{auth()->user()->email}}</p>
        <p><span class="fw-bold">Nomor HP  : </span> 012334445612</p>
        <p><span class="fw-bold">Role  : </span> {{auth()->user()->role}}</p>
        <p><span class="fw-bold">Tanggal Bergabung  : </span> {{auth()->user()->created_at}}</p>
    </div>
</div>

@endsection