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
use App\Models\StockBarang;
use App\Models\BarangPesanan;
use App\Models\BarangWarung;
use App\Models\Pemesanan;
use App\Models\Kwitansi;
use App\Models\LogTransaksi;
use App\Models\RekapitulasiPenjualan;
use App\Models\SuratJalan;
use App\User;
use App\Mail\KwitansiDanSuratJalanMail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use PDF;
use Auth;

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
            if (Auth::user()->pengurusGudang->status == 1) {
                $data = StorageOut::with('stockBarangRetail', 'gudang', 'pemesanan', 'satuan')
                ->where('user_id',Auth::user()->id)
                ->orderBy('id', 'desc')
                ->get();
            } else {
                $data = StorageOut::with('stockBarangRetail', 'gudang', 'pemesanan', 'satuan')
                ->where('gudang_id', Auth::user()->pengurusGudang->gudang[0]->id)
                ->where('user_id',Auth::user()->id)
                ->orderBy('id', 'desc')
                ->get();
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    // return '<a href="/v1/storage/out/'.$data->id.'/edit" class="btn btn-primary btn-sm">Edit</a>&nbsp;<a href="#" class="btn btn-danger btn-sm" onclick="sweet(\'/v1/storage/out/'.$data->id.'\')">Hapus</a>';
                    return '<a href="#" class="btn btn-danger btn-sm" onclick="sweet(\'/v1/storage/out/'.$data->id.'\')">Hapus</a>';
                })
                ->editColumn('created_at',function($data){
                    return date('d-m-Y H:i:s', strtotime($data->created_at));
                })
                ->make(true);
        }
        return view('app.data-master.storage.index');
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
        $data = Kwitansi::with('pemesanan.barangPesanan','gudang','user')->findOrFail($request->query('id'));

        // dd($data);
        // PDF::;
        $customPaper = array(0,0,283.80,567.00);

        $counter = $data->count();
        $kode = sprintf("%'.04d", (String)$counter);
        $pdf = PDF::loadview('app.transaksi.kwitansi.print', compact('data','date','kode'));
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
        $data = SuratJalan::whereId($request->query('id'))->with('user.pengurusGudang.desa','user.pengurusGudang.kecamatan','user.pengurusGudang.kabupaten','user.pengurusGudang.provinsi','pemesanan.gudang','pemesanan.barangPesanan','pemesanan.pelanggan.desa','pemesanan.pelanggan.kecamatan','pemesanan.pelanggan.kabupaten','pemesanan.pelanggan.provinsi')->first();

        // dd($data->pemesanan->pelanggan);
        // PDF::;
        // $customPaper = array(0,0,283.80,567.00);

        $counter = $data->count();
        $kode = sprintf("%'.04d", (String)$counter);
        $pdf = PDF::loadview('app.transaksi.surat-jalan.print', compact('data','date','kode'));
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
        $gudang = Gudang::all();
        if($request->query('id') != 0){
            $pemesanan = Pemesanan::findOrFail($request->query('id'));
            $setted = true;
            $same = StorageOut::where('pemesanan_id',$pemesanan->id)->get();
            if($same->count() > 0){
                return back()->with('failed','Barang Sudah Dikirm! Mohon Cek Di Data Barang Keluar');
            }
        }else{
            $pemesanan = Pemesanan::where('status','2')->orWhere('status','6')->doesntHave('storageOut')->get();
            $setted = false;
        }

        if($pemesanan->count() < 1){
            return redirect('v1/storage')->with('failed','Belum Ada Pesanan Baru Dari Warung!');
        }
        $poci = $request->query('pemesanan', null);

        $surat = SuratJalan::all();
        $number = $surat->count();
        $alpha = "LK";
        $date = date("ymdHis");
        $kode_surat = sprintf("%04s",abs($number+1));

        return view('app.data-master.storage.out.create', compact('setted','gudang', 'pemesanan', 'kode_surat', 'poci'));
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
            'pemesanan_id' => 'required|exists:pemesanans,id',
            // 'pengirim' => 'required|string|max:50',
            'terima_dari' => 'required|string|max:50',
            'jumlah_uang_digits' => 'required|integer',
            'jumlah_uang_word' => 'required|string',
            'keterangan' => 'required|string',
            'tempat' => 'required|string',
            'profil_lembaga' => 'required|string|max:6|min:3',
            'tanggal_surat' => 'required|date'
            // 'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        if ($v->fails()) {
            // dd($v);
            return back()->withErrors($v)->withInput();
        }

        $pesanan = Pemesanan::with('barangPesanan', 'gudang')->findOrFail($request->pemesanan_id);
        $gudang = $pesanan->gudang;
        foreach ($pesanan->barangPesanan as $key => $value) {
            $pesan = $value;
        }

        foreach ($pesanan->barangPesanan as $barang) {
            $kode_barang = $barang->barang_retail_id;

            $satuan = ($barang->satuan == 'Kuintal') ? 'Kg' : $barang->satuan;

            $stok = Storage::where('barang_retail_id', $kode_barang)
            ->whereHas('storageIn', function($query)use($kode_barang, $gudang){
                $query->where('gudang_id', $gudang->id);
            })
            ->orderBy('waktu', 'asc')
            ->get();

            $jumlahBarang = count($stok) - 1;
            $now = 0;

            $jumlah = $barang->jumlah_barang;

            $hasil = 0;

            for ($i=0; $i < count($stok); $i++) {
                if ($stok[$i]->satuan == 'Kuintal') {
                    $jumlahStok = $stok[$i]->jumlah * 100;

                    if ($jumlahStok != 0) {
                        $jumlahStok = $jumlahStok - $jumlah;
                        if ($jumlahStok >= 0) {
                            $jumlahStok = $jumlahStok / 100;

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

            $barangRetail = StockBarang::where('id', $kode_barang)
            ->first();

            $satuanId = ($barangRetail->satuan == 'Kuintal') ? 3 : 2 ;

            $out = StorageOut::create($request->only('pemesanan_id')+[
                'gudang_id' => $gudang->id,
                'barang_retail_id' => $barangRetail->id,
                'jumlah' => $barang->jumlah_barang,
                'satuan_id' => $satuanId,
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
                'aktifitas_transaksi' => 'Pengiriman Barang'
            ]);

        }

        foreach ($pesanan->barangPesanan as $kodex){
            $jumlahAkhir = Storage::where('barang_retail_id', $kodex->barang_retail_id)
            ->sum('jumlah');

            $new = Storage::where('barang_retail_id', $kodex->barang_retail_id)
            ->first();

            StockBarang::find($kodex->barang_retail_id)->update([
                'jumlah' => $jumlahAkhir
            ]);
        }


        $kode_kwi = $faker->unique()->ean13;

        $surat = SuratJalan::all();
        $number = $surat->count();
        $alpha = "LK";
        $date = date("ymdHis");
        $kode_surat = sprintf("%04s",abs($number+1));

        $jens = date("m", strtotime($request->tanggal_surat));
        $hari = date("d", strtotime($request->tanggal_surat));
        $tahun = date("Y", strtotime($request->tanggal_surat));

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
        $date = date('d-m-Y');

        $kwitansi = Kwitansi::create($request->only('terima_dari', 'jumlah_uang_digits', 'jumlah_uang_word', 'pemesanan_id', 'tempat', 'keterangan')+[
            'user_id' => auth()->user()->id,
            'kode' => $kode_kwi,
            'gudang_id' => $gudang->id,
            'tanggal' => now('Asia/Jakarta')
        ]);

        $surat = SuratJalan::create($request->only('tempat', 'pemesanan_id')+[
            'pengirim' => auth()->user()->pengurusGudang->nama,
            'penerima' => $pesanan->nama_pemesan,
            'kode' => $surat_kode,
            'user_id' => auth()->user()->id,
            'tanggal' => now('Asia/Jakarta')
        ]);

        $counterKwitansi = $kwitansi->count();
        $pdfKodeKwi = sprintf("%'.04d", (String)$counterKwitansi);
        $pdfKwitansi = PDF::loadview('app.transaksi.kwitansi.print', [
            'data' => $kwitansi,
            'date' => $date,
            'kode' => $pdfKodeKwi
        ]);

        $counterSJ = $surat->count();
        $pdfKodeSJ = sprintf("%'.04d", (String)$counterSJ);
        $pdfSJ = PDF::loadview('app.transaksi.surat-jalan.print', [
            'data' => $surat,
            'date' => $date,
            'kode' => $pdfKodeSJ
        ]);
        // $pesanan->retail->user->email
        $user = User::where('pelanggan_id', $pesanan->pelanggan_id)->first();

        Mail::to($user->email)->send(new KwitansiDanSuratJalanMail($pdfSJ, $pdfKwitansi));

        $bp = BarangPesanan::where('pemesanan_id',$out->pemesanan->id)->get();
        $jumlah = 0;
        $total = 0;
        $satuan = [];
        foreach ($bp as $key => $value) {
            $jumlah += $value->jumlah_barang;
            $total += $value->harga;
            $satuan = $value->satuan;
        }
        $harga_total = $total / $jumlah;
        // dd($harga_total);
        RekapitulasiPenjualan::create([
            'storage_out_id' => $out->id,
            'tanggal_penjualan' => $out->waktu,
            'no_penjualan' => $out->kode,
            'no_kwitansi' => $kwitansi->kode,
            'no_surat_jalan' => $surat->kode,
            'nama_pembeli' => $out->pemesanan->nama_pemesan,
            'barang' => $out->pemesanan->barangPesanan[0]->stockBarangRetail->nama_barang,
            'jumlah' => $jumlah,
            'satuan' => $satuan,
            'harga' => $harga_total,
            'total' => $total
        ]);

        $pesanan->update(['status'=>'4']);
        return redirect('v1/storage')->with('success', __( 'Penyimpanan Keluar Telah Berhasil !' ));
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
