<?php

use App\Models\BatasPiutang;
use Illuminate\Database\Seeder;

class BatasPiutangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BatasPiutang::create([
            'jumlah_hari' => 25,
            'batas_jumlah_uang' => 10000000
        ]);
    }
}
