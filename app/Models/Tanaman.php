<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tanaman extends Model
{
    use HasFactory;

    protected $table = 'mst_tanaman';
    protected $primaryKey = 'id_tanaman';
    protected $fillable = ['jenis_tanam','jenis_panen','jenis_puso','nama_tanaman'];
    protected $guarded = [];

    public function tb_produktivitas() {
        return $this->hasMany(Produktivitas::class, 'tanaman_id', 'id_tanaman');
    }
    public function tb_produktivitas_tanam() {
        return $this->hasMany(ProduktivitasTanam::class, 'tanaman_id', 'id_tanaman');
    }
    public function tb_produktivitas_puso() {
        return $this->hasMany(ProduktivitasPuso::class, 'tanaman_id', 'id_tanaman');
    }

    public function mst_tanam(){
        return $this->hasMany(Tanaman::class, 'jenis_tanam', 'id_tanam');
    }
    public function mst_panen(){
        return $this->hasMany(Tanaman::class, 'jenis_panen', 'id_panen');
    }
    public function mst_puso(){
        return $this->hasMany(Tanaman::class, 'jenis_puso', 'id_puso');
    }
}
