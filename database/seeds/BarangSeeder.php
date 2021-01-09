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
    	$pemasok = Pemasok::all();
    	$kategori = Kategori::all();
    	$city = City::all();
    	$faker = \Faker\Factory::create('id_ID');
    	$data = [];
    	$kat = [];
    	foreach($kategori as $k){
    		$kat[] = $k->id;
    	}
    	// dd($kat[array_rand($kat)]);
		foreach ($pemasok as $p) {
			foreach ($city as $c) {
				$jumlah = $faker->numberBetween($min = 1, $max = 100);
				$harga = $faker->numberBetween($min = 1, $max = 9) * 10000;
    			$data[] = [
    				'pemasok_id' => $p->id,
    				'kategori_id' => $kat[array_rand($kat)],
    				'kode_barang' => $faker->unique()->ean13,
    				'nama_barang' => $faker->text($maxNbChars = 20),
    				'jumlah' => $jumlah,
    				'harga_barang' => $harga,
    				'harga_total' => $harga * $jumlah,
    				'satuan' => 'Kg'
    			];
			}
		}
    	// dd($harga);
        DB::table('barangs')->insert($data);
    }
}
