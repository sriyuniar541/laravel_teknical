<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Shop App - @yield('title')</title>
        <link
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            rel="stylesheet"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
            crossorigin="anonymous"
        />
        <script src="https://code.jquery.com/jquery-3.7.1.slim.js" integrity="sha256-UgvvN8vBkgO0luPSUl2s8TIlOSYRoGFAX4jlCIm9Adc=" crossorigin="anonymous"></script>
      

    </head>
    <body>
        <div class="container">

            <!-- navbar -->
            <div class="row shadow-lg p-3 mb-2 bg-body-tertiary rounded d-flex">
                <ul class="nav">

                    {{-- link home --}}
                    <li class="nav-item">
                        <a
                            class="nav-link active fs-4 border rounded"
                            aria-current="page"
                            href="/"
                            >Shop</a
                        >
                    </li>

                    @if (Auth::check())

                        {{-- role super admin --}}
                        @if(auth()->user()->role ==='super_admin') 
                            <li class="nav-item">
                                <a
                                    class="nav-link active"
                                    aria-current="page"
                                    href="{{ url('/product/addProduct') }}"
                                    >Mulai Jual</a
                                >
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/purchases') }}"
                                    >Pembelian</a
                                >
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/sales') }}"
                                    > Sales</a
                                >
                            </li>

                        @endif


                        {{-- manager --}}
                        @if( auth()->user()->role ==='manager') 
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/sales/viewSales') }}"
                                    > Daftar Sales</a
                                >
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/purchases/viewPurchases') }}"
                                    > Daftar Pembelian</a
                                >
                            </li>

                        @endif


                        {{-- role purchases --}}
                        @if( auth()->user()->role ==='purchase') 
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/purchases/purc/get') }}"
                                    > Keranjang</a
                                >
                            </li>
                        @endif
                    

                        {{-- role sales --}}
                        @if( auth()->user()->role ==='sales') 
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/product/sal/addProduct') }}"
                                    > Penjualan</a
                                >
                            </li>
                        @endif



                        {{-- profile --}}
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('user/profile') }}"
                                >Profile</a
                            >
                        </li>

                        
                        {{-- logout --}}
                          <li class="nav-item">
                            <a class="nav-link" href="{{ url('/user/logout') }}"
                                >logout</a
                            >
                        </li>

                         {{-- search --}}
                         <li class="nav-item ">
                            <form
                                class="d-flex "
                                role="search"
                                method="GET"
                                action="{{ url('/') }}"
                            >
                                {{-- search --}}
                                <input
                                    class="form-control me-2"
                                    type="search"
                                    placeholder="Search "
                                    aria-label="Search"
                                    name="katakunci"
                                    value="{{Request::get('katakunci')}}"
                                />

                                <button
                                    class="btn btn-outline-primary"
                                    type="submit"
                                >
                                    Search
                                </button>
                            </form>
                        </li>   
                        
                    @else
                        
                        {{-- login --}}
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/user/login') }}"
                                >login</a
                            >
                        </li>

                    @endif

                </ul>
            </div>
            <!-- akhir navbar -->

            @yield('content')
        </div>

        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
            crossorigin="anonymous"
        ></script>

        {{-- sweet Allert --}}
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

        @include('sweetalert::alert')

        {{-- jquery --}}
        {{-- <script src="https://code.jquery.com/jquery-3.7.1.slim.js" integrity="sha256-UgvvN8vBkgO0luPSUl2s8TIlOSYRoGFAX4jlCIm9Adc=" crossorigin="anonymous"></script> --}}
    </body>
</html>
