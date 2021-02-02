<?php

use App\Models\Pemasok;
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
        $pin = mt_rand(100, 999)
                .mt_rand(100, 999);
        $date = date("Y");
        $kode = "PMSK".$date.$pin;
        $pemasok = Pemasok::create([
            'nama' => 'Pemasok',
            'alamat' => 'Jl A',
            'telepon' => '085212114582',
            'nik' => '000212255542',
            'tempat_lahir' => 'Sumedang',
            'tgl_lahir' => '2001-02-02',
            'agama' => 'Islam',
            'pekerjaan' => 'Pelajar',
            'jenis_kelamin' => 'Pria',
            'status_perkawinan' => 'Belum Kawin',
            'kewarganegaraan' => 'WNI',
            'desa_id' => 1101010001,
            'kecamatan_id' => 1101010,
            'kabupaten_id' => 1101,
            'provinsi_id' => 11,
            'kode_pemasok' => $kode
        ]);
        User::create([
            'name' => 'Admin',
            'email' => 'admin@makerindo.com',
            'username' => 'admin',
            'password' => Hash::make('12341234'),
            'approved_at' => now(),
            'status' => 1
        ]);

        User::create([
            'email' => 'pemasok@makerindo.com',
            'username' => 'pemasok',
            'password' => Hash::make('12341234'),
            'pemasok_id' => $pemasok->id,
            'approved_at' => now(),
            'status' => 1
        ]);

        User::create([
            'email' => 'retail@makerindo.com',
            'username' => 'retail',
            'password' => Hash::make('12341234'),
            'pengurus_gudang_id' => 1,
            'approved_at' => now(),
            'status' => 1
        ]);

        User::create([
            'email' => 'bulky@makerindo.com',
            'username' => 'bulky',
            'password' => Hash::make('12341234'),
            'pengurus_gudang_bulky_id' => 1,
            'approved_at' => now(),
            'status' => 1
        ]);

        User::create([
            'email' => 'pelanggan@makerindo.com',
            'username' => 'pelanggan',
            'password' => Hash::make('12341234'),
            'pelanggan_id' => 1,
            'approved_at' => now(),
            'status' => 1
        ]);
        User::create([
            'email' => 'pembeli@makerindo.com',
            'username' => 'pembeli',
            'password' => Hash::make('12341234'),
            'pembeli_id' => 1,
            'approved_at' => now(),
            'status' => 1
        ]);
    }
}
