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
            'nomor_gudang' => 'GUD/RTI/19950312/892712334',
            'nama' => 'Gudang Beras',
            'lat' => '-6.406742565978931',
            'long' => '106.78298950195314',
            'kontak' => '6285559396827',
            'pemilik' => 'Pak Soeharto',
            'kapasitas_meter' => '900',
            'kapasitas_berat' => '1.2',
            'jam_buka' => '08:00:00',
            'jam_tutup' => '17:00:00',
            'hari' => 'Senin - Sabtu',
            'alamat' => 'Jl ABC',
            'desa_id' => 3276020006,
            'user_id' => 3,
            'status' => 1
        ];

        DB::table('gudangs')->insert($value);
        DB::table('gudang_bulkies')->insert([
            'nomor_gudang' => 'GUD/BKY/19950312/822612431',
            'nama' => 'Gudang Pertama',
            'lat' => '-6.406742565978931',
            'long' => '106.78298950195314',
            'kontak' => '6285559396827',
            'pemilik' => 'Pak Soemanto',
            'kapasitas_meter' => '900',
            'kapasitas_berat' => '1.2',
            'jam_buka' => '08:00:00',
            'jam_tutup' => '17:00:00',
            'hari' => 'Senin - Sabtu',
            'alamat' => 'Jl ABC',
            'desa_id' => 3276020006,
            'user_id' => 4,
            'status' => 1
        ]);
    }
}
