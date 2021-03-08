<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Models\StorageMasukBulky;
use App\Models\StorageBulky;
use App\Models\GudangBulky;
use App\Models\Barang;
use App\Models\BarangKeluarPemesananBulky;
use App\Models\LogTransaksi;
use App\Models\PemesananKeluarBulky;
use App\Models\StockBarangBulky;
use App\Models\RekapitulasiPembelianBulky;
use Illuminate\Support\Facades\Auth;

class StorageMasukBulkyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = StorageMasukBulky::with('barang', 'bulky')
            ->where('user_id',Auth::user()->id)
            ->orderBy('id', 'desc')
            ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    // return '<a href="/v1/bulky/storage/masuk/'.$data->id.'/edit" class="btn btn-primary btn-sm">Edit</a>&nbsp;<a class="btn btn-info btn-sm" data-toggle="modal" data-target="#exampleModal" onclick="detail('.$data->id.')" data-id="'.$data->id.'" style="cursor: pointer;" title="Detail">Detail</a>&nbsp;<a href="#" class="btn btn-danger btn-sm" onclick="sweet(\'/v1/storage/in/'.$data->id.'\')">Hapus</a>';
                    return '<a class="btn btn-info btn-sm" data-toggle="modal" data-target="#exampleModal" onclick="detail('.$data->id.')" data-id="'.$data->id.'" style="cursor: pointer;" title="Detail">Detail</a>';
                })
                ->editColumn('created_at',function($data){
                    return date('d-m-Y H:i:s', strtotime($data->created_at));
                })
                ->make(true);
        }
        return view('app.data-master.storageBulky.index');
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
    public function create(Request $request)
    {
            $gudang = GudangBulky::whereHas('akunGudangBulky', function($query){
                $query->where('pengurus_bulky_id', auth()->user()->pengurus_gudang_bulky_id);
            })
            ->where('status', 1)
            ->get();
            if ($gudang->count() < 1) {
                return redirect('v1/gudang-bulky')->with('failed','Mohon Pastikan Gudang Anda Sudah Terdaftar dan Diaktifkan!');
            }
            return view('app.data-master.storageBulky.in.create', compact('gudang'));
    }

    public function findStorageKeluar($id)
    {
        try {
            $pesanan = BarangKeluarPemesananBulky::with('pemesanan', 'barang')
            ->whereHas('pemesanan', function($query)use($id){
                $query->where([
                    ['bulky_id', $id],
                    ['status', 5]
                ]);
            })
            ->has('pemesanan.storageKeluarPemasok')
            ->doesntHave('pemesanan.storageMasuk')
            ->get();
            // dd($pesanan[1]->pemesanan);
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
    public function findBarang($id)
    {
        try {
            $pesanan = BarangKeluarPemesananBulky::with('pemesanan.kwitansiPemasok','pemesanan.suratJalanPemasok', 'barang')
            ->where('id',$id)
            ->whereHas('pemesanan', function($query){
                $query->where('status',5);
            })
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $v = Validator::make($request->all(),[
            'barang_kode' => 'required|exists:barangs,kode_barang',
            'bulky_id' => 'required|exists:gudang_bulkies,id',
            'pemesanan_keluar_bulky_id' => 'required|exists:pemesanan_keluar_bulky,id',
            'jumlah' => 'required|numeric',
            'harga_beli' => 'required|numeric',
            'nomor_kwitansi' => 'nullable|numeric',
            'nomor_surat_jalan' => 'required|string',
            'foto_kwitansi' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'foto_surat_piutang' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'foto_surat_jalan' => 'required|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        }

        $faker = \Faker\Factory::create('id_ID');

        $kode = $faker->unique()->ean13;
        $kode_stock_bulky = $faker->unique()->ean13;

        $barang = Barang::where('kode_barang', $request->barang_kode)->first();



        $foto_surat_jalan = $request->file('foto_surat_jalan');
        $nama_surat_jalan = time()."_".$foto_surat_jalan->getClientOriginalName();
        $foto_surat_jalan->move("upload/foto/surat_jalan", $nama_surat_jalan);


        if ($barang->satuan == 'Ton') {
            $jumlah = $request->jumlah;
            $satuan = 'Ton';
        } elseif ($barang->satuan == 'Kg') {
            $jumlah = $request->jumlah;
            $satuan = 'Ton';
        }else{
            $jumlah = $request->jumlah;
            $satuan = $barang->satuan;
        }

        if ($request->file('foto_kwitansi') != null) {
            $foto_kwitansi = $request->file('foto_kwitansi');
            $nama_kwitansi = time()."_".$foto_kwitansi->getClientOriginalName();
            $foto_kwitansi->move("upload/foto/kwitansi", $nama_kwitansi);
            $masuk = StorageMasukBulky::create($request->only('barang_kode', 'bulky_id','pemesanan_keluar_bulky_id', 'nomor_kwitansi', 'nomor_surat_jalan', 'harga_beli')+[
                'jumlah' => $jumlah,
                'kode' => $kode,
                'satuan' => $satuan,
                'user_id' => auth()->user()->id,
                'foto_kwitansi' => 'upload/foto/kwitansi/'.$nama_kwitansi,
                'foto_surat_jalan' => 'upload/foto/surat_jalan/'.$nama_surat_jalan,
                'waktu' => now('Asia/Jakarta')
            ]);
        } else {

            $foto_surat_piutang = $request->file('foto_surat_piutang');
            $nama_surat_piutang = time()."_".$foto_surat_piutang->getClientOriginalName();
            $foto_surat_piutang->move("upload/foto/surat_piutang", $nama_surat_piutang);
            $masuk = StorageMasukBulky::create($request->only('barang_kode', 'bulky_id','pemesanan_keluar_bulky_id', 'nomor_kwitansi', 'nomor_surat_jalan', 'harga_beli')+[
                'jumlah' => $jumlah,
                'kode' => $kode,
                'satuan' => $satuan,
                'user_id' => auth()->user()->id,
                'foto_surat_jalan' => 'upload/foto/surat_jalan/'.$nama_surat_jalan,
                'foto_surat_piutang' => 'upload/foto/surat_piutang/'.$nama_surat_piutang,
                'waktu' => now('Asia/Jakarta')
            ]);
        }


        StorageBulky::create([
            'storage_masuk_bulky_kode' => $kode,
            'jumlah' => $jumlah,
            'satuan' => $satuan,
            'waktu' => now('Asia/Jakarta')
        ]);

        $checkStock = StockBarangBulky::where([
            ['bulky_id', $request->bulky_id],
            ['barang_kode', $request->barang_kode]
        ])->first();

        if($checkStock !== null){
            $updateJumlah = $checkStock->jumlah + $jumlah;

            $checkStock->update([
                'jumlah' => $updateJumlah,
                'satuan' => $satuan
            ]);
        }else{
            StockBarangBulky::create($request->only('bulky_id', 'barang_kode')+[
                'kode' => $kode_stock_bulky,
                'nama_barang' => $barang->nama_barang,
                'satuan' => $satuan,
                'jumlah' => $jumlah
            ]);
        }

        $total = ($masuk->harga_beli / ($masuk->jumlah));

        RekapitulasiPembelianBulky::create([
            'storage_masuk_bulky_id' => $masuk->id,
            'tanggal_pembelian' => $masuk->waktu,
            'no_pembelian' => $masuk->kode,
            'no_kwitansi' => $request->nomor_kwitansi,
            'no_surat_jalan' => $request->nomor_surat_jalan,
            'nama_penjual' => $masuk->barang->pemasok->nama,
            'barang' => $masuk->barang->nama_barang,
            'jumlah' => $masuk->jumlah,
            'satuan' => $satuan,
            'harga' => round($total, 0, PHP_ROUND_HALF_UP),
            'total' => $masuk->harga_beli
        ]);

        LogTransaksi::create([
            'user_id' => Auth::user()->id,
            'tanggal' => now('Asia/Jakarta'),
            'jam' => now('Asia/Jakarta'),
            'aktifitas_transaksi' => 'Barang Masuk',
            'role' => 'Bulky'
        ]);

        return redirect('/v1/bulky/storage')->with('success', __( 'Data Barang Masuk Berhasil dibuat!' ));
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
            $data = StorageMasukBulky::with('barang', 'bulky', 'user.pengurusGudangBulky')->where('id', $id)->first();

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
        $data = StorageMasukBulky::find($id);
        $gudang = GudangBulky::all();
        return view('app.data-master.storageBulky.in.edit', compact('gudang', 'data'));
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
            'bulky_id' => 'required|exists:gudang_bulkies,id',
            'jumlah' => 'required|numeric',
            'harga_beli' => 'required|integer',
            'nomor_kwitansi' => 'required|numeric',
            'nomor_surat_jalan' => 'required|numeric',
            'foto_kwitansi' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'foto_surat_jalan' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
            // 'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        if ($v->fails()) {
            // dd($v);
            return back()->withErrors($v)->withInput();
        }

        // $faker = \Faker\Factory::create('id_ID');

        $barang = Barang::where('kode_barang', $request->barang_kode)->first();

        // $kode = $faker->unique()->ean13;
        $storage = StorageMasukBulky::with('storageBulky')->findOrFail($id);

        if ($request->jumlah > $storage->jumlah) {
            $total = $request->jumlah - $storage->jumlah;
            $hasil = $storage->storageBulky->jumlah + $total;

            $storage->storageBulky->update([
                'jumlah' => $hasil,
                'satuan' => $barang->satuan
            ]);
        }elseif ($request->jumlah < $storage->jumlah) {
            $total = $storage->jumlah - $request->jumlah;
            $hasil = $storage->storageBulky->jumlah - $total;

            $storage->storageBulky->update([
                'jumlah' => $hasil,
                'satuan' => $barang->satuan
            ]);
        }else{
            $storage->storageBulky->update([
                'satuan' => $barang->satuan
            ]);
        }

        $storage->update($request->only('barang_kode', 'bulky_id', 'jumlah', 'nomor_kwitansi', 'nomor_surat_jalan', 'harga_beli')+[
            'satuan' => $barang->satuan
        ]);

        // $simpanan = StorageBulky::where('storage_masuk_bulky_kode', $storage->kode)->first();

        if ($request->file('foto_kwitansi')) {
            File::delete($storage->foto_kwitansi);

            $foto_kwitansi = $request->file('foto_kwitansi');
            $nama_kwitansi = time()."_".$foto_kwitansi->getClientOriginalName();
            $foto_kwitansi->move("upload/foto/kwitansi", $nama_kwitansi);

            $storage->update([
                'foto_kwitansi' => 'upload/foto/kwitansi/'.$nama_kwitansi,
            ]);
        }

        if ($request->file('foto_surat_jalan')) {
            File::delete($storage->foto_surat_jalan);

            $foto_surat_jalan = $request->file('foto_surat_jalan');
            $nama_surat_jalan = time()."_".$foto_surat_jalan->getClientOriginalName();
            $foto_surat_jalan->move("upload/foto/surat_jalan", $nama_surat_jalan);

            $storage->update([
                'foto_surat_jalan' => 'upload/foto/surat_jalan/'.$nama_surat_jalan,
            ]);
        }

        $rekap = RekapitulasiPembelianBulky::where('storage_masuk_bulky_id', $storage->id)
        ->first();
        $rekap->update([
            'barang' => $storage->barang->nama_barang,
            'jumlah' => $storage->jumlah,
            'satuan' => $barang->satuan,
            'harga' => ($storage->harga_beli / $storage->jumlah),
            'total' => $storage->harga_beli
        ]);

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
        $data = StorageMasukBulky::with('storageBulky')->findOrFail($id);

        $checkStock = StockBarangBulky::where([
            ['bulky_id', $data->bulky_id],
            ['barang_kode', $data->barang_kode]
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
