<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            UserTableSeeder::class,
            KecamatanTableSeeder::class,
            DesaTableSeeder::class,
            TanamTableSeeder::class,
            PanenTableSeeder::class,
            PusoTableSeeder::class,
            TanamanTableSeeder::class,
        ]);
    }
}
