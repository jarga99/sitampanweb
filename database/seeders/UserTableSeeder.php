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
                'nama' => 'Super Admin',
                'username' => 'superAdmin',
                'password' => bcrypt('AdminSuper'),
                'foto' => '/img/avatar.png',
                'level' => 1
            ],
            [
                'nama' => 'Kepala Dinas',
                'username' => 'kadin',
                'password' => bcrypt('kadin dkpp'),
                'foto' => '/img/avatar3.png',
                'level' => 1
            ],
            [
                'nama' => 'Admin',
                'username' => 'desa1',
                'password' => bcrypt('admindesa1'),
                'foto' => '/img/avatar5.png',
                'level' => 2
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
