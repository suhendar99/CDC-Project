<?php

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
        $this->call(PemasokSeeder::class);
        $this->call(KaryawanSeeder::class);
        $this->call(PelangganSeeder::class);
        $this->call(UserSeeder::class);
    }
}
