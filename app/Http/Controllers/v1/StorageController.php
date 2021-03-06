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
        if($request->ajax()){
            $data = Storage::with('storageIn.barang', 'tingkat.rak', 'storageIn.gudang')
            ->orderBy('id', 'desc')
            ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    return '<a href="/v1/storage/penyimpanan/'.$data->id.'" class="btn btn-primary btn-sm">Ubah Penyimpanan</a>';
                })
                ->make(true);
        }

        return view('app.data-master.storage.index');
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
        $masuk = StorageIn::find($id);
        $rak = Rak::with('tingkat')->where('gudang_id', $masuk->gudang_id)->get();

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

        return redirect(route('storage.index'))->with('success', __( 'Saved!' ));
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
