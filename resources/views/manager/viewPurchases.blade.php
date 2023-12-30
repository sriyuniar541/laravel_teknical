@extends('index') @section('title', 'Daftar Pembelian') @section('content')

<div class="row shadow-lg p-3 mb-2 mt-5 bg-body-tertiary rounded d-flex">
    
    {{-- export pdf, excel, csv --}}
    <div class="flex mb-4">
            <a href="/purchases/exportExcel">
                <button class="btn btn-info text-white" type="submit">Export Excel</button>
            </a>

            <a href="/purchases/exportPdf" target="_blank">
                <button class="btn btn-info text-white">Export PDF</button>
            </a>

            <a href="/purchases/exportCsv" target="_blank">
                <button class="btn btn-info text-white">Export CSV</button>
            </a>
        
    </div>
    
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Nomor Barang</th>
                <th scope="col">Nama</th>
                <th scope="col">Tanggal pesanan</th>
                <th scope="col">Harga</th>
                <th scope="col">Qty</th>
            </tr>
        </thead>
        <tbody>

            @forelse ($data as $item)
            <tr>
                <td scope="row">{{ $item->purchase->number }}</td>
                <td>{{ $item->inventory->name }}</td>
                <td>{{ $item->purchase->date }}</td>

                @php $Price = $item->price;
                $formatTotalPrice = number_format($Price, 0, ',', '.');
                @endphp

                <td>Rp. {{ $formatTotalPrice }}</td>
                <td>{{ $item->qty }}</td>
    
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
