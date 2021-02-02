<?php

use Illuminate\Database\Seeder;

class PembeliSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $akun = [
            'nama' => 'Pak Pembeli',
            'alamat' => 'Jl A',
            'telepon' => '085445825212',
            'desa_id' => 1101010001,
            'kecamatan_id' => 1101010,
            'kabupaten_id' => 1101,
            'provinsi_id' => 11,
        ];
        DB::table('pembelis')->insert($akun);
    }
}
