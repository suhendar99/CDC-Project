<?php

use Illuminate\Database\Seeder;
use App\Models\Pemasok;
use App\Models\Kategori;
use App\City;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create('id_ID');
        $harga = 14000000;
        $jumlah =  100;
        $data = array(
            [
                'pemasok_id' => 1,
                'kategori_id' => 1,
                'kode_barang' => $faker->unique()->ean13,
                'nama_barang' => 'Kopi Luwak',
                'jumlah' => $jumlah,
                'harga_beli' => $harga,
                'harga_barang' => $harga * $jumlah,
                'satuan' => 'Ton'
            ]
        );
        DB::table('barangs')->insert($data);
        DB::table('barangs')->insert([
            'pemasok_id' => 1,
            'kategori_id' => 18,
            'kode_barang' => $faker->unique()->ean13,
            'nama_barang' => 'Ayam Beku',
            'jumlah' => 100,
            'harga_barang' => 25000000 * 100,
            'harga_beli' => 25000000,
            'satuan' => 'Ton'
        ]);
    }
}
