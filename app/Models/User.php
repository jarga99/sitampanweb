<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'tb_user';
    protected $primaryKey = 'id_user';

    protected $fillable = ['nama', 'username', 'password'];

    protected $appends = [
        'foto_profil_url',
    ];

    public function scopeIsNotAdmin($query)
    {
        return $query->where('level', '!=', 1);
    }
}
