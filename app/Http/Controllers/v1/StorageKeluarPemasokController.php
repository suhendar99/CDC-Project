<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\BarangKeluarPemesananBulky;
use App\Models\KwitansiPemasok;
use App\Models\LogTransaksi;
use App\Models\Pemasok;
use App\Models\PemesananKeluarBulky;
use App\Models\RekapitulasiPenjualanPemasok;
use App\Models\Satuan;
use App\Models\StorageKeluarPemasok;
use App\Models\SuratJalanPemasok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use PDF;
use App\User;
use App\Mail\KwitansiDanSuratJalanMail;
use Illuminate\Support\Facades\Mail;

class StorageKeluarPemasokController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = StorageKeluarPemasok::where('pemasok_id',Auth::user()->pemasok_id)->with('pemesananKeluarBulky','barang','pemasok','satuan')->orderBy('id','desc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    // <a href="/v1/barang/'.$data->id.'/edit" class="btn btn-primary btn-sm">Edit</a>&nbsp;
                    return '<a href="#" class="btn btn-danger btn-sm" onclick="sweet('.$data->id.')">Hapus</a>';
                })
                ->editColumn('pemesanan',function($data){
                    return $data->pemesananKeluarBulky->kode.' | '.$data->pemesananKeluarBulky->nama_pemesan;
                })
                ->editColumn('waktu',function($data){
                    return date('d-m-Y H:i', strtotime($data->created_at)).' WIB';
                })
                ->make(true);
        }
        return view('app.data-master.barang.index');
    }

    public function printKwitansi(Request $request)
    {
        set_time_limit(120);
        $date = date('d-m-Y');
        $data = KwitansiPemasok::with('pemesananKeluarBulky.barangKeluarPemesananBulky','pemasok','user')->findOrFail($request->query('id'));
        // dd($data->pemesananKeluarBulky->barangKeluarPemesananBulky[0]);
        // PDF::;
        $customPaper = array(0,0,283.80,567.00);

        $counter = $data->count();
        $kode = sprintf("%'.04d", (String)$counter);
        $pdf = PDF::loadview('app.transaksi.kwitansi.print_pemasok', compact('data','date','kode'));
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
        $data = SuratJalanPemasok::whereId($request->query('id'))->with('user','pemesananKeluarBulky.bulky','pemesananKeluarBulky.barangKeluarPemesananBulky')->first();
        // dd($data);
        // dd($data);
        // PDF::;
        // $customPaper = array(0,0,283.80,567.00);

        $counter = $data->count();
        $kode = sprintf("%'.04d", (String)$counter);
        $pdf = PDF::loadview('app.transaksi.surat-jalan.print_pemasok', compact('data','date','kode'));
        return $pdf->stream();

        // return view('app.transaksi.surat-jalan.print');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $pemasok = Pemasok::all();
        $pemesanan = PemesananKeluarBulky::where('status', '2')->orWhere('status','6')->get();

        if($request->query('id') != 0){
            $pemesanan = PemesananKeluarBulky::findOrFail($request->query('id'));
            $setted = true;
            $same = StorageKeluarPemasok::where('pemesanan_keluar_bulky_id',$pemesanan->id)->get();
            if($same->count() > 0){
                return back()->with('failed','Barang Sudah Dikirm! Mohon Cek Di Data Barang Keluar');
            }
        }else{
            $pemesanan = PemesananKeluarBulky::where('status', '2')->orWhere('status','6')->get();
            $setted = false;
        }

        if($pemesanan->count() < 1){
            return redirect('v1/storage-keluar-pemasok')->with('error','Belum Ada Pesanan Baru Dari Bulky!');
        }

        $poci = $request->query('pemesanan', null);
        // dd($poci);
        $surat = SuratJalanPemasok::all();
        $number = $surat->count();
        $alpha = "LK";
        $date = date("ymdHis");
        $kode_surat = sprintf("%04s",abs($number+1));

        return view('app.data-master.barang.keluar.create', compact('pemasok','setted', 'pemesanan', 'kode_surat', 'poci'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $pesanan = PemesananKeluarBulky::with('barangKeluarPemesananBulky', 'bulky')->findOrFail($request->pemesanan_keluar_bulky_id);

        if ($pesanan->metode_pembayaran != null) {
            $v = Validator::make($request->all(),[
                // 'barang_kode' => 'required|numeric|exists:barangs,kode_barang',
                // 'gudang_id' => 'required|exists:gudangs,id',
                'pemesanan_keluar_bulky_id' => 'required|exists:pemesanan_keluar_bulky,id',
                // 'pengirim' => 'required|string|max:50',
                'terima_dari' => 'required|string|max:50',
                'jumlah_uang_digits' => 'required|numeric',
                'jumlah_uang_word' => 'required|string',
                'keterangan' => 'required|string',
                'tempat' => 'required|string',
                'profil_lembaga' => 'required|string|max:6|min:3',
                'tanggal_surat' => 'required|date'
                // 'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
            ]);
        } else {
            $v = Validator::make($request->all(),[
                // 'barang_kode' => 'required|numeric|exists:barangs,kode_barang',
                // 'gudang_id' => 'required|exists:gudangs,id',
                'pemesanan_keluar_bulky_id' => 'required|exists:pemesanan_keluar_bulky,id',
                // 'pengirim' => 'required|string|max:50',
                'terima_dari' => 'nullable|string|max:50',
                'jumlah_uang_digits' => 'nullable|numeric',
                'jumlah_uang_word' => 'nullable|string',
                'keterangan' => 'nullable|string',
                'tempat' => 'nullable|string',
                'profil_lembaga' => 'required|string|max:6|min:3',
                'tanggal_surat' => 'required|date'
                // 'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
            ]);
        }


        if ($v->fails()) {
            dd($v);
            return back()->withErrors($v)->withInput();
        }


        $gudang = $pesanan->bulky;
        foreach ($pesanan->barangKeluarPemesananBulky as $key => $value) {
            $pesan = $value;
        }
        foreach ($pesanan->barangKeluarPemesananBulky as $barang) {
            $kode_barang = $barang->barang_kode;
            $id_barang = $barang->barang->id;
            $satuan = ($barang->satuan == 'Ton') ? 'Ton' : $barang->satuan;

            $stok = Barang::orderBy('id', 'asc')->get();
            $jumlahBarang = count($stok) - 1;
            $now = 0;

            $jumlah = $barang->jumlah_barang;
            $hasil = 0;
            for ($i=0; $i < count($stok); $i++) {
                $sat = Satuan::where('satuan',$stok[$i]->satuan)->first();
                if ($stok[$i]->satuan == 'Ton') {
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

            $out = StorageKeluarPemasok::create($request->only('pemesanan_keluar_bulky_id')+[
                'pemasok_id' => $pesanan->pemasok_id,
                'barang_id' => $id_barang,
                'satuan_id' => $sat->id,
                'jumlah' => $barang->jumlah_barang,
                'satuan' => $satuan,
                'kode' => $kode_out,
                'user_id' => auth()->user()->id,
                'waktu' => now('Asia/Jakarta')
            ]);
            $stoks = Barang::findOrFail($out->barang_id);

            $stokEnd = $stoks->jumlah - $out->jumlah;

            $stoks->update([
                'jumlah' => $stokEnd
            ]);

            // BarangWarung::create([
            //     'kode' => rand(1000000,9999999),
            //     'storage_out_kode' => $out->kode,
            //     'pelanggan_id' => $pesanan->pelanggan_id,
            //     'jumlah' => $pesan->jumlah_barang,
            //     'satuan' => $pesan->satuan,
            //     'waktu' => Carbon::now()
            // ]);
            LogTransaksi::create([
                'user_id' => Auth::user()->id,
                'tanggal' => now('Asia/Jakarta'),
                'jam' => now('Asia/Jakarta'),
                'aktifitas_transaksi' => 'Barang keluar / Dikirim',
                'role' => 'Pemasok'
            ]);

        }
        // dd($pesanan->barangKeluarPemesananBulky);
        // foreach ($pesanan->barangPesanan as $kodex){
        //     $jumlahAkhir = Storage::whereHas('storageIn', function($query)use($kodex, $gudang){
        //         $query->where([
        //                 ['gudang_id', $gudang->id],
        //                 ['barang_kode', $kodex->barang_kode]
        //             ]);
        //     })->sum('jumlah');

        //     StockBarang::update([
        //         'jumlah' => $jumlahAkhir
        //     ]);
        // }

        $kode_kwi = $faker->unique()->ean13;

        $surat = SuratJalanPemasok::all();
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

        if ($pesanan->metode_pembayaran != null) {
            $kwitansi = KwitansiPemasok::create($request->only('terima_dari', 'jumlah_uang_digits', 'jumlah_uang_word', 'pemesanan_keluar_bulky_id', 'tempat', 'keterangan')+[
                'user_id' => auth()->user()->id,
                'kode' => $kode_kwi,
                'storage_keluar_pemasok_id' => $out->id,
                'pemasok_id' => $pesanan->pemasok_id,
                'tanggal' => now('Asia/Jakarta')
            ]);
        }

        $surat = SuratJalanPemasok::create($request->only('tempat', 'pemesanan_keluar_bulky_id')+[
            'pengirim' => auth()->user()->pemasok->nama,
            'penerima' => $pesanan->nama_pemesan,
            'kode' => $surat_kode,
            'user_id' => auth()->user()->id,
            'tanggal' => now('Asia/Jakarta')
        ]);

        $pdfKwitansi = 'none';

        if($pesanan->metode_pembayaran != null){
            $dataKwitansi = KwitansiPemasok::all();
            $counterKwitansi = $dataKwitansi->count();
            $pdfKodeKwi = sprintf("%'.04d", (String)$counterKwitansi);
            $pdfKwitansi = PDF::loadview('app.transaksi.kwitansi.print_pemasok', [
                'data' => $kwitansi,
                'date' => $date,
                'kode' => $pdfKodeKwi
            ]);
        }

        $dataSurat = SuratJalanPemasok::all();
        $counterSJ = $dataSurat->count();
        $pdfKodeSJ = sprintf("%'.04d", (String)$counterSJ);
        $pdfSJ = PDF::loadview('app.transaksi.surat-jalan.print_pemasok', [
            'data' => $surat,
            'date' => $date,
            'kode' => $pdfKodeSJ
        ]);
        
        // $pesanan->bulky->user->email
        Mail::to($pesanan->bulky->user->email)->send(new KwitansiDanSuratJalanMail($pdfSJ, $pdfKwitansi));

        $user_bulky = $pesanan->bulky->id;

        $firebaseToken = User::whereHas('pengurusGudangBulky.bulky', function($query)use($user_bulky){
                $query->where('bulky_id', $user_bulky);
            })
            ->whereNotNull('device_token')
            ->pluck('device_token')
            ->all();

        $judul = __( 'Barang yang dipesan sedang dikirim!' );

        $this->notif($judul, $firebaseToken);

        $bp = BarangKeluarPemesananBulky::where('pemesanan_id',$out->pemesananKeluarBulky->id)->get();
        $jumlah = 0;
        $total = 0;
        $satuan = [];
        foreach ($bp as $key => $value) {
            $jumlah += $value->jumlah_barang;
            $total += $value->harga;
            $satuan = $value->satuan;
        }

        $harga_total = $total / $jumlah;
        if ($pesanan->metode_pembayaran != null) {
            RekapitulasiPenjualanPemasok::create([
                'storage_keluar_id' => $out->id,
                'tanggal_penjualan' => $out->waktu,
                'no_penjualan' => $out->kode,
                'no_kwitansi' => $kwitansi->kode,
                'no_surat_jalan' => $surat->kode,
                'nama_pembeli' => $out->pemesananKeluarBulky->nama_pemesan,
                'barang' => $out->pemesananKeluarBulky->barangKeluarPemesananBulky[0]->nama_barang,
                'jumlah' => $jumlah,
                'satuan' => $satuan,
                'harga' => $harga_total,
                'total' => $total
            ]);
        } else {
            RekapitulasiPenjualanPemasok::create([
                'storage_keluar_id' => $out->id,
                'tanggal_penjualan' => $out->waktu,
                'no_penjualan' => $out->kode,
                // 'no_kwitansi' => $kwitansi->kode,
                'no_surat_jalan' => $surat->kode,
                'nama_pembeli' => $out->pemesananKeluarBulky->nama_pemesan,
                'barang' => $out->pemesananKeluarBulky->barangKeluarPemesananBulky[0]->nama_barang,
                'jumlah' => $jumlah,
                'satuan' => $satuan,
                'harga' => $harga_total,
                'total' => $total
            ]);
        }

        $pesanan->update(['status'=>'4']);
        if ($pesanan->metode_pembayaran == null) {
            return redirect('/v1/surat-piutang-bulky-pemasok/create?id='.$out->id);
        } else {
            return redirect(route('storage-keluar-pemasok.index'))->with('success', __( 'Penyimpanan Keluar Telah Berhasil !' ));
        }
    }

    public function notif($judul, $firebase)
    {
        $SERVER_API_KEY = 'AAAAK3EE3yQ:APA91bEbilWopL1DWWDejff_25XMW2tiFtLoMl__a48yB2kSP7uWDHBo89-WxZ8YdazpFrmR7NgPFXeLrS_MrmMBq4wyr6KiOwy0WQ6YaHBvQAXlYSQSmMBrMVBFAlOe9pUYCGH-pp6j';

        $data = [
            "registration_ids" => $firebase,
            "notification" => [
                "title" => __( 'Pengiriman' ),
                "body" => $judul,
            ]
        ];

        $dataString = json_encode($data);

        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);

        // dd($response);

        return true;
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
        //
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
        //
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
