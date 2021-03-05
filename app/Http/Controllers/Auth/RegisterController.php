<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\Pelanggan;
use App\Models\Pemasok;
use App\Models\Pembeli;
use App\Models\PengurusGudang;
use App\Models\PengurusGudangBulky;
use App\Notifications\NewUser;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'nama' => ['required', 'string', 'max:255'],
            'nik' => ['required', 'numeric'],
            'telepon' => ['required', 'numeric'],
            'provinsi_id' => ['required'],
            'alamat' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string','alpha_dash', 'unique:users','max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'email_verified_at' => ['nullable'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        if ($data['role'] == 'warung') {
            if ($data['keanggotaan'] == 1) {
                $pelanggan = Pelanggan::create([
                    'nama' => $data['nama'],
                    'nik' => $data['nik'],
                    'telepon' => '62'.(int)$data['telepon'],
                    'jenis_kelamin' => $data['jenis_kelamin'],
                    'provinsi_id' => $data['provinsi_id'],
                    'kabupaten_id' => $data['kabupaten_id'],
                    'kecamatan_id' => $data['kecamatan_id'],
                    'desa_id' => $data['desa_id'],
                    'alamat' => $data['alamat'],
                    'kota_asal' => $data['kota_asal'],
                ]);

                return User::create([
                    'username' => $data['username'],
                    'email' => $data['email'],
                    'keanggotaan' => $data['keanggotaan'],
                    'koperasi_id' => $data['koperasi_id'],
                    'password' => Hash::make($data['password']),
                    'pelanggan_id' => $pelanggan->id,
                    'email_verified_at' => $data['email_verified_at'],
                    'status' => 1
                ]);
            } else {
                $pelanggan = Pelanggan::create([
                    'nama' => $data['nama'],
                    'nik' => $data['nik'],
                    'telepon' => '62'.(int)$data['telepon'],
                    'jenis_kelamin' => $data['jenis_kelamin'],
                    'provinsi_id' => $data['provinsi_id'],
                    'kabupaten_id' => $data['kabupaten_id'],
                    'kecamatan_id' => $data['kecamatan_id'],
                    'desa_id' => $data['desa_id'],
                    'alamat' => $data['alamat'],
                ]);

                return User::create([
                    'username' => $data['username'],
                    'email' => $data['email'],
                    'password' => Hash::make($data['password']),
                    'pelanggan_id' => $pelanggan->id,
                    'email_verified_at' => $data['email_verified_at'],
                    'status' => 1
                ]);
            }
        } elseif ($data['role'] == 'pemasok') {
            if ($data['keanggotaan'] == 1) {
                $pin = mt_rand(100, 999)
                        .mt_rand(100, 999);
                $date = date("Y");
                $kode = "SP".$date.$pin;
                $pemasok = Pemasok::create([
                    'nama' => $data['nama'],
                    'kode_pemasok' => $kode,
                    'nik' => $data['nik'],
                    'telepon' => '62'.(int)$data['telepon'],
                    'jenis_kelamin' => $data['jenis_kelamin'],
                    'provinsi_id' => $data['provinsi_id'],
                    'kabupaten_id' => $data['kabupaten_id'],
                    'kecamatan_id' => $data['kecamatan_id'],
                    'desa_id' => $data['desa_id'],
                    'alamat' => $data['alamat'],
                ]);

                return User::create([
                    'username' => $data['username'],
                    'email' => $data['email'],
                    'koperasi_id' => $data['koperasi_id'],
                    'keanggotaan' => $data['keanggotaan'],
                    'password' => Hash::make($data['password']),
                    'pemasok_id' => $pemasok->id,
                    'email_verified_at' => $data['email_verified_at'],
                    'status' => 1
                ]);
            } else {
                $pin = mt_rand(100, 999)
                        .mt_rand(100, 999);
                $date = date("Y");
                $kode = "SP".$date.$pin;
                $pemasok = Pemasok::create([
                    'nama' => $data['nama'],
                    'kode_pemasok' => $kode,
                    'nik' => $data['nik'],
                    'telepon' => '62'.(int)$data['telepon'],
                    'jenis_kelamin' => $data['jenis_kelamin'],
                    'provinsi_id' => $data['provinsi_id'],
                    'kabupaten_id' => $data['kabupaten_id'],
                    'kecamatan_id' => $data['kecamatan_id'],
                    'desa_id' => $data['desa_id'],
                    'alamat' => $data['alamat'],
                ]);

                return User::create([
                    'username' => $data['username'],
                    'email' => $data['email'],
                    'password' => Hash::make($data['password']),
                    'pemasok_id' => $pemasok->id,
                    'email_verified_at' => $data['email_verified_at'],
                    'status' => 1
                ]);
            }

        } elseif ($data['role'] == 'bulky') {
            if ($data['keanggotaan'] == 1) {
                $bulki = PengurusGudangBulky::create([
                    'nama' => $data['nama'],
                    'status' => 1,
                    'nik' => $data['nik'],
                    'telepon' => '62'.(int)$data['telepon'],
                    'jenis_kelamin' => $data['jenis_kelamin'],
                    'provinsi_id' => $data['provinsi_id'],
                    'kabupaten_id' => $data['kabupaten_id'],
                    'kecamatan_id' => $data['kecamatan_id'],
                    'desa_id' => $data['desa_id'],
                    'alamat' => $data['alamat'],
                ]);

                return User::create([
                    'username' => $data['username'],
                    'email' => $data['email'],
                    'password' => Hash::make($data['password']),
                    'keanggotaan' => $data['keanggotaan'],
                    'koperasi_id' => $data['koperasi_id'],
                    'pengurus_gudang_bulky_id' => $bulki->id,
                    'email_verified_at' => $data['email_verified_at'],
                    'status' => 1
                ]);
            } else {
                $bulki = PengurusGudangBulky::create([
                    'nama' => $data['nama'],
                    'status' => 1,
                    'nik' => $data['nik'],
                    'telepon' => '62'.(int)$data['telepon'],
                    'jenis_kelamin' => $data['jenis_kelamin'],
                    'provinsi_id' => $data['provinsi_id'],
                    'kabupaten_id' => $data['kabupaten_id'],
                    'kecamatan_id' => $data['kecamatan_id'],
                    'desa_id' => $data['desa_id'],
                    'alamat' => $data['alamat'],
                ]);

                return User::create([
                    'username' => $data['username'],
                    'email' => $data['email'],
                    'password' => Hash::make($data['password']),
                    'pengurus_gudang_bulky_id' => $bulki->id,
                    'email_verified_at' => $data['email_verified_at'],
                    'status' => 1
                ]);
            }

        } elseif ($data['role'] == 'pembeli') {
            $pembeli = Pembeli::create([
                'nama' => $data['nama'],
                'nik' => $data['nik'],
                'telepon' => '62'.(int)$data['telepon'],
                'jenis_kelamin' => $data['jenis_kelamin'],
                'provinsi_id' => $data['provinsi_id'],
                'kabupaten_id' => $data['kabupaten_id'],
                'kecamatan_id' => $data['kecamatan_id'],
                'desa_id' => $data['desa_id'],
                'alamat' => $data['alamat'],
            ]);

            return User::create([
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'pembeli_id' => $pembeli->id,
                'email_verified_at' => $data['email_verified_at'],
                'status' => 1
            ]);
        } elseif ($data['role'] == 'retail') {
            if ($data['keanggotaan'] == 1) {
                $pengurusGudang = PengurusGudang::create([
                    'nama' => $data['nama'],
                    'status' => 1,
                    'nik' => $data['nik'],
                    'telepon' => '62'.(int)$data['telepon'],
                    'jenis_kelamin' => $data['jenis_kelamin'],
                    'provinsi_id' => $data['provinsi_id'],
                    'kabupaten_id' => $data['kabupaten_id'],
                    'kecamatan_id' => $data['kecamatan_id'],
                    'desa_id' => $data['desa_id'],
                    'alamat' => $data['alamat'],
                ]);

                return User::create([
                    'username' => $data['username'],
                    'email' => $data['email'],
                    'password' => Hash::make($data['password']),
                    'keanggotaan' => $data['keanggotaan'],
                    'koperasi_id' => $data['koperasi_id'],
                    'pengurus_gudang_id' => $pengurusGudang->id,
                    'email_verified_at' => $data['email_verified_at'],
                    'status' => 1,
                    // 'jenis' => $data['jenis']
                ]);
            } else {
                $pengurusGudang = PengurusGudang::create([
                    'nama' => $data['nama'],
                    'status' => 1,
                    'nik' => $data['nik'],
                    'telepon' => '62'.(int)$data['telepon'],
                    'jenis_kelamin' => $data['jenis_kelamin'],
                    'provinsi_id' => $data['provinsi_id'],
                    'kabupaten_id' => $data['kabupaten_id'],
                    'kecamatan_id' => $data['kecamatan_id'],
                    'desa_id' => $data['desa_id'],
                    'alamat' => $data['alamat'],
                ]);

                return User::create([
                    'username' => $data['username'],
                    'email' => $data['email'],
                    'password' => Hash::make($data['password']),
                    'pengurus_gudang_id' => $pengurusGudang->id,
                    'email_verified_at' => $data['email_verified_at'],
                    'status' => 1,
                    // 'jenis' => $data['jenis']
                ]);
            }

            // if ($data['jenis'] == null) {
            //     return back()->with('error', 'Mohon pilih Jenis Usaha !');
            // }
        } else {
            return back()->with('error', 'Mohon pilih role terlebih dahulu !');
        }
    }
    public function verify()
    {

        return view('auth.verify');
    }
}
