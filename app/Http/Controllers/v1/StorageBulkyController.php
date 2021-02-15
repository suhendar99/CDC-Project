<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;
use App\Models\RakBulky;
use App\Models\TingkatRakBulky;
use App\Models\StorageMasukBulky;
use App\Models\StorageBulky;
use App\Models\Barang;
use App\Models\StockBarangBulky;
use App\Models\GudangBulky;

class StorageBulkyController extends Controller
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
            $data = StockBarangBulky::with('barang.storageMasukBulky.storageBulky.tingkat.rak', 'bulky')
            ->whereHas('bulky.akunGudangBulky', function($query){
                $query->where('pengurus_bulky_id', auth()->user()->pengurus_gudang_bulky_id);
            })
            ->orderBy('id', 'desc')
            ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    return '<a href="/v1/bulky/barang/stock/'.$data->id.'" class="btn btn-dark btn-sm">Atur Harga Barang</a>';
                })
                ->editColumn('created_at',function($data){
                    return date('d-m-Y H:i', strtotime($data->created_at)).' WIB';
                })
                ->make(true);
        }

        return view('app.data-master.storageBulky.index');
    }

    public function detail($id)
    {
        $data = StockBarangBulky::with('barang.storageMasukBulky.storageBulky.tingkat.rak', 'bulky')
        ->find($id);

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

    public function check($kode)
    {
        $data = StorageBulky::whereHas('storageMasukBulky', function($query)use($kode){
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
        $masuk = StorageBulky::with('storageMasukBulky.bulky', 'tingkat.rak')->find($id);
        $rak = RakBulky::with('tingkat')->where('gudang_bulky_id', $masuk->storageMasukBulky->bulky_id)->get();

        $tingkat = ($masuk->tingkat_id == null) ? null : $masuk->tingkat_id ;
        $raks = ($masuk->tingkat_id == null) ? null : $masuk->tingkat->rak->id;

        if ($rak->count() == 0) {
            return redirect(route('rak.bulky.create', $masuk->storageMasukBulky->bulky_id))->with('failed', __( 'Gudang Bulky '.$masuk->storageMasukBulky->bulky->nama.' belum memiliki Rak. Harap buat data Rak!' ));
        }

        return view('app.data-master.storageBulky.create', compact('rak', 'masuk', 'tingkat', 'raks'));
    }

    public function tingkatRak($id)
    {
        $tingkat = TingkatRakBulky::where('rak_bulky_id', $id)->get();

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
            'rak_id' => 'required|exists:rak_bulkies,id',
            'tingkat_id' => 'required|exists:tingkat_rak_bulkies,id'
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        }
        $storage = StorageBulky::where('storage_masuk_bulky_kode', $id)->first();

        $storage->update($request->only('tingkat_id'));

        return redirect(route('bulky.storage.index'))->with('success', __( 'Tersimpan !' ));
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
