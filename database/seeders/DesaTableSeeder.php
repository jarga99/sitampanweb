<?php

namespace Database\Seeders;

use App\Models\Desa;
use Illuminate\Database\Seeder;

class DesaTableSeeder extends Seeder
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
                'id_desa' => 3522012015,
                'kecamatan_id' => 352201,
                'jenis' => 'Desa',
                'nama_desa' => 'Bancer',
            ],
            [
                'id_desa' => 3522012008,
                'kecamatan_id' => 352201,
                'jenis' => 'Desa',
                'nama_desa' => 'Blimbinggede',
            ],
            [
                'id_desa' => 3522022007,
                'kecamatan_id' => 352202,
                'jenis' => 'Desa',
                'nama_desa' => 'Bakalan',
            ],
            [
                'id_desa' => 3522022016,
                'kecamatan_id' => 352202,
                'jenis' => 'Desa',
                'nama_desa' => 'Dolokgede',
            ],
            [
                'id_desa' => 3522032005,
                'kecamatan_id' => 352203,
                'jenis' => 'Desa',
                'nama_desa' => 'Bondol',
            ],
            [
                'id_desa' => 3522032002,
                'kecamatan_id' => 352203,
                'jenis' => 'Desa',
                'nama_desa' => 'Karangmangu',
            ],
        ];

        Desa::insert($data);
    }
}
