<?php

use Illuminate\Database\Seeder;

class PengaturanAplikasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $input = [
        	'nama_app' => 'CDC',
        	'nama_tab' => 'CDC',
        	'copyright_text' => 'PT LAPI ITB'
        ];

        \DB::table('pengaturan_aplikasis')->insert($input);
    }
}
