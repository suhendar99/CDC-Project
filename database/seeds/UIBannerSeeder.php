<?php

use App\Models\UiBanner;
use Illuminate\Database\Seeder;

class UIBannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UiBanner::create([
            'nama' => 'banner 1',
            'foto' => '/images/banner1.png'
        ]);
    }
}
