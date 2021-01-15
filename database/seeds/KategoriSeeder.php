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
            ['nama' => 'Kopi'],
            ['nama' => 'Kakao'],
            ['nama' => 'Teh'],
            ['nama' => 'Bawang Merah'],
            ['nama' => 'Gabah'],
            ['nama' => 'Beras'],
            ['nama' => 'Jagung'],
            ['nama' => 'Lada'],
            ['nama' => 'Garam'],
            ['nama' => 'Karet'],
            ['nama' => 'Rotan'],
            ['nama' => 'Pala'],
            ['nama' => 'Gambir'],
            ['nama' => 'Kopra'],
            ['nama' => 'Timah'],
            ['nama' => 'Ikan'],
            ['nama' => 'Rumput Laut'],
            ['nama' => 'Ayam Beku']
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
