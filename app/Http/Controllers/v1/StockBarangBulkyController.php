<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\StockBarangBulky;
use App\Models\StorageMasukBulky;

class StockBarangBulkyController extends Controller
{
    public function editHarga($id)
    {
        $data = StockBarangBulky::with('barang', 'bulky')->findOrFail($id);

        $base_harga = StorageMasukBulky::with('barang')
        ->where([
            ['bulky_id', $data->bulky_id],
            ['barang_kode', $data->barang_kode]
        ])->orderBy('id', 'desc')
        ->first();

        $harga = ($data->harga_barang === null) ? null : $data->harga_barang ;
        $diskon = ($data->diskon === null) ? null : $data->diskon ;

        $satuan = $data->satuan;

        return view('app.data-master.storageBulky.harga', compact('harga', 'id', 'satuan', 'data', 'diskon', 'base_harga'));
    }

    public function simpanHarga(Request $request, $id)
    {
        $v = Validator::make($request->all(),[
            'harga_barang' => 'required|integer|min:0',
            'diskon' => 'required|numeric|min:0',
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        }

        StockBarangBulky::findOrFail($id)->update($request->only('harga_barang', 'diskon'));

        return redirect(route('bulky.storage.index'))->with('success', __( 'Harga Barang telah disimpan.' ));
    }
}
