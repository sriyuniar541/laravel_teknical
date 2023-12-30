<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Purchases_details extends Model
{
    use HasFactory;
    protected $fillable = [
        'purchase_id', 'inventory_id', 'qty', 'price'
    ];
    protected $table = 'purchases_details';



    // public function purchases()
    // {
    //     return $this->belongsTo(Purchases::class);
    // }

    public function purchase()
{
    return $this->belongsTo(Purchases::class);
}
    
    public function inventory()
    {
        return $this->belongsTo(Inventories::class);
    }

    public static function getAllPurchases()
    {
        $result = DB::table('purchases_details')
        ->select( 'id','purchase_id', 'inventory_id', 'qty', 'price', 'created_at','updated_at')
        ->get()->toArray();

        return $result;
    }
}
