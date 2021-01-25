<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KoperasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $value = array(
            ['nama_koperasi' => 'Koperasi 1','alamat' => 'Jl A','sektor_usaha' => 'pertanian','jenis_koperasi' => ' Koperasi Produsen'],
            ['nama_koperasi' => 'Koperasi 2','alamat' => 'Jl B','sektor_usaha' => 'pertanian','jenis_koperasi' => ' Koperasi Produsen'],
            ['nama_koperasi' => 'Koperasi 3','alamat' => 'Jl C','sektor_usaha' => 'pertanian','jenis_koperasi' => ' Koperasi Produsen'],
            ['nama_koperasi' => 'Koperasi 4','alamat' => 'Jl D','sektor_usaha' => 'pertanian','jenis_koperasi' => ' Koperasi Produsen'],
            ['nama_koperasi' => 'Koperasi 5','alamat' => 'Jl E','sektor_usaha' => 'pertanian','jenis_koperasi' => ' Koperasi Produsen'],
        );

        DB::table('koperasis')->insert($value);
    }
}
