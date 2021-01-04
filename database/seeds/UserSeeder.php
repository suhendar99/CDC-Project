<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@makerindo.com',
            'username' => 'admin',
            'password' => Hash::make('12341234')
        ]);

        User::create([
            'email' => 'pemasok@makerindo.com',
            'username' => 'pemasok',
            'password' => Hash::make('12341234'),
            'pemasok_id' => 1
        ]);

        User::create([
            'email' => 'karyawan@makerindo.com',
            'username' => 'pemasok',
            'password' => Hash::make('12341234'),
            'karyawan_id' => 1
        ]);

        User::create([  
            'email' => 'pelanggan@makerindo.com',
            'username' => 'pemasok',
            'password' => Hash::make('12341234'),
            'pelanggan_id' => 1
        ]);
    }
}
