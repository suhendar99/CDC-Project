<?php

use Illuminate\Database\Seeder;

class KaryawanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $akun = [
            'nama' => 'Pak Karyawan',
            'desa_id' => 1101010001,
            'kecamatan_id' => 1101010,
            'kabupaten_id' => 1101,
            'provinsi_id' => 11,
            'status' => 1
        ];
        DB::table('pengurus_gudangs')->insert($akun);
    }
}
