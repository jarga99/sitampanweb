<?php

namespace Database\Seeders;

use App\Models\Kecamatan;
use Illuminate\Database\Seeder;

class KecamatanTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
            'id_kecamatan'=>352201,
            'nama_Kecamatan'=>'Ngeraho',
            ],
            [
            'id_kecamatan'=>352202,
            'nama_Kecamatan'=>'Tambakrejo',
            ],
        ];

        Kecamatan::insert($data);
    }
}
