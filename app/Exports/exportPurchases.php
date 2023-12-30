<?php

namespace App\Exports;

use App\Models\Purchases_details;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class exportPurchases implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect(Purchases_details::getAllPurchases());
    }

    public function headings():array {
        return [
            'id','purchase_id', 'inventory_id', 'qty', 'price',   'createAt', 'updateAt'
        ];
    }
}
