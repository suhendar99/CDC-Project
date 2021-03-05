<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Models\LogTransaksiAdmin;
use App\Mail\ValidatePaymentMail;
use Illuminate\Support\Facades\Mail;

class PemesananKeluarPembeliController extends Controller
{
    public function __construct(Pemesanan $pemesanan)
    {
        $this->model = $pemesanan;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->model::with('storageOut.user.pengurusGudang.kabupaten','pelanggan.kabupaten','barangPesanan')->where('pelanggan_id',Auth::user()->pelanggan_id)->orderBy('id','desc')->paginate(4);
        // dd($data);
        return view('app.transaksi.pemesanan-keluar-warung.index',compact('data'));
    }

    public function konfirmasi($id)
    {
        $data = $this->model::findOrFail($id);
        // dd($data);
        $data->update(['status'=>'5']);
        return back()->with('success','Penerimaan Pesanan Telah Dikonfirmasi!');
        // return redirect('/v1/barangMasukPelanggan/create?id='.$data->id)->with('success','Penerimaan Pesanan Telah Dikonfirmasi!');
    }

    public function validasi($id)
    {
        $data = $this->model::findOrFail($id);
        $data->update(['status'=>'2']);

        LogTransaksiAdmin::create([
            'time' => now('Asia/Jakarta'),
            'transaksi' => "Pemesanan Warung ke Retail",
            'penjual' => $data->gudang->nama,
            'pembeli' => $data->pelanggan->nama,
            'barang' => $data->barangPesanan[0]->nama_barang,
            'jumlah' => $data->barangPesanan[0]->jumlah_barang,
            'satuan' => $data->barangPesanan[0]->satuan,
            'harga' => $data->barangPesanan[0]->harga
        ]);

        $user_email = User::where('pelanggan_id', $data->pelanggan->id)->first();

        $newData['nomor_pemesanan'] = $data->nomor_pemesanan;
        $newData['pembeli'] = $data->gudang->nama;
        $newData['penjual'] = $data->pelanggan->nama;
        $newData['waktu'] = now('Asia/Jakarta');

        set_time_limit(99999999);
        Mail::to($user_email->email)->send(new ValidatePaymentMail($newData));

        // $retail = $data->retail->id;

        $firebaseToken = User::where('pelanggan_id', $data->pelanggan->id)
            ->whereNotNull('device_token')
            ->pluck('device_token')
            ->all();

        $judul = __( 'Penjual sudah memverifikasi pemesanan anda!' );
        $title = __( 'Verifikasi Pemesanan' );

        $this->notif($judul, $firebaseToken, $title);

        return back()->with('success','Pembayaran Pesanan Telah Divalidasi!');
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
