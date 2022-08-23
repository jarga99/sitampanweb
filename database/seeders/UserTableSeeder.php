<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = array (
            [
                'nama' => 'Operator Pemkab',
                'username' => '0perator01',
                'password' => bcrypt('4Dministrat0r'),
                'kecamatan_id' => null,
                'foto' => '/img/avatar.png',
                'level' => 1
            ],
            [
                'nama' => 'Kepala Dinas',
                'username' => 'Pengamat',
                'password' => bcrypt('secreetUser'),
                'kecamatan_id' => null,
                'foto' => '/img/avatar3.png',
                'level' => 2
            ],
            [
                'nama' => 'Admin Ngraho',
                'username' => 'Ngraho',
                'password' => bcrypt('Ngraho123'),
                'kecamatan_id' => '352201',
                'foto' => '/img/avatar5.png',
                'level' => 3
            ],
            [
                'nama' => 'Admin Tambakrejo',
                'username' => 'Tambakrejo',
                'password' => bcrypt('Tambakrejo123'),
                'kecamatan_id' => '352202',
                'foto' => '/img/avatar5.png',
                'level' => 3
            ],
            [
                'nama' => 'Admin Ngambon',
                'username' => 'Ngambon',
                'password' => bcrypt('Ngambon123'),
                'kecamatan_id' => '352203',
                'foto' => '/img/avatar5.png',
                'level' => 3
            ],
            [
                'nama' => 'Admin Ngasem',
                'username' => 'Ngasem',
                'password' => bcrypt('Ngasem123'),
                'kecamatan_id' => '352204',
                'foto' => '/img/avatar5.png',
                'level' => 3
            ],
            [
                'nama' => 'Admin Bubulan',
                'username' => 'Bubulan',
                'password' => bcrypt('Bubulan123'),
                'kecamatan_id' => '352205',
                'foto' => '/img/avatar5.png',
                'level' => 3
            ],
            [
                'nama' => 'Admin Dander',
                'username' => 'Dander',
                'password' => bcrypt('Dander123'),
                'kecamatan_id' => '352206',
                'foto' => '/img/avatar5.png',
                'level' => 3
            ],
            [
                'nama' => 'Admin Sugihwaras',
                'username' => 'Sugihwaras',
                'password' => bcrypt('Sugihwaras123'),
                'kecamatan_id' => '352207',
                'foto' => '/img/avatar5.png',
                'level' => 3
            ],
            [
                'nama' => 'Admin Kedungadem',
                'username' => 'Kedungadem',
                'password' => bcrypt('Kedungadem123'),
                'kecamatan_id' => '352208',
                'foto' => '/img/avatar5.png',
                'level' => 3
            ],
            [
                'nama' => 'Admin Kepohbaru',
                'username' => 'Kepohbaru',
                'password' => bcrypt('Kepohbaru123'),
                'kecamatan_id' => '352209',
                'foto' => '/img/avatar5.png',
                'level' => 3
            ],
            [
                'nama' => 'Admin Baureno',
                'username' => 'Baureno',
                'password' => bcrypt('Baureno123'),
                'kecamatan_id' => '352210',
                'foto' => '/img/avatar5.png',
                'level' => 3
            ],
            [
                'nama' => 'Admin Kanor',
                'username' => 'Kanor',
                'password' => bcrypt('Kanor123'),
                'kecamatan_id' => '352211',
                'foto' => '/img/avatar5.png',
                'level' => 3
            ],
            [
                'nama' => 'Admin Sumberrejo',
                'username' => 'Sumberrejo',
                'password' => bcrypt('Sumberrejo123'),
                'kecamatan_id' => '352212',
                'foto' => '/img/avatar5.png',
                'level' => 3
            ],
            [
                'nama' => 'Admin Balen',
                'username' => 'Balen',
                'password' => bcrypt('Balen123'),
                'kecamatan_id' => '352213',
                'foto' => '/img/avatar5.png',
                'level' => 3
            ],
            [
                'nama' => 'Admin Kapas',
                'username' => 'Kapas',
                'password' => bcrypt('Kapas123'),
                'kecamatan_id' => '352214',
                'foto' => '/img/avatar5.png',
                'level' => 3
            ],
            [
                'nama' => 'Admin Bojonegoro',
                'username' => 'Bojonegoro',
                'password' => bcrypt('Bojonegoro123'),
                'kecamatan_id' => '352215',
                'foto' => '/img/avatar5.png',
                'level' => 3
            ],
            [
                'nama' => 'Admin Kalitidu',
                'username' => 'Kalitidu',
                'password' => bcrypt('Kalitidu123'),
                'kecamatan_id' => '352216',
                'foto' => '/img/avatar5.png',
                'level' => 3
            ],
            [
                'nama' => 'Admin Malo',
                'username' => 'Malo',
                'password' => bcrypt('Malo123'),
                'kecamatan_id' => '352217',
                'foto' => '/img/avatar5.png',
                'level' => 3
            ],
            [
                'nama' => 'Admin Purwosari',
                'username' => 'Purwosari',
                'password' => bcrypt('Purwosari123'),
                'kecamatan_id' => '352218',
                'foto' => '/img/avatar5.png',
                'level' => 3
            ],
            [
                'nama' => 'Admin Padangan',
                'username' => 'Padangan',
                'password' => bcrypt('Padangan123'),
                'kecamatan_id' => '352219',
                'foto' => '/img/avatar5.png',
                'level' => 3
            ],
            [
                'nama' => 'Admin Kasiman',
                'username' => 'Kasiman',
                'password' => bcrypt('Kasiman123'),
                'kecamatan_id' => '352220',
                'foto' => '/img/avatar5.png',
                'level' => 3
            ],
            [
                'nama' => 'Admin Temayang',
                'username' => 'Temayang',
                'password' => bcrypt('Temayang123'),
                'kecamatan_id' => '352221',
                'foto' => '/img/avatar5.png',
                'level' => 3
            ],
            [
                'nama' => 'Admin Margomulyo',
                'username' => 'Margomulyo',
                'password' => bcrypt('Margomulyo123'),
                'kecamatan_id' => '352222',
                'foto' => '/img/avatar5.png',
                'level' => 3
            ],
            [
                'nama' => 'Admin Trucuk',
                'username' => 'Trucuk',
                'password' => bcrypt('Trucuk123'),
                'kecamatan_id' => '352223',
                'foto' => '/img/avatar5.png',
                'level' => 3
            ],
            [
                'nama' => 'Admin Sukosewu',
                'username' => 'Sukosewu',
                'password' => bcrypt('Sukosewu123'),
                'kecamatan_id' => '352224',
                'foto' => '/img/avatar5.png',
                'level' => 3
            ],
            [
                'nama' => 'Admin Kedewan',
                'username' => 'Kedewan',
                'password' => bcrypt('Kedewan123'),
                'kecamatan_id' => '352225',
                'foto' => '/img/avatar5.png',
                'level' => 3
            ],
            [
                'nama' => 'Admin Gondang',
                'username' => 'Gondang',
                'password' => bcrypt('Gondang123'),
                'kecamatan_id' => '352226',
                'foto' => '/img/avatar5.png',
                'level' => 3
            ],
            [
                'nama' => 'Admin Sekar',
                'username' => 'Sekar',
                'password' => bcrypt('Sekar123'),
                'kecamatan_id' => '352227',
                'foto' => '/img/avatar5.png',
                'level' => 3
            ],
            [
                'nama' => 'Admin Gayam',
                'username' => 'Gayam',
                'password' => bcrypt('Gayam123'),
                'kecamatan_id' => '352228',
                'foto' => '/img/avatar5.png',
                'level' => 3
            ],

        );
        array_map(function (array $user){
          User::query()->updateOrCreate(
            ['username' => $user['username']],
            $user
          );
        }, $user);
    }
}
