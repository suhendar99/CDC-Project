<?php

use App\Models\Bank;
use App\Models\BungaBank;
use Illuminate\Database\Seeder;

class BungaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bank = Bank::all();
        $bungaBank = BungaBank::all();
    	$faker = \Faker\Factory::create('id_ID');
    	$data = [];
		foreach ($bank as $p) {
            $data[] = [
                'bank_id' => $p->id,
                'koperasi' => $faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = NULL),
                'ritel' => $faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = NULL),
                'mikro' => $faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = NULL),
                'kpr' => $faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = NULL),
                'non_kpr' => $faker->randomFloat($nbMaxDecimals = NULL, $min = 0, $max = NULL),
            ];
        }
    	// dd($harga);
        DB::table('bunga_banks')->insert($data);
    }
}
