@extends('index') @section('title', 'Dashboard') @section('content')

<div class="row justify-content-around">
    <!-- card -->
    @forelse ($data as $item)
    <div
        class="card p-2 my-5 shadow-lg p-3 mb-5 bg-body-tertiary rounded"
        style="width: 18rem"
    >
        <img
            src="https://s2.bukalapak.com/uploads/content_attachment/25b2545020e8d7621b5d51c5/original/main_investasi_barang_antik_piring_shutterstock.jpg"
            class="card-img-top"
            alt="..."
        />
        <div class="card-body">
            <h5>{{$item->name}}</h5>
            <p>
                <span class="fw-bold text-secondary">Code Produk : </span><br />
                {{ $item->code }}
            </p>

            {{-- format ke rupiah --}}
            @php 
                $integerValue = $item->price; $formattedValue =
                number_format($integerValue, 0, ',', '.'); 
            @endphp

            <p>
                <span class="fw-bold text-secondary">Harga Produk : </span
                ><br />Rp {{ $formattedValue }}
            </p>

            {{-- penegecekan produk habis --}}
            @if ($item->stock == 0) 
                <p class="text-danger fw-bold">Habis</p>    
            @endif

               
            <!-- Modal detail-->
            <div class="row bg-white">

                {{-- hanya purchase dan super admin --}}
                @if (auth()->check() && auth()->user()->role ==='purchase' || auth()->user()->role ==='super_admin') 
                    <button
                        type="button"
                        class="btn btn-outline-info col-12"
                        data-bs-toggle="modal"
                        data-bs-target="#exampleModal-{{$item->id}}"
                    >
                        Lihat Details
                    </button>
                @endif

                @foreach ($data as $dataProduct)
                <form
                    action="{{url('purchases')}}"
                    method="POST" 
                    enctype="multipart/form-data"
                >
                @csrf 
                    <input type="hidden" name='inventory_id' value={{$dataProduct->id}}>
                    <input type="hidden" name='price' value={{$dataProduct->price}}>
                    <div
                        class="modal fade"
                        id="exampleModal-{{$dataProduct->id}}"
                        tabindex="-1"
                        aria-labelledby="exampleModalLabel"
                        aria-hidden="true"
                    >
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1
                                        class="modal-title fs-5"
                                        id="exampleModalLabel"
                                    >
                                        Deskripsi Produk
                                    </h1>
                                    <button
                                        type="button"
                                        class="btn-close"
                                        data-bs-dismiss="modal"
                                        aria-label="Close"
                                    ></button>
                                </div>
                                <div class="modal-body">
                                    {{-- nama --}}
                                    <p>
                                        <span class="fw-bold">Nama : </span
                                        ><br />
                                        {{ $dataProduct->name }}
                                    </p>

                                    {{-- price --}}
                                    @php $Price = $dataProduct->price;
                                    $formatTotalPrice = number_format($Price, 0,
                                    ',', '.'); @endphp
                                    <p>
                                        <span class="fw-bold">Harga : </span
                                        ><br />Rp {{ $formatTotalPrice }}
                                    </p>

                                    {{-- qty --}}
                                    <div class="mb-3">
                                        <label for="qty" class="form-label fw-bold">Tambah Qty</label>
                                        <input  class="form-control" type="number" name="qty" id="qty" value="1" min="1" max={{$dataProduct->stock}} required>
                                    </div>

                                    {{-- deskri --}}
                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Corrupti, facere. Vitae totam ratione aliquam id odio cum recusandae nemo atque commodi expedita cupiditate dolor enim asperiores, ullam consectetur illum nisi?</p>
                                </div>                                
                                
                                <div class="modal-footer">
                                    <button
                                        class="btn btn-primary"
                                        type="submit"
                                    >
                                        +Keranjang
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                @endforeach
                {{-- akhir modal --}}
            </div>
        </div>
    </div>
    @empty
    <p>data belum tersedia</p>
    @endforelse
    {{ $data->withQueryString()->links()}}
</div>

@endsection
