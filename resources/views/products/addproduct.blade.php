@extends('index') @section('title', 'Add_Product') @section('content') 

<div class="row shadow-lg p-3 mb-2 mt-5 bg-body-tertiary rounded d-flex">
    <!-- Modal -->
    <div class="d-flex">

        {{-- export-excel --}}
        <a href="/product/exportExcel">
            <button class="btn btn-info text-white me-2" type="submit" >Export Excel</button>
        </a>

        {{-- export-pdf --}}
        <a href="/product/exportPdf" target="_blank">
            <button class="btn btn-info text-white me-2" >Export PDF</button>
        </a>

        {{-- export CSV --}}
        <a href="/product/exportCsv" target="_blank">
            <button class="btn btn-info text-white" >Export CSV</button>
        </a>      

    </div>  

    
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">Code</th>
                <th scope="col">Nama</th>
                <th scope="col">Harga</th>
                <th scope="col">Stock</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $item)
            <tr>
                <td scope="row">{{ $item->code }}</td>
                <td>{{ $item->name }}</td>
                
                @php $Price = $item->price;
                    $formatTotalPrice = number_format($Price, 0, ',', '.'); 
                @endphp

                <td>Rp. {{ $formatTotalPrice }}</td>
                <td>{{ $item->stock }}</td>
                <td>

                    <div class="d-flex">
                    {{-- delete --}}

                    <form method="POST"   onsubmit="return confirm('Apakah anda yakin akan menghapus data ini ?')" enctype="multipart/form-data" action="{{ url('/product/'.$item->id) }}">
                        @csrf
                        @method('DELETE')
                        
                        <button class="btn btn-danger delete" type="submit" id-barang="{{$item->id}}">Hapus</button>
                    </form>
                    

                {{-- modal edit --}}
                <button
                    type="button"
                    class="btn btn-outline-info "
                    data-bs-toggle="modal"
                    data-bs-target="#exampleModal-{{$item->id}}"
                > Edit
                </button>

                @foreach ($data as $dataProduct)
                <form
                    action="{{url('/product/'.$dataProduct->id)}}"
                    method="POST"
                    enctype="multipart/form-data"
                >
                    @csrf @method('PUT')
                    <!-- Button trigger modal -->
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
                                        Edit Produk
                                    </h1>
                                    <button
                                        type="button"
                                        class="btn-close"
                                        data-bs-dismiss="modal"
                                        aria-label="Close"
                                    ></button>
                                </div>

                                <div class="modal-body">
                                    {{-- code --}}
                                    <div class="mb-3">
                                        <label for="code" class="form-label"
                                            >Kode Produk</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="code"
                                            name = 'code'
                                            value={{$dataProduct->code}}
                                            required

                                        />
                                    </div>

                                    {{-- name --}}
                                    <div class="mb-3">
                                        <label for="name" class="form-label"
                                            >Nama Produk</label
                                        >
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="name"
                                            name = 'name'
                                            value={{$dataProduct->name}}
                                            required
                                        />
                                    </div>

                                    {{-- price --}}
                                    <div class="mb-3">
                                        <label for="price" class="form-label">Harga</label>
                                        <input
                                            type="number"
                                            class="form-control"
                                            id="price"
                                            name = 'price'
                                            value={{$dataProduct->price}}
                                            required
                                        />
                                    </div>

                                    {{-- stock --}}
                                    <div class="mb-3">
                                        <label for="stock" class="form-label">Stok</label>
                                        <input
                                            type="number"
                                            class="form-control"
                                            id="stock"
                                            name = 'stock'
                                            value={{$dataProduct->stock}}
                                            required
                                        />
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button
                                        class="btn btn-primary"
                                        type="submit"
                                    >
                                        Save
                                    </button>
                                </div>

                            </div>                          
            
                        </div>
                    </div>
                {{-- </div> --}}
                </form>
            </div>
            @endforeach
            {{-- akhir modal --}}

            </td>
            </tr>
            @empty
                <p>data belum tersedia</p>
            @endforelse
        </tbody>
    </table>
    <div class="d-flex justify-content-center">
        {{ $data->withQueryString()->links()}}
    </div>  

    <h4 class="mt-5">Jual Produk</h4>
    <form
        action="{{ url('/product') }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf
        @method("POST")

        <table class="table" id="table">
            <thead>
            <tr>
                <th scope="col">Code</th>
                <th scope="col">Nama</th>
                <th scope="col">Harga</th>
                <th scope="col">Stock</th>
            <th scope="col">Aksi</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>
                    <input
                        type="text"
                        class="form-control"
                        id="code"
                        {{-- placeholder="ABC123" --}}
                        name = "inputs[0][code]"
                        required
                    />
                </td>
                <td>
                    <input
                        type="text"
                        class="form-control"
                        id="name"
                        {{-- placeholder="Baju..." --}}
                        name = "inputs[0][name]"
                        required
                    />
                </td>
                <td>
                    <input
                        type="number"
                        class="form-control"
                        id="price"
                        {{-- placeholder="100000" --}}
                        name = "inputs[0][price]"
                        required
                    />
                </td>
                <td>
                    <input
                        type="number"
                        class="form-control"
                        id="stock"
                        {{-- placeholder="50" --}}
                        name = "inputs[0][stock]"
                        required
                    />
                </td>
                <td><button type="button" name="add" id="add" class="btn btn-outline-info col-lg-10">Insert multi</button></td>
            </tr>
            </tbody>
        </table>
        <button class="btn btn-info text-white">Save</button>
    </form>
</div>

<script>
    var i = 0;

    $('#add').click(function(){
        ++i;
        $('#table').append(
            `
            <tr>
                <td>
                    <input
                        type="text"
                        class="form-control"
                        name="inputs[${i}][code]"
                    />
                </td>
                <td>
                    <input
                        type="text"
                        class="form-control"
                        name="inputs[${i}][name]"
                    />
                </td>
                <td>
                    <input
                        type="number"
                        class="form-control"
                        name="inputs[${i}][price]"
                    />
                </td>
                <td>
                    <input
                        type="number"
                        class="form-control"
                        name="inputs[${i}][stock]"
                    />
                </td>
                <td>
                    <button type="button" class="remove-table-row btn btn-outline-danger col-lg-10">Remove</button>
                </td>
            </tr>
            `
        );

        // Add event listener for the "Remove" button in the new row
        $('.remove-table-row').last().click(function () {
            $(this).closest('tr').remove();
        });
    });
</script>


@endsection
