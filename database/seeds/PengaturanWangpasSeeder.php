<?php

use App\Models\pengaturanWangpas;
use Illuminate\Database\Seeder;

class PengaturanWangpasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        pengaturanWangpas::create([
            'pendaftaran' => 'https://google.com',
            'top_up' => 'https://google.com',
            'pembayaran' => 'https://google.com',
            'cek_saldo' => 'https://google.com',
        ]);
    }
}
