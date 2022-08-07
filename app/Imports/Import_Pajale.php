<?php

namespace App\Imports;

use App\Models\ProduktivitasTanam;
use Maatwebsite\Excel\Concerns\ToModel;

class Import_Pajale implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ProduktivitasTanam([
            'Tanggal'       => $row[1],
            'Kecamatan'     => $row[2],
            'Desa'          => $row[3],
            'Tanaman'       => $row[4],
            'Luas Tanam'    => $row[5],
            'kadar'         => $row[6],
            'Produksi'      => $row[7],
            'Provitas'      => $row[8],
            'Harga'         => $row[9],
        ]);
    }
}
