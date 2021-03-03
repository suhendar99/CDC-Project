<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Models\PemesananKeluarBulky;
use App\Models\KwitansiBulky;
use App\Models\Barang;
use App\Models\LogTransaksi;
use App\Models\ReturKeluarBulky;
use App\Models\StorageMasukBulky;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\PengembalianBarangMail;
Use App\Models\PengurusGudangBulky;
use App\User;

class ReturKeluarBulkyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = ReturKeluarBulky::with('barang','pengurusGudang','storageMasuk')
            ->where('pengurus_gudang_id',Auth::user()->pengurus_gudang_bulky_id)
            ->orderBy('id', 'desc')
            ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    return '<a href="#" class="btn btn-danger btn-sm" onclick="sweet('.$data->id.')">Hapus</a>';
                })
                ->addColumn('status',function($data){
                    if ($data->status == null) {
                        return "<span class='text-primary'>Retur sedang diproses</span>";
                    } elseif ($data->status == 1) {
                        return "<span class='text-success'>Retur sudah di setujui</span>";
                    } elseif ($data->status == 2) {
                        return "<span class='text-danger'>Retur ditolak</span>";
                    }
                })
                ->editColumn('created_at',function($data){
                    return date('d-m-Y H:i:s', strtotime($data->created_at));
                })
                ->rawColumns(['action','status'])
                ->make(true);
        }

        return view('app.transaksi.retur-keluar-bulky.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $arr = [];
        // dd(auth()->user()->pengurusGudangBulky->bulky);
        foreach (auth()->user()->pengurusGudangBulky->bulky as $value) {
            $arr[] = $value->id;
        }
        $barang = PemesananKeluarBulky::with('bulky','barangKeluarPemesananBulky.barang')->whereIn('bulky_id', $arr)->first();
        $storageIn = StorageMasukBulky::with('barang','bulky')
        ->where('nomor_kwitansi','!=',null)
        ->doesntHave('returKeluar')
        ->whereIn('bulky_id',$arr)->get();
        // dd($storageIn[0]);
        // $barang = Barang::has('pemesananKeluarBulky')
        // ->whereHas('pemesananKeluarBulky', function($query)use($arr){
        //     $query->whereIn('bulky_id', $arr);
        // })
        // ->get();
        // $barang = Barang::all();

        return view('app.transaksi.retur-keluar-bulky.create', compact('barang','storageIn'));
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
            'nomor_kwitansi' => 'required',
            'barang_kode' => 'required|exists:barangs,kode_barang',
            'jumlah' => 'required|numeric',
            'tanggal_pengembalian' => 'required|date',
            'keterangan' => 'required|string|max:65534'
            // 'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        if ($v->fails()) {
            dd($v);
            return back()->withErrors($v)->withInput();
        }

        $barang = Barang::where('kode_barang', $request->barang_kode)->first();

        if ($barang->satuan == 'Kg') {
            $jumlah = $request->jumlah;
            $satuan = 'Ton';
        } else {
            $jumlah = $request->jumlah;
            $satuan = $barang->satuan;
        }
        $arr = [];
        // dd(auth()->user()->pengurusGudangBulky->bulky);
        foreach (auth()->user()->pengurusGudangBulky->bulky as $value) {
            $arr[] = $value->id;
        }
        $storageIn = StorageMasukBulky::whereIn('bulky_id',$arr)->first();
        // dd($storageIn);
        $retur = ReturKeluarBulky::create($request->only('nomor_kwitansi', 'tanggal_pengembalian', 'keterangan', 'barang_kode')+[
            'pengurus_gudang_id' => Auth::user()->pengurus_gudang_bulky_id,
            'storage_masuk_id' => $storageIn->id,
            'jumlah_barang' => $jumlah,
            'satuan' => $satuan
        ]);

        $storage = StorageMasukBulky::where('nomor_kwitansi', $request->nomor_kwitansi)->first();
        $pemasok = $storage->pemesanan->pemasok->nama;

        $kwitansi = $request->nomor_kwitansi;
        $nama_barang = $barang->nama_barang;

        $pembeli = Auth::user()->pengurusGudangBulky->nama;

        $waktu = $request->tanggal_pengembalian;

        $keterangan = $request->keterangan;

        $user_mail = User::where('pemasok_id', $storage->pemesanan->pemasok->id)->first();

        // (No kwitansi, nama barang, jumlah, satuan, penjual, pembeli, waktu, keterangan);
        set_time_limit(99999999);
        Mail::to($user_mail->email)->send(new PengembalianBarangMail($kwitansi, $nama_barang, $jumlah, $satuan, $pemasok, $pembeli, $waktu, $keterangan));

        $firebaseToken = User::where('pemasok_id', $storage->pemesanan->pemasok->id)
            ->whereNotNull('device_token')
            ->pluck('device_token')
            ->all();

        $judul = __( 'Bulky meminta melakukan pengembalian barang!' );

        $this->notif($judul, $firebaseToken);

        LogTransaksi::create([
            'user_id' => Auth::user()->id,
            'tanggal' => now('Asia/Jakarta'),
            'jam' => now('Asia/Jakarta'),
            'aktifitas_transaksi' => 'Retur Keluar',
            'role' => 'Bulky'
        ]);


        return redirect(route('bulky.retur.keluar.index'))->with('success', __( 'Retur berhasil dibuat!' ));
    }

    public function notif($judul, $firebase)
    {
        $SERVER_API_KEY = 'AAAAK3EE3yQ:APA91bEbilWopL1DWWDejff_25XMW2tiFtLoMl__a48yB2kSP7uWDHBo89-WxZ8YdazpFrmR7NgPFXeLrS_MrmMBq4wyr6KiOwy0WQ6YaHBvQAXlYSQSmMBrMVBFAlOe9pUYCGH-pp6j';

        $data = [
            "registration_ids" => $firebase,
            "notification" => [
                "title" => __( 'Pengembalian Barang' ),
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
        ReturKeluarBulky::findOrFail($id)->delete();

        return back()->with('success', __( 'Retur berhasil dihapus.' ));
    }
}
