<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Models\StorageOut;
use App\Models\StorageIn;
use App\Models\Storage;
use App\Models\Gudang;
use App\Models\Barang;

class StorageOutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = StorageOut::with('barang', 'gudang')
            ->orderBy('id', 'desc')
            ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    return '<a href="/v1/storage/out/'.$data->id.'/edit" class="btn btn-primary btn-sm">Edit</a>&nbsp;<a href="#" class="btn btn-danger btn-sm" onclick="sweet(\'/v1/storage/out/'.$data->id.'\')">Hapus</a>';
                })
                ->make(true);
        }
        return view('app.data-master.storage.index');
    }

    public function findBarang($id)
    {
        $barang = Barang::with('storageIn.storage')->whereHas('storageIn', function($query)use($id){
            $query->where('gudang_id', $id);
        })->get();

        return response()->json([
            'data' => $barang
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $gudang = Gudang::all();

        return view('app.data-master.storage.out.create', compact('gudang'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $v = Validator::make($request->all(),[
            'barang_kode' => 'required|numeric|exists:barangs,kode_barang',
            'gudang_id' => 'required|exists:barangs,id',
            'jumlah' => 'required|numeric',
            'satuan' => 'required|string'
            // 'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        }

        $kode_barang = $request->barang_kode;

        $stok = Storage::whereHas('storageIn', function($query)use($kode_barang){
            $query->where('barang_kode', $kode_barang);
        })
        ->orderBy('waktu', 'asc')
        ->get();

        $jumlahBarang = count($stok) - 1;
        $now = 0;

        $jumlah = $request->jumlah;

        $hasil = 0;

        while ( $jumlah != 0 ) {
            if ($now <= $jumlahBarang) {
                $jumlahStok = $stok[$now]->jumlah;

                if ($jumlahStok != 0) {
                    $jumlahStok = $jumlahStok - $jumlah;
                    if ($jumlahStok >= 0) {
                        $stok[$now]->update([
                            'jumlah' => $jumlahStok
                        ]);

                        $jumlah = 0;
                    }elseif($jumlahStok < 0){
                        $stok[$now]->update([
                            'jumlah' => 0
                        ]);

                        $jumlah = abs($jumlahStok);
                        $now++;
                    }
                }else{
                    $now++;
                }
            }
        }

        $faker = \Faker\Factory::create('id_ID');

        $kode = $faker->unique()->ean13;

        StorageOut::create($request->only('barang_kode', 'gudang_id', 'jumlah', 'satuan')+[
            'kode' => $kode,
            'user_id' => auth()->user()->id,
            'waktu' => now('Asia/Jakarta')
        ]);

        return back()->with('success', __( 'Storage Out!' ));
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

    public function detail($id)
    {
        try {
            $data = StorageOut::with('barang', 'gudang', 'user.pengurusGudang')->where('id', $id)->first();

            return response()->json([
                'data' => $data
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = StorageOut::find($id);
        $gudang = Gudang::all();
        return view('app.data-master.storage.out.edit', compact('gudang', 'data'));
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
            'barang_kode' => 'required|numeric|exists:barangs,kode_barang',
            'gudang_id' => 'required|exists:barangs,id',
            'jumlah' => 'required|numeric',
            'satuan' => 'required|string'
            // 'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        }

        // $faker = \Faker\Factory::create('id_ID');

        // $kode = $faker->unique()->ean13;

        StorageOut::findOrFail($id)->update($request->only('barang_kode', 'gudang_id', 'jumlah', 'satuan'));

        return back()->with('success', __( 'Storage Out Updated!' ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        StorageOut::findOrFail($id)->delete();

        return back()->with('success', __( 'Storage In Deleted!' ));
    }
}
