<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\Karyawan;
use App\Models\Pelanggan;
use App\Models\Pemasok;
use App\Models\PengurusGudang;
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
        if ($data['role'] == 'pelanggan') {
            $pelanggan = Pelanggan::create([
                'nama' => $data['nama'],
            ]);

            return User::create([
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'pelanggan_id' => $pelanggan->id,
                'email_verified_at' => $data['email_verified_at'],
                'status' => 1
            ]);
        } elseif ($data['role'] == 'pemasok') {
            $pin = mt_rand(100, 999)
                    .mt_rand(100, 999);
            $date = date("Y");
            $kode = "SP".$date.$pin;
            $pemasok = Pemasok::create([
                'nama' => $data['nama'],
                'kode_pemasok' => $kode
            ]);

            return User::create([
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'pemasok_id' => $pemasok->id,
                'email_verified_at' => $data['email_verified_at']
            ]);
        } elseif ($data['role'] == 'karyawan') {
            $karyawan = Karyawan::create([
                'nama' => $data['nama'],
            ]);

            return User::create([
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'karyawan_id' => $karyawan->id,
                'email_verified_at' => $data['email_verified_at'],
                'status' => 1
            ]);
        } elseif ($data['role'] == 'bank') {
            $bank = Bank::create([
                'nama' => $data['nama'],
            ]);

            return User::create([
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'bank_id' => $bank->id,
                'email_verified_at' => $data['email_verified_at'],
                'status' => 1
            ]);
        } elseif ($data['role'] == 'gudang') {
            $pengurusGudang = PengurusGudang::create([
                'nama' => $data['nama'],
            ]);

            return User::create([
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'pengurus_gudang_id' => $pengurusGudang->id,
                'email_verified_at' => $data['email_verified_at']
            ]);
        } else {
            return back()->with('failed', 'Mohon pilih role terlebih dahulu !');
        }
    }
    public function verify()
    {

        return view('auth.verify');
    }
}
