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
            'nama' => 'Pak Ratail',
            'desa_id' => 1101010001,
            'kecamatan_id' => 1101010,
            'kabupaten_id' => 1101,
            'provinsi_id' => 11,
            'status' => 1
        ];
        DB::table('pengurus_gudangs')->insert($akun);
        DB::table('pengurus_gudang_bulkies')->insert([
            'nama' => 'Pak Bulky',
            'desa_id' => 1101010001,
            'kecamatan_id' => 1101010,
            'kabupaten_id' => 1101,
            'provinsi_id' => 11,
            'status' => 1
        ]);
    }
}
