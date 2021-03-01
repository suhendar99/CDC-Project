<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\BarangKeluarPelanggan;
use App\Models\BarangWarung;
use App\Models\LogTransaksi;
use App\Models\PemesananPembeli;
use App\Models\RekapitulasiPenjualanPelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class BarangKeluarPelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = BarangKeluarPelanggan::with('user', 'barangWarung', 'pemesanan')
            ->where('user_id',Auth::user()->id)
            ->orderBy('id', 'desc')
            ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    // return '<a href="/v1/storage/out/'.$data->id.'/edit" class="btn btn-primary btn-sm">Edit</a>&nbsp;<a href="#" class="btn btn-danger btn-sm" onclick="sweet(\'/v1/storage/out/'.$data->id.'\')">Hapus</a>';
                    return '<a href="#" class="btn btn-danger btn-sm" onclick="sweet('.$data->id.')">Hapus</a>';
                })
                ->addColumn('nama_barang',function($data){
                    return $data->barangWarung->storageOut->stockBarangRetail->nama_barang;
                })
                ->addColumn('jumlah_barang',function($data){
                    return $data->jumlah.' '.$data->satuan;
                })
                ->addColumn('pemesanan',function($data){
                    return $data->pemesanan->kode.' | '.$data->pemesanan->pembeli->nama;
                })
                ->editColumn('created_at',function($data){
                    return date('d-m-Y H:i:s', strtotime($data->created_at));
                })
                ->rawColumns(['action','nama_barang','jumlah_barang','pemesanan'])
                ->make(true);
        }
        return view('app.data-master.manajemenBarangPelanggan.keluar.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if($request->query('id') != null){
            $pemesanan = PemesananPembeli::with('pemesananPembeliItem','barangKeluar')->findOrFail($request->query('id'));
            $set = true;
            if ($pemesanan->barangKeluar != null) {
                return back()->with('failed','Pesanan SedangDalam Proses Pengiriman');
            }
        } else {
            $pemesanan = PemesananPembeli::with('pemesananPembeliItem','barangKeluar')->where('status','2')->doesntHave('barangKeluar')->get();
            $set = false;
        }

        $barang = BarangWarung::where('pelanggan_id',Auth::user()->pelanggan_id)
        ->with('pemesananPembeliItem.pemesananPembeli')
        // ->doesntHave('pemesananPembeliItem.pemesananPembeli.barangKeluar')
        ->get();
        // dd($barang);
        return view('app.data-master.manajemenBarangPelanggan.keluar.create',compact('pemesanan','barang','set'));
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
            'pemesanan_id' =>'required|exists:pemesanan_pembelis,id',
            'barang_warung_kode' =>'required|exists:barang_warungs,kode'
        ]);
        if ($v->fails()) {
            // return back()->withErrors($v)->withInput();
        } else {
            $out = BarangKeluarPelanggan::create([
                'pemesanan_id' => $request->pemesanan_id,
                'barang_warung_kode' => $request->barang_warung_kode,
                'user_id' => Auth::user()->id,
                'kode' => rand(1000000,9999999),
                'jumlah' => $request->jumlah,
                'satuan' => $request->satuan,
                'waktu' => now()
            ]);
            RekapitulasiPenjualanPelanggan::create([
                'barang_keluar_id' => $out->id,
                'tanggal_penjualan' => $out->waktu,
                'no_penjualan' => $out->kode,
                'nama_pembeli' => $out->pemesanan->nama_pemesan,
                'barang' => $out->pemesanan->pemesananPembeliItem[0]->barang->nama_barang,
                'jumlah' => $out->jumlah,
                'satuan' => $out->satuan,
                'harga' => $out->pemesanan->pemesananPembeliItem[0]->barang->harga_barang,
                'total' => $out->pemesanan->pemesananPembeliItem[0]->harga
            ]);
        }
        LogTransaksi::create([
            'user_id' => Auth::user()->id,
            'tanggal' => now('Asia/Jakarta'),
            'jam' => now('Asia/Jakarta'),
            'aktifitas_transaksi' => 'Barang Keluar',
            'role' => 'Warung'
        ]);

        $data = PemesananPembeli::findOrFail($request->pemesanan_id);
        $data->update(['status'=>'4']);
        return redirect('v1/barangKeluarPelanggan')->with('success','Data Berhasil Dibuat !');
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
        BarangKeluarPelanggan::findOrFail($id)->delete();

        return back()->with('success', __( 'Penyimpanan Keluar Telah Berhasil Di Hapus !' ));
    }
}
