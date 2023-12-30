<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class Sales extends Model
{
    use HasFactory;
    protected $fillable = [
        'number', 'date', 'user_id'
    ];
    protected $table = 'sales';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sales_details()
    {
        return $this->hasMany(Sales_details::class);
    }

    public static function getAllSales()
    {
        $result = DB::table('sales')
        ->select('id','number', 'date', 'user_id','created_at','updated_at')
        ->get()->toArray();

        return $result;
    }

}
