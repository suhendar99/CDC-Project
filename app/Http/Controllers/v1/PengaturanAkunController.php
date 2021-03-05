<?php

namespace App\Http\Controllers\v1;

use App\City;
use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\Karyawan;
use App\Models\Pelanggan;
use App\Models\Pemasok;
use App\Models\PengurusGudang;
use App\Models\Pembeli;
use App\Models\PengurusGudangBulky;
use App\Models\Provinsi;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class PengaturanAkunController extends Controller
{
    public function __construct()
    {
        $this->path = 'app.managementAkun.updateAkun.';
        $this->pathUpdatePassword = 'app.managementAkun.updatePassword.';
        $this->alert = 'Data Berhasil ';
    }

    public function showFormUpdateAkunAdmin()
    {
        $auth = Auth::user();
        $provinsi = Provinsi::all();
        return view($this->path.'updateAkunAdmin', compact('auth','provinsi'));
    }
    public function showFormUpdateAkunPelanggan()
    {
        $auth = Auth::user();
        $provinsi = Provinsi::all();
        $city = City::all();
        return view($this->path.'updateAkunPelanggan', compact('auth','provinsi','city'));
    }
    public function showFormUpdateAkunPemasok()
    {
        $auth = Auth::user();
        $provinsi = Provinsi::all();
        return view($this->path.'updateAkunPemasok', compact('auth','provinsi'));
    }
    public function showFormUpdateAkunPengurusGudang()
    {
        $auth = Auth::user();
        $provinsi = Provinsi::all();
        $bnk = Bank::all();
        return view($this->path.'updateAkunPengurusGudang', compact('auth','provinsi','bnk'));
    }
    public function showFormUpdateAkunKaryawan()
    {
        $auth = Auth::user();
        $provinsi = Provinsi::all();
        $bnk = Bank::all();
        return view($this->path.'updateAkunKaryawan', compact('auth','provinsi','bnk'));
    }
    public function showFormUpdateAkunBank()
    {
        $auth = Auth::user();
        $provinsi = Provinsi::all();
        return view($this->path.'updateAkunBank', compact('auth','provinsi'));
    }
    public function showFormUpdateAkunPembeli()
    {
        $auth = Auth::user();
        $provinsi = Provinsi::all();
        $bank = Bank::all();
        return view($this->path.'updateAkunPembeli', compact('auth','provinsi','bank'));
    }

    // Action
    public function UpdateAkunAdmin(Request $request)
    {
        $v = Validator::make($request->all(),[
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email,'.$request->id,
            'username'  => 'required|string|unique:users,username,'.$request->id,
        ]);
        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        } else {
            $set = User::find($request->id);
            $set->update($request->only('name','username','email'));
        }
        return back()->with('success',$this->alert.'Diubah !');
    }

    public function UpdateAkunPembeli(Request $request)
    {
        // dd($request->all());
        $v = Validator::make($request->all(),[
            'email' => 'required|email|unique:users,email,'.$request->id,
            'username'  => 'required|string|unique:users,username,'.$request->id,
            'nama' => 'required|string|max:100',
            'alamat' => 'required|string|max:200',
            'telepon' => 'required|string|regex:/(08)[0-9]{9}/',
            'nik' => 'required|string|max:17',
            'tempat_lahir' => 'required|string|max:40',
            'tgl_lahir' => 'required|string|',
            'agama' => 'required|string',
            'pekerjaan' => 'required',
            'jenis_kelamin' => 'required',
            'status_perkawinan' => 'required',
            'kewarganegaraan' => 'required',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'desa_id' => 'nullable',
            'kecamatan_id' => 'nullable',
            'kabupaten_id' => 'nullable',
            'provinsi_id' => 'nullable',
            ]);
        if ($v->fails()) {
            // dd($v->errors()->all());
            return back()->withErrors($v)->withInput();
        } else {
            $data = User::find($request->id);
            $set = Pembeli::find($data->pembeli_id);
            if ($request->file('foto')) {
                File::delete($set->foto);
                $name = $request->file('foto');
                $foto = time()."_".$name->getClientOriginalName();
                $request->foto->move("upload/foto/pembeli", $foto);
                if ($request->desa_id == null) {
                    $set->update(array_merge($request->only('nama','nik','tempat_lahir','alamat','telepon','tgl_lahir','agama','pekerjaan','jenis_kelamin','status_perkawinan','kewarganegaraan','kecamatan_id','kabupaten_id','provinsi_id'),[
                        'foto' => 'upload/foto/pembeli/'.$foto
                    ]));
                    $data->update($request->only('username','email'));
                    dd($data);
                } else {
                    $set->update(array_merge($request->only('nama','nik','tempat_lahir','alamat','telepon','tgl_lahir','agama','pekerjaan','jenis_kelamin','status_perkawinan','kewarganegaraan','desa_id','kecamatan_id','kabupaten_id','provinsi_id'),[
                        'foto' => 'upload/foto/pembeli/'.$foto
                    ]));
                    $data->update($request->only('username','email'));
                }
            } else {
                if ($request->desa_id == null) {
                    $set->update(array_merge($request->only('nama','nik','tempat_lahir','alamat','telepon','tgl_lahir','agama','pekerjaan','jenis_kelamin','status_perkawinan','kewarganegaraan','kecamatan_id','kabupaten_id','provinsi_id')));
                    $data->update($request->only('username','email'));
                } else {
                    $set->update(array_merge($request->only('nama','nik','tempat_lahir','alamat','telepon','tgl_lahir','agama','pekerjaan','jenis_kelamin','status_perkawinan','kewarganegaraan','desa_id','kecamatan_id','kabupaten_id','provinsi_id')));
                    $data->update($request->only('username','email'));
                }
            }
            return back()->with('success',$this->alert.'Diubah !');
        }
    }
    public function UpdateAkunPelanggan(Request $request)
    {
        $v = Validator::make($request->all(),[
            'email' => 'required|email|unique:users,email,'.$request->id,
            'username'  => 'required|string|unique:users,username,'.$request->id,
            'nama' => 'required|string|max:100',
            'alamat' => 'required|string|max:200',
            'telepon' => 'required|string|regex:/(08)[0-9]{9}/',
            'nik' => 'required|string|max:17',
            'tempat_lahir' => 'required|string|max:40',
            'tgl_lahir' => 'required|string|',
            'agama' => 'required|string',
            'pekerjaan' => 'required',
            'kota_asal' => 'required',
            'jenis_kelamin' => 'required',
            'status_perkawinan' => 'required',
            'kewarganegaraan' => 'required',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'desa_id' => 'nullable',
            'kecamatan_id' => 'nullable',
            'kabupaten_id' => 'nullable',
            'provinsi_id' => 'nullable',
            ]);
            if ($v->fails()) {
                // dd($v->errors()->all());
                return back()->withErrors($v)->withInput();
        } else {
            $data = User::find($request->id);
            $set = Pelanggan::find($data->pelanggan_id);
            if ($request->file('foto')) {
                File::delete($set->foto);
                $name = $request->file('foto');
                $foto = time()."_".$name->getClientOriginalName();
                $request->foto->move("upload/foto/pelanggan", $foto);
                if ($request->desa_id == null) {
                    $set->update(array_merge($request->only('nama','nik','tempat_lahir','kota_asal','alamat','telepon','tgl_lahir','agama','pekerjaan','jenis_kelamin','status_perkawinan','kewarganegaraan','kecamatan_id','kabupaten_id','provinsi_id'),[
                        'foto' => 'upload/foto/pelanggan/'.$foto
                    ]));
                    $data->update($request->only('username','email'));
                } else {
                    $set->update(array_merge($request->only('nama','nik','tempat_lahir','kota_asal','alamat','telepon','tgl_lahir','agama','pekerjaan','jenis_kelamin','status_perkawinan','kewarganegaraan','desa_id','kecamatan_id','kabupaten_id','provinsi_id'),[
                        'foto' => 'upload/foto/pelanggan/'.$foto
                    ]));
                    $data->update($request->only('username','email'));
                }
            } else {
                if ($request->desa_id == null) {
                    $set->update(array_merge($request->only('nama','nik','tempat_lahir','kota_asal','alamat','telepon','tgl_lahir','agama','pekerjaan','jenis_kelamin','status_perkawinan','kewarganegaraan','kecamatan_id','kabupaten_id','provinsi_id')));
                    $data->update($request->only('username','email'));
                } else {
                    $set->update(array_merge($request->only('nama','nik','tempat_lahir','kota_asal','alamat','telepon','tgl_lahir','agama','pekerjaan','jenis_kelamin','status_perkawinan','kewarganegaraan','desa_id','kecamatan_id','kabupaten_id','provinsi_id')));
                    $data->update($request->only('username','email'));
                }
            }
            return back()->with('success',$this->alert.'Diubah !');
        }
    }
    public function UpdateAkunPemasok(Request $request)
    {
        $v = Validator::make($request->all(),[
            'email' => 'required|email|unique:users,email,'.$request->id,
            'username'  => 'required|string|unique:users,username,'.$request->id,
            'nama' => 'required|string|max:100',
            'alamat' => 'required|string|max:200',
            'telepon' => 'required|string|regex:/(08)[0-9]{9}/',
            'nik' => 'required|string|max:17',
            'tempat_lahir' => 'required|string|max:40',
            'tgl_lahir' => 'required|string|',
            'agama' => 'required|string',
            'pekerjaan' => 'required',
            'jenis_kelamin' => 'required',
            'status_perkawinan' => 'required',
            'kewarganegaraan' => 'required',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'desa_id' => 'nullable',
            'kecamatan_id' => 'nullable',
            'kabupaten_id' => 'nullable',
            'provinsi_id' => 'nullable',
        ]);
        if ($v->fails()) {
            // dd($v->errors()->all());
            return back()->withErrors($v)->withInput();
        } else {
            $data = User::find($request->id);
            $set = Pemasok::find($data->pemasok_id);
            if ($request->file('foto')) {
                File::delete($set->foto);
                $name = $request->file('foto');
                $foto = time()."_".$name->getClientOriginalName();
                $request->foto->move("upload/foto/pemasok", $foto);
                if ($request->desa_id == null) {
                    $set->update(array_merge($request->only('nama','nik','tempat_lahir','alamat','telepon','tgl_lahir','agama','pekerjaan','jenis_kelamin','status_perkawinan','kewarganegaraan','kecamatan_id','kabupaten_id','provinsi_id'),[
                        'foto' => 'upload/foto/pemasok/'.$foto
                    ]));
                    $data->update($request->only('username','email'));
                } else {
                    $set->update(array_merge($request->only('nama','nik','tempat_lahir','alamat','telepon','tgl_lahir','agama','pekerjaan','jenis_kelamin','status_perkawinan','kewarganegaraan','desa_id','kecamatan_id','kabupaten_id','provinsi_id'),[
                        'foto' => 'upload/foto/pemasok/'.$foto
                    ]));
                    $data->update($request->only('username','email'));
                }
            } else {
                if ($request->desa_id == null) {
                    $set->update(array_merge($request->only('nama','nik','tempat_lahir','alamat','telepon','tgl_lahir','agama','pekerjaan','jenis_kelamin','status_perkawinan','kewarganegaraan','kecamatan_id','kabupaten_id','provinsi_id')));
                    $data->update($request->only('username','email'));
                } else {
                    $set->update(array_merge($request->only('nama','nik','tempat_lahir','alamat','telepon','tgl_lahir','agama','pekerjaan','jenis_kelamin','status_perkawinan','kewarganegaraan','desa_id','kecamatan_id','kabupaten_id','provinsi_id')));
                    $data->update($request->only('username','email'));
                }
            }
            return back()->with('success',$this->alert.'Diubah !');
        }
    }
    public function UpdateAkunPengurusGudang(Request $request)
    {
        $v = Validator::make($request->all(),[
            'email' => 'required|email|unique:users,email,'.$request->id,
            'username'  => 'required|string|unique:users,username,'.$request->id,
            'nama' => 'required|string|max:100',
            'alamat' => 'required|string|max:200',
            'telepon' => 'required|string|regex:/(08)[0-9]{9}/',
            'nik' => 'required|string|max:17',
            'no_rek' => 'required|numeric',
            'bank_id' => 'required',
            'tempat_lahir' => 'required|string|max:40',
            'tgl_lahir' => 'required|string|',
            'agama' => 'required|string',
            'pekerjaan' => 'required',
            'jenis_kelamin' => 'required',
            'status_perkawinan' => 'required',
            'kewarganegaraan' => 'required',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'desa_id' => 'nullable',
            'kecamatan_id' => 'nullable',
            'kabupaten_id' => 'nullable',
            'provinsi_id' => 'nullable',
        ]);
        if ($v->fails()) {
            // dd($v->errors()->all());
            return back()->withErrors($v)->withInput();
        } else {
            $data = User::find($request->id);
            $set = PengurusGudang::find($data->pengurus_gudang_id);
            if ($request->file('foto')) {
                File::delete($set->foto);
                $name = $request->file('foto');
                $foto = time()."_".$name->getClientOriginalName();
                $request->foto->move("upload/foto/pengurus_gudang", $foto);
                if ($request->desa_id == null) {
                    $set->update(array_merge($request->only('nama','nik','no_rek','tempat_lahir','alamat','telepon','tgl_lahir','agama','pekerjaan','jenis_kelamin','status_perkawinan','kewarganegaraan','kecamatan_id','kabupaten_id','provinsi_id','bank_id'),[
                        'foto' => 'upload/foto/pengurus_gudang/'.$foto
                    ]));
                    $data->update($request->only('username','email'));
                } else {
                    $set->update(array_merge($request->only('nama','nik','no_rek','tempat_lahir','alamat','telepon','tgl_lahir','agama','pekerjaan','jenis_kelamin','status_perkawinan','kewarganegaraan','desa_id','kecamatan_id','kabupaten_id','provinsi_id','bank_id'),[
                        'foto' => 'upload/foto/pengurus_gudang/'.$foto
                    ]));
                    $data->update($request->only('username','email'));
                }
            } else {
                if ($request->desa_id == null) {
                    $set->update(array_merge($request->only('nama','nik','no_rek','tempat_lahir','alamat','telepon','tgl_lahir','agama','pekerjaan','jenis_kelamin','status_perkawinan','kewarganegaraan','kecamatan_id','kabupaten_id','provinsi_id','bank_id')));
                    $data->update($request->only('username','email'));
                } else {
                    $set->update(array_merge($request->only('nama','nik','no_rek','tempat_lahir','alamat','telepon','tgl_lahir','agama','pekerjaan','jenis_kelamin','status_perkawinan','kewarganegaraan','desa_id','kecamatan_id','kabupaten_id','provinsi_id','bank_id')));
                    $data->update($request->only('username','email'));
                }
            }
            return back()->with('success',$this->alert.'Diubah !');
        }
    }
    public function UpdateAkunKaryawan(Request $request)
    {
        $v = Validator::make($request->all(),[
            'email' => 'required|email|unique:users,email,'.$request->id,
            'username'  => 'required|string|unique:users,username,'.$request->id,
            'nama' => 'required|string|max:100',
            'alamat' => 'required|string|max:200',
            'telepon' => 'required|string|regex:/(08)[0-9]{9}/',
            'nik' => 'required|string|max:17',
            'no_rek' => 'required|numeric',
            'bank_id' => 'required',
            'tempat_lahir' => 'required|string|max:40',
            'tgl_lahir' => 'required|string|',
            'agama' => 'required|string',
            'pekerjaan' => 'required',
            'jenis_kelamin' => 'required',
            'status_perkawinan' => 'required',
            'kewarganegaraan' => 'required',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'desa_id' => 'nullable',
            'kecamatan_id' => 'nullable',
            'kabupaten_id' => 'nullable',
            'provinsi_id' => 'nullable',
        ]);
        if ($v->fails()) {
            // dd($v->errors()->all());
            return back()->withErrors($v)->withInput();
        } else {
            $data = User::find($request->id);
            $set = PengurusGudangBulky::find($data->pengurus_gudang_bulky_id);
            if ($request->file('foto')) {
                File::delete($set->foto);
                $name = $request->file('foto');
                $foto = time()."_".$name->getClientOriginalName();
                $request->foto->move("upload/foto/pengurus_gudang_bulky", $foto);
                if ($request->desa_id == null) {
                    $set->update(array_merge($request->only('nama','nik','no_rek','tempat_lahir','alamat','telepon','tgl_lahir','agama','pekerjaan','jenis_kelamin','status_perkawinan','kewarganegaraan','kecamatan_id','kabupaten_id','provinsi_id','bank_id'),[
                        'foto' => 'upload/foto/pengurus_gudang_bulky/'.$foto
                    ]));
                    $data->update($request->only('username','email'));
                } else {
                    $set->update(array_merge($request->only('nama','nik','no_rek','tempat_lahir','alamat','telepon','tgl_lahir','agama','pekerjaan','jenis_kelamin','status_perkawinan','kewarganegaraan','desa_id','kecamatan_id','kabupaten_id','provinsi_id','bank_id'),[
                        'foto' => 'upload/foto/pengurus_gudang_bulky/'.$foto
                    ]));
                    $data->update($request->only('username','email'));
                }
            } else {
                if ($request->desa_id == null) {
                    $set->update(array_merge($request->only('nama','nik','no_rek','tempat_lahir','alamat','telepon','tgl_lahir','agama','pekerjaan','jenis_kelamin','status_perkawinan','kewarganegaraan','kecamatan_id','kabupaten_id','provinsi_id','bank_id')));
                    $data->update($request->only('username','email'));
                } else {
                    $set->update(array_merge($request->only('nama','nik','no_rek','tempat_lahir','alamat','telepon','tgl_lahir','agama','pekerjaan','jenis_kelamin','status_perkawinan','kewarganegaraan','desa_id','kecamatan_id','kabupaten_id','provinsi_id','bank_id')));
                    $data->update($request->only('username','email'));
                }
            }
            return back()->with('success',$this->alert.'Diubah !');
        }
    }
    public function UpdateAkunBank(Request $request)
    {
        $date = Carbon::now()->format('Y');
        $v = Validator::make($request->all(),[
            'email' => 'required|email|unique:users,email,'.$request->id,
            'username'  => 'required|string|unique:users,username,'.$request->id,
            'nama' => 'required|string|max:100',
            'alamat' => 'required|string|max:200',
            'tahun_berdiri' => 'required|integer|min:1900|max:'.$date,
            'telepon' => 'required|string|regex:/(08)[0-9]{9}/',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'desa_id' => 'nullable',
            'kecamatan_id' => 'nullable',
            'kabupaten_id' => 'nullable',
            'provinsi_id' => 'nullable',
        ]);
        if ($v->fails()) {
            // dd($v->errors()->all());
            return back()->withErrors($v)->withInput();
        } else {
            $data = User::find($request->id);
            $set = Bank::find($data->bank_id);
            if ($request->file('foto')) {
                File::delete($set->foto);
                $name = $request->file('foto');
                $foto = time()."_".$name->getClientOriginalName();
                $request->foto->move("upload/foto/bank", $foto);
                if ($request->desa_id == null) {
                    $set->update(array_merge($request->only('nama','alamat','telepon','tahun_berdiri','kecamatan_id','kabupaten_id','provinsi_id'),[
                        'foto' => 'upload/foto/bank/'.$foto
                    ]));
                    $data->update($request->only('username','email'));
                } else {
                    $set->update(array_merge($request->only('nama','alamat','telepon','tahun_berdiri','desa_id','kecamatan_id','kabupaten_id','provinsi_id'),[
                        'foto' => 'upload/foto/bank/'.$foto
                    ]));
                    $data->update($request->only('username','email'));
                }
            } else {
                if ($request->desa_id == null) {
                    $set->update(array_merge($request->only('nama','alamat','telepon','tahun_berdiri','kecamatan_id','kabupaten_id','provinsi_id')));
                    $data->update($request->only('username','email'));
                } else {
                    $set->update(array_merge($request->only('nama','alamat','telepon','tahun_berdiri','desa_id','kecamatan_id','kabupaten_id','provinsi_id')));
                    $data->update($request->only('username','email'));
                }
            }
        }
        return back()->with('success',$this->alert.'Diubah !');
    }
    public function updatePassword()
    {
        $auth = Auth::user();
        return view($this->pathUpdatePassword.'index',compact('auth'));
    }
    public function actionUpdatePassword(Request $request)
    {
        $user = User::find($request->id);
        if (Hash::check($request->old_password, $user->password)) {
            $v = Validator::make($request->all(),[
                'old_password' => 'required',
                'new_password' => 'required|confirmed|min:6',
                'new_password_confirmation' => 'required'
            ]);

            if ($v->fails()) {
                dd($v->errors()->all());
                return back()->withErrors($v)->withInput();
            }
            $user = User::find($request->id)->update(['password' => Hash::make($request->new_password)]);

            return back()->with('success',  __('Update Data Password Berhasil.'));
        } else {
            $v = Validator::make($request->all(),[
                'old_password' => 'required',
            ],[
                'old_password.required' => 'Password Lama Harus diisi !',
            ]);
            if ($v->fails()) {
                return back()->withErrors($v)->withInput();
            }

            return back()->with('success',  __('Update Data Password Berhasil.'));
        }
    }
}
