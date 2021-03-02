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
        $harga = 100000000;
        $jumlah =  100;
        $data = array(
            [
                'pemasok_id' => 1,
                'kategori_id' => 1,
                'kode_barang' => $faker->unique()->ean13,
                'nama_barang' => 'Beras Cianjur',
                'jumlah' => $jumlah,
                'harga_beli' => $harga,
                'harga_barang' => $harga * $jumlah,
                'satuan' => 'Ton'
            ]
        );
    	// dd($harga);
        DB::table('barangs')->insert($data);
        DB::table('barangs')->insert([
            'pemasok_id' => 1,
            'kategori_id' => 7,
            'kode_barang' => $faker->unique()->ean13,
            'nama_barang' => 'Jagung Belanda',
            'jumlah' => 100,
            'harga_barang' => 120000000 * 100,
            'harga_beli' => 120000000,
            'satuan' => 'Ton'
        ]);
    }
}
