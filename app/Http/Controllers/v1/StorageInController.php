<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Models\StorageIn;
use App\Models\Gudang;
use App\Models\Barang;

class StorageInController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = StorageIn::with('barang', 'gudang')
            ->orderBy('id', 'desc')
            ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    return '<a href="/v1/storage/in/'.$data->id.'/edit" class="btn btn-primary btn-sm">Edit</a>&nbsp;<a class="btn btn-info btn-sm" data-toggle="modal" data-target="#exampleModal" onclick="detail('.$data->id.')" data-id="'.$data->id.'" style="cursor: pointer;" title="Detail">Detail</a>&nbsp;<a href="#" class="btn btn-danger btn-sm" onclick="sweet(\'/v1/storage/in/'.$data->id.'\')">Hapus</a>';
                })
                ->make(true);
        }
        return view('app.data-master.storage.index');
    }

    public function checkBarang($kode)
    {
        try {
            $barang = Barang::with('kategori', 'pemasok')->where('kode_barang', $kode)->first();

            if (!$barang) {
                return response()->json([
                    'data' => 'Tidak ada barang'
                ], 404);
            } else {
                return response()->json([
                    'data' => $barang
                ], 200);
                # code...
            }
            
        } catch (Throwable $t) {
            return response()->json([
                'message' => $t->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $gudang = Gudang::all();
        return view('app.data-master.storage.in.create', compact('gudang'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $v = Validator::make($request->all(),[
            'barang_kode' => 'required|exists:barangs,kode_barang',
            'gudang_id' => 'required|exists:barangs,id',
            'jumlah' => 'required|numeric',
            'satuan' => 'required'
            // 'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        if ($v->fails()) {
            dd($v);
            return back()->withErrors($v)->withInput();
        }

        $faker = \Faker\Factory::create('id_ID');

        $kode = $faker->unique()->ean13;

        StorageIn::create($request->only('barang_kode', 'gudang_id', 'jumlah', 'satuan')+[
            'kode' => $kode,
            'user_id' => auth()->user()->id,
            'waktu' => now('Asia/Jakarta')
        ]);

        return back()->with('success', __( 'Storage In!' ));
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
            $data = StorageIn::with('barang', 'gudang', 'user.pengurusGudang')->where('id', $id)->first();

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
        $data = StorageIn::find($id);
        $gudang = Gudang::all();
        return view('app.data-master.storage.in.edit', compact('gudang', 'data'));
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

        StorageIn::findOrFail($id)->update($request->only('barang_kode', 'gudang_id', 'jumlah', 'satuan'));

        return back()->with('success', __( 'Storage In Updated!' ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        StorageIn::findOrFail($id)->delete();

        return back()->with('success', __( 'Storage In Deleted!' ));
    }
}
