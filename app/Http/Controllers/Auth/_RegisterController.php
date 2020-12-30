<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use App\Models\Pemasok;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    protected $redirectTo = RouteServiceProvider::HOME;

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $v = Validator::make($request->all(),[
            'nama' => 'required|string|max:100',
            'username' => 'required|alpha_dash|unique:users,username',
            'email' => 'required|email|unique:users,email,',
            'password' => 'required|string|min:8|confirmed',
            'alamat' => 'required|string|max:200',
            'telepon' => 'required|string|regex:/(08)[0-9]{9}/'
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        } else {
            $role = $request->role;
            if ($role == 'pelanggan') {
                $pelanggan = Pelanggan::create($request->only('alamat','telepon'));

                User::create(array_merge($request->only('nama','username','email'),[
                    'password' => Hash::make($request->password),
                    'pelanggan_id' => $pelanggan->id
                ]));

            } elseif ($role == 'pemasok') {
                $pemasok = Pemasok::create($request->only('alamat','telepon'));

                User::create(array_merge($request->only('nama','username','email'),[
                    'password' => Hash::make($request->password),
                    'pelanggan_id' => $pemasok->id
                ]));
            } elseif ($role == 'karyawan') {
                $karyawan = Karyawan::create($request->only('alamat','telepon'));

                User::create(array_merge($request->only('nama','username','email'),[
                    'password' => Hash::make($request->password),
                    'pelanggan_id' => $karyawan->id
                ]));
            } elseif ($role == 'bank') {
                # code...
            }
        }
    }
}
