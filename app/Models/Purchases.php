<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchases extends Model
{
    use HasFactory;
    protected $fillable = [
        'number', 'date', 'user_id'
    ];
    protected $table = 'purchases';

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function purchases_details()
    {
        return $this->hasMany(Purchases_details::class);
    }

    

}

