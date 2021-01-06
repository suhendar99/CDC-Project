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
            'kode_pemasok' => $kode,
            'desa_id' => 1101010001,
            'kecamatan_id' => 1101010,
            'kabupaten_id' => 1101,
            'provinsi_id' => 11,
        ];
        DB::table('pemasoks')->insert($akun);
    }
}
