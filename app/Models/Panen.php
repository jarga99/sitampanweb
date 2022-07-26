<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Panen extends Model
{
    use HasFactory;

    protected $table = 'mst_panen';
    protected $primaryKey = 'id_panen';
    protected $fillable = ['nama_panen'];
    protected $guarded = [];

    public function tb_produktivitas() {
        return $this->hasMany(Produktivitas::class, 'panen_id', 'id_panen');
    }
}
