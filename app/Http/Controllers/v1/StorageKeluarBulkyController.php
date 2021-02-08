<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Models\StorageKeluarBulky;
use App\Models\StorageMasukBulky;
use App\Models\StorageBulky;
use App\Models\GudangBulky;
use App\Models\Barang;
use App\Models\StockBarangBulky;
use App\Models\BarangPemesananBulky;
use App\Models\BarangWarung;
use App\Models\PemesananBulky;
use App\Models\KwitansiBulky;
use App\Models\LogTransaksi;
use App\Models\RekapitulasiPenjualan;
use App\Models\RekapitulasiPenjualanBulky;
use App\Models\SuratJalanBulky;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use PDF;

class StorageKeluarBulkyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = StorageKeluarBulky::with('barang', 'bulky', 'pemesananBulky')->where('user_id',Auth::user()->id)
            ->orderBy('id', 'desc')
            ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    // return '<a href="/v1/storage/out/'.$data->id.'/edit" class="btn btn-primary btn-sm">Edit</a>&nbsp;<a href="#" class="btn btn-danger btn-sm" onclick="sweet(\'/v1/storage/out/'.$data->id.'\')">Hapus</a>';
                    return '<a href="#" class="btn btn-danger btn-sm" onclick="sweet(\'/v1/bulky/storage/keluar/'.$data->id.'\')">Hapus</a>';
                })
                ->editColumn('created_at',function($data){
                    return date('d-m-Y H:i:s', strtotime($data->created_at));
                })
                ->make(true);
        }
        return view('app.data-master.storageBulky.index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function printKwitansi(Request $request)
    {
        set_time_limit(120);
        $date = date('d-m-Y');
        $data = KwitansiBulky::with('pemesananBulky.barangPesananBulky','bulky','user')->findOrFail($request->query('id'));

        // dd($data);
        // PDF::;
        $customPaper = array(0,0,283.80,567.00);

        $counter = $data->count();
        $kode = sprintf("%'.04d", (String)$counter);
        $pdf = PDF::loadview('app.transaksi.kwitansi.print_bulky', compact('data','date','kode'));
        return $pdf->stream();
        // return view('app.transaksi.kwitansi.print', compact('data','date','kode'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function printSuratJalan(Request $request)
    {
        set_time_limit(120);
        $date = date('d-m-Y');
        $data = SuratJalanBulky::whereId($request->query('id'))->with('user','pemesananBulky.bulky','pemesananBulky.barangPesananBulky')->first();

        // dd($data);
        // PDF::;
        // $customPaper = array(0,0,283.80,567.00);

        $counter = $data->count();
        $kode = sprintf("%'.04d", (String)$counter);
        $pdf = PDF::loadview('app.transaksi.surat-jalan.print_bulky', compact('data','date','kode'));
        return $pdf->stream();

        // return view('app.transaksi.surat-jalan.print');
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
    public function create(Request $request)
    {
        // dd($request->query());
        $gudang = GudangBulky::all();
        $pemesanan = PemesananBulky::doesntHave('storageKeluarBulky')
        ->where('status', '2')
        ->orWhere('status','6')
        ->get();

        // dd($pemesanan);

        $poci = $request->query('pemesanan', null);
        // dd($poci);
        $surat = SuratJalanBulky::all();
        $number = $surat->count();
        $alpha = "LK";
        $date = date("ymdHis");
        $kode_surat = sprintf("%04s",abs($number+1));

        return view('app.data-master.storageBulky.out.create', compact('gudang', 'pemesanan', 'kode_surat', 'poci'));
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
            // 'barang_kode' => 'required|numeric|exists:barangs,kode_barang',
            // 'gudang_id' => 'required|exists:gudangs,id',
            'pemesanan_bulky_id' => 'required|exists:pemesanan_bulkies,id',
            // 'pengirim' => 'required|string|max:50',
            'terima_dari' => 'required|string|max:50',
            'jumlah_uang_digits' => 'required|integer',
            'jumlah_uang_word' => 'required|string',
            'keterangan' => 'required|string',
            'tempat' => 'required|string',
            'profil_lembaga' => 'required|string|max:6|min:3'
            // 'tanggal_surat' => 'required|date'
            // 'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        }

        $pesanan = PemesananBulky::with('barangPesananBulky', 'bulky')->findOrFail($request->pemesanan_bulky_id);

        $gudang = $pesanan->bulky;

        $pesanan->update([
            'status' => '4'
        ]);


        $barang = $pesanan->barangPesananBulky;

        $satuan = ($barang->satuan == 'Ton') ? 'Kwintal' : $barang->satuan;

        $kode_barang = $barang->barang_kode;

        $stok = StorageBulky::whereHas('storageMasukBulky', function($query)use($kode_barang, $gudang){
            $query->where([
                ['bulky_id', $gudang->id],
                ['barang_kode', $kode_barang]
            ]);
        })
        ->orderBy('waktu', 'asc')
        ->get();

        $jumlahBarang = count($stok) - 1;
        $now = 0;

        $jumlah = $barang->jumlah_barang;

        $hasil = 0;

        for ($i=0; $i < count($stok); $i++) {

            if ($stok[$i]->satuan == 'Ton') {
                $jumlahStok = $stok[$i]->jumlah * 10;

                if ($jumlahStok != 0) {
                    $jumlahStok = $jumlahStok - $jumlah;

                    if ($jumlahStok >= 0) {
                        $jumlahStok = $jumlahStok / 10;

                        $stok[$i]->update([
                            'jumlah' => $jumlahStok
                        ]);

                        break;
                    }elseif($jumlahStok < 0){
                        $stok[$i]->update([
                            'jumlah' => 0
                        ]);

                        $jumlah = abs($jumlahStok);
                    }
                    // dd($jumlah);
                }
            } else {
                $jumlahStok = $stok[$i]->jumlah;

                if ($jumlahStok != 0) {
                    $jumlahStok = $jumlahStok - $jumlah;
                    if ($jumlahStok >= 0) {
                        $stok[$i]->update([
                            'jumlah' => $jumlahStok
                        ]);

                        break;
                    }elseif($jumlahStok < 0){
                        $stok[$i]->update([
                            'jumlah' => 0
                        ]);

                        $jumlah = abs($jumlahStok);
                    }
                    // dd($jumlah);
                }
            }


        }


        $faker = \Faker\Factory::create('id_ID');

        $kode_out = $faker->unique()->ean13;

        $out = StorageKeluarBulky::create($request->only('pemesanan_bulky_id')+[
            'bulky_id' => $gudang->id,
            'barang_kode' => $kode_barang,
            'jumlah' => $barang->jumlah_barang,
            'satuan' => $barang->satuan,
            'kode' => $kode_out,
            'user_id' => auth()->user()->id,
            'waktu' => now('Asia/Jakarta')
        ]);



        // BarangWarung::create([
        //     'kode' => rand(1000000,9999999),
        //     'storage_out_kode' => $out->kode,
        //     'pelanggan_id' => $pesanan->pelanggan_id,
        //     'jumlah' => $pesan->jumlah_barang,
        //     'satuan' => $pesan->satuan,
        //     'waktu' => Carbon::now()
        // ]);
        $log = LogTransaksi::create([
            'tanggal' => now('Asia/Jakarta'),
            'jam' => now('Asia/Jakarta'),
            'Aktifitas_transaksi' => 'Pengiriman Barang'
        ]);

        $kodex = $pesanan->barangPesananBulky;

        $jumlahAkhir = StorageBulky::whereHas('storageMasukBulky', function($query)use($kodex, $gudang){
            $query->where([
                    ['bulky_id', $gudang->id],
                    ['barang_kode', $kodex->barang_kode]
                ]);
        })->sum('jumlah');

        StockBarangBulky::where([
            ['bulky_id', $gudang->id],
            ['barang_kode', $kodex->barang_kode]
        ])
        ->update([
            'jumlah' => $jumlahAkhir
        ]);


        $kode_kwi = $faker->unique()->ean13;

        $surat = SuratJalanBulky::all();
        $number = $surat->count();
        $alpha = "LK";
        $date = date("ymdHis");
        $kode_surat = sprintf("%04s",abs($number+1));

        $jens = date("m", strtotime(now('Asia/Jakarta')));
        $hari = date("d", strtotime(now('Asia/Jakarta')));
        $tahun = date("Y", strtotime(now('Asia/Jakarta')));

        if ($jens == 1) {
            $romawi = "I";
        } elseif ($jens == 2) {
            $romawi = "II";
        } elseif ($jens == 3) {
            $romawi = "III";
        } elseif ($jens == 4) {
            $romawi = "IV";
        } elseif ($jens == 5) {
            $romawi = "V";
        } elseif ($jens == 6) {
            $romawi = "VI";
        } elseif ($jens == 7) {
            $romawi = "VII";
        } elseif ($jens == 8) {
            $romawi = "VIII";
        } elseif ($jens == 9) {
            $romawi = "IX";
        } elseif ($jens == 10) {
            $romawi = "X";
        } elseif ($jens == 11) {
            $romawi = "XI";
        } elseif ($jens == 12) {
            $romawi = "XII";
        }

        $tanggal_surat = $hari.'/'.$romawi.'/'.$tahun;


        $surat_kode = (string)$kode_surat.'/'.$request->profil_lembaga.'/'.$tanggal_surat;
        // $kode_surat = $faker->unique()->ean13;

        $kwitansi = KwitansiBulky::create($request->only('terima_dari', 'jumlah_uang_digits', 'jumlah_uang_word', 'pemesanan_bulky_id', 'tempat', 'keterangan')+[
            'user_id' => auth()->user()->id,
            'kode' => $kode_kwi,
            'bulky_id' => $gudang->id,
            'tanggal' => now('Asia/Jakarta')
        ]);

        $surat = SuratJalanBulky::create($request->only('tempat', 'pemesanan_bulky_id')+[
            'pengirim' => auth()->user()->pengurusGudangBulky->nama,
            'penerima' => $pesanan->nama_pemesan,
            'kode' => $surat_kode,
            'user_id' => auth()->user()->id,
            'tanggal' => now('Asia/Jakarta')
        ]);

        $bp = BarangPemesananBulky::where('pemesanan_bulky_id',$out->pemesananBulky->id)->first();
        $jumlah = 0;
        $total = 0;
        $satuan = [];
        $bar = "";

        $total = ($out->pemesananBulky->barangPesananBulky->harga / $out->pemesananBulky->barangPesananBulky->jumlah_barang);

        RekapitulasiPenjualanBulky::create([
            'storage_keluar_bulky_id' => $out->id,
            'tanggal_penjualan' => $out->waktu,
            'no_penjualan' => $out->kode,
            'no_kwitansi' => $kwitansi->kode,
            'no_surat_jalan' => $surat->kode,
            'nama_pembeli' => $out->pemesananBulky->nama_pemesan,
            'barang' => $out->pemesananBulky->barangPesananBulky->nama_barang,
            'jumlah' => $out->jumlah,
            'satuan' => $out->satuan,
            'harga' => round($total, 0, PHP_ROUND_HALF_UP),
            'total' => $out->pemesananBulky->barangPesananBulky->harga
        ]);

        return redirect('/v1/bulky/storage')->with('success', __( 'Penyimpanan Keluar Telah Berhasil !' ));
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
            $data = StorageOut::with('barang', 'gudang = $pesanan->gudang;', 'user.pengurusGudang')->where('id', $id)->first();

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

        return back()->with('success', __( 'Penyimpanan Keluar Telah Berhasil Di Edit !' ));
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

        return back()->with('success', __( 'Penyimpanan Keluar Telah Berhasil Di Hapus !' ));
    }
}
