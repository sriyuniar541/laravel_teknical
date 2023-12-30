@extends('index') @section('title', 'Daftar Sales') @section('content')
<div class="row shadow-lg p-3 mb-2 mt-5 bg-body-tertiary rounded d-flex">
   
    <!-- button Modal -->
   <div class="flex mb-4">

        {{-- export-excel --}}
        <a href="/sales/exportExcel">
            <button class="btn btn-info text-white" type="submit" >Export Excel</button>
        </a>

        {{-- export-pdf --}}
        <a href="/sales/exportPdf" target="_blank">
            <button class="btn btn-info text-white" >Export PDF</button>
        </a>

        {{-- export CSV --}}
        <a href="/sales/exportCsv" target="_blank">
            <button class="btn btn-info text-white" >Export CSV</button>
        </a>
   </div>
    
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Nama</th>
                <th scope="col">Number</th>
                <th scope="col">Tanggal Bergabung</th>

            </tr>
        </thead>
        <tbody>
            @forelse ($data as $item)
            <tr>
                <td scope="row">{{ $item->user->name }}</td>
                <td>{{ $item->number }}</td>
                <td>{{ $item->date }}</td>
            </tr>
            @empty
            <p>data belum tersedia</p>
            @endforelse
        </tbody>
    </table>
    <div class="d-flex justify-content-center">
        {{ $data->withQueryString()->links()}}
    </div>  
</div>
@endsection
