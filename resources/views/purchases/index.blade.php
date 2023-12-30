@extends('index') @section('title', 'Keranjang') @section('content')

<div class="row shadow-lg p-3 mb-2 mt-5 bg-body-tertiary rounded d-flex">
    
    {{-- export pdf, excel, csv --}}
    <div class="flex mb-4">
        @if(auth()->user()->role ==='sales' || auth()->user()->role ==='super_admin')
            <a href="/purchases/exportExcel">
                <button class="btn btn-info text-white" type="submit">Export Excel</button>
            </a>

            <a href="/purchases/exportPdf" target="_blank">
                <button class="btn btn-info text-white">Export PDF</button>
            </a>

            <a href="/purchases/exportCsv" target="_blank">
                <button class="btn btn-info text-white">Export CSV</button>
            </a>
        @endif
    </div>
    
    <table class="table">
        <thead>
            <tr>
                <th scope="col">Nomor Barang</th>
                <th scope="col">Nama</th>
                <th scope="col">Tanggal pesanan</th>
                <th scope="col">Harga</th>
                <th scope="col">Qty</th>
                @if(auth()->user()->role ==='purchase' || auth()->user()->role ==='super_admin')
                <th scope="col">Aksi</th>
                @endif
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
                @if(auth()->user()->role ==='purchase' || auth()->user()->role ==='super_admin')
                <td class="d-flex">

                    @if ($item->status_bayar == 0 && $item->inventory->stock > 0)

                    {{-- update stock --}}
                    <form action="{{ url('/product/stock/'.$item->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <button class="btn btn-info text-white" type="submit">Bayar</button>
                        <input type="hidden" value="{{$item->id}}" name='id_detail'>
                        <input type="hidden" value="{{$item->qty}}" name='qty'>
                        <input type="hidden" value="{{$item->inventory_id}}" name='inventory_id'>
                        <input type="hidden" value="{{$item->inventory->stock}}" name='stock'>
                    </form>


                    {{-- modal edit --}}
                    
                    <button type="button" class="btn btn-outline-info " data-bs-toggle="modal"
                        data-bs-target="#exampleModal-{{$item->id}}">
                         +qty
                    </button>

                    @foreach ($data as $dataProduct)
                    <form action="{{url('/purchases/'.$dataProduct->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf @method('PUT')
                        <!-- Button trigger modal -->
                        <div class="modal fade" id="exampleModal-{{$dataProduct->id}}" tabindex="-1"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">
                                            Edit Produk
                                        </h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        {{-- code --}}
                                        <div class="mb-3">
                                            <label for="code" class="form-label">Kode Produk</label>
                                            <input type="text" class="form-control" id="code" name='code'
                                                value={{$dataProduct->inventory->code}}
                                            readonly

                                            />
                                        </div>

                                        {{-- name --}}
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Nama Produk</label>
                                            <input type="text" class="form-control" id="name" name='name' {{--
                                                value={{$dataProduct->name}} --}}
                                            value={{$dataProduct->inventory->name}}
                                            readonly
                                            />
                                        </div>

                                        {{-- price --}}
                                        <div class="mb-3">
                                            <label for="price" class="form-label">Harga</label>
                                            <input type="number" class="form-control" id="price" name='price'
                                                value={{$dataProduct->price}}
                                            readonly
                                            />
                                        </div>

                                        {{-- qty --}}
                                        <div class="mb-3">
                                            <label for="qty" class="form-label">Qty</label>
                                            <input type="number" class="form-control" id="qty" name='qty'
                                                value={{$dataProduct->qty}}
                                            min=1
                                            max={{$dataProduct->inventory->stock}}
                                            required
                                            />
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-primary" type="submit">
                                            Save
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                @endforeach

                {{-- penegecekan stok --}}
                @elseif($item->inventory->stock === 0)
                    <button class="btn btn-outline-danger text-danger" type="submit">Habis</button>
                @else
                    {{-- tombol dasboard --}}
                    <a href="/">
                        <button class="btn btn-outline-info text-info" type="submit">Beli Lagi</button>
                    </a>

                    {{-- hapus pembelian --}}

                    <form action="{{ url('/purchases/'.$item->id) }}" method="POST"
                        enctype="multipart/form-data"
                        onsubmit="return confirm('Apakah anda yakin akan menghapus data ini ?')"
                        >
                        @csrf
                        @method('Delete')
                        <button class="btn btn-outline-danger text-danger delete_pur" id-pur={{$item->id}} type="submit">Hapus</button>
                        <input type="hidden" value="{{$item->purchase_id}}" name='purchase_id'>
                    </form>
                @endif
            {{-- akhir modal --}}
            </td>
        @endif
        </tr>

    {{-- @endif --}}
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