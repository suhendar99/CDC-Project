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
            ['nama' => 'Kopi','icon' => '/images/kategori/Kopi.png'],
            ['nama' => 'Kakao','icon' => '/images/kategori/Kakao.png'],
            ['nama' => 'Teh','icon' => '/images/kategori/Teh.png'],
            ['nama' => 'Bawang Merah','icon' => '/images/kategori/Bawang.png'],
            ['nama' => 'Gabah','icon' => '/images/kategori/Gabah.png'],
            ['nama' => 'Beras','icon' => '/images/kategori/Beras.png'],
            ['nama' => 'Jagung','icon' => '/images/kategori/Jagung.png'],
            ['nama' => 'Lada','icon' => '/images/kategori/Lada.png'],
            ['nama' => 'Garam','icon' => '/images/kategori/Garam.png'],
            ['nama' => 'Karet','icon' => '/images/kategori/Karet.png'],
            ['nama' => 'Rotan','icon' => '/images/kategori/Rotan.png'],
            ['nama' => 'Pala','icon' => '/images/kategori/Pala.png'],
            ['nama' => 'Gambir','icon' => '/images/kategori/Gambir.png'],
            ['nama' => 'Kopra','icon' => '/images/kategori/Kopra.png'],
            ['nama' => 'Timah','icon' => '/images/kategori/Timah.png'],
            ['nama' => 'Ikan','icon' => '/images/kategori/Ikan.png'],
            ['nama' => 'Rumput Laut','icon' => '/images/kategori/Rumput.png'],
            ['nama' => 'Ayam Beku','icon' => '/images/kategori/Ayam.png']
        );
        $category = array(
          ['icon'=>'grass','nama'=>'Pertanian'],
          ['icon'=>'grass','nama'=>'Perkebunan'],
          ['icon'=>'set_meal','nama'=>'Perikanan'],
          ['icon'=>'flutter_dash','nama'=>'Peternakan'],
          // ['icon'=>'bento','nama'=>'Makanan Kaleng'],
          // ['icon'=>'kitchen','nama'=>'Makanan Beku'],
          // ['icon'=>'free_breakfast','nama'=>'Minuman'],
          // ['icon'=>'rice_bowl','nama'=>'Makanan Instan'],
        );
        \DB::table('kategoris')->insert($value);
    }
}
