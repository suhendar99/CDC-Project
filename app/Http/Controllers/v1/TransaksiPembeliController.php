<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PemesananPembeli;
use App\Models\BarangWarung;
use App\Models\ReturMasukPelanggan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TransaksiPembeliController extends Controller
{
	public function __construct(PemesananPembeli $pemesanan)
	{
		$this->model = $pemesanan;
		$this->path = 'app.transaksi.pembeli.riwayat-transaksi.';
		$this->pathRetur = 'app.transaksi.pembeli.retur.';
	}

	public function index()
	{
		$data = $this->model::with('pemesananPembeliItem','pembeli.kabupaten','pelanggan.kabupaten')
        ->where('pembeli_id',Auth::user()->pembeli_id)
        ->orderBy('created_at','desc')
        ->paginate(6);
		return view($this->path.'index',compact('data'));
	}

    public function retur(Request $request)
    {
        $data = ReturMasukPelanggan::with('pemesanan','kode')
        ->whereHas('pemesanan',function($q){
            $q->where('pembeli_id',Auth::user()->pembeli_id);
        })
        ->orderBy('id','desc')
        ->paginate(4);
        return view($this->pathRetur.'index',compact('data'));
    }

	public function konfirmasi($id)
	{
		$data = $this->model::findOrFail($id);
		$data->update(['status'=>'5']);
		// dd($data);
		return back()->with('success','Penerimaan Pesanan Telah Dikonfirmasi!');
	}

    public function validasi($id)
    {
        $data = $this->model::findOrFail($id);
        $data->update(['status'=>'2']);
        // dd($data);
        return back()->with('success','Pembayaran Pesanan Telah Divalidasi!');
    }


    public function tolak($id)
    {
        $data = $this->model::with('pemesananPembeliItem','barangKeluar')->findOrFail($id);
        $data->update(['status'=>'0']);
        // dd($data);

        $kode = $data->pemesananPembeliItem[0]->barang;
        $jumlah = $data->pemesananPembeliItem[0]->jumlah_barang;
        // $d = BarangWarung::where('kode',$kode)->first();


        dd($jumlah, $kode);
        return back()->with('success','Pesanan Berhasil Ditolak!');
    }

    public function kirim($id)
    {
        return redirect('/v1/storage/out/create',['data'=>'data']);
    }

    public function bukti(Request $request, $id)
    {
        // dd($request->file('foto_bukti'));
        $data = $this->model::findOrFail($id);
        $foto_bukti = $request->file('foto_bukti');
        $nama_bukti = time()."_".$foto_bukti->getClientOriginalName();
        $foto_bukti->move("upload/foto/bukti", $nama_bukti);

        $data->update([
            'foto_bukti' => '/upload/foto/bukti/'.$nama_bukti
        ]);

        return back()->with('success','Bukti Pembayaran Berhasil Diupload!');
    }

    public function create()
    {
        $barang = $this->model::with('pelanggan','pembeli','pemesananPembeliItem','returMasukPelanggan','barangKeluar')
        ->where('pembeli_id',Auth::user()->pembeli_id)
        ->where('status','5')
        ->get();
        // dd($barang);
        return view($this->pathRetur.'create', compact('barang'));
    }

    public function store(Request $request)
    {
        $v = Validator::make($request->all(),[
            // 'barang_kode' => 'required|numeric|exists:barangs,kode_barang',
            'barang_warung_kode' => 'required|exists:barang_warungs,kode',
            'pemesanan_pembeli_id' => 'required|exists:pemesanans,id',
            'tanggal_pengembalian' => 'required|date',
            'keterangan' => 'required|string|max:65534'
        ]);

        if ($v->fails()) {
            dd($v->errors()->all());
            return back()->withErrors($v)->withInput();
        }

        ReturMasukPelanggan::create($request->only('barang_warung_kode', 'pemesanan_pembeli_id', 'tanggal_pengembalian', 'keterangan'));
        // $log = LogTransaksi::create([
        //     'tanggal' => now(),
        //     'jam' => now(),
        //     'aktifitas_transaksi' => 'Retur Barang Keluar'
        // ]);

        return redirect('/v1/transaksi/pembeli/retur')->with('success', __( 'Retur Telah Dibuat !' ));
    }
}
