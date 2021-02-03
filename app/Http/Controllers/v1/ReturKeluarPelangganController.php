<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Kwitansi;
use App\Models\LogTransaksi;
use App\Models\Retur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

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
            ->orderBy('id', 'desc')
            ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    return '<a href="/v1/returKeluarPelanggan/'.$data->id.'/edit" class="btn btn-primary btn-sm">Edit</a>&nbsp;<a href="#" class="btn btn-danger btn-sm" onclick="sweet('.$data->id.')">Hapus</a>';
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
        $kwitansi = Kwitansi::with('pemesanan')->get();
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
        $log = LogTransaksi::create([
            'tanggal' => now(),
            'jam' => now(),
            'Aktifitas_transaksi' => 'Retur Barang Masuk'
        ]);


        return back()->with('success', __( 'Retur Dibuat!' ));
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
