<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\Gudang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Kecamatan;

class GudangController extends Controller
{
    public function __construct()
    {
        $this->Data = new Gudang;

        $this->path = 'app.data-master.gudang.';
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
                    return '<a href="/v1/gudang/'.$data->id.'/edit" class="btn btn-primary btn-sm">Edit</a>&nbsp;<a class="btn btn-info btn-sm" data-toggle="modal" data-target="#exampleModal" onclick="detail('.$data->id.')" data-id="'.$data->id.'" style="cursor: pointer;" title="Detail">Detail</a>&nbsp;<a href="/v1/gudang/'.$data->id.'/rak" class="btn btn-secondary btn-sm">Rak</a>&nbsp;<a href="#" class="btn btn-danger btn-sm" onclick="sweet('.$data->id.')">Hapus</a>';
                })
                ->make(true);
        }
        $data = Gudang::paginate(6);

        return view($this->path.'index', compact('data'));
    }

    public function search(Request $request)
    {
        $data = Gudang::where('nama', 'like', '%'.$request->nama.'%')->paginate(6);

        return view($this->path.'index', compact('data'));
    }

    public function geocode(Request $request)
    {
        if ($request->query('kecamatan')) {
            $kecamatan = Kecamatan::with('kabupaten.provinsi')->where('nama', 'like', '%'.$request->query('kecamatan').'%')->get();
            if (count($kecamatan) > 0) {
                $data = $kecamatan[0];
                $index = 'kecamatan';
            }
        }elseif ($request->query('kabupaten')) {
            $kabupaten = Kabupaten::with('provinsi')->where('nama', 'like', '%'.$request->query('kabupaten').'%')->get();
            if (count($kabupaten) > 0) {
                $data = $kabupaten[0];
                $index = 'kabupaten';
            }
        }elseif ($request->query('provinsi')) {
            $provinsi = Provinsi::where('nama', 'like', '%'.$request->query('provinsi').'%')->get();
            if (count($provinsi) > 0) {
                $data = $provinsi[0];
                $index = 'provinsi';
            }
        }

        return response()->json([
            $index => $data
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $provinsi = Provinsi::all();
        return view($this->path.'create', compact('provinsi'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $v = Validator::make($request->all(),[
            'lat' => 'required',
            'long' => 'required',
            'nama' => 'required|string|max:50',
            'kontak' => 'required|string|regex:/(08)[0-9]{9}/',
            'hari' => 'required|',
            'jam_buka' => 'required|',
            'jam_tutup' => 'required|',
            'alamat' => 'required|string|max:200',
            'kapasitas' => 'required|numeric',
            'desa_id' => 'required',
            'pemilik' => 'required|string',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);
        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        } else {
            if ($request->file('foto')) {
                $name = $request->file('foto');
                $foto = time()."_".$name->getClientOriginalName();
                $request->foto->move(public_path("upload/foto/gudang"), $foto);
                $this->Data::create(array_merge($request->only('nama','lat','long','alamat','kontak','kapasitas','jam_buka','jam_tutup','hari', 'desa_id', 'pemilik'),[
                    'foto' => 'upload/foto/gudang/'.$foto
                ]));

            } else {
                $this->Data::create(array_merge($request->only('nama','lat','long','alamat','kontak','kapasitas','jam_buka','jam_tutup','hari', 'desa_id', 'pemilik')));
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
        $data = Gudang::with('desa.kecamatan.kabupaten.provinsi')->where('id',$id)->get();

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
        $data = Gudang::find($id);
        $provinsi = Provinsi::all();
        return view($this->path.'edit',compact('data', 'provinsi'));
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
            'lat' => 'required',
            'long' => 'required',
            'alamat' => 'required|string|max:200',
            'kontak' => 'required|string|regex:/(08)[0-9]{9}/',
            'kapasitas' => 'required|numeric',
            'jam_buka' => 'required|',
            'jam_tutup' => 'required|',
            'hari' => 'required|',
            'desa_id' => 'required|exists:desas,id',
            'pemilik' => 'required|string',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);
        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        } else {
            $data = Gudang::find($id);
            if ($request->file('foto')) {
                File::delete($data->foto);
                $name = $request->file('foto');
                $foto = time()."_".$name->getClientOriginalName();
                $request->foto->move(public_path("upload/foto/gudang"), $foto);
                $data->update(array_merge($request->only('nama','lat','long','alamat','kontak','kapasitas','jam_buka','jam_tutup','hari','desa_id','pemilik'),[
                    'foto' => 'upload/foto/gudang/'.$foto
                ]));

            } else {
                $data->update(array_merge($request->only('nama','lat','long','alamat','kontak','kapasitas','jam_buka','jam_tutup','hari','desa_id','pemilik')));
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
