<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\PengurusGudangBulky;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PemilikGudangBulkyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = PengurusGudangBulky::orderBy('id', 'desc')
            ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    return '<div class="text-center" style="width: 100%"><a href="/v1/pemilik-gudang-retail/'.$data->id.'/edit" class="btn btn-primary btn-sm">Edit</a>&nbsp;<a href="#" class="btn btn-danger btn-sm" onclick="sweet('.$data->id.')">Hapus</a></div>';
                })
                ->addColumn('ttl',function($data){
                    if ($data->tgl_lahir != null && $data->tempat_lahir != null) {
                        return $data->tempat_lahir.', '.date('d-F-Y', strtotime($data->tgl_lahir));
                    } else {
                        return "";
                    }
                })
                ->editColumn('created_at',function($data){
                    if ($data->tgl_lahir != null && $data->tempat_lahir != null) {
                        return date('d-m-Y H:i:s', strtotime($data->created_at));
                    } else {
                        return "";
                    }
                })
                ->rawColumns(['action','ttl'])
                ->make(true);
        }

        return view('app.data-master.gudang.akun.pemilik-bulky.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
