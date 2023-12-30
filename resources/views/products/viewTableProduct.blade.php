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
    </head>
    <body>


<table class="table table-bordered">
    <thead>
        <tr>
            <th scope="col">Code</th>
            <th scope="col">Nama</th>
            <th scope="col">Harga</th>
            <th scope="col">Stock</th>
            {{-- <th scope="col">Aksi</th> --}}
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
           
        </tr>
        @empty
        <p>data belum tersedia</p>
        @endforelse
        {{-- {{ $data->withQueryString()->links()}} --}}
    </tbody>
</table>

</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>
</html>