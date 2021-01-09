<?php

use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $value = array(
            ['nama' => 'Fashion'],
            ['nama' => 'Barang Koleksi'],
            ['nama' => 'Barang Elektronik'],
            ['nama' => 'Keperluan Rumah Tangga'],
            ['nama' => 'Aksesoris'],
            ['nama' => 'Barang Antik'],
            ['nama' => 'Bahan Pangan'],
            ['nama' => 'Produk Kecantikan'],
        );
        $category = array(
          ['icon'=>'grass','nama'=>'Pertanian'],
          ['icon'=>'grass','nama'=>'Perkebunan'],
          ['icon'=>'set_meal','nama'=>'Perikanan'],
          ['icon'=>'flutter_dash','nama'=>'Peternakan'],
          ['icon'=>'bento','nama'=>'Makanan Kaleng'],
          ['icon'=>'kitchen','nama'=>'Makanan Beku'],
          ['icon'=>'free_breakfast','nama'=>'Minuman'],
          ['icon'=>'rice_bowl','nama'=>'Makanan Instan'],
        );
        \DB::table('kategoris')->insert($category);
    }
}
