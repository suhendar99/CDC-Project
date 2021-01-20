<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\BarangPesanan;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Pemesanan;
use App\Models\Piutang;
use App\User;
use Carbon\Carbon;

class PemesananController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = Pemesanan::with('barangPesanan.barang')
            ->orderBy('id', 'desc')
            ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    return '<a href="#" class="btn btn-danger btn-sm" onclick="sweet('.$data->id.')">Hapus</a></div>';
                })
                ->addColumn('nama', function($data){
                    $nama = [];
                    foreach ($data->barangPesanan as $key => $value) {
                        $nama = $value->barang->nama_barang;
                        // dd($value->barang->nama_barang);
                    }
                    return $nama;
                })
                ->addColumn('jumlah_barang', function($data){
                    // dd($data->barangPesanan->toArray());
                    $jumlah = 0;
                    foreach ($data->barangPesanan as $key => $value) {
                        $jumlah += $value->barang->jumlah;
                        // dd($value->barang->nama_barang);
                    }
                    // $jumlah = $data->barangPesanan[0]->jumlah_barang;
                    // dd($jumlah);
                    return $jumlah;
                })
                ->rawColumns(['nama','jumlah_barang','action'])
                ->make(true);
        }
        return view('app.data-master.pemesanan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pelanggan = Pelanggan::all();
        $barang = Barang::all();
        return view('app.data-master.pemesanan.create',compact('pelanggan','barang'));
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
            'alamat_pemesan' => 'required',
            'telepon_penerima' => 'required',
            'metode_pembayaran' => 'nullable|numeric',
            'barang.*' => 'required',
            'jumlah.*' => 'required',
            'harga.*' => 'required',
            'satuan.*' => 'required'
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        } else {
            $pelanggan = $request->pelanggan_id;
            $search = Pelanggan::find($pelanggan);
            $nama = $search->nama;
            $kode = 'PM'.rand(10000,99999);
            // $kodeBarang = explode(' ',$kodeBar);
            // dd($v->errors()->all(),$request->all());
            $pemesanan = Pemesanan::create(array_merge($request->only('alamat_pemesan','metode_pembayaran'),[
                'kode' => $kode,
                'telepon' => $request->telepon_penerima,
                'nama_pemesan' => $nama,
                'tanggal_pemesanan' => Carbon::now()
            ]));
            $arrayLength = count($request->satuan);
            for ($i=0; $i < $arrayLength; $i++) {
                // dd($kodeBarang[$i]);
                $kodeBarang = 'BRP'.rand(10000,99999);
                BarangPesanan::create([
                    'pemesanan_id' => $pemesanan->id,
                    'kode' => $kodeBarang,
                    'barang_kode' => $request->barang[$i],
                    'satuan' => $request->satuan[$i],
                    'jumlah_barang' => $request->jumlah[$i],
                    'harga' => $request->harga[$i],
                ]);
            }
            if ($request->pembayaran == 'later') {
                $poItem = BarangPesanan::where('pemesanan_id',$pemesanan->id)->get();
                $harga = 0;
                $jumlah = 0;
                foreach ($poItem as $key => $value) {
                    $harga += $value->harga;
                    $jumlah += $value->jumlah_barang;
                    $subtotal = $harga*$jumlah;
                }
                $hutang = $subtotal;
                // dd($hutang);
                Piutang::create([
                    'barang_id' => $pemesanan->id,
                    'tanggal'=> Carbon::now(),
                    'nama_pembeli' => $nama,
                    'hutang' => $hutang,
                ]);
            }
            return back()->with('success','Data Telah ditambahkan');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Pelanggan::with('user')->where('id',$id)->get();
        $ser = User::where('pelanggan_id',$id)->get();
        foreach ($ser as $key => $value) {
            $user = $value;
        }
        return response()->json([
            'data' => $data,
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Pemesanan::findOrFail($id);
        return view('app.data-master.pemesanan.edit', compact('data'));
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
            'barang_kode' => 'required|string|exists:barangs,kode_barang',
            'jumlah_barang' => 'required|integer',
            'nama_pemesan' => 'required|string|max:50',
            'tanggal_pemesanan' => 'required|date',
            'alamat_pemesan' => 'required|string|max:255',
            'metode_pembayaran' => 'required|integer',
            'total_harga' => 'required|integer|min:0',
            'satuan' => 'required'
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        }

        $arrayName = ["kg", "ons", "gram", "ml", "m3", "m2", "m", "gram"];

        if (!in_array($request->satuan, $arrayName)) {
            return back()->with('failed', __( 'Masukan inputan satuan yang benar' ))->withInput();
        }

        Pemesanan::findOrFail($id)
        ->update($request->only('barang_kode', 'jumlah_barang', 'nama_pemesan', 'tanggal_pemesanan', 'alamat_pemesan', 'metode_pembayaran', 'total_harga', 'satuan'));

        return redirect(route('pemesanan.index'))->with('success', __( 'Pemesanan Updated' ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Pemesanan::findOrFail($id)->delete();

        return back()->with('success', __( 'Pemesanan Deleted' ));
    }
}
