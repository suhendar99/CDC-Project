<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Models\StorageIn;
use App\Models\Storage;
use App\Models\Gudang;
use App\Models\Barang;
use App\Models\RekapitulasiPembelian;

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
            'gudang_id' => 'required|exists:gudangs,id',
            'jumlah' => 'required|numeric',
            'harga_barang' => 'required|numeric',
            'nomor_kwitansi' => 'required|numeric',
            'nomor_surat_jalan' => 'required|numeric',
            'foto_kwitansi' => 'required|image|mimes:jpg,png,jpeg|max:2048',
            'foto_surat_jalan' => 'required|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        }

        $faker = \Faker\Factory::create('id_ID');

        $kode = $faker->unique()->ean13;

        $barang = Barang::where('kode_barang', $request->barang_kode)->first();

        $foto_kwitansi = $request->file('foto_kwitansi');
        $nama_kwitansi = time()."_".$foto_kwitansi->getClientOriginalName();
        $foto_kwitansi->move(public_path("upload/foto/kwitansi"), $nama_kwitansi);

        $foto_surat_jalan = $request->file('foto_surat_jalan');
        $nama_surat_jalan = time()."_".$foto_surat_jalan->getClientOriginalName();
        $foto_surat_jalan->move(public_path("upload/foto/surat_jalan"), $nama_surat_jalan);

        $masuk = StorageIn::create($request->only('barang_kode', 'gudang_id', 'jumlah', 'nomor_kwitansi', 'nomor_surat_jalan')+[
            'kode' => $kode,
            'satuan' => $barang->satuan,
            'user_id' => auth()->user()->id,
            'foto_kwitansi' => 'upload/foto/kwitansi/'.$nama_kwitansi,
            'foto_surat_jalan' => 'upload/foto/surat_jalan/'.$nama_surat_jalan,
            'waktu' => now('Asia/Jakarta')
        ]);
        Storage::create([
            'storage_in_kode' => $kode,
            'jumlah' => $request->jumlah,
            'satuan' => $barang->satuan,
            'harga_barang' => $request->harga_barang,
            'waktu' => now('Asia/Jakarta')
        ]);

        RekapitulasiPembelian::create([
            'storage_in_id' => $masuk->id,
            'tanggal_pembelian' => $masuk->waktu,
            'no_pembelian' => $masuk->kode,
            'nama_penjual' => $masuk->barang->pemasok->nama,
            'barang' => $masuk->barang->nama_barang,
            'jumlah' => $masuk->jumlah,
            'satuan' => $barang->satuan,
            'harga' => $masuk->barang->harga_barang,
            'total' => $masuk->barang->harga_total
        ]);

        return back()->with('success', __( 'Penyimpanan Masuk Telah Berhasil !' ));
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
            'satuan' => 'required|string',
            'nomor_kwitansi' => 'required|numeric',
            'nomor_surat_jalan' => 'required|numeric',
            'foto_kwitansi' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'foto_surat_jalan' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
            // 'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        }

        // $faker = \Faker\Factory::create('id_ID');

        // $kode = $faker->unique()->ean13;
        $storage = StorageIn::findOrFail($id);

        $storage->update($request->only('barang_kode', 'gudang_id', 'jumlah', 'satuan', 'nomor_kwitansi', 'nomor_surat_jalan'));

        if ($request->file('foto_kwitansi')) {
            File::delete($storage->foto_kwitansi);

            $foto_kwitansi = $request->file('foto_kwitansi');
            $nama_kwitansi = time()."_".$foto_kwitansi->getClientOriginalName();
            $foto_kwitansi->move(public_path("upload/foto/kwitansi"), $nama_kwitansi);

            $storage->update([
                'foto_kwitansi' => 'upload/foto/kwitansi/'.$nama_kwitansi,
            ]);
        }

        if ($request->file('foto_surat_jalan')) {
            File::delete($storage->foto_surat_jalan);

            $foto_surat_jalan = $request->file('foto_surat_jalan');
            $nama_surat_jalan = time()."_".$foto_surat_jalan->getClientOriginalName();
            $foto_surat_jalan->move(public_path("upload/foto/surat_jalan"), $nama_surat_jalan);

            $storage->update([
                'foto_surat_jalan' => 'upload/foto/surat_jalan/'.$nama_surat_jalan,
            ]);
        }

        return back()->with('success', __( 'Penyimpanan Masuk Telah Berhasil Di Edit!' ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = StorageIn::findOrFail($id);

        File::delete($data->foto_kwitansi);
        File::delete($data->foto_surat_jalan);
        $data->delete();

        return back()->with('success', __( 'Penyimpanan Masuk Telah Berhasil Dihapus!' ));
    }
}
