<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\Pemasok;
use App\Models\Provinsi;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PemasokController extends Controller
{
    public function __construct()
    {
        $this->Data = new Pemasok;

        $this->path = 'app.data-master.pemasok.';
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
                    return '<a href="/v1/pemasok/'.$data->id.'/edit" class="btn btn-primary btn-sm">Edit</a>&nbsp;<a class="btn btn-info btn-sm" data-toggle="modal" data-target="#exampleModal" onclick="detail('.$data->id.')" data-id="'.$data->id.'" style="cursor: pointer;" title="Detail">Detail</a>&nbsp;<a href="#" class="btn btn-danger btn-sm" onclick="sweet('.$data->id.')">Hapus</a>';
                })
                ->make(true);
        }
        return view($this->path.'index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $provinsi = Provinsi::all();
        return view($this->path.'create',compact('provinsi'));
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
            if ($request->file('foto')) {
                $pin = mt_rand(100, 999)
                        .mt_rand(100, 999);
                $date = date("Y");
                $kode = "PMSK".$date.$pin;
                $name = $request->file('foto');
                $foto = time()."_".$name->getClientOriginalName();
                $request->foto->move(public_path("upload/foto/pemasok"), $foto);
                if ($request->desa_id == null) {
                    $pemasok = Pemasok::create(array_merge($request->only('nama','nik','tempat_lahir','alamat','telepon','tgl_lahir','agama','pekerjaan','jenis_kelamin','status_perkawinan','kewarganegaraan','kecamatan_id','kabupaten_id','provinsi_id'),[
                        'foto' => 'upload/foto/pemasok/'.$foto,
                        'kode_pemasok' => $kode,
                    ]));
                } else {
                    $pemasok = Pemasok::create(array_merge($request->only('nama','nik','tempat_lahir','alamat','telepon','tgl_lahir','agama','pekerjaan','jenis_kelamin','status_perkawinan','kewarganegaraan','desa_id','kecamatan_id','kabupaten_id','provinsi_id'),[
                        'foto' => 'upload/foto/pemasok/'.$foto,
                        'kode_pemasok' => $kode,
                    ]));
                }
            } else {
                $pin = mt_rand(100, 999)
                        .mt_rand(100, 999);
                $date = date("Y");
                $kode = "PMSK".$date.$pin;
                if ($request->desa_id == null) {
                    $pemasok = Pemasok::create(array_merge($request->only('nama','nik','tempat_lahir','alamat','telepon','tgl_lahir','agama','pekerjaan','jenis_kelamin','status_perkawinan','kewarganegaraan','kecamatan_id','kabupaten_id','provinsi_id'),[
                        'kode_pemasok' => $kode,
                    ]));
                } else {
                    $pemasok = Pemasok::create(array_merge($request->only('nama','nik','tempat_lahir','alamat','telepon','tgl_lahir','agama','pekerjaan','jenis_kelamin','status_perkawinan','kewarganegaraan','desa_id','kecamatan_id','kabupaten_id','provinsi_id'),[
                        'kode_pemasok' => $kode,
                    ]));
                }
            }
            $numRand = mt_rand(100, 999);
            $nama = $request->nama;
            $subStr = explode(' ',trim($nama));
            User::create([
                'username' => $subStr[0].$numRand,
                'email' => $subStr[0].$numRand."@gmail.com",
                'password' => Hash::make('12341234'),
                'pemasok_id' => $pemasok->id
            ]);
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
        $data = Pemasok::with('desa','kecamatan','kabupaten')->where('id',$id)->get();

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
        $data = Pemasok::findOrFail($id);
        $provinsi = Provinsi::all();
        return view($this->path.'edit',compact('data','provinsi'));
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
            $set = Pemasok::find($id);
            if ($request->file('foto')) {
                File::delete($set->foto);
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
        $data = $this->Data->find($id);
        File::delete($data->foto);
        $data->delete();

        return back();
    }
}
