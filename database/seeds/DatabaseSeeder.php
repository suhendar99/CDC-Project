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
        \Eloquent::unguard();
        \DB::unprepared(file_get_contents('public/db/wilayah_indo.sql'));
        $this->call(PemasokSeeder::class);
        $this->call(KaryawanSeeder::class);
        $this->call(PelangganSeeder::class);
        $this->call(KategoriSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(PengaturanAplikasiSeeder::class);
        $this->call(LocationsSeeder::class);
        $this->call(BarangSeeder::class);
    }
}
