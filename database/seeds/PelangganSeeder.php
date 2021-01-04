<?php

use Illuminate\Database\Seeder;

class PelangganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $akun = [
        	'nama' => 'Pak Pelanggan',
        ];
        DB::table('pelanggans')->insert($akun);
    }
}
