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
        	'copyright_text' => 'PT LAPI ITB',
            'logo_app' => '/images/logo_new/Logo-CDC.png',
            'logo_pemasok' => '/images/logo_new/Logo-cdc-pemasok.png',
            'logo_bulky' => '/images/logo_new/Logo-cdc-bulky.png',
            'logo_retail' => '/images/logo_new/Logo-cdc-retail.png',
            'logo_warung' => '/images/logo_new/Logo-iwarung.png',
            'logo_pembeli' => '/images/logo_new/Logo-imarket.png',
        ];

        \DB::table('pengaturan_aplikasis')->insert($input);
    }
}
