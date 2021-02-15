<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\StockBarang;
use App\Models\StorageIn;

class StockBarangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function editHarga($id)
    {
        $data = StockBarang::with('stockBarangBulky', 'gudang', 'storage.storageIn')->findOrFail($id);

        $standar = 0;
        $total = 0;
        $arr = [];

        foreach ($data->storage as $storage) {
            if ($storage->jumlah != 0) {
                $standar += $storage->storageIn->jumlah;
                $total += $storage->storageIn->harga_beli;
            }
        }

        $arr['satuan'] = $data->satuan;   
        $arr['nama_barang'] = $data->nama_barang;   
        $arr['jumlah'] = $standar;   
        $arr['harga_beli'] = $total;   

        // dd($base_harga);
        $base_harga = (object) $arr;

        $harga = ($data->harga_barang === null) ? null : $data->harga_barang ;
        $diskon = ($data->diskon === null) ? null : $data->diskon ;

        $satuan = $data->satuan;

        return view('app.data-master.storage.harga', compact('harga', 'id', 'satuan', 'data', 'diskon', 'base_harga'));
    }

    public function simpanHarga(Request $request, $id)
    {
        $v = Validator::make($request->all(),[
            'harga_barang' => 'required|integer|min:0',
            'diskon' => 'nullable|numeric|min:0',
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        }

        StockBarang::findOrFail($id)->update($request->only('harga_barang', 'diskon'));

        return redirect(route('storage.index'))->with('success', __( 'Harga Barang telah disimpan.' ));
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
