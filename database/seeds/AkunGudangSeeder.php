<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AkunGudangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $value = [
            'gudang_id' => 1,
            'pengurus_id' => 1
        ];

        DB::table('akun_gudangs')->insert($value);
    }
}