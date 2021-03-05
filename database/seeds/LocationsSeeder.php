<?php

use App\City;
use App\Province;
use Illuminate\Database\Seeder;
use Kavist\RajaOngkir\Facades\RajaOngkir;

class LocationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kota = RajaOngkir::kota()->all();
        // dd($kota->toArray());
        foreach ($kota as $key => $value) {
            City::create([
                'province_id'   => $value['province_id'],
                'city_id'       => $value['city_id'],
                'name'          => $value['city_name'],
            ]);
        }
    }
}
