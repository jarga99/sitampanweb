<?php

namespace Database\Seeders;

use App\Models\Puso;
use Illuminate\Database\Seeder;

class PusoTableSeeder extends Seeder
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
                'id_puso' => 1,
                'jenis_puso' => 'Pajale',
            ],
            [
                'id_puso' => 2,
                'jenis_puso' => 'Horti',
            ],
            [
                'id_puso' => 3,
                'jenis_puso' => 'Perkebunan',
            ],
        ];

        Puso::insert($data);
    }
}
