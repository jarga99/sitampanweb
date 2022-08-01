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
                'jenis_tanam' => 1,
                'jenis_panen' => 1,
                'nama_tanaman'=>'Kedelai',
               ],
               [
                'id_tanaman'=>4,
                'jenis_tanam' => 1,
                'jenis_panen' => 1,
                'nama_tanaman'=>'Kacang Tanah',
               ],
               [
                'id_tanaman'=>5,
                'jenis_tanam' => 1,
                'jenis_panen' => 1,
                'nama_tanaman'=>'Kacang Hijau',
               ],
               [
                'id_tanaman'=>6,
                'jenis_tanam' => 1,
                'jenis_panen' => 1,
                'nama_tanaman'=>'Ubi Kayu',
               ],
               [
                'id_tanaman'=>7,
                'jenis_tanam' => 1,
                'jenis_panen' => 1,
                'nama_tanaman'=>'Ubi Jalar',
               ],
               [
                'id_tanaman'=>8,
                'jenis_tanam' => 1,
                'jenis_panen' => 1,
                'nama_tanaman'=>'Porang',
               ],
               [
                'id_tanaman'=>9,
                'jenis_tanam' => 2,
                'jenis_panen' => 2,
                'nama_tanaman'=>'Bawang Merah',
               ],
               [
                'id_tanaman'=>10,
                'jenis_tanam' => 2,
                'jenis_panen' => 2,
                'nama_tanaman'=>'Cabe Rawit',
               ],
               [
                'id_tanaman'=>11,
                'jenis_tanam' => 2,
                'jenis_panen' => 2,
                'nama_tanaman'=>'Cabe Besar',
               ],
               [
                'id_tanaman'=>12,
                'jenis_tanam' => 2,
                'jenis_panen' => 2,
                'nama_tanaman'=>'Cabe Kriting',
               ],
               [
                'id_tanaman'=>13,
                'jenis_tanam' => 3,
                'jenis_panen' => 3,
                'nama_tanaman'=>'Tembakau',
               ],
               [
                'id_tanaman'=>14,
                'jenis_tanam' => 3,
                'jenis_panen' => 3,
                'nama_tanaman'=>'Kelapa',
               ],
               [
                'id_tanaman'=>15,
                'jenis_tanam' => 3,
                'jenis_panen' => 3,
                'nama_tanaman'=>'Tebu',
               ],
               [
                'id_tanaman'=>16,
                'jenis_tanam' => 3,
                'jenis_panen' => 3,
                'nama_tanaman'=>'Kopi',
               ],
               [
                'id_tanaman'=>17,
                'jenis_tanam' => 3,
                'jenis_panen' => 3,
                'nama_tanaman'=>'Petai',
               ],

        ];

        Tanaman::insert($data);
    }
}
