<?php

namespace App\Exports;

use App\Models\Inventories;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class exportInventory implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect(Inventories::getAllInventory());
    }

    public function headings():array {
        return [
            'id',
            'Kode Produk',
            'Nama Produk',
            'Harga Produk',
            'stok',
            'createAt',
            'updateAt'
        ];
    }
}
