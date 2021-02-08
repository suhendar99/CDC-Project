<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KodeRoleAksesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $value = array(
            ['nama' => 'Pemasok','kode_role' => 'PMK'],
            ['nama' => 'CDC Bulky','kode_role' => 'BKY'],
            ['nama' => 'CDC Retail','kode_role' => 'RTL'],
            ['nama' => 'Warung','kode_role' => 'WRG'],
            ['nama' => 'Pembeli','kode_role' => 'PBL'],
        );

        DB::table('kode_role_akses')->insert($value);
    }
}
