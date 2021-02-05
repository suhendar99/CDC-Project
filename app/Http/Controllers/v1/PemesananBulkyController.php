<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PemesananBulky;
use App\Models\BarangPemesananBulky;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\File;

class PemesananBulkyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = BarangPemesananBulky::with('barang', 'pemesananBulky.storageKeluarBulky')
        ->orderBy('id', 'desc')
        ->get();
        // dd($data[0]);
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
                ->addColumn('jumlah_barang', function($data){
                    return $data->jumlah_barang.' '.$data->satuan;
                })
                ->addColumn('status_pembayaran', function($data){
                    if ($data->pemesananBulky->metode_pembayaran == null && $data->pemesananBulky->foto_bukti == null) {
                        return "<span class='text-danger'>Hutang</span>";
                    } elseif ($data->pemesananBulky->metode_pembayaran != null && $data->pemesananBulky->foto_bukti == null ) {
                        return "<span class='text-danger'>Belum Ada Bukti Pembayaran</span>";
                    } elseif ($data->pemesananBulky->foto_bukti != null && $data->pemesananBulky->status == '2') {
                        return "<span class='text-success'>Lunas</span>";
                    } else {
                        return "Belum Terverifikasi";
                    }
                })
                ->addColumn('metode_pembayaran', function($data){
                    $uc = ucwords($data->pemesananBulky->metode_pembayaran);
                    return $uc;
                })
                ->addColumn('bukti_pembayaran', function($data){
                    if($data->pemesananBulky->foto_bukti != null){

                        return '&nbsp;<a class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalBukti" onclick="bukti('.$data->pemesananBulky->id.')" data-id="'.$data->pemesananBulky->id.'" style="cursor: pointer;" title="Lihat Bukti Pembayaran">Lihat Bukti Pembayaran</a>';
                    } else {
                        return '&nbsp; <span class="text-danger">Bukti Pembayaran Belum Diupload</span>';
                    }
                })
                ->addColumn('status_pemesanan',function($data){
                    if($data->pemesananBulky->status == 0){
                        return '&nbsp;<span class="text-danger">Pesanan Ditolak</span>';
                    } elseif ($data->pemesananBulky->status == 1){
                        return '&nbsp;<span class="text-danger">Pembayaran Belum Terverifikasi</span>';
                    }elseif ($data->pemesananBulky->status == 2) {
                        return '&nbsp;Pembayaran Terverifikasi';
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
                ->rawColumns(['action','total_pembayaran','aksi_pemesanan','bukti_pembayaran','jumlah_barang','status_pembayaran','status_pemesanan'])
                ->make(true);
        }

        return view('app.data-master.pemesananBulky.index');
    }


    public function getPemesananRetail($id)
    {

        $data = BarangPemesananBulky::with('barang', 'pemesananBulky.storageKeluarBulky')->where('id',$id)->first();
        // $data = PemesananPembeliItem::with('pemesananPembeli.barangKeluar')->where('id',$id)->get();
        return response()->json([
            'data' => $data
        ]);
    }

    public function validasi($id)
    {
        $data = PemesananBulky::findOrFail($id);
        $data->update(['status'=>'2']);
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
        $data = PemesananBulky::with('barangPesananBulky')->first();
        $barang = $data->barangPesananBulky;
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
