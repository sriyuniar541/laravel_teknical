<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    
    protected $fillable = [
        'name', 'role', 'email' ,'password'
    ];
    protected $table = 'users';

    public function sales()
    {
        return $this->hasMany(Sales::class);
    }

    public function purchases()
    {
        return $this->hasMany(Purchases::class);
    }
}
