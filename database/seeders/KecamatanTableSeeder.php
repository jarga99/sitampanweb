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
                'id_kecamatan' => 352201,
                'nama_kecamatan' => 'Ngraho',
            ],
            [
                'id_kecamatan' => 352202,
                'nama_kecamatan' => 'Tambakrejo',
            ],
            [
                'id_kecamatan' => 352203,
                'nama_kecamatan' => 'Ngambon',
            ],
            [
                'id_kecamatan' => 352204,
                'nama_kecamatan' => 'Ngasem',
            ],
            [
                'id_kecamatan' => 352205,
                'nama_kecamatan' => 'Bubulan',
            ],
            [
                'id_kecamatan' => 352206,
                'nama_kecamatan' => 'Dander',
            ],
        ];

        Kecamatan::insert($data);
    }
}
