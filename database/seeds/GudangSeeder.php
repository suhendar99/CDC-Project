<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GudangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $value = [
            'nomor_gudang' => 'GUD/19950312/892712334',
            'nama' => 'Gudang Beras',
            'lat' => '-6.406742565978931',
            'long' => '106.78298950195314',
            'kontak' => '085442525445',
            'pemilik' => 'Pak pemilik gudang',
            'kapasitas' => '200',
            'jam_buka' => '08:00:00',
            'jam_tutup' => '17:00:00',
            'hari' => 'Senin - Sabtu',
            'alamat' => 'Jl ABC',
            'desa_id' => 3276020006,
            'user_id' => 3
        ];

        DB::table('gudangs')->insert($value);
    }
}
