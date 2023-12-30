<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Inventories extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'name', 'price', 'stock'
    ];
    protected $table = 'inventories';

    public function sales_details()
    {
        return $this->hasMany(Sales_details::class);
    }

    public function purchases_details()
    {
        return $this->hasMany(Purchases_details::class);
    }

    // untuk export data ke exel
    public static function getAllInventory()
    {
        $result = DB::table('inventories')
        ->select('id','code', 'name', 'price', 'stock','created_at','updated_at')
        ->get()->toArray();

        return $result;
    }
}
