<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Kwitansi;
use App\Models\LogTransaksi;
use App\Models\Retur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Mail;
use App\Mail\PengembalianBarangMail;
Use App\Models\PengurusGudangBulky;
use App\User;

class ReturKeluarPelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = Retur::with('barang', 'kwitansi.pemesanan')
            ->whereHas('kwitansi.pemesanan',function($q){
                $q->where('pelanggan_id',Auth::user()->pelanggan_id);
            })
            ->orderBy('id', 'desc')
            ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    return '<a href="/v1/returKeluarPelanggan/'.$data->id.'/edit" class="btn btn-primary btn-sm">Edit</a>&nbsp;<a href="#" class="btn btn-danger btn-sm" onclick="sweet('.$data->id.')">Hapus</a>';
                })
                ->editColumn('created_at',function($data){
                    return date('d-m-Y H:i:s', strtotime($data->created_at));
                })
                ->make(true);
        }

        return view('app.transaksi.returKeluarPelanggan.index');
    }

    public function barangPesanan($id)
    {
        $kwi = Kwitansi::find($id);

        $barang = Barang::whereHas('barangPesanan', function($query)use($kwi){
            $query->where('pemesanan_id', $kwi->pemesanan_id);
        })->get();

        return response()->json([
            'data' => $barang
        ], 200);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kwitansi = Kwitansi::with('pemesanan')
        ->whereHas('pemesanan',function($q){
            $q->where('pelanggan_id',Auth::user()->pelanggan_id);
        })
        ->orderBy('id','desc')
        ->get();
        // $barang = Barang::all();

        return view('app.transaksi.retur.create', compact('kwitansi'));
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
            'barang_id' => 'required|exists:barangs,id',
            'kwitansi_id.*' => 'required|exists:kwitansis,id',
            'tanggal_pengembalian' => 'required|date',
            'keterangan' => 'required|string|max:65534'
            // 'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        if ($v->fails()) {
            dd($v);
            return back()->withErrors($v)->withInput();
        }

        $retur = Retur::create($request->only('kwitansi_id', 'tanggal_pengembalian', 'keterangan'));

        foreach ($request->barang_id as $value) {
            DB::table('barang_retur_masuks')->insert([
                'barang_id' => $value,
                'retur_id' => $retur->id,
                'created_at' => now('Asia/Jakarta')
            ]);
        }

        $nomor_kwitansi = $retur->kwitansi->kode;

        $nama_barang = $retur->kwitansi->pemesanan->barangPesanan[0]->nama_barang;
        $jumlah = $retur->kwitansi->pemesanan->barangPesanan[0]->jumlah_barang;
        $satuan = $retur->kwitansi->pemesanan->barangPesanan[0]->satuan;

        $penjual = $retur->kwitansi->pemesanan->gudang->nama;

        $user_mail = $retur->kwitansi->pemesanan->gudang->user->email;

        $pembeli = auth()->user()->name;

        $user_mail = $pesanan->bulky->user->email;

        // (No kwitansi, nama barang, jumlah, satuan, penjual, pembeli, waktu, keterangan);
        set_time_limit(99999999);
        Mail::to($user_mail)->send(new PengembalianBarangMail($request->nomor_kwitansi, $nama_barang, $jumlah, $satuan, $penjual, $pembeli, $request->tanggal_pengembalian, $request->keterangan));

        $firebaseToken = User::where('id', auth()->user()->id)
            ->whereNotNull('device_token')
            ->pluck('device_token')
            ->all();

        $judul = __( 'Warung meminta melakukan pengembalian barang!' );

        $this->notif($judul, $firebaseToken);

        LogTransaksi::create([
            'user_id' => Auth::user()->id,
            'tanggal' => now('Asia/Jakarta'),
            'jam' => now('Asia/Jakarta'),
            'aktifitas_transaksi' => 'Retur Keluar',
            'role' => 'Warung'
        ]);


        return back()->with('success', __( 'Retur Dibuat!' ));
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
        $kwitansi = Kwitansi::all();
        $data = Retur::with('barang')->findOrFail($id);

        return view('app.transaksi.retur.edit', compact('kwitansi', 'data'));
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
            // 'barang_kode' => 'required|numeric|exists:barangs,kode_barang',
            'barang_id' => 'required|exists:barangs,id',
            'kwitansi_id.*' => 'required|exists:kwitansis,id',
            'tanggal_pengembalian' => 'required|date',
            'keterangan' => 'required|string|max:65534'
            // 'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        }

        Retur::findOrFail($id)->update($request->only('kwitansi_id', 'tanggal_pengembalian', 'keterangan'));

        $data = DB::table('barang_retur_masuks')
        ->where('retur_id', $id)
        ->delete();

        foreach ($request->barang_id as $value) {
            DB::table('barang_retur_masuks')->insert([
                'barang_id' => $value,
                'retur_id' => $id,
                'created_at' => now('Asia/Jakarta')
            ]);
        }

        return back()->with('success', __( 'Retur Diedit!' ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Retur::findOrFail($id)->delete();

        return back()->with('success', __( 'Retur Dihapus!' ));
    }
}
