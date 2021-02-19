<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Gudang;
use App\Models\GudangBulky;
use App\Models\LogTransaksi;
use App\Models\PenawaranBulky;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PenawaranPemasokController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $gudangs = GudangBulky::where('status',1)
        ->orderBy('id','desc')
        ->paginate(6);

        if ($request->query('search') !== null) {
        	$gudangs = GudangBulky::where('nama', 'like', '%'.$request->query('search').'%')
            ->orderBy('id','desc')
	        ->paginate(6);
        }
        return view('app.transaksi.pemasok.penawaran.index',compact('gudangs'));
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
        $data = Barang::find($id);
        return response()->json([
            'data' => $data
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
        $barang = Barang::where('pemasok_id',Auth::user()->pemasok_id)->get();
        $gudang = GudangBulky::find($id);
        return view('app.transaksi.pemasok.penawaran.create',compact('gudang','barang'));
    }

    public function riwayat(Request $request)
    {
        $data = PenawaranBulky::with('barang', 'gudangBulky','pemasok')
        ->where('pemasok_id',Auth::user()->pemasok_id)
        ->orderBy('id', 'desc')
        ->get();
        // dd($data[0]);
        if($request->ajax()){
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    // return '<a class="btn btn-info btn-sm" data-toggle="modal" data-target="#exampleModal" onclick="detail('.$data->id.')" data-id="'.$data->id.'" style="cursor: pointer;" title="Detail">Detail</a> <a href="#" class="btn btn-danger btn-sm" onclick="sweet('.$data->id.')">Hapus</a>';
                    return '&nbsp;<a href="#" class="btn btn-outline-danger btn-sm" onclick="sweet('.$data->id.')" ><i class="fa fa-trash"></i> Hapus</a>';
                })
                ->addColumn('harga', function($data){
                    return '&nbsp;Rp. '.Number_format($data->harga_barang,0,',','.');
                })
                ->addColumn('status_penawaran',function($data){
                    if($data->status == null){
                        return '&nbsp;<span>Penawaran Belum disetujui</span>';
                    } elseif ($data->status == 4){
                        return '&nbsp;<span class="text-danger">Penawaran Ditolak</span>';
                    } elseif ($data->status == 1){
                        return '&nbsp;Penawaran Disetujui Langsung Dipesan';
                    } elseif ($data->status == 2) {
                        return '&nbsp;Pesanan Sedang Dikirim';
                    } elseif ($data->status == 3) {
                        return '&nbsp;Pesanan Sudah Diterima';
                    }
                })
                ->addColumn('aksi_penawaran',function($data){
                    if ($data->status == null){
                        return '&nbsp;Penawaran Belum Diverivikasi';
                    } elseif ($data->status == 1) {
                        return '&nbsp;<a href="/v1/storage-keluar-pemasok/create?penawaran='.$data->id.'" class="btn btn-outline-success btn-sm">Kirim</a>';
                    } else {
                        return '&nbsp;-&nbsp;';
                    }
                })
                ->editColumn('created_at',function($data){
                    return date('d-m-Y H:i', strtotime($data->created_at)).' WIB';
                })
                ->rawColumns(['action','harga','status_penawaran','aksi_penawaran'])
                ->make(true);
        }
        return view('app.transaksi.pemasok.penawaran.riwayat');
    }

    public function penawaranBulky()
    {
        $data = PenawaranBulky::with('barang','gudangBulky','pemasok')
        ->whereHas('gudangBulky',function($q){
            $q->where('user_id',Auth::user()->id);
        })
        ->orderBy('created_at','desc')
        ->paginate(6);
        return view('app.transaksi.pemesanan-keluar-bulky.penawaran',compact('data'));
        // $data = PenawaranBulky::findOrFail($id);
        // // dd($data);
        // $data->update(['status'=>'5']);

        // return back()->with('success','Penerimaan Pesanan Telah Dikonfirmasi!');
    }
    public function konfirmasi($id)
    {
        $penawaran = PenawaranBulky::findOrFail($id);
        $penawaran->update(['status'=>'1']);

        return redirect('/shop/pesanan/'.$penawaran->barang->id.'?jumlah='.$penawaran->jumlah)->with('success','Penawaran Telah Dikonfirmasi!');
    }
    public function tolak($id)
    {
        $data = PenawaranBulky::findOrFail($id);
        // dd($data);
        $data->update(['status'=> 4]);

        return back()->with('error','Penawaran Telah Ditolak!');
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
            'barang_id' => 'required|exists:barangs,id',
            'jumlah' => 'required|numeric',
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        } else {
            $barang = Barang::find($request->barang_id);
            PenawaranBulky::create(array_merge($request->only('barang_id','jumlah','satuan','harga_barang'),[
                'kode' => rand(100000,999999),
                'gudang_bulky_id' => $id,
                'pemasok_id' => Auth::user()->pemasok->id,
                'nama_barang' => $barang->nama_barang
            ]));
            LogTransaksi::create([
                'tanggal' => now('Asia/Jakarta'),
                'jam' => now('Asia/Jakarta'),
                'aktifitas_transaksi' => 'Penawaran Barang',
                'role' => 'Pemasok'
            ]);
            return redirect(route('riwayat'))->with('success', 'Penaawaran berhasil dibuat !');
        }
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
