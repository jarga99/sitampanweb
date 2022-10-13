<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tanam extends Model
{
    use HasFactory;

    protected $table = 'mst_tanam';
    protected $primaryKey = 'id_tanam';
    protected $fillable = ['nama_tanam'];
    protected $guarded = [];

    public function tb_produktivitas_tanam() {
        return $this->hasMany(ProduktivitasTanam::class, 'tanam_id', 'id_tanam');
    }
}
