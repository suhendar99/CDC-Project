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
        \DB::table('kategoris')->insert($value);
    }
}
