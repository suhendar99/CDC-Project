<?php

use Illuminate\Database\Seeder;

class PemasokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$kode = 'PM'.date('YmdHis');
        $akun = [
        	'nama' => 'Pak Pemasok',
        	'kode_pemasok' => $kode
        ];
        DB::table('pemasoks')->insert($akun);
    }
}
