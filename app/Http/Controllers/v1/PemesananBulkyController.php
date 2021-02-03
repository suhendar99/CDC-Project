<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PemesananBulky;
use App\Models\BarangPemesananBulky;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PemesananBulkyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = PemesananBulky::with('barangPesananBulky.barang', 'storageKeluarBulky')
            ->orderBy('id', 'desc')
            ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    return '<a class="btn btn-info btn-sm" data-toggle="modal" data-target="#exampleModal" onclick="detail('.$data->id.')" data-id="'.$data->id.'" style="cursor: pointer;" title="Detail">Detail</a>&nbsp;<a href="#" class="btn btn-danger btn-sm" onclick="sweet('.$data->id.')">Hapus</a></div>';
                })
                // ->addColumn('nama', function($data){
                //     $nama = [];
                //     foreach ($data->barangPesanan as $key => $value) {
                //         $nama = $value->barang->nama_barang;
                //         // dd($value->barang->nama_barang);
                //     }
                //     return $nama;
                // })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('app.data-master.pemesananBulky.index');
    }

    public function detail($id)
    {
        $data = PemesananBulky::with('barangPesananBulky.barang', 'storageKeluarBulky', 'bulky', 'retail')
            ->find($id);

        return response()->json([
            'data' => $data
        ], 200);
    }

    function getPesanan($id){
        $data = PemesananBulky::with('barangPesananBulky')->first();
        $barang = $data->barangPesananBulky;
        $harga = $barang->sum('harga');
        return response()->JSON([
            'data' => $data,
            'barang' => $barang,
            'harga' => $harga,
        ]);
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
