<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Rak;
use App\Models\TingkatanRak;
use App\Models\StorageIn;
use App\Models\Storage;
use App\Models\Barang;
use App\Models\StockBarang;
use App\Models\Gudang;

class StorageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $data = StockBarang::with('barang.storageIn.storage.tingkat.rak', 'gudang.akunGudang.user')
        // ->get();
        // dd($data);
        if($request->ajax()){
            $data = StockBarang::with('barang.storageIn.storage.tingkat.rak', 'gudang')
            ->whereHas('gudang.akunGudang', function($query){
                $query->where('pengurus_id', auth()->user()->pengurus_gudang_id);
            })
            ->orderBy('id', 'desc')
            ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    return '<a href="/v1/barang/stock/'.$data->id.'" class="btn btn-dark btn-sm">Atur Harga Barang</a>';
                })
                ->make(true);
        }

        return view('app.data-master.storage.index');
    }

    public function detail(Request $request)
    {
        if ($request->query('id')) {
            $data = StockBarang::with('barang.storageIn.storage.tingkat.rak')->find($request->query('id'));

            if ($data != null) {
                return response()->json([
                    'data' => $data
                ], 200);
            } else {
                return response()->json([
                    'message' => __( 'Data Stock Barang tidak ditemukan.' )
                ], 400);
            }
        }
    }

    public function check($kode)
    {
        $data = Storage::whereHas('storageIn', function($query)use($kode){
            $query->where('barang_kode', $kode);
        })
        ->orderBy('id', 'desc')
        ->first();

        if ($data === null) {
            return response()->json([
                'message' => __( 'Kode tidak diketahui' )
            ], 400);
        } else {
            return response()->json([
                'data' => $data
            ], 200);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
        $masuk = Storage::with('storageIn.gudang')->find($id);
        $rak = Rak::with('tingkat')->where('gudang_id', $masuk->storageIn->gudang_id)->where('status',0)->get();

        if ($rak->count() == 0) {
            return redirect(route('rak.create', $masuk->storageIn->gudang_id))->with('failed', __( 'Gudang '.$masuk->storageIn->gudang->nama.' belum memiliki Rak. Harap buat data Rak!' ));
        }

        return view('app.data-master.storage.create', compact('rak', 'masuk'));
    }

    public function tingkatRak($id)
    {
        $tingkat = TingkatanRak::where('rak_id', $id)->get();

        return response()->json([
            'data' => $tingkat
        ], 200);
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
            'rak_id' => 'required|exists:raks,id',
            'tingkat_id' => 'required|exists:tingkatan_raks,id'
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        }
        $storage = Storage::where('storage_in_kode', $id)->first();

        $storage->update($request->only('tingkat_id'));

        return redirect(route('storage.index'))->with('success', __( 'Tersimpan !' ));
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
