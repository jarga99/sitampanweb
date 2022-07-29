<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Desa extends Model
{
    use HasFactory;
    protected $table = 'mst_desa';
    protected $primaryKey = 'id_desa';
    protected $fillable = ['kecamatan_id','jenis','nama_desa'];
    protected $guarded = [];

    public function mst_kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id', 'id_kecamatan');
    }

}
