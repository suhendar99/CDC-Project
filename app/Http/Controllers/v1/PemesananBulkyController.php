<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PemesananBulky;
use App\Models\BarangPemesananBulky;
use App\Models\LogTransaksi;
use App\User;
use App\Models\PemesananKeluarBulky;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\File;
use App\Mail\SendProofOfPaymentMail;
use App\Mail\ValidatePaymentMail;
use Illuminate\Support\Facades\Mail;

class PemesananBulkyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = BarangPemesananBulky::with('pemesananBulky.storageKeluarBulky', 'pemesananBulky.bulky.user', 'stockBarangBulky')
        ->whereHas('pemesananBulky.bulky.user',function($q){
            $q->where('pengurus_gudang_bulky_id',Auth::user()->pengurus_gudang_bulky_id);
        })
        ->orderBy('id', 'desc')
        ->get();
        if($request->ajax()){
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    // return '<a class="btn btn-info btn-sm" data-toggle="modal" data-target="#exampleModal" onclick="detail('.$data->id.')" data-id="'.$data->id.'" style="cursor: pointer;" title="Detail">Detail</a> <a href="#" class="btn btn-danger btn-sm" onclick="sweet('.$data->id.')">Hapus</a>';
                    return '&nbsp;<a href="#" class="btn btn-outline-danger btn-sm" onclick="sweet('.$data->pemesananBulky->id.')" ><i class="fa fa-trash"></i> Hapus</a>';
                })
                ->addColumn('total_pembayaran', function($data){
                    return '&nbsp;Rp. '.Number_format($data->harga,0,',','.');
                })
                ->addColumn('status_pembayaran', function($data){
                    if ($data->pemesananBulky->metode_pembayaran == null && $data->pemesananBulky->foto_bukti == null) {
                        return "<span class='text-danger'>Hutang</span>";
                    } elseif ($data->pemesananBulky->metode_pembayaran != null && $data->pemesananBulky->foto_bukti == null ) {
                        return "<span class='text-danger'>Belum Ada Bukti Pembayaran</span>";
                    } elseif ($data->pemesananBulky->foto_bukti != null && $data->pemesananBulky->status == '2') {
                        if ($data->pemesananBulky->metode_pembayaran == null) {
                            return "<span class='text-success'>Hutang</span>";
                        } else {
                            return "<span class='text-success'>Lunas</span>";
                        }
                    } else {
                        return "Belum Diterima";
                    }
                })
                ->addColumn('metode_pembayaran', function($data){
                    if ($data->pemesananBulky->metode_pembayaran == null) {
                        return '-';
                    } else {
                        $uc = ucwords($data->pemesananBulky->metode_pembayaran);
                        return $uc;
                    }
                })
                ->addColumn('bukti_pembayaran', function($data){
                    if($data->pemesananBulky->foto_bukti != null && $data->pemesananBulky->metode_pembayaran != null){
                        return '&nbsp;<a class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalBukti" onclick="bukti('.$data->pemesananBulky->id.')" data-id="'.$data->pemesananBulky->id.'" style="cursor: pointer;" title="Lihat Bukti Pembayaran">Lihat Bukti Pembayaran</a>';
                    } elseif($data->pemesananBulky->foto_bukti == null && $data->pemesananBulky->metode_pembayaran == null) {
                        return '-';
                    } elseif($data->pemesananBulky->foto_bukti == null && $data->pemesananBulky->metode_pembayaran != null) {
                        return '&nbsp; <span class="text-danger">Bukti Pembayaran Belum Diupload</span>';
                    }
                })
                ->addColumn('status_pemesanan',function($data){
                    if($data->pemesananBulky->status == 0){
                        return '&nbsp;<span class="text-danger">Pesanan Ditolak</span>';
                    } elseif ($data->pemesananBulky->status == 1){
                        return '&nbsp;<span class="text-danger">Pemesanan Belum Terverifikasi</span>';
                    }elseif ($data->pemesananBulky->status == 2 && $data->pemesananBulky->metode_pembayaran != null) {
                        return '&nbsp;Pembayaran Terverifikasi';
                    }elseif ($data->pemesananBulky->status == 2 && $data->pemesananBulky->metode_pembayaran == null) {
                        return '&nbsp;Pembayaran Hutang';
                    } elseif ($data->pemesananBulky->status == 4) {
                        return '&nbsp;Pesanan Sedang Dikirim';
                    } elseif ($data->pemesananBulky->status == 5) {
                        return '&nbsp;Pesanan Sudah Diterima';
                    } elseif ($data->pemesananBulky->status == 6) {
                        return '&nbsp;Pesanan Diambil';
                    }
                })
                ->addColumn('aksi_pemesanan',function($data){
                    if ($data->pemesananBulky->status == 1 && $data->pemesananBulky->foto_bukti != null) {
                        return '&nbsp;<a href="/v1/validasi/bukti/retail/'.$data->pemesananBulky->id.'" class="btn btn-outline-primary btn-sm">Verifikasi</a> <a href="/v1/tolak/pesanan/retail/'.$data->pemesananBulky->id.'" class="btn btn-outline-danger btn-sm" >Tolak Pesanan</a>';
                    } elseif ($data->pemesananBulky->status == 1){
                        return '&nbsp;<a href="/v1/tolak/pesanan/retail/'.$data->pemesananBulky->id.'" class="btn btn-outline-danger btn-sm" >Tolak Pesanan</a>';
                    } elseif ($data->pemesananBulky->status == 2) {
                        return '&nbsp;<a href="/v1/bulky/storage/keluar/create?pemesanan='.$data->pemesananBulky->id.'" class="btn btn-outline-success btn-sm">Kirim</a>';
                    } else {
                        return '&nbsp;-&nbsp;';
                    }
                })
                ->editColumn('created_at',function($data){
                    return date('d-m-Y H:i:s', strtotime($data->created_at));
                })
                ->rawColumns(['action','total_pembayaran','aksi_pemesanan','bukti_pembayaran','status_pembayaran','status_pemesanan'])
                ->make(true);
        }

        return view('app.data-master.pemesananBulky.index');
    }

    public function bukti(Request $request, $id)
    {
        // dd($request->file('foto_bukti'));
        $data = PemesananKeluarBulky::findOrFail($id);
        $foto_bukti = $request->file('foto_bukti');
        $nama_bukti = time()."_".$foto_bukti->getClientOriginalName();
        $foto_bukti->move("upload/foto/bukti-bulky", $nama_bukti);

        $data->update([
            'foto_bukti' => '/upload/foto/bukti-bulky/'.$nama_bukti
        ]);

        $pemasok = $data->pemasok_id;

        $user_email = User::where('pemasok_id', $pemasok)->first();

        set_time_limit(99999999);
        Mail::to($user_email->email)->send(new SendProofOfPaymentMail('\upload\foto\bukti-bulky\\'.$nama_bukti, $foto_bukti->getClientMimeType(), now('Asia/Jakarta'), $data));

        $firebaseToken = User::where('pemasok_id', $pemasok)
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

    public function getPemesananRetail($id)
    {

        $data = BarangPemesananBulky::with('pemesananBulky.storageKeluarBulky')->where('id',$id)->first();
        // $data = PemesananPembeliItem::with('pemesananPembeli.barangKeluar')->where('id',$id)->get();
        return response()->json([
            'data' => $data
        ]);
    }

    public function validasi($id)
    {
        $data = PemesananBulky::findOrFail($id);
        $data->update(['status'=>'2']);
        LogTransaksi::create([
            'user_id' => Auth::user()->id,
            'tanggal' => now('Asia/Jakarta'),
            'jam' => now('Asia/Jakarta'),
            'aktifitas_transaksi' => 'Penerimaan Pesanan',
            'role' => 'Warung'
        ]);

        $newData['nomor_pemesanan'] = $data->nomor_pemesanan;
        $newData['pembeli'] = $data->retail->nama;
        $newData['penjual'] = $data->bulky->nama;
        $newData['waktu'] = now('Asia/Jakarta');

        $user_email = $data->retail->user->email;

        set_time_limit(99999999);
        Mail::to($user_email)->send(new ValidatePaymentMail($newData));

        $retail = $data->retail->id;

        $firebaseToken = User::whereHas('pengurusGudang.gudang', function($query)use($retail){
                $query->where('gudang_id', $retail);
            })
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
        $data = PemesananBulky::findOrFail($id);
        $data->update(['status'=>'0']);

        return back()->with('success','Pesanan Berhasil Ditolak!');
    }

    public function detail($id)
    {
        $data = PemesananBulky::with('barangPesananBulky.barang', 'storageKeluarBulky', 'bulky', 'retail')
            ->find($id);

        return response()->json([
            'data' => $data
        ], 200);
    }

    function getPesanan($id){
        $data = PemesananBulky::with('barangPesananBulky')->find($id);
        $barang = BarangPemesananBulky::where('pemesanan_bulky_id',$data->id)->get();
        $harga = $barang->sum('harga');
        return response()->JSON([
            'data' => $data,
            'barang' => $barang,
            'harga' => $harga,
        ]);
    }

    public function validateBukti(Request $request, $id)
    {
        $v = Validator::make($request->all(),[
            'foto_bukti' => 'required|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput()->with('failed', __( 'Masukan format file foto yang benar dan harus berukuran tidak lebih dari 2mb.' ));
        }

        $name = $request->file('foto_bukti');
        $foto = time()."_".$name->getClientOriginalName();
        $name->move("upload/foto/bukti-pembayaran", $foto);

        PemesananBulky::findOrFail($id)->update([
            'foto_bukti' => '/upload/foto/bukti-pembayaran/'.$foto,
            'status' => '1'
        ]);

        return back()->with('success', __( 'Bukti telah dimasukan.' ));
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
        $data = PemesananBulky::findOrFail($id);
        $data->delete();

        return back()->with('success','Hapus Data Pemesanan Berhasil!');
    }
}
