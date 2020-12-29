<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PelangganController extends Controller
{
    public function __construct()
    {
        $this->Data = new Pelanggan;

        $this->path = 'app.data-master.pembeli.';
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
                    return '<a href="/v1/pelanggan/'.$data->id.'/edit" class="btn btn-primary btn-sm">Edit</a>&nbsp;<a href="#" class="btn btn-danger btn-sm" onclick="sweet('.$data->id.')">Hapus</a>';
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
            'nama' => 'required|string|max:50',
            'alamat' => 'required|string|max:200',
            'telepon' => 'required|string|regex:/(08)[0-9]{9}/',
            'jenis_kelamin' => 'required',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);
        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        } else {
            if ($request->file('foto')) {
                $name = $request->file('foto');
                $foto = time()."_".$name->getClientOriginalName();
                $request->foto->move(public_path("upload/foto/pelangan"), $foto);
                $pelanggan = Pelanggan::create([
                    'nama' => $request->nama,
                    'alamat' => $request->alamat,
                    'telepon' => $request->telepon,
                    'foto' => 'upload/foto/pelanggan/'.$foto,
                    'jenis_kelamin' => $request->jenis_kelamin
                ]);
                $numRand = mt_rand(100, 999);
                $nama = $request->nama;
                $subStr = explode(' ',trim($nama));
                User::create([
                    'username' => $subStr[0].$numRand,
                    'email' => $subStr[0].$numRand."@gmail.com",
                    'password' => Hash::make('12341234'),
                    'pelanggan_id' => $pelanggan->id
                ]);

            } else {
                $pelanggan = Pelanggan::create([
                    'nama' => $request->nama,
                    'alamat' => $request->alamat,
                    'telepon' => $request->telepon,
                    'jenis_kelamin' => $request->jenis_kelamin
                ]);
                $numRand = mt_rand(100, 999);
                $nama = $request->nama;
                $subStr = explode(' ',trim($nama));
                User::create([
                    'username' => $subStr[0].$numRand,
                    'email' => $subStr[0].$numRand."@gmail.com",
                    'password' => Hash::make('12341234'),
                    'pelanggan_id' => $pelanggan->id
                ]);
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Pelanggan::find($id);
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
            'nama' => 'required|string|max:50',
            'alamat' => 'required|string|max:200',
            'telepon' => 'required|string|regex:/(08)[0-9]{9}/',
            'jenis_kelamin' => 'required',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);
        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        } else {
            $pelanggan = Pelanggan::find($id);
            if ($request->file('foto')) {
                File::delete($pelanggan->foto);
                $name = $request->file('foto');
                $foto = time()."_".$name->getClientOriginalName();
                $request->foto->move(public_path("upload/foto/pelangan"), $foto);
                $pelanggan->update([
                    'nama' => $request->nama,
                    'alamat' => $request->alamat,
                    'telepon' => $request->telepon,
                    'foto' => 'upload/foto/pelanggan/'.$foto,
                    'jenis_kelamin' => $request->jenis_kelamin
                ]);
            } else {
                $pelanggan->update([
                    'nama' => $request->nama,
                    'alamat' => $request->alamat,
                    'telepon' => $request->telepon,
                    'jenis_kelamin' => $request->jenis_kelamin
                ]);
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
