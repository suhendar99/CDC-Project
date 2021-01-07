<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\Desa;
use App\Models\Kabupaten;
use App\Models\Karyawan;
use App\Models\Kecamatan;
use App\Models\Pelanggan;
use App\Models\Pemasok;
use App\Models\PengurusGudang;
use App\Models\Provinsi;
use App\User;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
	public function __construct()
	{
		$this->pathPemasok = 'app.dashboard.pemasok.';
		$this->pathPelanggan = 'app.dashboard.pelanggan.';
		$this->pathKaryawan = 'app.dashboard.karyawan.';
        $this->pathAdmin = 'app.dashboard.admin.';
        $this->pathBank = 'app.dashboard.bank.';
        $this->pathPengurusGudang = 'app.dashboard.pengurusGudang.';

        $this->pathCompleteAkun = 'app.managementAkun.completeAkun.';
	}

    public function index()
    {
        $auth = Auth::user();
        $provinsi = Provinsi::all();
    	if ($auth->pemasok_id != null) {
            if ($auth->pemasok->nik == null) {
                return view($this->pathCompleteAkun.'completeAkunPemasok',compact('auth','provinsi'));
            }
            if ($auth->status == 0) {
                Auth::logout();
                return redirect('/');
            }
            return view($this->pathPemasok.'index');
    	} elseif ($auth->karyawan_id != null) {
            if ($auth->karyawan->nik == null) {
                return view($this->pathCompleteAkun.'completeAkunKaryawan',compact('auth','provinsi'));
            }
            if ($auth->status == 0) {
                Auth::logout();
                return redirect('/');
            }
            return view($this->pathKaryawan.'index');
    	} elseif ($auth->pelanggan_id != null) {
            if ($auth->pelanggan->nik == null) {
                return view($this->pathCompleteAkun.'completeAkunPelanggan',compact('auth','provinsi'));
            }
            if ($auth->status == 0) {
                Auth::logout();
                return redirect('/');
            }
            return view($this->pathPelanggan.'index');
    	}elseif ($auth->bank_id != null) {
            if ($auth->bank->tahun_berdiri == null) {
                return view($this->pathCompleteAkun.'completeAkunBank',compact('auth','provinsi'));
            }
            if ($auth->status == 0) {
                Auth::logout();
                return redirect('/');
            }
            return view($this->pathBank.'index');
    	}elseif ($auth->pengurus_gudang_id != null) {
            if ($auth->pengurusGudang->nik == null) {
                return view($this->pathCompleteAkun.'completeAkunPengurusGudang',compact('auth','provinsi'));
            }
            if ($auth->status == 0) {
                Auth::logout();
                return redirect('/');
            }
            return view($this->pathPengurusGudang.'index');
    	} else {
    		return view($this->pathAdmin.'index');
    	}
    }
    public function getDesa($id)
    {
        $data = Desa::where('kecamatan_id',$id)->get();
        return response()->json([
            'code' => 200,
            'data' => $data,
        ]);
    }
    public function getKecamatan($id)
    {
        $data = Kecamatan::where('kabupaten_id',$id)->get();
        return response()->json([
            'code' => 200,
            'data' => $data,
        ]);
    }
    public function getKabupaten($id)
    {
        $data = Kabupaten::where('provinsi_id',$id)->get();
        return response()->json([
            'code' => 200,
            'data' => $data,
        ]);
    }
    public function approval()
    {
        return view('approval');
    }
    public function complete(Request $request, $id)
    {
        $auth = Auth::user();
        $data = User::find($id);
        if ($auth->pemasok_id != null) {
            $v = Validator::make($request->all(),[
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
                $set = Pemasok::find($data->pemasok_id);
                if ($request->file('foto')) {
                    $name = $request->file('foto');
                    $foto = time()."_".$name->getClientOriginalName();
                    $request->foto->move(public_path("upload/foto/pemasok"), $foto);
                    if ($request->desa_id == null) {
                        $set->update(array_merge($request->only('nama','nik','tempat_lahir','alamat','telepon','tgl_lahir','agama','pekerjaan','jenis_kelamin','status_perkawinan','kewarganegaraan','kecamatan_id','kabupaten_id','provinsi_id'),[
                            'foto' => 'upload/foto/pemasok/'.$foto
                        ]));
                    } else {
                        $set->update(array_merge($request->only('nama','nik','tempat_lahir','alamat','telepon','tgl_lahir','agama','pekerjaan','jenis_kelamin','status_perkawinan','kewarganegaraan','desa_id','kecamatan_id','kabupaten_id','provinsi_id'),[
                            'foto' => 'upload/foto/pemasok/'.$foto
                        ]));
                    }
                } else {
                    if ($request->desa_id == null) {
                        $set->update(array_merge($request->only('nama','nik','tempat_lahir','alamat','telepon','tgl_lahir','agama','pekerjaan','jenis_kelamin','status_perkawinan','kewarganegaraan','kecamatan_id','kabupaten_id','provinsi_id')));
                    } else {
                        $set->update(array_merge($request->only('nama','nik','tempat_lahir','alamat','telepon','tgl_lahir','agama','pekerjaan','jenis_kelamin','status_perkawinan','kewarganegaraan','desa_id','kecamatan_id','kabupaten_id','provinsi_id')));
                    }
                }
            }
        } elseif ($auth->pelanggan_id != null) {
            $v = Validator::make($request->all(),[
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
                $set = Pelanggan::find($data->pelanggan_id);
                if ($request->file('foto')) {
                    $name = $request->file('foto');
                    $foto = time()."_".$name->getClientOriginalName();
                    $request->foto->move(public_path("upload/foto/pelanggan"), $foto);
                    if ($request->desa_id == null) {
                        $set->update(array_merge($request->only('nama','nik','tempat_lahir','alamat','telepon','tgl_lahir','agama','pekerjaan','jenis_kelamin','status_perkawinan','kewarganegaraan','kecamatan_id','kabupaten_id','provinsi_id'),[
                            'foto' => 'upload/foto/pelanggan/'.$foto
                        ]));
                    } else {
                        $set->update(array_merge($request->only('nama','nik','tempat_lahir','alamat','telepon','tgl_lahir','agama','pekerjaan','jenis_kelamin','status_perkawinan','kewarganegaraan','desa_id','kecamatan_id','kabupaten_id','provinsi_id'),[
                            'foto' => 'upload/foto/pelanggan/'.$foto
                        ]));
                    }
                } else {
                    if ($request->desa_id == null) {
                        $set->update(array_merge($request->only('nama','nik','tempat_lahir','alamat','telepon','tgl_lahir','agama','pekerjaan','jenis_kelamin','status_perkawinan','kewarganegaraan','kecamatan_id','kabupaten_id','provinsi_id')));
                    } else {
                        $set->update(array_merge($request->only('nama','nik','tempat_lahir','alamat','telepon','tgl_lahir','agama','pekerjaan','jenis_kelamin','status_perkawinan','kewarganegaraan','desa_id','kecamatan_id','kabupaten_id','provinsi_id')));
                    }
                }
            }
        } elseif ($auth->karyawan_id != null) {
            $v = Validator::make($request->all(),[
                'nama' => 'required|string|max:100',
                'alamat' => 'required|string|max:200',
                'telepon' => 'required|string|regex:/(08)[0-9]{9}/',
                'nik' => 'required|string|max:17',
                'tempat_lahir' => 'required|string|max:40',
                'tgl_lahir' => 'required|string|',
                'agama' => 'required|string',
                'jabatan' => 'required',
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
                $set = Karyawan::find($data->karyawan_id);
                if ($request->file('foto')) {
                    $name = $request->file('foto');
                    $foto = time()."_".$name->getClientOriginalName();
                    $request->foto->move(public_path("upload/foto/karyawan"), $foto);
                    if ($request->desa_id == null) {
                        $set->update(array_merge($request->only('nama','nik','tempat_lahir','alamat','telepon','tgl_lahir','agama','jabatan','jenis_kelamin','status_perkawinan','kewarganegaraan','kecamatan_id','kabupaten_id','provinsi_id'),[
                            'foto' => 'upload/foto/karyawan/'.$foto
                        ]));
                    } else {
                        $set->update(array_merge($request->only('nama','nik','tempat_lahir','alamat','telepon','tgl_lahir','agama','jabatan','jenis_kelamin','status_perkawinan','kewarganegaraan','desa_id','kecamatan_id','kabupaten_id','provinsi_id'),[
                            'foto' => 'upload/foto/karyawan/'.$foto
                        ]));
                    }
                } else {
                    if ($request->desa_id == null) {
                        $set->update(array_merge($request->only('nama','nik','tempat_lahir','alamat','telepon','tgl_lahir','agama','jabatan','jenis_kelamin','status_perkawinan','kewarganegaraan','kecamatan_id','kabupaten_id','provinsi_id')));
                    } else {
                        $set->update(array_merge($request->only('nama','nik','tempat_lahir','alamat','telepon','tgl_lahir','agama','jabatan','jenis_kelamin','status_perkawinan','kewarganegaraan','desa_id','kecamatan_id','kabupaten_id','provinsi_id')));
                    }
                }
            }
        } elseif ($auth->pengurus_gudang_id != null) {
            $v = Validator::make($request->all(),[
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
                $set = PengurusGudang::find($data->pengurus_gudang_id);
                if ($request->file('foto')) {
                    $name = $request->file('foto');
                    $foto = time()."_".$name->getClientOriginalName();
                    $request->foto->move(public_path("upload/foto/pengurus_gudang"), $foto);
                    if ($request->desa_id == null) {
                        $set->update(array_merge($request->only('nama','nik','tempat_lahir','alamat','telepon','tgl_lahir','agama','pekerjaan','jenis_kelamin','status_perkawinan','kewarganegaraan','kecamatan_id','kabupaten_id','provinsi_id'),[
                            'foto' => 'upload/foto/pengurus_gudang/'.$foto
                        ]));
                    } else {
                        $set->update(array_merge($request->only('nama','nik','tempat_lahir','alamat','telepon','tgl_lahir','agama','pekerjaan','jenis_kelamin','status_perkawinan','kewarganegaraan','desa_id','kecamatan_id','kabupaten_id','provinsi_id'),[
                            'foto' => 'upload/foto/pengurus_gudang/'.$foto
                        ]));
                    }
                } else {
                    if ($request->desa_id == null) {
                        $set->update(array_merge($request->only('nama','nik','tempat_lahir','alamat','telepon','tgl_lahir','agama','pekerjaan','jenis_kelamin','status_perkawinan','kewarganegaraan','kecamatan_id','kabupaten_id','provinsi_id')));
                    } else {
                        $set->update(array_merge($request->only('nama','nik','tempat_lahir','alamat','telepon','tgl_lahir','agama','pekerjaan','jenis_kelamin','status_perkawinan','kewarganegaraan','desa_id','kecamatan_id','kabupaten_id','provinsi_id')));
                    }
                }
            }
        } elseif ($auth->bank_id != null) {
            $date = Carbon::now()->format('Y');
            $v = Validator::make($request->all(),[
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
                $set = Bank::find($data->bank_id);
                if ($request->file('foto')) {
                    $name = $request->file('foto');
                    $foto = time()."_".$name->getClientOriginalName();
                    $request->foto->move(public_path("upload/foto/bank"), $foto);
                    if ($request->desa_id == null) {
                        $set->update(array_merge($request->only('nama','alamat','telepon','tahun_berdiri','kecamatan_id','kabupaten_id','provinsi_id'),[
                            'foto' => 'upload/foto/bank/'.$foto
                        ]));
                    } else {
                        $set->update(array_merge($request->only('nama','alamat','telepon','tahun_berdiri','desa_id','kecamatan_id','kabupaten_id','provinsi_id'),[
                            'foto' => 'upload/foto/bank/'.$foto
                        ]));
                    }
                } else {
                    if ($request->desa_id == null) {
                        $set->update(array_merge($request->only('nama','alamat','telepon','tahun_berdiri','kecamatan_id','kabupaten_id','provinsi_id')));
                    } else {
                        $set->update(array_merge($request->only('nama','alamat','telepon','tahun_berdiri','desa_id','kecamatan_id','kabupaten_id','provinsi_id')));
                    }
                }
            }
        }

        if ($set = true) {
            return redirect('v1/dashboard')->with('success',  __('Data Sudah Dilengkapi, Terima Kasih Sudah melengkapi.'));
        } else {
            return redirect('v1/dashboard')->with('failed',  __('Update Data Gagal.'));
        }
    }
}
