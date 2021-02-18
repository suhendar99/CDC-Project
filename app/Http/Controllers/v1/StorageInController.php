<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Models\PemesananBulky;
use App\Models\BarangPemesananBulky;
use App\Models\StockBarangBulky;
use App\Models\StorageIn;
use App\Models\Storage;
use App\Models\Gudang;
use App\Models\Barang;
use App\User;
use App\Models\LogTransaksi;
use App\Models\StockBarang;
use App\Models\RekapitulasiPembelian;
use Auth;

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
            if (Auth::user()->pengurusGudang->status == 1) {
                $data = StorageIn::with('barangBulky', 'gudang', 'satuan')
                ->where('user_id',Auth::user()->id)
                ->orderBy('id', 'desc')
                ->get();
            } else {
                $data = StorageIn::with('barangBulky', 'gudang', 'satuan')
                ->where('gudang_id', Auth::user()->pengurusGudang->gudang[0]->id)
                ->where('user_id',Auth::user()->id)
                ->orderBy('id', 'desc')
                ->get();
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    return '<a class="btn btn-info btn-sm" data-toggle="modal" data-target="#exampleModal" onclick="detail('.$data->id.')" data-id="'.$data->id.'" style="cursor: pointer;" title="Detail">Detail</a>&nbsp;<a href="#" class="btn btn-danger btn-sm" onclick="sweet(\'/v1/storage/in/'.$data->id.'\')">Hapus</a>';
                    // return '<a href="/v1/storage/in/'.$data->id.'/edit" class="btn btn-primary btn-sm">Edit</a>&nbsp;<a class="btn btn-info btn-sm" data-toggle="modal" data-target="#exampleModal" onclick="detail('.$data->id.')" data-id="'.$data->id.'" style="cursor: pointer;" title="Detail">Detail</a>&nbsp;<a href="#" class="btn btn-danger btn-sm" onclick="sweet(\'/v1/storage/in/'.$data->id.'\')">Hapus</a>';
                })
                ->editColumn('created_at',function($data){
                    return date('d-m-Y H:i:s', strtotime($data->created_at));
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

    public function findStorageKeluar($id)
    {
        try {
            $pesanan = BarangPemesananBulky::with('pemesananBulky', 'stockBarangBulky.barang')
            ->whereHas('pemesananBulky', function($query)use($id){
                $query->where([
                    ['gudang_retail_id', $id],
                    ['status', 5]
                ]);
            })
            ->has('pemesananBulky.storageKeluarBulky')
            ->doesntHave('pemesananBulky.storageMasukRetail')
            ->get();

            // dd($pesanan);
            // $barangBulky = StockBarangBulky::with('barangPemesananBulky.pemesananBulky')
            // ->whereIn('id', $pesanan)
            // ->get();

            if (!$pesanan) {
                return response()->json([
                    'data' => 'Tidak ada barang'
                ], 404);
            } else {
                return response()->json([
                    'data' => $pesanan
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
        $gudang = Gudang::whereHas('akunGudang', function($query){
            $query->where('pengurus_id', auth()->user()->pengurus_gudang_id);
        })
        ->where('status', 1)
        ->get();

        if($gudang->count() < 1){
            return back()->with('failed','Mohon Daftarkan/Aktifkan Gudang Anda Terlebih Dahulu!');
        }
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
            'barang_bulky_id' => 'required|exists:stock_barang_bulkies,id',
            'pemesanan_bulky_id' => 'required|exists:pemesanan_bulkies,id',
            'gudang_id' => 'required|exists:gudangs,id',
            'jumlah' => 'required|numeric',
            'harga_beli' => 'required|numeric',
            'nomor_kwitansi' => 'required|numeric',
            'nomor_surat_jalan' => 'required|numeric',
            'foto_kwitansi' => 'required|image|mimes:jpg,png,jpeg|max:2048',
            'foto_surat_jalan' => 'required|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        }

        date_default_timezone_set('Asia/Jakarta');

        $faker = \Faker\Factory::create('id_ID');

        $kode = $faker->unique()->ean13;

        $kode_barang_retail = $faker->unique()->ean13;

        $barang = StockBarangBulky::with('barang')->find($request->barang_bulky_id);

        $one = ($barang->satuan == 'Ton') ? 2 : 1;
        $satuan = ($barang->satuan == 'Ton') ? 'Kuintal' : $barang->satuan;

        $jumlah = $request->jumlah;

        $foto_kwitansi = $request->file('foto_kwitansi');
        $nama_kwitansi = time()."_".$foto_kwitansi->getClientOriginalName();
        $foto_kwitansi->move(public_path("upload/foto/kwitansi"), $nama_kwitansi);

        $foto_surat_jalan = $request->file('foto_surat_jalan');
        $nama_surat_jalan = time()."_".$foto_surat_jalan->getClientOriginalName();
        $foto_surat_jalan->move(public_path("upload/foto/surat_jalan"), $nama_surat_jalan);

        $masuk = StorageIn::create($request->only('barang_bulky_id', 'pemesanan_bulky_id', 'gudang_id', 'nomor_kwitansi', 'nomor_surat_jalan', 'harga_beli')+[
            'kode' => $kode,
            'nama_barang' => $barang->barang->nama_barang,
            'jumlah' => $jumlah,
            'satuan_id' => $one,
            'user_id' => auth()->user()->id,
            'foto_kwitansi' => 'upload/foto/kwitansi/'.$nama_kwitansi,
            'foto_surat_jalan' => 'upload/foto/surat_jalan/'.$nama_surat_jalan,
            'waktu' => now('Asia/Jakarta')
        ]);

        $checkStock = StockBarang::where([
            ['gudang_id', $request->gudang_id],
            ['barang_bulky_id', $request->barang_bulky_id]
        ])->first();

        if($checkStock !== null){
            $updateJumlah = $checkStock->jumlah + $jumlah;

            $checkStock->update([
                'jumlah' => $updateJumlah,
                'satuan' => $satuan
            ]);

            $stock_id = $checkStock->id;
        }else{
            $stok = StockBarang::create($request->only('gudang_id', 'barang_bulky_id')+[
                'kode' => $kode_barang_retail,
                'jumlah' => $jumlah,
                'nama_barang' => $barang->barang->nama_barang,
                'satuan' => $satuan
            ]);

            $stock_id = $stok->id;
        }

        Storage::create([
            'storage_masuk_id' => $masuk->id,
            'barang_retail_id' => $stock_id,
            'jumlah' => $jumlah,
            'satuan' => $satuan,
            'waktu' => now('Asia/Jakarta')
        ]);

        $harga = $masuk->harga_beli / $masuk->jumlah;

        RekapitulasiPembelian::create([
            'storage_in_id' => $masuk->id,
            'tanggal_pembelian' => $masuk->waktu,
            'no_pembelian' => $masuk->kode,
            'nama_penjual' => $masuk->barangBulky->barang->pemasok->nama,
            'barang' => $masuk->barangBulky->barang->nama_barang,
            'jumlah' => $masuk->jumlah,
            'satuan' => $satuan,
            'harga' => $harga,
            'total' => $masuk->harga_beli
        ]);

        $log = LogTransaksi::create([
            'tanggal' => now(),
            'jam' => now(),
            'aktifitas_transaksi' => 'Penerimaan Barang'
        ]);

        return back()->with('success', __( 'Data Barang Masuk Berhasil dibuat!' ));
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
            $data = StorageIn::with('barangBulky', 'gudang', 'user.pengurusGudang', 'satuan')->where('id', $id)->first();

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

        return back()->with('success', __( 'Data Barang Masuk Berhasil diubah!' ));
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

        $checkStock = StockBarang::where([
            ['gudang_id', $data->gudang_id],
            ['barang_bulky_id', $data->barang_bulky_id]
        ])->first();

        if ($checkStock != null) {
            $hasil = $checkStock->jumlah - $data->jumlah;

            if ($hasil == 0) {
                $checkStock->delete();
            } else {
                $checkStock->update([
                    'jumlah' => $hasil
                ]);
            }

        }

        File::delete($data->foto_kwitansi);
        File::delete($data->foto_surat_jalan);
        $data->delete();

        return back()->with('success', __( 'Data Barang Masuk dihapus!' ));
    }
}
