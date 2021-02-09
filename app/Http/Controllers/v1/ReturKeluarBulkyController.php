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
use Illuminate\Support\Facades\DB;

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
            $data = ReturKeluarBulky::with('barang')
            ->orderBy('id', 'desc')
            ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    return '<a href="#" class="btn btn-danger btn-sm" onclick="sweet('.$data->id.')">Hapus</a>';
                })
                ->editColumn('created_at',function($data){
                    return date('d-m-Y H:i:s', strtotime($data->created_at));
                })
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

        $barang = PemesananKeluarBulky::with('barang', 'bulky')->whereIn('bulky_id', $arr)->get();
        // $barang = Barang::has('pemesananKeluarBulky')
        // ->whereHas('pemesananKeluarBulky', function($query)use($arr){
        //     $query->whereIn('bulky_id', $arr);
        // })
        // ->get();
        // $barang = Barang::all();

        return view('app.transaksi.retur-keluar-bulky.create', compact('barang'));
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

        $retur = ReturKeluarBulky::create($request->only('nomor_kwitansi', 'tanggal_pengembalian', 'keterangan', 'barang_kode')+[
            'jumlah_barang' => $jumlah,
            'satuan' => $satuan
        ]);

        $log = LogTransaksi::create([
            'tanggal' => now(),
            'jam' => now(),
            'aktifitas_transaksi' => 'Retur Barang Masuk'
        ]);


        return redirect(route('bulky.retur.keluar.index'))->with('success', __( 'Retur berhasil dibuat!' ));
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
