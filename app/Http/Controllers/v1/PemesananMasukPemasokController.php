<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\BarangKeluarPemesananBulky;
use App\Models\PemesananKeluarBulky;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PemesananMasukPemasokController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = BarangKeluarPemesananBulky::with('barang', 'pemesanan')
        ->whereHas('pemesanan',function($q){
            $q->where('pemasok_id',Auth::user()->pemasok_id);
        })
        ->orderBy('id', 'desc')
        ->get();
        if($request->ajax()){
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    return '&nbsp;<a href="#" class="btn btn-outline-danger btn-sm" onclick="sweet('.$data->pemesanan->id.')" ><i class="fa fa-trash"></i> Hapus</a>';
                })
                ->addColumn('total_pembayaran', function($data){
                    return '&nbsp;Rp. '.Number_format($data->harga,0,',','.');
                })
                ->addColumn('status_pembayaran', function($data){
                    if ($data->pemesanan->metode_pembayaran == null && $data->pemesanan->foto_bukti == null) {
                        return "<span class='text-danger'>Hutang</span>";
                    } elseif ($data->pemesanan->metode_pembayaran != null && $data->pemesanan->foto_bukti == null ) {
                        return "<span class='text-danger'>Belum Ada Bukti Pembayaran</span>";
                    } elseif ($data->pemesanan->foto_bukti != null && $data->pemesanan->status == '2') {
                        return "<span class='text-success'>Lunas</span>";
                    } elseif ($data->pemesanan->foto_bukti != null && $data->pemesanan->status == '5') {
                        return "<span class='text-success'>Lunas</span>";
                    } else {
                        return "Belum Diterima";
                    }
                })
                ->addColumn('metode_pembayaran', function($data){
                    $uc = ucwords($data->pemesanan->metode_pembayaran);
                    return $uc;
                })
                ->addColumn('bukti_pembayaran', function($data){
                    if($data->pemesanan->foto_bukti != null){

                        return '&nbsp;<a class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalBukti" onclick="bukti('.$data->pemesanan->id.')" data-id="'.$data->pemesanan->id.'" style="cursor: pointer;" title="Lihat Bukti Pembayaran">Lihat Bukti Pembayaran</a>';
                    } else {
                        return '&nbsp; <span class="text-danger">Bukti Pembayaran Belum Diupload</span>';
                    }
                })
                ->addColumn('status_pemesanan',function($data){
                    if($data->pemesanan->status == 0){
                        return '&nbsp;<span class="text-danger">Pesanan Ditolak</span>';
                    } elseif ($data->pemesanan->status == 1){
                        return '&nbsp;<span class="text-danger">Pemesanan Belum Terverifikasi</span>';
                    }elseif ($data->pemesanan->status == 2) {
                        return '&nbsp;Pembayaran Terverifikasi';
                    } elseif ($data->pemesanan->status == 4) {
                        return '&nbsp;Pesanan Sedang Dikirim';
                    } elseif ($data->pemesanan->status == 5) {
                        return '&nbsp;Pesanan Sudah Diterima';
                    } elseif ($data->pemesanan->status == 6) {
                        return '&nbsp;Pesanan Diambil';
                    }
                })
                ->addColumn('aksi_pemesanan',function($data){
                    if ($data->pemesanan->status == 1 && $data->pemesanan->foto_bukti != null) {
                        return '&nbsp;<a href="/v1/validasi/bukti/bulky/'.$data->pemesanan->id.'" class="btn btn-outline-primary btn-sm">Verifikasi</a> <a href="/v1/tolak/pesanan/bulky/'.$data->pemesanan->id.'" class="btn btn-outline-danger btn-sm" >Tolak Pesanan</a>';
                    } elseif ($data->pemesanan->status == 1){
                        return '&nbsp;<a href="/v1/tolak/pesanan/retail/'.$data->pemesanan->id.'" class="btn btn-outline-danger btn-sm" >Tolak Pesanan</a>';
                    } elseif ($data->pemesanan->status == 2) {
                        return '&nbsp;<a href="/v1/storage-keluar-pemasok/create?id='.$data->pemesanan->id.'" class="btn btn-outline-success btn-sm">Kirim</a>';
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

        return view('app.transaksi.pemesanan-masuk-pemasok.index');
    }
    public function getPemesananBulky($id)
    {

        $data = BarangKeluarPemesananBulky::with('barang', 'pemesanan')->where('id',$id)->first();

        return response()->json([
            'data' => $data
        ]);
    }
    public function validasi($id)
    {
        $data = PemesananKeluarBulky::findOrFail($id);
        $data->update(['status'=>'2']);
        // dd($data);
        return back()->with('success','Pembayaran Pesanan Telah Divalidasi!');
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
