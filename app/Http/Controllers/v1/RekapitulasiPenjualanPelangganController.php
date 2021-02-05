<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\RekapitulasiPenjualanPelanggan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RekapitulasiPenjualanPelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = RekapitulasiPenjualanPelanggan::with('barangKeluarPelanggan')->orderBy('id','desc')->get();
        $total = $data->sum('total');

        if($request->ajax()){
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    return '<a href="/v1/rekapitulasiPembelian/'.$data->id.'/edit" class="btn btn-primary btn-sm">Edit</a>&nbsp;<a href="#" class="btn btn-danger btn-sm" onclick="sweet('.$data->id.')">Hapus</a>';
                })
                ->addColumn('jumlah', function($data){
                    return $data->jumlah.' '.$data->satuan;
                })
                ->addColumn('nama_pembeli', function($data){
                    return $data->nama_pembeli;
                })
                ->addColumn('no_penjualan', function($data){
                    return $data->no_penjualan;
                })
                ->rawColumns(['action','jumlah','nama_pembeli','no_penjualan'])
                ->make(true);
        }
        return view('app.transaksi.rekapitulasi.penjualanPelanggan.index', compact('total'));
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
