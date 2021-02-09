<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\KodeRoleAkses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class KodeRoleAksesController extends Controller
{
    public function __construct()
    {
        $this->Data = new KodeRoleAkses;

        $this->path = 'app.data-master.kode-role-akses.';
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
            $data = $this->Data->orderBy('id','desc');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    return '<a href="/v1/kode-role-akses/'.$data->id.'/edit" class="btn btn-primary btn-sm">Edit</a>&nbsp;<a href="#" class="btn btn-danger btn-sm" onclick="sweet('.$data->id.')">Hapus</a>';
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
            'kode_role' => 'required|string|max:4'
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        } else {
            $this->Data->storeData($request->only('nama','kode_role'));

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
        $data = KodeRoleAkses::find($id);
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
            'kode_role' => 'required|string|max:4'
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        } else {
            $this->Data->updateData($id,$request->only('nama','kode_role'));

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
        $this->Data->deleteData($id);

        return back()->with('success',$this->alert.'dihapus !');
    }
}
