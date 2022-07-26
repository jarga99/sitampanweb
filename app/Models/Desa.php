<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Desa extends Model
{
    use HasFactory;
    protected $table = 'mst_desa';
    protected $primaryKey = 'id_desa';
    protected $fillable = ['nama_desa','luas_wilayah'];
    protected $guarded = [];

    public function mst_kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id', 'id_kecamatan');
    }

}
