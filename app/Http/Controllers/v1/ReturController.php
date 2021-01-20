<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Pemesanan;
use App\Models\Barang;
use App\Models\Retur;
use Illuminate\Support\Facades\DB;

class ReturController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = Retur::with('barang', 'pemesanan')
            ->orderBy('id', 'desc')
            ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    return '<a href="/v1/retur/'.$data->id.'/edit" class="btn btn-primary btn-sm">Edit</a>&nbsp;<a href="#" class="btn btn-danger btn-sm" onclick="sweet('.$data->id.')">Hapus</a>';
                })
                ->make(true);
        }

        return view('app.transaksi.retur.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $barang = Barang::all();
        $pemesanan = Pemesanan::all();

        return view('app.transaksi.retur.create', compact('barang', 'pemesanan'));
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
            'barang_kode' => 'required|exists:barangs,kode_barang',
            'pemesanan_id' => 'required|exists:pemesanans,id',
            'tanggal_pengembalian' => 'required|date',
            'keterangan' => 'required|string|max:65534'
            // 'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        }

        Retur::create($request->only('barang_kode', 'pemesanan_id', 'tanggal_pengembalian', 'keterangan'));

        return redirect(route('retur.index'))->with('success', __( 'Retur Created!' ));
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
        $barang = Barang::all();
        $pemesanan = Pemesanan::all();
        $data = Retur::findOrFail($id);

        return view('app.transaksi.retur.edit', compact('barang', 'pemesanan', 'data'));
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
            'barang_kode' => 'required|exists:barangs,kode_barang',
            'pemesanan_id' => 'required|exists:pemesanans,id',
            'tanggal_pengembalian' => 'required|date',
            'keterangan' => 'required|string|max:65534'
            // 'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        }

        Retur::findOrFail($id)->update($request->only('barang_kode', 'pemesanan_id', 'tanggal_pengembalian', 'keterangan'));

        return redirect(route('retur.index'))->with('success', __( 'Retur Updated!' ));
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

        return redirect(route('retur.index'))->with('success', __( 'Retur Deleted!' ));
    }
}
