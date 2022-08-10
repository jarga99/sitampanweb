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
                'id_tanaman'=>1,
                'jenis_tanam' => 1,
                'jenis_panen' => 1,
                'nama_tanaman'=>'Padi',
            ],
            [
                'id_tanaman'=>2,
                'jenis_tanam' => 1,
                'jenis_panen' => 1,
                'nama_tanaman'=>'Jagung',
            ],
            [
                'id_tanaman'=>3,
                'jenis_tanam' => 2,
                'jenis_panen' => 2,
                'nama_tanaman'=>'Bawang Merah',
            ],
            [
                'id_tanaman'=>4,
                'jenis_tanam' => 2,
                'jenis_panen' => 2,
                'nama_tanaman'=>'Cabe Rawit',
            ],
            [
                'id_tanaman'=>5,
                'jenis_tanam' => 3,
                'jenis_panen' => 3,
                'nama_tanaman'=>'Tembakau',
            ],
            [
                'id_tanaman'=>6,
                'jenis_tanam' => 3,
                'jenis_panen' => 3,
                'nama_tanaman'=>'Kelapa',
            ],

        ];

        Tanaman::insert($data);
    }
}
