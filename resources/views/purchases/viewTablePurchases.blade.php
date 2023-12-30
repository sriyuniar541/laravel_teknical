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
                <tr id="inventory_id{{ $item->id}}">
                   
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
                {{ $data->withQueryString()->links()}}
            </tbody>
        </table>

</div>

<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"
></script>
</body>
</html>