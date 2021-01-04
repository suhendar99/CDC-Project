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
        ];
        DB::table('karyawans')->insert($akun);
    }
}
