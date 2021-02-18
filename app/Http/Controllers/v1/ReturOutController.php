<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\LogTransaksi;
use App\Models\Po;
use App\Models\ReturMasukBulky;
use App\Models\KwitansiBulky;
use App\Models\PemesananBulky;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ReturOutController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = ReturMasukBulky::with('kwitansiBulky.pemesananBulky.barangPesananBulky','kwitansiBulky.pemesananBulky.retail')
            ->whereHas('kwitansiBulky.pemesananBulky.retail',function($q){
                $q->where('user_id',Auth::user()->id);
            })
            ->orderBy('id', 'desc')
            ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    return '<a href="/v1/returOut/'.$data->id.'/edit" class="btn btn-primary btn-sm">Edit</a>&nbsp;<a href="#" class="btn btn-danger btn-sm" onclick="sweet('.$data->id.')">Hapus</a>';
                })
                ->editColumn('created_at',function($data){
                    return date('d-m-Y H:i:s', strtotime($data->created_at));
                })
                ->editColumn('barang',function($data){
                    return '('.$data->kwitansiBulky->pemesananBulky->kode.') '.$data->kwitansiBulky->pemesananBulky->barangPesananBulky->nama_barang;
                })
                ->make(true);
        }

        return view('app.transaksi.returOut.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kwitansi = KwitansiBulky::with('pemesananBulky.barangPesananBulky')->whereHas('pemesananBulky',function($query){
            $query->where('gudang_retail_id', auth()->user()->pengurus_gudang_id);
        })->doesntHave('returMasukBulky')
        ->get();

        return view('app.transaksi.returOut.create', compact('kwitansi'));
    }

    public function barangKwitansi($id)
    {
        $barang = KwitansiBulky::with('pemesananBulky.barang')->find($id);

        return response()->json([
            'data' => $barang
        ],200);
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
            // 'barang_kode' => 'required|exists:barangs,kode_barang',
            'kwitansi_bulky_id' => 'required|exists:kwitansi_bulkies,id',
            'tanggal_pengembalian' => 'required|date',
            'keterangan' => 'required|string|max:65534'
            // 'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        }

        ReturMasukBulky::create($request->only('kwitansi_bulky_id', 'tanggal_pengembalian', 'keterangan'));
        $log = LogTransaksi::create([
            'tanggal' => now('Asia/Jakarta'),
            'jam' => now('Asia/Jakarta'),
            'aktifitas_transaksi' => 'Retur Barang Keluar'
        ]);

        return redirect(route('returOut.index'))->with('success', __( 'Retur Created!' ));
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
        $kwitansi = KwitansiBulky::with('pemesananBulky.barangPesananBulky')->whereHas('pemesananBulky',function($query){
            $query->where('gudang_retail_id', auth()->user()->pengurus_gudang_id);
        })->doesntHave('returMasukBulky')
        ->get();;

        $data = ReturMasukBulky::findOrFail($id);

        return view('app.transaksi.returOut.edit', compact('kwitansi', 'data'));
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
            'kwitansi_bulky_id' => 'required|exists:kwitansi_bulkies,id',
            'tanggal_pengembalian' => 'required|date',
            'keterangan' => 'required|string|max:65534'
            // 'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        }

        ReturMasukBulky::findOrFail($id)->update($request->only('kwitansi_bulky_id', 'tanggal_pengembalian', 'keterangan'));

        return redirect(route('returOut.index'))->with('success', __( 'Retur Updated!' ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ReturMasukBulky::findOrFail($id)->delete();

        return redirect(route('returOut.index'))->with('success', __( 'Retur Deleted!' ));
    }
}
