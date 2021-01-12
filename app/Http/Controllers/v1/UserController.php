<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\Karyawan;
use App\Models\Pelanggan;
use App\Models\Pemasok;
use App\Models\PengurusGudang;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function __construct()
    {
        $this->Data = new User;

        $this->path = 'app.data-master.user.';
        $this->alert = 'Data Berhasil ';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = $this->Data->getData();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    return '<a href="/v1/user/'.$data->id.'/edit" class="btn btn-primary btn-sm">Edit</a>&nbsp;<a href="#" class="btn btn-danger btn-sm" onclick="sweet('.$data->id.')">Hapus</a>';
                })
                ->addColumn('status', function($data){
                    if ($data->status == 1) {
                        return '<a style="text-decoration:none;" class="text-primary font-weight-bold">AKTIF </a>&nbsp;<a href="/v1/user/'.$data->id.'/unapprove" class="btn btn-danger btn-sm">Non-Aktifkan</a>';
                    } else{
                        return '<a href="/v1/user/'.$data->id.'/approve" class="btn btn-success btn-sm">Aktifkan</a>&nbsp;<a style="text-decoration:none;" class="text-danger font-weight-bold"> NON-AKTIF</a>';
                    }
                })
                ->addColumn('role', function($data){
                    if ($data->pengurus_gudang_id != null) {
                        return 'Karyawan Gudang';
                    } elseif ($data->bank_id != null) {
                        return 'Pihak Bank';
                    } elseif ($data->pemasok_id != null) {
                        return 'Pemasok';
                    } elseif ($data->pelanggan_id != null) {
                        return 'Pembeli';
                    }
                })
                ->addColumn('foto_ktp', function($data){
                    if ($data->pengurus_gudang_id != null) {
                        if ($data->pengurusGudang->foto_ktp !=null) {
                            return '<a data-toggle="modal" data-target="#fotoKtpGudang" onclick="detailFotoKtpPengurusGudang('.$data->id.')" data-id="'.$data->id.'" style="cursor: pointer;" title="Detail"><img src="'.asset($data->pengurusGudang->foto_ktp).'" alt="" height="50" width="100"></a>';
                        } else {
                            return '<center>No Foto !</center>';
                        }
                    } elseif ($data->bank_id != null) {
                        return 'Tidak Mempunyai Foto KTP';
                    } elseif ($data->pemasok_id != null) {
                        if ($data->pemasok->foto_ktp !=null) {
                            return '<a data-toggle="modal" data-target="#fotoKtpPemasok" onclick="detailFotoKtpPemasok('.$data->id.')" data-id="'.$data->id.'" style="cursor: pointer;" title="Detail"><img src="'.asset($data->pemasok->foto_ktp).'" alt="" height="50" width="100"></a>';
                        } else {
                            return '<center>No Foto !</center>';
                        }
                    } elseif ($data->pelanggan_id != null) {
                        return 'Tidak Mempunyai Foto KTP';
                    }
                })
                ->addColumn('foto_ktp_selfie', function($data){
                    if ($data->pengurus_gudang_id != null) {
                        if ($data->pengurusGudang->foto_ktp !=null) {
                            return '<a data-toggle="modal" data-target="#fotoKtpSelfieGudang" onclick="detailFotoKtpSelfiePengurusGudang('.$data->id.')" data-id="'.$data->id.'" style="cursor: pointer;" title="Detail"><img src="'.asset($data->pengurusGudang->foto_ktp).'" alt="" height="50" width="100"></a>';
                        } else {
                            return '<center>No Foto !</center>';
                        }
                    } elseif ($data->bank_id != null) {
                        return 'Tidak Mempunyai Foto KTP';
                    } elseif ($data->pemasok_id != null) {
                        if ($data->pemasok->foto_ktp !=null) {
                            return '<a data-toggle="modal" data-target="#fotoKtpSelfiePemasok" onclick="detailFotoKtpSelfiePemasok('.$data->id.')" data-id="'.$data->id.'" style="cursor: pointer;" title="Detail"><img src="'.asset($data->pemasok->foto_ktp).'" alt="" height="50" width="100"></a>';
                        } else {
                            return '<center>No Foto !</center>';
                        }
                    } elseif ($data->pelanggan_id != null) {
                        return 'Tidak Mempunyai Foto KTP';
                    }
                })
                ->addColumn('nik', function($data){
                    if ($data->pengurus_gudang_id != null) {
                        if ($data->pengurusGudang->nik != null) {
                            return $data->pengurusGudang->nik;
                        } else {
                            return 'Kosong';
                        }
                    } elseif ($data->bank_id != null) {
                        if ($data->bank->nik != null) {
                            return $data->bank->nik;
                        } else {
                            return 'Kosong';
                        }
                    } elseif ($data->pemasok_id != null) {
                        if ($data->pemasok->nik != null) {
                            return $data->pemasok->nik;
                        } else {
                            return 'Kosong';
                        }
                    } elseif ($data->pelanggan_id != null) {
                        if ($data->pelanggan->nik != null) {
                            return $data->pelanggan->nik;
                        } else {
                            return 'Kosong';
                        }
                    }
                })
                ->rawColumns(['action','status','role','foto_ktp','foto_ktp_selfie'])
                ->make(true);
        }
        return view($this->path.'index');
    }

    public function approve($id)
    {
        $user = User::findOrFail($id);
        $user->update(['approved_at' => now(),'status' => 1]);

        return redirect()->back()->withMessage('User diaktifkan');
    }
    public function unapprove($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 0]);

        return redirect()->back()->withMessage('User di non-aktifkan !');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view($this->path.'create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $v = Validator::make($request->all(),[
            'nama' => 'required|string|max:20',
            'username' => 'nullable|string|max:20',
            'email' => 'required|email|unique:users,email,',
            'password' => 'required|string|min:8',
        ]);
        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        } else {
            $pin = mt_rand(100, 999)
                    .mt_rand(100, 999);
            $date = date("Y");
            $kode = "SP".$date.$pin;

            if ($request->role == 'pelanggan') {
                $pelanggan = Pelanggan::create([
                    'nama' => $request->nama
                ]);

                User::create(array_merge($request->only('username','email'),[
                    'password' => Hash::make($request->password),
                    'pelanggan_id' => $pelanggan->id,

                ]));
            } elseif ($request->role == 'karyawan') {
                $karyawan = Karyawan::create([
                    'nama' => $request->nama
                ]);

                User::create(array_merge($request->only('username','email'),[
                    'password' => Hash::make($request->password),
                    'karyawan_id' => $karyawan->id,

                ]));
            } elseif ($request->role == 'bank') {
                $bank = Bank::create([
                    'nama' => $request->nama
                ]);

                User::create(array_merge($request->only('username','email'),[
                    'password' => Hash::make($request->password),
                    'bank_id' => $bank->id,

                ]));
            } elseif ($request->role == 'pemasok') {
                $pemasok = Pemasok::create([
                    'nama' => $request->nama,
                    'kode_pemasok' => $kode
                ]);

                User::create(array_merge($request->only('username','email'),[
                    'password' => Hash::make($request->password),
                    'pemasok_id' => $pemasok->id,

                ]));
            } elseif ($request->role == 'pengurus gudang') {
                $pengurusGudang = PengurusGudang::create([
                    'nama' => $request->nama,
                    // 'kode_pemasok' => $kode
                ]);

                User::create(array_merge($request->only('username','email'),[
                    'password' => Hash::make($request->password),
                    'pengurus_gudang_id' => $pengurusGudang->id,

                ]));
            } else {
                return back()->with('failed', "Mohon Pilih Kembali Role !");
            }
        }
        return back()->with('success',$this->alert.'Disimpan !');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = User::with('pemasok','pengurusGudang','bank','pelanggan')->where('id',$id)->get();

        return response()->json([
            'data' => $data
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = User::findOrFail($id);
        return view($this->path.'edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $v = Validator::make($request->all(),[
            // 'name' => 'required|string|max:20',
            'username' => 'nullable|string|max:20',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'nullable|string|min:8',
        ]);
        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        } else {
            $user = User::find($id);

            if ($request->role == 'pelanggan') {
                // $pelanggan = Pelanggan::create([
                //     'nama' => $request->nama
                // ]);

                $user->update(array_merge($request->only('username','email'),[
                    'password' => Hash::make($request->password),
                    // 'pelanggan_id' => $pelanggan->id
                ]));
            } elseif ($request->role == 'karyawan') {
                // $karyawan = Karyawan::create([
                //     'nama' => $request->nama
                // ]);

                $user->update(array_merge($request->only('username','email'),[
                    'password' => Hash::make($request->password),
                    // 'karyawan_id' => $karyawan->id
                ]));
            } elseif ($request->role == 'bank') {
                // $bank = Bank::create([
                //     'nama' => $request->nama
                // ]);

                $user->update(array_merge($request->only('username','email'),[
                    'password' => Hash::make($request->password),
                    // 'bank_id' => $bank->id
                ]));
            } elseif ($request->role == 'pemasok') {
                // $pemasok = Pemasok::create([
                //     'nama' => $request->nama,
                // ]);

                $user->update(array_merge($request->only('username','email'),[
                    'password' => Hash::make($request->password),
                    // 'pemasok_id' => $pemasok->id
                ]));
            } elseif ($request->role == 'pengurus gudang') {
                // $pengurusGudang = PengurusGudang::create([
                //     'nama' => $request->nama,
                // ]);

                $user->update(array_merge($request->only('username','email'),[
                    'password' => Hash::make($request->password),
                    // 'pengurus_gudang_id' => $pengurusGudang->id
                ]));
            } else {
                return back()->with('failed', "Mohon Pilih Kembali Role !");
            }
        }
        return back()->with('success',$this->alert.'Diedit !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();

        return back();
    }
}
