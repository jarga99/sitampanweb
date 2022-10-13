<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Puso extends Model
{
    use HasFactory;
    protected $table = 'mst_puso';
    protected $primaryKey = 'id_puso';
    protected $fillable = ['jenis_puso'];
    protected $guarded = [];

    public function tb_produktivitas() {
        return $this->hasMany(ProduktivitasPuso::class, 'puso_id', 'id_puso');
    }
}
