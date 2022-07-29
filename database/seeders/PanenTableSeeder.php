<?php

namespace Database\Seeders;

use App\Models\Panen;
use Illuminate\Database\Seeder;

class PanenTableSeeder extends Seeder
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
                'id_panen' => 1,
                'nama_panen' => 'Pajale',
            ],
            [
                'id_panen' => 2,
                'nama_panen' => 'Horti',
            ],
            [
                'id_panen' => 3,
                'nama_panen' => 'Perkebunan',
            ],
        ];

        Panen::insert($data);
    }
}
