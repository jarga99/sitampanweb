<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produktivitas extends Model
{
    use HasFactory;

    protected $table = 'tb_produktivitas';
    protected $primaryKey = 'id_produktivitas';
    protected $guarded = [];

    public function mst_tanaman() {
        return $this->belongsTo(Tanaman::class, 'tanaman_id', 'id_tanaman');
    }

    public function mst_desa() {
        return $this->belongsTo(Desa::class, 'desa_id', 'id_desa');
    }

    public function tb_user() {
        return $this->hasOne(User::class, 'user_id', 'id_user');
    }
}
