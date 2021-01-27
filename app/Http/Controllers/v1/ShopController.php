<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Province;
use App\City;
use App\Models\Barang;
use App\Models\BarangPesanan;
use App\Models\Pemesanan;
use App\Models\Piutang;
use App\Models\Storage;
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
        if ($request->has('search') && $request->search !== '') {
            $search = trim($request->search);
            if($search == ''){
                $barang = $this->storage->with('storageIn.barang.foto')->orderBy('id','desc')->paginate(20);
            }else{
           $barang = $this->storage->with('storageIn.barang.foto')->orderBy('id','desc')
                ->whereHas('storageIn.barang',function($q) use ($search){
                    $q->where('nama_barang','LIKE',"%".$search."%")
                    ->orWhere('harga_barang','LIKE',"%".$search."%");
                })
                ->paginate(20);
            }
        } else {
            $barang = $this->storage->with('storageIn.barang.foto')->orderBy('id','desc')->paginate(20);

            // dd($barang->storageIn->barang);
        }
        $else = $request->search;
        //$barang = Barang::where('sarpras_id',$id)->get();
        // $data = SaranaPrasaranaUptd::find($id);
		$category = $this->category->getData();
		return view($this->shopPath.'index', compact('category','barang','else'));
	}

    public function showPemesanan($id)
    {
        $data = Storage::find($id);

        return view($this->shopPath.'pesanan',compact('id','data'));
    }
    public function pemesanan(Request $request, $id)
    {
        $v = Validator::make($request->all(),[
            'penerima_po' => 'required|string|max:50',
            'nama_pemesan' => 'nullable|string|max:50',
            'telepon' => 'required|numeric',
            'email_penerima' => 'nullable|email',
            'alamat_pemesan' => 'required',
            'pembayaran' => 'required',
            'metode_pembayaran' => 'nullable',

            'nama_barang.*' => 'required|string|max:100',
            'satuan.*' => 'required|string|max:10',
            'jumlah.*' => 'required|numeric|min:1',
            'harga.*' => 'required|numeric',
            'diskon.*' => 'nullable|numeric',
            'pajak.*' => 'nullable|numeric',
        ]);
        if ($v->fails()) {
            dd($v->errors()->all());
            // return back()->withErrors($v)->withInput();
            return back()->with('error','Pastikan Formulir diisi dengan lengkap!');
        }
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
        $kode = 'PEM/'.$tanggal.'/'.$tahunRomawi.'/'.$bulanRomawi.'/'.$kode_faker;

        $pemesanan = Pemesanan::create(array_merge($request->only('pelanggan_id','pengurus_gudang_id','penerima_po','telepon','alamat_pemesan','metode_pembayaran'),[
            'kode' => $kode_faker,
            'nomor_pemesanan' => $kode,
            'nama_pemesan' => $request->nama_pemesan,
            'tanggal_pemesanan' => now('Asia/Jakarta')
        ]));
        // dd($request->barang);
        $kodes = 'BP'.rand(10000,99999);
        BarangPesanan::create([
            'kode' => $kodes,
            'barang_kode' => $request->barangKode,
            'pemesanan_id' => $pemesanan->id,
            'nama_barang' => $request->nama_barang,
            'satuan' => $request->satuan,
            'jumlah_barang' => $request->jumlah,
            'harga' => $request->harga,
        ]);
        if ($request->pembayaran == 'later') {
            $BarangPesanan = BarangPesanan::where('pemesanan_id',$pemesanan->id)->get();
            // dd($hutang);
            Piutang::create([
                'barang_id' => $pemesanan->id,
                'tanggal'=> Carbon::now(),
                'nama_pembeli' => Auth::user()->pelanggan->nama,
                'hutang' => $BarangPesanan->harga * $BarangPesanan->jumlah_barang,
            ]);
        }
        return back()->with('success','Pesanan Telah dibuat !');
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
