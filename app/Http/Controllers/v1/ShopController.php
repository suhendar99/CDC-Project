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
use App\Models\Storage;
use App\Models\StockBarang;
use App\Models\StockBarangBulky;
use App\Models\PemesananPembeliItem;
use App\Models\PiutangBulky;
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
            if (Auth::user()->pelanggan_id != null) {
                if ($request->has('search') && $request->search !== '') {
                    $search = trim($request->search);
                    if($search == ''){
                        $barang = StockBarang::with('barang.storageIn.storage.tingkat.rak', 'gudang.user', 'barang.foto')->where('harga_barang','!=',null)
                        ->orderBy('id','desc')
                        ->whereHas('gudang', function($query){
                            $query->where('status', 1);
                        })->paginate(20);
                    }else{
                        $barang = StockBarang::with('barang.storageIn.storage.tingkat.rak', 'gudang.user', 'barang.foto')->where('harga_barang','!=',null)
                        ->orderBy('id','desc')
                        ->whereHas('barang',function($q) use ($search){
                            $q->where('nama_barang','LIKE',"%".$search."%")
                            ->orWhere('harga_barang','LIKE',"%".$search."%");
                        })
                        ->whereHas('gudang', function($query){
                            $query->where('status', 1);
                        })
                        ->paginate(20);
                    }
                } else {
                    $barang = StockBarang::with('barang.storageIn.storage.tingkat.rak', 'gudang.user', 'barang.foto')->where('harga_barang','!=',null)
                    ->orderBy('id','desc')
                    ->whereHas('gudang', function($query){
                        $query->where('status', 1);
                    })
                    ->paginate(20);

                    // dd(Auth::user());
                }
            } elseif (Auth::user()->pembeli_id != null) {
                if ($request->has('search') && $request->search !== '') {
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
                } else {
                    $barang = BarangWarung::where('harga_barang','!=',null)
                    ->orderBy('id','desc')
                    ->paginate(20);
                }
            } elseif (Auth::user()->pengurus_gudang_bulky_id != null) {
                if ($request->has('search') && $request->search !== '') {
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
                } else {
                    $barang = Barang::where('harga_barang','!=',null)
                    ->orderBy('id','desc')
                    ->paginate(20);
                }
            } else {
                if ($request->has('search') && $request->search !== '') {
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
                } else {
                    $barang = StockBarangBulky::with('barang.storageMasukBulky.storageBulky.tingkat.rak', 'bulky.user', 'barang.foto')->where('harga_barang','!=',null)
                    ->orderBy('id','desc')
                    ->paginate(20);
                }
            }
        }else{
            return redirect('/');
        }
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

        // dd($data);

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
            $kode = 'PEM/RTL/'.$tanggal.'/'.$tahunRomawi.'/'.$bulanRomawi.'/'.$kode_faker;

            $store = StockBarang::find($id);

            $harga = $store->harga_barang * $request->jumlah;

            $satuan = ($request->satuan == 'Kwintal') ? 'Kg' : $request->satuan;

            if ($request->pengiriman == 'ambil') {
                $pemesanan = Pemesanan::create(array_merge($request->only('pelanggan_id','gudang_id','penerima_po','telepon','alamat_pemesan','metode_pembayaran'),[
                    'kode' => $kode_faker,
                    'nomor_pemesanan' => $kode,
                    'nama_pemesan' => $request->nama_pemesan,
                    'tanggal_pemesanan' => now('Asia/Jakarta'),
                    'status' => '6'
                ]));
            } else {
                $pemesanan = Pemesanan::create(array_merge($request->only('pelanggan_id','gudang_id','penerima_po','telepon','alamat_pemesan','metode_pembayaran'),[
                    'kode' => $kode_faker,
                    'nomor_pemesanan' => $kode,
                    'nama_pemesan' => $request->nama_pemesan,
                    'tanggal_pemesanan' => now('Asia/Jakarta')
                ]));
            }
            // dd($request->barang);
            $kodes = 'BP'.rand(10000,99999);
            BarangPesanan::create([
                'kode' => $kodes,
                'barang_kode' => $request->barangKode,
                'pemesanan_id' => $pemesanan->id,
                'nama_barang' => $request->nama_barang,
                'satuan' => $satuan,
                'pajak' => $request->pajak,
                'biaya_admin' => $request->biaya_admin,
                'jumlah_barang' => $request->jumlah,
                'harga' => $request->harga
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

            $gudang = $request->gudang_id;

            $firebaseToken = User::whereHas('gudang', function($query)use($gudang){
                $query->where('id', $gudang);
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
                'barang_kode' => $request->barangKode,
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

            if ($request->pengiriman == 'ambil') {
                $pemesanan = PemesananBulky::create(array_merge($request->only('bulky_id','penerima_po','telepon','alamat_pemesan','metode_pembayaran'),[
                    'gudang_retail_id' => $request->gudang_id,
                    'kode' => $kode_faker,
                    'nomor_pemesanan' => $kode,
                    'nama_pemesan' => $request->nama_pemesan,
                    'tanggal_pemesanan' => now('Asia/Jakarta'),
                    'status' => '6'
                ]));
            } else {
                $pemesanan = PemesananBulky::create(array_merge($request->only('bulky_id','penerima_po','telepon','alamat_pemesan','metode_pembayaran'),[
                    'gudang_retail_id' => $request->gudang_id,
                    'kode' => $kode_faker,
                    'nomor_pemesanan' => $kode,
                    'nama_pemesan' => $request->nama_pemesan,
                    'tanggal_pemesanan' => now('Asia/Jakarta')
                ]));
            }

            $satuan = ($request->satuan == 'Ton') ? 'Kwintal' : $request->satuan;

            // dd($request->barang);
            $kodes = 'BP'.rand(10000,99999);
            BarangPemesananBulky::create([
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

            if ($request->pembayaran == 'later') {
                $BarangPesanan = BarangPemesananBulky::where('pemesanan_bulky_id',$pemesanan->id)->get();
                // dd($hutang);
                Piutang::create([
                    'barang_id' => $pemesanan->id,
                    'tanggal'=> Carbon::now(),
                    'nama_pembeli' => Auth::user()->pelanggan->nama,
                    'hutang' => $BarangPesanan->harga * $BarangPesanan->jumlah_barang,
                ]);

                if ($request->pembayaran == 'later') {
                    // $BarangPesanan = BarangPesanan::where('pemesanan_id',$pemesanan->id)->get();
                    // dd($hutang);
                    Piutang::create([
                        'barang_id' => $pemesanan->id,
                        'tanggal'=> Carbon::now(),
                        'nama_pembeli' => Auth::user()->pelanggan->nama,
                        'hutang' => $harga,
                    ]);
                }
            }

            $gudang = $request->bulky_id;

            $firebaseToken = User::whereHas('pengurusGudangBulky.bulky', function($query)use($gudang){
                $query->where('bulky_id', $gudang);
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
            $kode = 'PEM/BKY/'.$tanggal.'/'.$tahunRomawi.'/'.$bulanRomawi.'/'.$kode_faker;

            $store = Barang::find($id);

            // $harga = $store->harga_barang * $request->jumlah;

            if ($request->pengiriman == 'ambil') {
                $pemesanan = PemesananKeluarBulky::create(array_merge($request->only('bulky_id','pemasok_id','penerima_po','telepon','alamat_pemesan','metode_pembayaran'),[
                    'bulky_id' => $request->gudang_id,
                    'kode' => $kode_faker,
                    'barang_kode' => $request->barangKode,
                    'nomor_pemesanan' => $kode,
                    'nama_pemesan' => $request->nama_pemesan,
                    'tanggal_pemesanan' => now('Asia/Jakarta'),
                    'status' => '6'
                ]));
            } else {
                $pemesanan = PemesananKeluarBulky::create(array_merge($request->only('bulky_id','pemasok_id','penerima_po','telepon','alamat_pemesan','metode_pembayaran'),[
                    'bulky_id' => $request->gudang_id,
                    'kode' => $kode_faker,
                    'nomor_pemesanan' => $kode,
                    'nama_pemesan' => $request->nama_pemesan,
                    'tanggal_pemesanan' => now('Asia/Jakarta'),
                    'status' => 1
                ]));
            }

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

            $firebaseToken = User::where('pemasok_id', $request->pemasok_id)
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
