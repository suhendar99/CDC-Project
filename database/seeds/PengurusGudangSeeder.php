<?php

use Illuminate\Database\Seeder;

class PengurusGudangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $akun = [
            'nama' => 'Gudang Retail',
            'alamat' => 'Jl A',
            'telepon' => '085445825212',
            'desa_id' => 1101010001,
            'kecamatan_id' => 1101010,
            'kabupaten_id' => 1101,
            'provinsi_id' => 11,
            'status' => 1,
        ];
        DB::table('pengurus_gudangs')->insert($akun);
    }
}
