@extends('index') @section('title', 'Add_Sales') @section('content') 

<div class="row shadow-lg p-3 mb-2 mt-5 bg-body-tertiary rounded d-flex">
    <!-- button Modal -->
   <div class="flex mb-4">

        {{-- hanya super admin --}}
        @if(auth()->user()->role ==='super_admin') 
            <button
                type="button"
                class="btn btn-outline-info col-2"
                data-bs-toggle="modal"
                data-bs-target="#exampleModal"
            >
                Daftar Sales
            </button>
        @endif

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
     

    {{-- modal daftar sales --}}

    <form
        action="{{ url('/sales') }}"
        method="POST"
        enctype="multipart/form-data"
    >
        @csrf
        @method("POST")
       >
        <div
            class="modal fade"
            id="exampleModal"
            tabindex="-1"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">
                            Daftar Sales
                        </h1>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <div class="modal-body">

                        {{-- user_id --}}
                        <div class="mb-3">
                            <label for="user_id" class="form-label">User_id</label>
                            <select class="form-select" aria-label="Default select example" name="user_id" id="user_id">
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                   
                    <div class="modal-footer">
                        <button
                            class="btn btn-primary"
                            type="submit"
                        >
                            Daftar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    {{-- akhir modal --}}

    <table class="table">
        <thead>
            <tr>
                <th scope="col">Nama</th>
                <th scope="col">Number</th>
                <th scope="col">Tanggal Bergabung</th>

                  {{-- hanya super admin --}}
                @if(auth()->user()->role ==='super_admin' || auth()->user()->role ==='sales') 
                    
                    <th scope="col">Aksi</th>
                
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $item)
            <tr>
                <td scope="row">{{ $item->user->name }}</td>
                <td>{{ $item->number }}</td>
                <td>{{ $item->date }}</td>

                {{-- hanya super admin --}}
                 @if(auth()->user()->role ==='super_admin' || auth()->user()->role ==='sales') 
                
                <td>
                    <div class="d-flex ">
                    {{-- delete --}}
                    <form
                        action="{{ url('/sales/'.$item->id) }}"
                        method="POST"
                        enctype="multipart/form-data"
                        onsubmit="return confirm('Apakah anda yakin akan menghapus data ini ?')"
                    >
                        @csrf
                        @method('Delete')
                        <button class="btn btn-danger delete_sales" type="submit" id-sales="{{$item->id}}">Hapus</button>
                    </form>


                    {{-- modal edit --}}
                    <button
                        type="button"
                        class="btn btn-outline-info "
                        data-bs-toggle="modal"
                        data-bs-target="#exampleModal-{{$item->id}}"
                    >
                        Edit
                    </button>

                    @foreach ($data as $dataSales)
                        <form
                            action="{{url('/sales/'.$dataSales->id)}}"
                            method="POST"
                            enctype="multipart/form-data"
                        >
                            @csrf @method('PUT')
                            <!-- Button trigger modal -->
                            <div
                                class="modal fade"
                                id="exampleModal-{{$dataSales->id}}"
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

                                            {{-- number --}}
                                            <div class="mb-3">
                                                <label for="number" class="form-label"
                                                    >Number</label
                                                >
                                                <input
                                                    type="number"
                                                    class="form-control"
                                                    id="number"
                                                    placeholder="123...."
                                                    name = 'number'
                                                    value={{$dataSales->number}}
                                                    readonly
                                                    
                                                />
                                            </div>
                    
                                            {{-- date --}}
                                            <div class="mb-3">
                                                <label for="date" class="form-label"
                                                    >Tanggal Bergabung</label
                                                >
                                                <input
                                                    type="date"
                                                    class="form-control"
                                                    id="date"
                                                    name = 'date'
                                                    value={{$dataSales->date}}
                                                    readonly
                                                />
                                            </div>
                    
                                            {{-- user_id --}}
                                            <div class="mb-3">
                                                <label for="user_id" class="form-label">User_id</label>
                                                <select class="form-select" aria-label="Default select example" name="user_id" id="user_id">
                                                    @foreach ($users as $user)
                                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                    @endforeach
                                                </select>
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
                            </div>
                        </form>
                    @endforeach
                    {{-- akhir modal --}}
                </div>
                </td>
                @endif
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
