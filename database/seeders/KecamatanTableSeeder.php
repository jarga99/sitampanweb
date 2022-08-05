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
                [
                'id_kecamatan'=>352203,
                'nama_Kecamatan'=>'Ngambon',
                ],
                [
                'id_kecamatan'=>352204,
                'nama_Kecamatan'=>'Ngasem',
                ],
                [
                'id_kecamatan'=>352205,
                'nama_Kecamatan'=>'Bubulan',
                ],
                [
                'id_kecamatan'=>352206,
                'nama_Kecamatan'=>'Dander',
                ],
                [
                'id_kecamatan'=>352207,
                'nama_Kecamatan'=>'Sugihwaras',
                ],
                [
                'id_kecamatan'=>352208,
                'nama_Kecamatan'=>'Kedungadem',
                ],
                [
                'id_kecamatan'=>352209,
                'nama_Kecamatan'=>'Kepohbaru',
                ],
                [
                'id_kecamatan'=>352210,
                'nama_Kecamatan'=>'Baureno',
                ],
                [
                'id_kecamatan'=>352211,
                'nama_Kecamatan'=>'Kanor',
                ],
                [
                'id_kecamatan'=>352212,
                'nama_Kecamatan'=>'Sumberrejo',
                ],
                [
                'id_kecamatan'=>352213,
                'nama_Kecamatan'=>'Balen',
                ],
                [
                'id_kecamatan'=>352214,
                'nama_Kecamatan'=>'Kapas',
                ],
                [
                'id_kecamatan'=>352215,
                'nama_Kecamatan'=>'Bojonegoro',
                ],
                [
                'id_kecamatan'=>352216,
                'nama_Kecamatan'=>'Kalitidu',
                ],
                [
                'id_kecamatan'=>352217,
                'nama_Kecamatan'=>'Malo',
                ],
                [
                'id_kecamatan'=>352218,
                'nama_Kecamatan'=>'Purwosari',
                ],
                [
                'id_kecamatan'=>352219,
                'nama_Kecamatan'=>'Padangan',
                ],
                [
                'id_kecamatan'=>352220,
                'nama_Kecamatan'=>'Kasiman',
                ],
                [
                'id_kecamatan'=>352221,
                'nama_Kecamatan'=>'Temayang',
                ],
                [
                'id_kecamatan'=>352222,
                'nama_Kecamatan'=>'Margomulyo',
                ],
                [
                'id_kecamatan'=>352223,
                'nama_Kecamatan'=>'Trucuk',
                ],
                [
                'id_kecamatan'=>352224,
                'nama_Kecamatan'=>'Sukosewu',
                ],
                [
                'id_kecamatan'=>352225,
                'nama_Kecamatan'=>'Kedewan',
                ],
                [
                'id_kecamatan'=>352226,
                'nama_Kecamatan'=>'Gondang',
                ],
                [
                'id_kecamatan'=>352227,
                'nama_Kecamatan'=>'Sekar',
                ],
                [
                'id_kecamatan'=>352228,
                'nama_Kecamatan'=>'Gayam',
                ],

        ];

        Kecamatan::insert($data);
    }
}
