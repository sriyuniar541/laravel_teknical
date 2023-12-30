<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales_details extends Model
{
    use HasFactory;
    protected $fillable = [
        'sales_id', 'inventory_id', 'qty', 'price'
    ];
    protected $table = 'sales_details';

    public function sales()
    {
        return $this->belongsTo(Sales::class);
    }

    public function inventories()
    {
        return $this->belongsTo(Inventories::class);
    }
}
