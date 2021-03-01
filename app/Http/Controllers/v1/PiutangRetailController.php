<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\PiutangRetail;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PiutangRetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = PiutangRetail::with('pemesananRetail')->where('status','=',0)->orderBy('id','desc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('hutang', function($data){
                    return 'Rp '.number_format($data->hutang);
                })
                ->editColumn('tanggal',function($data){
                    return date('d-m-Y', strtotime($data->tanggal));
                })
                ->editColumn('jatuh_tempo',function($data){
                    return date('d-m-Y', strtotime($data->jatuh_tempo));
                })
                ->rawColumns(['hutang'])
                ->make(true);
        }
        return view('app.data-master.piutang-bulky.masuk-retail.index');
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
