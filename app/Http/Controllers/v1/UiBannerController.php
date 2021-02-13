<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\UiBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class UiBannerController extends Controller
{
    public function __construct()
    {
        $this->path = 'app.ui-element.banner.';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = UiBanner::orderBy('id','desc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    return '<a href="/v1/ui-banner/'.$data->id.'/edit" class="btn btn-primary btn-sm">Edit</a>&nbsp;<a href="#" class="btn btn-danger btn-sm" onclick="sweet('.$data->id.')">Hapus</a>';
                })
                ->addColumn('foto', function($data){
                    if ($data->foto != null) {
                        return '<img src="'.asset($data->foto).'" class="rounded mx-auto" height="100" width="250" alt="Icon">';
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
            'foto' => 'nullable|image|mimes:png,jpg|max:1048'
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        } else {
            if ($request->hasFile('foto')) {
                $image = $request->file('foto');
                $name = rand(). '.' . $image->getClientOriginalExtension();
                $image->move("upload/foto/banner", $name);
                UiBanner::create($request->only('nama')+['foto' => '/upload/foto/banner/'.$name]);
            } else {
                UiBanner::create($request->only('nama'));
            }


            return back()->with('success','Data berhasil ditambah !');
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
        $data = UiBanner::find($id);
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
            'foto' => 'nullable|image|mimes:png,jpg|max:1048'
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        } else {
            $data = UiBanner::find($id);
            if ($request->hasFile('foto')) {
                File::delete(public_path($data->foto));
                $image = $request->file('foto');
                $name = rand(). '.' . $image->getClientOriginalExtension();
                $image->move("upload/foto/banner", $name);

                $data->update($request->only('nama')+['foto' => '/upload/foto/banner/'.$name]);
            } else {
                $data->update($request->only('nama'));
            }

            return back()->with('success','Data berhasil diedit !');
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
        $data = UiBanner::find($id);
        File::delete(public_path($data->foto));
        $data->delete();

        return back()->with('success','Data berhasil dihapus !');
    }
}
