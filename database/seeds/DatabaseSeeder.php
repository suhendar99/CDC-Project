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
        $this->call(BankSeeder::class);
        $this->call(BulkySeeder::class);
        $this->call(PembeliSeeder::class);
        $this->call(PengurusGudangSeeder::class);
        $this->call(PelangganSeeder::class);
        $this->call(KategoriSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(PengaturanAplikasiSeeder::class);
        // $this->call(LocationsSeeder::class);
        $this->call(BarangSeeder::class);
        $this->call(GudangSeeder::class);
        $this->call(AkunGudangSeeder::class);
        $this->call(BatasPiutangSeeder::class);
        $this->call(KoperasiSeeder::class);
        $this->call(ArmadaPengirimanSeeder::class);
        $this->call(PengaturanTransaksiSeeder::class);
    }
}
