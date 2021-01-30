<?php

use App\Models\PengaturanTransaksi;
use Illuminate\Database\Seeder;

class PengaturanTransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PengaturanTransaksi::create([
            'pajak' => 10,
            'biaya_admin' => 12000
        ]);
    }
}
