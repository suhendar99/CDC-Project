<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\Koperasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class KoperasiController extends Controller
{
    public function __construct()
    {
        $this->path = 'app.data-master.koperasi.';
        $this->alert = 'Data berhasil ';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = Koperasi::orderBy('id','desc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    return '<a href="/v1/koperasi/'.$data->id.'/edit" class="btn btn-primary btn-sm">Edit</a>&nbsp;<a href="#" class="btn btn-danger btn-sm" onclick="sweet('.$data->id.')">Hapus</a>';
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
            'nama_koperasi' => 'required',
            'alamat' => 'required',
            'sektor_usaha' => 'required',
            'jenis_koperasi' => 'required'
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        } else {
            Koperasi::create($request->all());
        }
        return back()->with('success', $this->alert.'ditambahkan !');
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
        $data = Koperasi::find($id);
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
            'nama_koperasi' => 'required',
            'alamat' => 'required',
            'sektor_usaha' => 'required',
            'jenis_koperasi' => 'required'
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        } else {
            $koperasi = Koperasi::find($id);
            $koperasi->update($request->all());
        }
        return back()->with('success', $this->alert.'diedit !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $koperasi = Koperasi::find($id);
        $koperasi->delete();
        return back()->with('success',$this->alert.'dihapus !');
    }
}
