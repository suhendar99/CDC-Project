<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Province;
use App\City;
use App\User;
use App\Models\Barang;
use App\Models\BarangKeluarPemesananBulky;
use Illuminate\Support\Facades\Mail;
use App\Models\BarangPesanan;
use App\Models\BarangPemesananBulky;
use App\Models\BarangWarung;
use App\Models\BatasPiutang;
use App\Models\Keranjang;
use App\Models\LogTransaksi;
use App\Models\Pemesanan;
use App\Models\PemesananBulky;
use App\Models\PemesananKeluarBulky;
use App\Models\PemesananPembeli;
use App\Models\PengaturanTransaksi;
use App\Models\Piutang;
use App\Models\Pelanggan;
use App\Models\Storage;
use App\Models\StockBarang;
use App\Models\StockBarangBulky;
use App\Models\PemesananPembeliItem;
use App\Models\PiutangBulky;
use App\Models\PiutangRetail;
use App\Models\GudangBulky;
use App\Models\Gudang;
use App\Mail\OrderingMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ShopController extends Controller
{
    public function __construct()
    {
        $this->category = new Kategori;
        $this->storage = new Storage;
        $this->province = new Province;
        $this->city = new City;
        $this->shopPath = 'app.shop.';
    }
    public function index(Request $request)
    {
        if (!Auth::guest()) {
            $search_kategori = $request->query('kategori', null);

            if (Auth::user()->pelanggan_id != null) {
                if ($request->has('search') && $request->search !== '' && $search_kategori != null) {
                    $search = trim($request->search);
                    if($search == ''){
                        $barang = StockBarang::with('gudang.user', 'stockBarangBulky')->where('harga_barang','!=',null)
                        ->orderBy('id','desc')
                        ->whereHas('stockBarangBulky.barang.kategori',function($q) use ($search_kategori){
                            $q->where('id', $search_kategori);
                        })
                        ->whereHas('gudang', function($query){
                            $query->where('status', 1);
                        })->paginate(20);
                    }else{
                        $barang = StockBarang::with('gudang.user', 'stockBarangBulky')->where('harga_barang','!=',null)
                        ->orderBy('id','desc')
                        ->whereHas('stockBarangBulky',function($q) use ($search){
                            $q->where('nama_barang','LIKE',"%".$search."%")
                            ->orWhere('harga_barang','LIKE',"%".$search."%");
                        })
                        ->whereHas('stockBarangBulky.barang.kategori',function($q) use ($search_kategori){
                            $q->where('id', $search_kategori);
                        })
                        ->whereHas('gudang', function($query){
                            $query->where('status', 1);
                        })
                        ->paginate(20);
                    }
                } elseif ($request->has('search') && $request->search !== '') {
                    $search = trim($request->search);
                    if($search == ''){
                        $barang = StockBarang::with('gudang.user', 'stockBarangBulky')->where('harga_barang','!=',null)
                        ->orderBy('id','desc')
                        ->whereHas('gudang', function($query){
                            $query->where('status', 1);
                        })->paginate(20);
                    }else{
                        $barang = StockBarang::with('gudang.user', 'stockBarangBulky')->where('harga_barang','!=',null)
                        ->orderBy('id','desc')
                        ->whereHas('stockBarangBulky',function($q) use ($search){
                            $q->where('nama_barang','LIKE',"%".$search."%")
                            ->orWhere('harga_barang','LIKE',"%".$search."%");
                        })
                        ->whereHas('gudang', function($query){
                            $query->where('status', 1);
                        })
                        ->paginate(20);
                    }
                } elseif($search_kategori != null) {
                    $barang = StockBarang::with('gudang.user', 'stockBarangBulky')->where('harga_barang','!=',null)
                        ->orderBy('id','desc')
                        ->whereHas('stockBarangBulky.barang.kategori',function($q) use ($search_kategori){
                            $q->where('id', $search_kategori);
                        })
                        ->whereHas('gudang', function($query){
                            $query->where('status', 1);
                        })
                        ->paginate(20);
                    // dd(Auth::user());
                }else{
                    $barang = StockBarang::with('gudang.user', 'stockBarangBulky')->where('harga_barang','!=',null)
                    ->orderBy('id','desc')
                    ->whereHas('gudang', function($query){
                        $query->where('status', 1);
                    })
                    ->paginate(20);
                }
            } elseif (Auth::user()->pembeli_id != null) {
                if ($request->has('search') && $request->search !== '' && $search_kategori != null) {
                    $search = trim($request->search);
                    if($search == ''){
                        $barang = BarangWarung::with('storageOut.barang', 'storageOut.barang.foto')
                        ->where('harga_barang','!=',null)
                        ->whereHas('storageOut.barang.kategori',function($q) use ($search_kategori){
                            $q->where('id', $search_kategori);
                        })
                        ->orderBy('id','desc')
                        ->paginate(20);
                    }else{
                        $barang = BarangWarung::with('storageOut.barang', 'storageOut.barang.foto')->where('harga_barang','!=',null)
                        ->orderBy('id','desc')
                        ->whereHas('storageOut.barang',function($q) use ($search){
                            $q->where('nama_barang','LIKE',"%".$search."%")
                            ->orWhere('harga_barang','LIKE',"%".$search."%");
                        })
                        ->whereHas('storageOut.barang.kategori',function($q) use ($search_kategori){
                            $q->where('id', $search_kategori);
                        })
                        ->paginate(20);
                    }
                } elseif ($request->has('search') && $request->search !== '') {
                    $search = trim($request->search);
                    if($search == ''){
                        $barang = BarangWarung::with('storageOut.barang', 'storageOut.barang.foto')->where('harga_barang','!=',null)
                        ->orderBy('id','desc')->paginate(20);
                    }else{
                        $barang = BarangWarung::with('storageOut.barang', 'storageOut.barang.foto')->where('harga_barang','!=',null)
                        ->orderBy('id','desc')
                        ->whereHas('storageOut.barang',function($q) use ($search){
                            $q->where('nama_barang','LIKE',"%".$search."%")
                            ->orWhere('harga_barang','LIKE',"%".$search."%");
                        })
                        ->paginate(20);
                    }
                } elseif ($search_kategori != null) {
                    $barang = BarangWarung::with('storageOut.barang', 'storageOut.barang.foto')->where('harga_barang','!=',null)
                        ->orderBy('id','desc')
                        ->whereHas('storageOut.barang.kategori',function($q) use ($search_kategori){
                            $q->where('id', $search_kategori);
                        })
                        ->paginate(20);
                    // dd(Auth::user());
                } else {
                    $barang = BarangWarung::where('harga_barang','!=',null)
                    ->orderBy('id','desc')
                    ->paginate(20);
                }
            } elseif (Auth::user()->pengurus_gudang_bulky_id != null) {
                if ($request->has('search') && $request->search !== '' && $search_kategori != null) {
                    $search = trim($request->search);
                    if($search == ''){
                        $barang = Barang::where('harga_barang','!=',null)
                        ->whereHas('kategori', function($query)use($search_kategori){
                            $query->where('id', $search_kategori);
                        })
                        ->orderBy('id','desc')->paginate(20);
                    }else{
                        $barang = Barang::where('harga_barang','!=',null)
                        ->orderBy('id','desc')
                        ->orWhere('nama_barang','LIKE',"%".$search."%")
                        ->orWhere('harga_barang','LIKE',"%".$search."%")
                        ->whereHas('kategori', function($query)use($search_kategori){
                            $query->where('id', $search_kategori);
                        })
                        ->paginate(20);
                    }
                } elseif ($request->has('search') && $request->search !== '') {
                    $search = trim($request->search);
                    if($search == ''){
                        $barang = Barang::where('harga_barang','!=',null)
                        ->orderBy('id','desc')->paginate(20);
                    }else{
                        $barang = Barang::where('harga_barang','!=',null)
                        ->orderBy('id','desc')
                        ->orWhere('nama_barang','LIKE',"%".$search."%")
                        ->orWhere('harga_barang','LIKE',"%".$search."%")
                        ->paginate(20);
                    }
                } elseif($search_kategori != null) {
                    $barang = Barang::where('harga_barang','!=',null)
                        ->orderBy('id','desc')
                        ->whereHas('kategori', function($query)use($search_kategori){
                            $query->where('id', $search_kategori);
                        })
                        ->paginate(20);
                    // dd(Auth::user());
                } else {
                    $barang = Barang::where('harga_barang','!=',null)
                    ->orderBy('id','desc')
                    ->paginate(20);
                }
            } else {
                if ($request->has('search') && $request->search !== '' && $search_kategori != null) {
                    $search = trim($request->search);
                    if($search == ''){
                        $barang = StockBarangBulky::with('barang.storageMasukBulky.storageBulky.tingkat.rak', 'bulky.user', 'barang.foto')->where('harga_barang','!=',null)
                        ->whereHas('barang.kategori', function($query)use($search_kategori){
                            $query->where('id', $search_kategori);
                        })
                        ->orderBy('id','desc')
                        ->paginate(20);
                    }else{
                        $barang = StockBarangBulky::with('barang.storageMasukBulky.storageBulky.tingkat.rak', 'bulky.user', 'barang.foto')->where('harga_barang','!=',null)
                        ->orderBy('id','desc')
                        ->where('nama_barang','LIKE',"%".$search."%")
                        ->orWhere('harga_barang','LIKE',"%".$search."%")
                        ->whereHas('barang.kategori', function($query)use($search_kategori){
                            $query->where('id', $search_kategori);
                        })
                        ->paginate(20);
                    }
                } elseif ($request->has('search') && $request->search !== '') {
                    $search = trim($request->search);
                    if($search == ''){
                        $barang = StockBarangBulky::with('barang.storageMasukBulky.storageBulky.tingkat.rak', 'bulky.user', 'barang.foto')->where('harga_barang','!=',null)
                        ->orderBy('id','desc')->paginate(20);
                    }else{
                        $barang = StockBarangBulky::with('barang.storageMasukBulky.storageBulky.tingkat.rak', 'bulky.user', 'barang.foto')->where('harga_barang','!=',null)
                        ->orderBy('id','desc')
                        ->where('nama_barang','LIKE',"%".$search."%")
                        ->orWhere('harga_barang','LIKE',"%".$search."%")
                        ->paginate(20);
                    }
                } elseif ($search_kategori != null) {
                    $barang = StockBarangBulky::with('barang.storageMasukBulky.storageBulky.tingkat.rak', 'bulky.user', 'barang.foto')->where('harga_barang','!=',null)
                        ->orderBy('id','desc')
                        ->whereHas('barang.kategori', function($query)use($search_kategori){
                            $query->where('id', $search_kategori);
                        })
                        ->paginate(20);
                    // dd(Auth::user());
                } else {
                    $barang = StockBarangBulky::with('barang.storageMasukBulky.storageBulky.tingkat.rak', 'bulky.user', 'barang.foto')->where('harga_barang','!=',null)
                    ->orderBy('id','desc')
                    ->paginate(20);
                }
            }
        }else{
            return redirect('/');
        }
        // dd($barang);
        $else = $request->search;
        //$barang = Barang::where('sarpras_id',$id)->get();
        // $data = SaranaPrasaranaUptd::find($id);
        if (Auth::user()) {
            $barangKeranjang = Keranjang::where('pelanggan_id',Auth::user()->pelanggan_id)->orderBy('created_at','desc')->get();

            $category = $this->category->getData();
            return view($this->shopPath.'index', compact('category','barang','else','barangKeranjang'));
        }else {
            $category = $this->category->getData();
            return view($this->shopPath.'index', compact('category','barang','else'));
        }
    }

    public function showPemesanan(Request $request, $id)
    {
        $biaya = PengaturanTransaksi::find(1);

        if (Auth::user()->pelanggan_id!= null) {
            $data = StockBarang::find($id);
            $user = 'pelanggan';
        } elseif (Auth::user()->pembeli_id!= null) {
            $data = BarangWarung::find($id);
            $user = 'pembeli';
        } elseif (Auth::user()->pengurus_gudang_bulky_id != null) {
            $user = 'bulky';
            if ($request->query('jumlah') != null) {
                $jumlah = $request->query('jumlah');
                $data = Barang::find($id);
                return view($this->shopPath.'pesanan',compact('id','data','biaya','jumlah','user'));
            } else {
                $data = Barang::find($id);
            }
        } elseif (Auth::user()->pengurus_gudang_id != null) {
            $data = StockBarangBulky::with('barang.storageMasukBulky.storageBulky.tingkat.rak', 'bulky.user', 'barang.foto')
            ->find($id);
            $user = 'retail';
        }
        // dd($data->stockBarangBulky);

        return view($this->shopPath.'pesanan',compact('id','data','biaya', 'user'));
    }

    public function pemesanan(Request $request, $id)
    {
        // dd($request->all());
        $v = Validator::make($request->all(),[
            'alamat_pemesan' => 'required',
            'pembayaran' => 'required',
            'telepon' => 'required',
            'metode_pembayaran' => 'required_with:pembayaran.now',
            'jumlah' => 'required|numeric|min:1',
            'harga' => 'required'
        ]);
        if ($request->pembayaran == 'now' && $request->metode_pembayaran == null) {
            return back()->with('error','Mohon Isi Metode Pembayaran!');
        }
        if ($v->fails()) {
            // return back()->withErrors($v)->withInput();
            // dd($v->errors()->all());
            return back()->with('error','Pastikan Formulir diisi dengan lengkap!');
        }
        // dd($request->all());
        date_default_timezone_set('Asia/Jakarta');

        $tanggal = date("Ymd");
        $tahun = date("y");
        $bulan = date("m");

        // Number To Romawi
        $map = array(
            'M' => 1000,
            'CM' => 900,
            'D' => 500,
            'CD' => 400,
            'C' => 100,
            'XC' => 90,
            'L' => 50,
            'XL' => 40,
            'X' => 10,
            'IX' => 9,
            'V' => 5,
            'IV' => 4,
            'I' => 1
        );
        $tahunRomawi = '';
        $bulanRomawi = '';

        while ($tahun > 0) {
            foreach ($map as $romawi => $int) {
                if ($tahun >= $int) {
                    $tahun -= $int;
                    $tahunRomawi .= $romawi;
                    break;
                }
            }
        }

        while ($bulan > 0) {
            foreach ($map as $roman => $num) {
                if ($bulan >= $num) {
                    $bulan -= $num;
                    $bulanRomawi .= $roman;
                    break;
                }
            }
        }

        if (Auth::user()->pelanggan_id != null) {
            $date = date('ymd');
            $latest = Pemesanan::orderBy('id','desc')->first();
            if ($latest == null) {
                $counter = 1;
            } else {
                $counter = $latest->id+1;
            }

            $faker = \Faker\Factory::create('id_ID');

            $kode_faker = $faker->unique()->regexify('[0-9]{9}');

            // $kode = 'PSN'.$date.sprintf("%'.02d", (String)$counter);
            $kode = 'PEM/WRG/'.$tanggal.'/'.$tahunRomawi.'/'.$bulanRomawi.'/'.$kode_faker;

            $store = StockBarang::find($id);

            $harga = $store->harga_barang * $request->jumlah;

            $satuan = ($request->satuan == 'Kuintal') ? 'Kg' : $request->satuan;

            if ($request->pembayaran == 'later') {
                if ($request->pengiriman == 'ambil') {
                    $pemesanan = Pemesanan::create(array_merge($request->only('pelanggan_id','gudang_id','penerima_po','telepon','alamat_pemesan'),[
                        'kode' => $kode_faker,
                        'nomor_pemesanan' => $kode,
                        'nama_pemesan' => $request->nama_pemesan,
                        'tanggal_pemesanan' => now('Asia/Jakarta'),
                        'status' => 6
                    ]));
                } else {
                    $pemesanan = Pemesanan::create(array_merge($request->only('pelanggan_id','gudang_id','penerima_po','telepon','alamat_pemesan'),[
                        'kode' => $kode_faker,
                        'nomor_pemesanan' => $kode,
                        'nama_pemesan' => $request->nama_pemesan,
                        'tanggal_pemesanan' => now('Asia/Jakarta'),
                        'status' => 2
                    ]));
                }
            } else {
                if ($request->pengiriman == 'ambil') {
                    $pemesanan = Pemesanan::create(array_merge($request->only('pelanggan_id','gudang_id','penerima_po','telepon','alamat_pemesan','metode_pembayaran'),[
                        'kode' => $kode_faker,
                        'nomor_pemesanan' => $kode,
                        'nama_pemesan' => $request->nama_pemesan,
                        'tanggal_pemesanan' => now('Asia/Jakarta'),
                        'status' => 6
                    ]));
                } else {
                    $pemesanan = Pemesanan::create(array_merge($request->only('pelanggan_id','gudang_id','penerima_po','telepon','alamat_pemesan','metode_pembayaran'),[
                        'kode' => $kode_faker,
                        'nomor_pemesanan' => $kode,
                        'nama_pemesan' => $request->nama_pemesan,
                        'tanggal_pemesanan' => now('Asia/Jakarta'),
                        'status' => 1
                    ]));
                }
            }

            // dd($request->barang);
            $kodes = 'BP'.rand(10000,99999);
            $out = BarangPesanan::create([
                'kode' => $kodes,
                'barang_retail_id' => $store->id,
                'pemesanan_id' => $pemesanan->id,
                'nama_barang' => $store->nama_barang,
                'satuan' => $satuan,
                'pajak' => $request->pajak,
                'biaya_admin' => $request->biaya_admin,
                'jumlah_barang' => $request->jumlah,
                'harga' => $request->harga
            ]);

            $day = BatasPiutang::find(1);
            $jatuhTempo = date('Y-m-d',strtotime('+'.$day->jumlah_hari.' day'));

            if ($request->pembayaran == 'later') {
                Piutang::create([
                    'pemesanan_id' => $pemesanan->id,
                    'tanggal'=> Carbon::now(),
                    'nama_pembeli' => Auth::user()->pelanggan->nama,
                    'hutang' => $out->harga,
                    'jatuh_tempo' => $jatuhTempo
                ]);
            }
            LogTransaksi::create([
                'user_id' => Auth::user()->id,
                'tanggal' => now('Asia/Jakarta'),
                'jam' => now('Asia/Jakarta'),
                'aktifitas_transaksi' => 'Pemesanan Keluar',
                'role' => 'Warung'
            ]);

            $retail_id = $request->gudang_id;

            $user_email = Gudang::find($store->gudang_id);

            // (kode_pemesanan, pemesan, barang_pesanan)
            Mail::to($user_email->user->email)->send(new OrderingMail($kode, $user_email, $out));

            $firebaseToken = User::whereHas('pengurusGudang.gudang', function($query)use($retail_id){
                $query->where('gudang_id', $retail_id);
            })
            ->whereNotNull('device_token')
            ->pluck('device_token')->all();

            $judul = __( 'Pesanan Baru!' );

            $this->notif($judul, $firebaseToken);

            return redirect('v1/pemesananKeluarWarung')->with('success','Pemesanan Ke Retail Berhasil!');

        } elseif (Auth::user()->pembeli_id != null) {
            $date = date('ymd');
            $latest = PemesananPembeli::orderBy('id','desc')->first();
            if ($latest == null) {
                $counter = 1;
            } else {
                $counter = $latest->id+1;
            }

            $faker = \Faker\Factory::create('id_ID');

            $kode_faker = $faker->unique()->regexify('[0-9]{9}');

            // $kode = 'PSN'.$date.sprintf("%'.02d", (String)$counter);
            $kode = 'PEM/'.$tanggal.'/'.$tahunRomawi.'/'.$bulanRomawi.'/'.$kode_faker;

            $store = BarangWarung::find($id);

            $harga = $request->harga * $request->jumlah;

            $penerima_po = $request->penerima_po;
            $nama_pemesan = Auth::user()->pembeli->nama;

            if ($request->pengiriman == 'ambil') {
                $pemesanan = PemesananPembeli::create(array_merge($request->only('pelanggan_id','pembeli_id','telepon','alamat_pemesan','metode_pembayaran'),[
                    'kode' => $kode_faker,
                    'nomor_pemesanan' => $kode,
                    'penerima_po' => $penerima_po,
                    'nama_pemesan' => $nama_pemesan,
                    'tanggal_pemesanan' => now('Asia/Jakarta'),
                    'status' => '6'
                ]));
            } else {
                $pemesanan = PemesananPembeli::create(array_merge($request->only('pelanggan_id','pembeli_id','telepon','alamat_pemesan','metode_pembayaran'),[
                    'kode' => $kode_faker,
                    'nomor_pemesanan' => $kode,
                    'penerima_po' => $penerima_po,
                    'nama_pemesan' => $nama_pemesan,
                    'tanggal_pemesanan' => now('Asia/Jakarta')
                ]));
            }


            // dd($request->barang);
            $kodes = 'BP'.rand(10000,99999);
            $barangPesanan = PemesananPembeliItem::create([
                'kode' => $kodes,
                // 'barang_kode' => $request->barangKode,
                'pemesanan_pembeli_id' => $pemesanan->id,
                'nama_barang' => $request->nama_barang,
                'barang_warung_kode' => $request->barang_warung_kode,
                'satuan' => $request->satuan,
                'jumlah_barang' => $request->jumlah,
                'pajak' => $request->pajak,
                'biaya_admin' => $request->biaya_admin,
                'harga' => $request->harga
            ]);

            $stok = $store->jumlah - $barangPesanan->jumlah_barang;

            $store->update([
                'jumlah' => $stok
            ]);

            if ($request->pembayaran == 'later') {
                // $BarangPesanan = BarangPesanan::where('pemesanan_id',$pemesanan->id)->get();
                // dd($hutang);
                Piutang::create([
                    'barang_id' => $pemesanan->id,
                    'tanggal'=> Carbon::now(),
                    'nama_pembeli' => Auth::user()->pelanggan->nama,
                    'hutang' => $request->harga,
                ]);
            }

            $user_email = Pelanggan::find($request->pelanggan_id);

            // (kode_pemesanan, pemesan, barang_pesanan)
            Mail::to($user_email->email)->send(new OrderingMail($kode, $user_email, $barangPesanan));

            $firebaseToken = User::where('pelanggan_id', $request->pelanggan_id)
            ->whereNotNull('device_token')
            ->pluck('device_token')
            ->all();

            $judul = __( 'Pesanan Baru!' );

            $this->notif($judul, $firebaseToken);

            return redirect('v1/transaksi/pembeli/riwayat')->with('sukses','Pesanan Telah dibuat !');

        } elseif (Auth::user()->pengurus_gudang_id != null){
            $date = date('ymd');
            $latest = PemesananBulky::orderBy('id','desc')->first();

            if ($latest == null) {
                $counter = 1;
            } else {
                $counter = $latest->id+1;
            }

            $faker = \Faker\Factory::create('id_ID');

            $kode_faker = $faker->unique()->regexify('[0-9]{9}');

            // $kode = 'PSN'.$date.sprintf("%'.02d", (String)$counter);
            $kode = 'PEM/BKY/'.$tanggal.'/'.$tahunRomawi.'/'.$bulanRomawi.'/'.$kode_faker;

            $store = StockBarangBulky::find($id);

            $harga = $store->harga_barang * $request->jumlah;

            if ($request->pembayaran == 'later') {
                if ($request->pengiriman == 'ambil') {
                    $pemesanan = PemesananBulky::create(array_merge($request->only('bulky_id','penerima_po','telepon','alamat_pemesan'),[
                        'gudang_retail_id' => $request->gudang_id,
                        'kode' => $kode_faker,
                        'nomor_pemesanan' => $kode,
                        'nama_pemesan' => $request->nama_pemesan,
                        'tanggal_pemesanan' => now('Asia/Jakarta'),
                        'status' => 6
                    ]));
                } else {
                    $pemesanan = PemesananBulky::create(array_merge($request->only('bulky_id','penerima_po','telepon','alamat_pemesan'),[
                        'gudang_retail_id' => $request->gudang_id,
                        'kode' => $kode_faker,
                        'nomor_pemesanan' => $kode,
                        'nama_pemesan' => $request->nama_pemesan,
                        'tanggal_pemesanan' => now('Asia/Jakarta'),
                        'status' => 2
                    ]));
                }
            } else {
                if ($request->pengiriman == 'ambil') {
                    $pemesanan = PemesananBulky::create(array_merge($request->only('bulky_id','penerima_po','telepon','alamat_pemesan','metode_pembayaran'),[
                        'gudang_retail_id' => $request->gudang_id,
                        'kode' => $kode_faker,
                        'nomor_pemesanan' => $kode,
                        'nama_pemesan' => $request->nama_pemesan,
                        'tanggal_pemesanan' => now('Asia/Jakarta'),
                        'status' => 6
                    ]));
                } else {
                    $pemesanan = PemesananBulky::create(array_merge($request->only('bulky_id','penerima_po','telepon','alamat_pemesan','metode_pembayaran'),[
                        'gudang_retail_id' => $request->gudang_id,
                        'kode' => $kode_faker,
                        'nomor_pemesanan' => $kode,
                        'nama_pemesan' => $request->nama_pemesan,
                        'tanggal_pemesanan' => now('Asia/Jakarta'),
                        'status' => 1
                    ]));
                }
            }

            LogTransaksi::create([
                'user_id' => Auth::user()->id,
                'tanggal' => now('Asia/Jakarta'),
                'jam' => now('Asia/Jakarta'),
                'aktifitas_transaksi' => 'Pemesanan Keluar',
                'role' => 'Retail'
            ]);
            $satuan = ($request->satuan == 'Ton') ? 'Kuintal' : $request->satuan;

            // dd($request->barang);
            $kodes = 'BP'.rand(10000,99999);
            $out = BarangPemesananBulky::create([
                'kode' => $kodes,
                'barang_bulky_id' => $store->id,
                'pemesanan_bulky_id' => $pemesanan->id,
                'nama_barang' => $request->nama_barang,
                'satuan' => $satuan,
                'pajak' => 0,
                'biaya_admin' => $request->biaya_admin,
                'jumlah_barang' => $request->jumlah,
                'harga' => $harga
            ]);

            $day = BatasPiutang::find(1);
            $jatuhTempo = date('Y-m-d',strtotime('+'.$day->jumlah_hari.' day'));

            if ($request->pembayaran == 'later') {
                PiutangRetail::create([
                    'pemesanan_keluar_id' => $pemesanan->id,
                    'tanggal'=> Carbon::now(),
                    'nama_pembeli' => Auth::user()->pengurusGudang->nama,
                    'hutang' => $out->harga,
                    'jatuh_tempo' => $jatuhTempo
                ]);
            }

            $gudang_bulky_id = $request->bulky_id;

            $user_email = $store->bulky->user;

            $gudang = Gudang::find($request->gudang_id);

            // (kode_pemesanan, pemesan, barang_pesanan)
            Mail::to($user_email->email)->send(new OrderingMail($kode, $gudang, $out));

            $firebaseToken = User::whereHas('pengurusGudangBulky.bulky', function($query)use($gudang_bulky_id){
                $query->where('bulky_id', $gudang_bulky_id);
            })
            ->whereNotNull('device_token')
            ->pluck('device_token')->all();

            $judul = __( 'Pesanan Baru!' );

            $this->notif($judul, $firebaseToken);

            return redirect('/v1/po')->with('sukses','Pesanan Telah dibuat !');
        } elseif (Auth::user()->pengurus_gudang_bulky_id != null){
            $date = date('ymd');
            $latest = PemesananKeluarBulky::orderBy('id','desc')->first();

            if ($latest == null) {
                $counter = 1;
            } else {
                $counter = $latest->id+1;
            }

            $faker = \Faker\Factory::create('id_ID');

            $kode_faker = $faker->unique()->regexify('[0-9]{9}');

            // $kode = 'PSN'.$date.sprintf("%'.02d", (String)$counter);
            $kode = 'PEM/PMS/'.$tanggal.'/'.$tahunRomawi.'/'.$bulanRomawi.'/'.$kode_faker;

            $store = Barang::find($id);

            // $harga = $store->harga_barang * $request->jumlah;

            if ($request->pembayaran == 'later') {
                // dd(PemesananKeluarBulky::all());
                if ($request->pengiriman == 'ambil') {
                    $pemesanan = PemesananKeluarBulky::create(array_merge($request->only('pemasok_id','penerima_po','telepon','alamat_pemesan'),[
                        'bulky_id' => $request->gudang_id,
                        'kode' => $kode_faker,
                        // 'barang_kode' => $request->barangKode,
                        'nomor_pemesanan' => $kode,
                        'nama_pemesan' => $request->nama_pemesan,
                        'tanggal_pemesanan' => now('Asia/Jakarta'),
                        'status' => '6'
                    ]));
                } else {
                    $pemesanan = PemesananKeluarBulky::create(array_merge($request->only('pemasok_id','penerima_po','telepon','alamat_pemesan'),[
                        'bulky_id' => $request->gudang_id,
                        'kode' => $kode_faker,
                        'nomor_pemesanan' => $kode,
                        'nama_pemesan' => $request->nama_pemesan,
                        'tanggal_pemesanan' => now('Asia/Jakarta'),
                        'status' => 2
                    ]));
                }
            } else {
                if ($request->pengiriman == 'ambil') {
                    $pemesanan = PemesananKeluarBulky::create(array_merge($request->only('pemasok_id','penerima_po','telepon','alamat_pemesan','metode_pembayaran'),[
                        'bulky_id' => $request->gudang_id,
                        'kode' => $kode_faker,
                        // 'barang_kode' => $request->barangKode,
                        'nomor_pemesanan' => $kode,
                        'nama_pemesan' => $request->nama_pemesan,
                        'tanggal_pemesanan' => now('Asia/Jakarta'),
                        'status' => '6'
                    ]));
                } else {
                    $pemesanan = PemesananKeluarBulky::create(array_merge($request->only('pemasok_id','penerima_po','telepon','alamat_pemesan','metode_pembayaran'),[
                        'bulky_id' => $request->gudang_id,
                        'kode' => $kode_faker,
                        'nomor_pemesanan' => $kode,
                        'nama_pemesan' => $request->nama_pemesan,
                        'tanggal_pemesanan' => now('Asia/Jakarta'),
                        'status' => 1
                    ]));
                }
            }

            LogTransaksi::create([
                'user_id' => Auth::user()->id,
                'tanggal' => now('Asia/Jakarta'),
                'jam' => now('Asia/Jakarta'),
                'aktifitas_transaksi' => 'Pemesanan Keluar',
                'role' => 'Bulky'
            ]);

            $satuan = ($request->satuan == 'Ton') ? 'Ton' : $request->satuan;

            // dd($request->barang);
            $kodes = 'BP'.rand(10000,99999);
            $out = BarangKeluarPemesananBulky::create([
                'kode' => $kodes,
                'barang_kode' => $request->barangKode,
                'pemesanan_id' => $pemesanan->id,
                'nama_barang' => $request->nama_barang,
                'satuan' => $satuan,
                'pajak' => 0,
                'biaya_admin' => $request->biaya_admin,
                'jumlah_barang' => $request->jumlah,
                'harga' => $request->harga
            ]);

            $day = BatasPiutang::find(1);
            $jatuhTempo = date('Y-m-d',strtotime('+'.$day->jumlah_hari.' day'));

            if ($request->pembayaran == 'later') {
                PiutangBulky::create([
                    'pemesanan_keluar_id' => $pemesanan->id,
                    'tanggal'=> Carbon::now(),
                    'nama_pembeli' => Auth::user()->pengurusGudangBulky->nama,
                    'hutang' => $out->harga,
                    'jatuh_tempo' => $jatuhTempo
                ]);
            }

            $user_email = User::where('pemasok_id', $store->pemasok->id)->first();

            $gudang = GudangBulky::find($request->gudang_id);

            // (kode_pemesanan, data_pemesan, barang_pesanan)
            Mail::to($user_email->email)->send(new OrderingMail($kode, $gudang, $out));

            $firebaseToken = User::where('pemasok_id', $store->pemasok->id)
            ->whereNotNull('device_token')
            ->pluck('device_token')
            ->all();

            $judul = __( 'Pesanan Baru!' );

            $this->notif($judul, $firebaseToken);

            return redirect('/v1/bulky/pemesanan/keluar')->with('sukses','Pesanan Telah dibuat !');
        }
    }

    public function notif($judul, $firebase)
    {
        $SERVER_API_KEY = 'AAAAK3EE3yQ:APA91bEbilWopL1DWWDejff_25XMW2tiFtLoMl__a48yB2kSP7uWDHBo89-WxZ8YdazpFrmR7NgPFXeLrS_MrmMBq4wyr6KiOwy0WQ6YaHBvQAXlYSQSmMBrMVBFAlOe9pUYCGH-pp6j';

        $data = [
            "registration_ids" => $firebase,
            "notification" => [
                "title" => __( 'Pemesanan' ),
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

    public function cariKategori($id)
    {
        return $id;
    }
    public function detail($id)
    {
        $data = $this->barang->find($id);
        $provinces = $this->province->pluck('name','province_id');
        // dd($barang);
        return view($this->shopPath.'detail', compact('data','provinces'));
    }

    public function getCities($id)
    {
        $city = $this->city->where('province_id', $id)->pluck('name', 'city_id');
        return response()->json($city);
    }
}
