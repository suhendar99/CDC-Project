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

    public function uploadFoto(Request $request, $id)
    {
        $v = Validator::make($request->all(),[
            'foto' => 'required|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        }

        $foto_barang = $request->file('foto');
        $nama_barang = "RTL".time()."_".$foto_barang->getClientOriginalName();
        $foto_barang->move("upload/foto/barang/retail", $nama_barang);

        StockBarang::findOrFail($id)->update([
            'foto_barang' => 'upload/foto/barang/retail/'.$nama_barang
        ]);

        return redirect(route('storage.index'))->with('success', __( 'Foto telah diunggah.' ));
    }

    public function getFoto($id)
    {
        try {
            $data = StockBarang::select('foto_barang')->find($id);

            return response()->json([
                'data' => $data
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ],400);
        }
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
