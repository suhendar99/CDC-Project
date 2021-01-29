<?php

use App\Models\ArmadaPengiriman;
use Illuminate\Database\Seeder;

class ArmadaPengirimanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ArmadaPengiriman::create([
            'nama' => 'JNE',
            'harga' => '12000',
            'alamat' => 'Jl AA',
        ]);
    }
}
