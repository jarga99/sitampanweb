<?php

namespace Database\Seeders;

use App\Models\Tanam;
use Illuminate\Database\Seeder;

class TanamTableSeeder extends Seeder
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
                'id_tanam' => 1,
                'nama_tanam' => 'Pajale',
            ],
            [
                'id_tanam' => 2,
                'nama_tanam' => 'Horti',
            ],
            [
                'id_tanam' => 3,
                'nama_tanam' => 'Perkebunan',
            ],
        ];

        Tanam::insert($data);
    }
}
