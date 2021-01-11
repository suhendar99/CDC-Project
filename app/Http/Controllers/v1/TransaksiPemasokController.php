<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gudang;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Barang;
use Auth;

class TransaksiPemasokController extends Controller
{
    public function __construct()
    {
        $this->indexPath = 'app.transaksi.pemasok.';
        $this->gudang = new Gudang;
        $this->barang = new Barang;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view($this->indexPath.'index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $barang = $this->barang->where('pemasok_id',Auth::user()->pemasok_id)->with('foto')->paginate(24);
        return view($this->indexPath.'create',compact('barang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createDetail($id)
    {
        $gudang = $this->gudang->all();
        $barang = $this->barang->where('pemasok_id',Auth::user()->pemasok_id)->where('id',$id)->with('foto')->first();
        return view($this->indexPath.'createDetail',compact('barang','gudang'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function selectGudang(Request $request)
    {
        $data = $this->gudang->with('desa.kecamatan.kabupaten.provinsi');
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($data){
                return '<button type="button" class="btn btn-danger btn-sm" onclick="select('.$data->id.')">Pilih</button>';
            })
            ->make(true);
    }

    public function selectedGudang($id)
    {
        $data = Gudang::where('id',$id)->with('desa.kecamatan.kabupaten.provinsi')->first();

        return response()->json([
            'data' => $data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request->all());
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
