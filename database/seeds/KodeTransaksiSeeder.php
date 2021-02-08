<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KodeTransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $value = array(
            ['nama' => 'Simpan', 'kode_transaksi' => 'SIMP'],
            ['nama' => 'Pinjam', 'kode_transaksi' => 'PINJ'],
            ['nama' => 'Bayar Tunai', 'kode_transaksi' => 'BT'],
            ['nama' => 'Bayar Utang', 'kode_transaksi' => 'BU'],
            ['nama' => 'Terima Pesanan', 'kode_transaksi' => 'TP'],
            ['nama' => 'Proses Pemesanan', 'kode_transaksi' => 'PP'],
            ['nama' => 'Kirim Pesanan', 'kode_transaksi' => 'KP'],
        );

        DB::table('kode_transaksis')->insert($value);
    }
}
