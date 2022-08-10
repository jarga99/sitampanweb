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
                'nama' => 'Tester1',
                'username' => 'Tester01',
                'password' => bcrypt('tester01'),
                'foto' => '/img/avatar.png',
                'level' => 1
            ],
            [
                'nama' => 'Terter2',
                'username' => 'Tester02',
                'password' => bcrypt('testter02'),
                'foto' => '/img/avatar.png',
                'level' => 2
            ],
            [
                'nama' => 'Terter3',
                'username' => 'Tester03',
                'password' => bcrypt('testter03'),
                'foto' => '/img/avatar.png',
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
