<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProduktivitasTanam extends Model
{
    use HasFactory;

    protected $table = 'tb_produktivitas_tanam';
    protected $primaryKey = 'id_produktivitas_tanam';
    protected $guarded = [];

    public function mst_tanaman() {
        return $this->belongsTo(Tanaman::class, 'tanaman_id', 'id_tanaman');
    }

    public function mst_kecamatan() {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id', 'id_kecamatan');
    }

    public function mst_desa() {
        return $this->belongsTo(Desa::class, 'desa_id', 'id_desa');
    }

    public function user() {
        return $this->belongsTo(User::class, 'created_by', 'id_user');
    }
}
