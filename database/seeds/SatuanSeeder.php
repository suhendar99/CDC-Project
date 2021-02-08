<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SatuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $value = array(
            ['nama' => 'Tonase', 'satuan' => 'Ton'],
            ['nama' => 'Kuintal', 'satuan' => 'Kuintal'],
            ['nama' => 'Kilogram', 'satuan' => 'Kg'],
            ['nama' => 'Gram', 'satuan' => 'Gram'],
            ['nama' => 'Ons', 'satuan' => 'Ons'],
        );
        DB::table('satuans')->insert($value);
    }
}
