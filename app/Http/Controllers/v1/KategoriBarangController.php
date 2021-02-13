<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class KategoriBarangController extends Controller
{
    public function __construct()
    {
        $this->Data = new Kategori;

        $this->path = 'app.data-master.kategori.';
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
                    return '<a href="/v1/kategoriBarang/'.$data->id.'/edit" class="btn btn-primary btn-sm">Edit</a>&nbsp;<a href="#" class="btn btn-danger btn-sm" onclick="sweet('.$data->id.')">Hapus</a>';
                })
                ->addColumn('foto', function($data){
                    if ($data->icon != null) {
                        return '<img src="'.asset($data->icon).'" class="rounded mx-auto" height="100" width="100" alt="Icon">';
                    } else {
                        return "<small class='text-danger'>Foto Kosong !</small>";
                    }

                })
                ->rawColumns(['action','foto'])
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
            'icon' => 'required|image|mimes:png,jpg|max:1048'
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        } else {
            if ($request->hasFile('icon')) {
                $image = $request->file('icon');
                $name = rand(). '.' . $image->getClientOriginalExtension();
                $image->move("upload/foto/komoditi", $name);
                $this->Data->storeData($request->only('nama')+['icon' => '/upload/foto/komoditi/'.$name]);
            } else {
                $this->Data->storeData($request->only('nama'));
            }


            return back()->with('success',$this->alert.'ditambah !');
        }
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
        $data = Kategori::find($id);
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
            'icon' => 'required|image|mimes:png,jpg|max:1048'
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        } else {
            if ($request->hasFile('icon')) {
                $data = Kategori::find($id);
                File::delete(public_path($data->icon));
                $image = $request->file('icon');
                $name = rand(). '.' . $image->getClientOriginalExtension();
                $image->move("upload/foto/komoditi", $name);

                $this->Data->updateData($id,$request->only('nama')+['icon' => '/upload/foto/komoditi/'.$name]);
            } else {
                $this->Data->updateData($id,$request->only('nama'));
            }

            return back()->with('success',$this->alert.'diedit !');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Kategori::find($id);
        File::delete(public_path($data->icon));
        $this->Data->deleteData($id);

        return back()->with('success',$this->alert.'dihapus !');
    }
}
