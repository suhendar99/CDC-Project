<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PemesananPembeli;
use App\Models\BarangWarung;
use App\Models\ReturMasukPelanggan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Mail\SendProofOfPaymentMail;
use App\Mail\ValidatePaymentMail;
use Illuminate\Support\Facades\Mail;
use App\Mail\PengembalianBarangMail;
use App\User;

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

        $newData['nomor_pemesanan'] = $data->nomor_pemesanan;
        $newData['pembeli'] = $data->pembeli->nama;
        $newData['penjual'] = $data->pelanggan->nama;
        $newData['waktu'] = now('Asia/Jakarta');

        $pembeli = User::where('pembeli_id', $data->pembeli->id)->first();

        $user_email = $pembeli->email;

        set_time_limit(99999999);
        Mail::to($user_email)->send(new ValidatePaymentMail($newData));
        // dd($data);
        // $retail = $data->retail->id;

        $firebaseToken = User::where('pembeli_id', $data->pembeli->id)
            ->whereNotNull('device_token')
            ->pluck('device_token')
            ->all();

        $judul = __( 'Penjual sudah memverifikasi pemesanan anda!' );
        $title = __( 'Verifikasi Pemesanan' );

        $this->notif($judul, $firebaseToken, $title);

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

        $pelanggan = $data->pelanggan_id;

        set_time_limit(99999999);
        Mail::to('filok5267@gmail.com')->send(new SendProofOfPaymentMail('\upload\foto\bukti\\'.$nama_bukti, $foto_bukti->getClientMimeType(), now('Asia/Jakarta'), $data));

        $firebaseToken = User::where('pelanggan_id', $pelanggan)
            ->whereNotNull('device_token')
            ->pluck('device_token')
            ->all();

        $judul = __( 'Pembeli melakukan pembayaran!' );
        $title = __( 'Pembayaran' );

        $this->notif($judul, $firebaseToken, $title);

        return back()->with('success','Bukti Pembayaran Berhasil Diupload!');
    }

    public function notif($judul, $firebase, $title)
    {
        $SERVER_API_KEY = 'AAAAK3EE3yQ:APA91bEbilWopL1DWWDejff_25XMW2tiFtLoMl__a48yB2kSP7uWDHBo89-WxZ8YdazpFrmR7NgPFXeLrS_MrmMBq4wyr6KiOwy0WQ6YaHBvQAXlYSQSmMBrMVBFAlOe9pUYCGH-pp6j';

        $data = [
            "registration_ids" => $firebase,
            "notification" => [
                "title" => $title,
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

        $retur = ReturMasukPelanggan::create($request->only('barang_warung_kode', 'pemesanan_pembeli_id', 'tanggal_pengembalian', 'keterangan'));

        $nama_barang = $retur->kode->nama_barang;

        $jumlah = $retur->pemesanan->pemesananPembeliItem[0]->jumlah_barang;
        $satuan = $retur->pemesanan->pemesananPembeliItem[0]->satuan;
        $penjual = $retur->pemesanan->pelanggan->nama;
        $pembeli = $retur->pemesanan->pembeli->nama;

        // (No kwitansi, nama barang, jumlah, satuan, penjual, pembeli, waktu, keterangan);
        set_time_limit(99999999);
        Mail::to($user_mail)->send(new PengembalianBarangMail(null, $nama_barang, $jumlah, $satuan, $penjual, $pembeli, $request->tanggal_pengembalian, $request->keterangan));

        $firebaseToken = User::where('id', auth()->user()->id)
            ->whereNotNull('device_token')
            ->pluck('device_token')
            ->all();

        $judul = __( 'Pembeli meminta melakukan pengembalian barang!' );
        $title = __( 'Pengembalian Barang' );

        $this->notif($judul, $firebaseToken, $title);

        // $log = LogTransaksi::create([
        //     'tanggal' => now(),
        //     'jam' => now(),
        //     'aktifitas_transaksi' => 'Retur Barang Keluar'
        // ]);

        return redirect('/v1/transaksi/pembeli/retur')->with('success', __( 'Retur Telah Dibuat !' ));
    }
}
