<?php

namespace Database\Seeders;

use App\Models\Tanaman;
use Illuminate\Database\Seeder;

class TanamanTableSeeder extends Seeder
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
                'id_tanaman' => 1,
                'jenis' => 'Pajale',
                'nama_tanaman' => 'Padi',
            ],
            [
                'id_tanaman' => 2,
                'jenis' => 'Pajale',
                'nama_tanaman' => 'Kedelai',
            ],
            [
                'id_tanaman' => 3,
                'jenis' => 'Pajale',
                'nama_tanaman' => 'Jagung',
            ],
            [
                'id_tanaman' => 4,
                'jenis' => 'Horti',
                'nama_tanaman' => 'Bawang Merah',
            ],
            [
                'id_tanaman' => 5,
                'jenis' => 'Horti',
                'nama_tanaman' => 'Cabe Rawit',
            ],
            [
                'id_tanaman' => 6,
                'jenis' => 'Perkebunan',
                'nama_tanaman' => 'Tembakau',
            ],
            [
                'id_tanaman' => 7,
                'jenis' => 'Perkebunan',
                'nama_tanaman' => 'Kelapa',
            ],

        ];

        Tanaman::insert($data);
    }
}
