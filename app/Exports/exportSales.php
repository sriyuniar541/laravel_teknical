<?php

namespace App\Exports;

use App\Models\Sales;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class exportSales implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect(Sales::getAllSales());
    }

    public function headings():array {
        return [
            'id',
            'number',
            'date',
            'user_id',
            'createAt',
            'updateAt',
           
        ];
    }
}
