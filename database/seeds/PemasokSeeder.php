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
    	$pin = mt_rand(100, 999)
                .mt_rand(100, 999);
        $date = date("Y");
        $kode = "PMSK".$date.$pin;
        $akun = [
        	'nama' => 'Pak Pemasok',
            'kode_pemasok' => $kode,
            'desa_id' => 1101010001,
            'kecamatan_id' => 1101010,
            'kabupaten_id' => 1101,
            'provinsi_id' => 11,
        ];
        DB::table('pemasoks')->insert($akun);
    }
}
