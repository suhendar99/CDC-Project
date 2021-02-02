<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\BarangWarung;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class BarangWarungController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $barangWarung = BarangWarung::where('pelanggan_id',Auth::user()->pelanggan_id)->with('storageOut')->orderBy('id','desc')->paginate(5);
        return view('app.data-master.barang-warung.index',compact('barangWarung'));
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

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = BarangWarung::find($id);
        $harga = ($data->harga_barang === null) ? null : $data->harga_barang ;
        $satuan = $data->satuan;
        return view('app.data-master.barang-warung.updateHarga',compact('data','id','harga','satuan'));
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
            'harga_barang' => 'required|integer|min:0',
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        }

        BarangWarung::findOrFail($id)->update($request->only('harga_barang'));

        return back()->with('success', __( 'Harga Barang telah disimpan.' ));
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
