<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\BarangKeluarPelanggan;
use App\Models\BarangWarung;
use App\Models\PemesananPembeli;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BarangKeluarPelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = BarangKeluarPelanggan::with('user', 'barangWarung', 'pemesanan')
            ->orderBy('id', 'desc')
            ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    // return '<a href="/v1/storage/out/'.$data->id.'/edit" class="btn btn-primary btn-sm">Edit</a>&nbsp;<a href="#" class="btn btn-danger btn-sm" onclick="sweet(\'/v1/storage/out/'.$data->id.'\')">Hapus</a>';
                    return '<a href="#" class="btn btn-danger btn-sm" onclick="sweet('.$data->id.')">Hapus</a>';
                })
                ->addColumn('nama_barang',function($data){
                    return $data->barangWarung->storageOut->barang->nama_barang;
                })
                ->addColumn('jumlah_barang',function($data){
                    return $data->jumlah.' '.$data->satuan;
                })
                ->addColumn('pemesanan',function($data){
                    return $data->pemesanan->kode.' | '.$data->pemesanan->pembeli->nama;
                })
                ->rawColumns(['action','nama_barang','jumlah_barang','pemesanan'])
                ->make(true);
        }
        return view('app.data-master.manajemenBarangPelanggan.keluar.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pemesanan = PemesananPembeli::with('pemesananPembeliItem')->where('status','4')->get();
        dd($pemesanan);
        $barang = BarangWarung::all();
        return view('app.data-master.manajemenBarangPelanggan.keluar.create',compact('pemesanan','barang'));
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
