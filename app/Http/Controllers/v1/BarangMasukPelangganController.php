<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\BarangMasukPelanggan;
use App\Models\BarangPesanan;
use App\Models\BarangWarung;
use App\Models\LogTransaksi;
use App\Models\Pemesanan;
use App\Models\RekapitulasiPembelianPelanggan;
use App\Models\StorageOut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Auth;

class BarangMasukPelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = BarangMasukPelanggan::with('storageOut.gudang','storageOut.stockBarangRetail', 'user')
            ->where('user_id',Auth::user()->id)
            ->orderBy('id', 'desc')
            ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    return '<a href="#" class="btn btn-danger btn-sm" onclick="sweet('.$data->id.')">Hapus</a>';
                    // return '<a href="/v1/barangMasukPelanggan/'.$data->id.'/edit" class="btn btn-primary btn-sm">Edit</a>&nbsp;<a class="btn btn-info btn-sm" data-toggle="modal" data-target="#exampleModal" onclick="detail('.$data->id.')" data-id="'.$data->id.'" style="cursor: pointer;" title="Detail">Detail</a>&nbsp;<a href="#" class="btn btn-danger btn-sm" onclick="sweet('.$data->id.')">Hapus</a>';
                })
                ->addColumn('nama_gudang',function($data){
                    return $data->storageOut->gudang->nama;
                })
                ->addColumn('jumlah_barang',function($data){
                    return $data->jumlah.' '.$data->satuan;
                })
                ->rawColumns(['action','nama_gudang','nama_barang','jumlah_barang'])
                ->make(true);
        }
        return view('app.data-master.manajemenBarangPelanggan.masuk.index');
    }

    public function detail($id)
    {
        try {
            $data = BarangMasukPelanggan::with('storageOut.gudang','storageOut.barang', 'user.pelanggan')->where('id', $id)->first();

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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $barang = StorageOut::with('barang','barangWarung','barangMasukPelanggan','gudang','user','stockBarangRetail','pemesanan')
            ->whereHas('pemesanan',function($q){
                $q->where('pelanggan_id',Auth::user()->pelanggan_id);
            })
            ->whereHas('pemesanan',function($q){
                $q->where('status',5);
            })
            ->doesntHave('barangMasukPelanggan')
            ->get();
            // dd($barang);
            return view('app.data-master.manajemenBarangPelanggan.masuk.create', compact('barang'));
    }
    public function findBarang($id)
    {
        try {
            $pesanan = BarangPesanan::with('pesanan.kwitansi','pesanan.suratJalan')
            ->where('pemesanan_id',$id)
            ->whereHas('pesanan', function($query){
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
            'nomor_kwitansi' => 'nullable|numeric',
            'nomor_surat_jalan' => 'required|string',
            'foto_kwitansi' => 'nullable|image|mimes:png,jpg',
            'foto_surat_jalan' => 'required|image|mimes:png,jpg',
            'storage_out_kode' => 'required|exists:storage_outs,kode',
            'jumlah' => 'required|numeric',
            'harga_beli' => 'required|numeric',
        ]);

        if ($v->fails()) {
            // dd($v->errors()->all());
            return back()->withErrors($v)->withInput();
        }

        $faker = \Faker\Factory::create('id_ID');

        $kode = $faker->unique()->ean13;

        $barang = StorageOut::where('kode', $request->storage_out_kode)->first();

        $foto_surat_jalan = $request->file('foto_surat_jalan');
        $nama_surat_jalan = time()."_".$foto_surat_jalan->getClientOriginalName();
        $foto_surat_jalan->move("upload/foto/surat_jalan", $nama_surat_jalan);

        if ($request->file('foto_kwitansi') != null) {
            $foto_kwitansi = $request->file('foto_kwitansi');
            $nama_kwitansi = time()."_".$foto_kwitansi->getClientOriginalName();
            $foto_kwitansi->move("upload/foto/kwitansi", $nama_kwitansi);
            $masuk = BarangMasukPelanggan::create($request->only('storage_out_kode', 'jumlah', 'nomor_kwitansi', 'nomor_surat_jalan', 'harga_beli')+[
                'kode' => $kode,
                'satuan' => $barang->satuan->satuan,
                'user_id' => auth()->user()->id,
                'foto_kwitansi' => 'upload/foto/kwitansi/'.$nama_kwitansi,
                'foto_surat_jalan' => 'upload/foto/surat_jalan/'.$nama_surat_jalan,
                'waktu' => now('Asia/Jakarta')
            ]);
        } else {
            $foto_surat_piutang = $request->file('foto_surat_piutang');
            $nama_surat_piutang = time()."_".$foto_surat_piutang->getClientOriginalName();
            $foto_surat_piutang->move("upload/foto/surat_piutang", $nama_surat_piutang);
            $masuk = BarangMasukPelanggan::create($request->only('storage_out_kode', 'jumlah', 'nomor_kwitansi', 'nomor_surat_jalan', 'harga_beli')+[
                'kode' => $kode,
                'satuan' => $barang->satuan->satuan,
                'user_id' => auth()->user()->id,
                'foto_surat_piutang' => 'upload/foto/surat_piutang/'.$nama_surat_piutang,
                'foto_surat_jalan' => 'upload/foto/surat_jalan/'.$nama_surat_jalan,
                'waktu' => now('Asia/Jakarta')
            ]);
        }
        $checkStock = BarangWarung::where([
            ['nama_barang',$masuk->storageOut->stockBarangRetail->nama_barang],
            ['pelanggan_id',Auth::user()->pelanggan_id]
        ])->first();

        if ($checkStock !== null) {
            $jumlah = $checkStock->jumlah + $masuk->jumlah;
            $checkStock->update([
                'jumlah' => $jumlah,
                'satuan' => $masuk->satuan
            ]);
        } else {
            BarangWarung::create([
                'storage_out_kode' => $masuk->storage_out_kode,
                'pelanggan_id' => Auth::user()->pelanggan_id,
                'kode' => rand(1000000,9999999),
                'nama_barang' => $request->nama_barang,
                'jumlah' => $request->jumlah,
                'satuan' => $barang->satuan->satuan,
                'waktu' => now('Asia/Jakarta')
            ]);
        }

        $rekapitulasi = RekapitulasiPembelianPelanggan::create([
            'barang_masuk_id' => $masuk->id,
            'tanggal_pembelian' => $masuk->waktu,
            'no_pembelian' => $masuk->kode,
            'no_kwitansi' => $masuk->nomor_kwitansi,
            'no_surat_jalan' => $masuk->nomor_surat_jalan,
            'nama_penjual' => $masuk->storageOut->pemesanan->penerima_po,
            'barang' => $masuk->storageOut->stockBarangRetail->nama_barang,
            'jumlah' => $masuk->jumlah,
            'satuan' => $barang->satuan->satuan,
            'harga' => $masuk->storageOut->stockBarangRetail->harga_barang,
            'total' => $masuk->jumlah*$masuk->storageOut->stockBarangRetail->harga_barang
        ]);

        // dd($rekapitulasi);

        // $checkStock = StockBarang::where([
        //     ['gudang_id', $request->gudang_id],
        //     ['barang_kode', $request->barang_kode]
        // ])->first();

        // if($checkStock !== null){
        //     $updateJumlah = $checkStock->jumlah + $request->jumlah;

        //     $checkStock->update([
        //         'jumlah' => $updateJumlah,
        //         'satuan' => $barang->satuan
        //     ]);
        // }else{
        //     StockBarang::create($request->only('gudang_id', 'barang_kode', 'jumlah')+[
        //         'satuan' => $barang->satuan
        //     ]);
        // }

        // RekapitulasiPembelian::create([
        //     'storage_in_id' => $masuk->id,
        //     'tanggal_pembelian' => $masuk->waktu,
        //     'no_pembelian' => $masuk->kode,
        //     'nama_penjual' => $masuk->barang->pemasok->nama,
        //     'barang' => $masuk->barang->nama_barang,
        //     'jumlah' => $masuk->jumlah,
        //     'satuan' => $barang->satuan,
        //     'harga' => $masuk->barang->harga_barang,
        //     'total' => $masuk->barang->harga_total
        // ]);
        LogTransaksi::create([
            'user_id' => Auth::user()->id,
            'tanggal' => now('Asia/Jakarta'),
            'jam' => now('Asia/Jakarta'),
            'aktifitas_transaksi' => 'Barang Masuk',
            'role' => 'Warung'
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = BarangMasukPelanggan::find($id);
        $barang = StorageOut::all();
        return view('app.data-master.manajemenBarangPelanggan.masuk.edit', compact('barang','data'));
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
            'nomor_kwitansi' => 'required|numeric',
            'nomor_surat_jalan' => 'required|numeric',
            'foto_kwitansi' => 'nullable|image|mimes:png,jpg',
            'foto_surat_jalan' => 'nullable|image|mimes:png,jpg',
            'storage_out_kode' => 'required|exists:storage_outs,kode',
            'jumlah' => 'required|numeric',
            'harga_beli' => 'required|numeric',
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        }

        // $faker = \Faker\Factory::create('id_ID');

        // $kode = $faker->unique()->ean13;
        $storage = BarangMasukPelanggan::findOrFail($id);

        $storage->update($request->only('storage_out_kode', 'jumlah', 'satuan', 'nomor_kwitansi', 'nomor_surat_jalan'));

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

        return redirect()->back()->with('success', __( 'Data Barang Masuk Berhasil diubah!' ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = BarangMasukPelanggan::findOrFail($id);

        File::delete($data->foto_kwitansi);
        File::delete($data->foto_surat_jalan);
        $data->delete();

        return back()->with('success', __( 'Data Barang Masuk dihapus!' ));
    }
}
