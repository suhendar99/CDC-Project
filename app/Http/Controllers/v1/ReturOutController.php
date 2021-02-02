<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\LogTransaksi;
use App\Models\Po;
use App\Models\ReturOut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ReturOutController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = ReturOut::with('barang', 'po')
            ->orderBy('id', 'desc')
            ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    return '<a href="/v1/returOut/'.$data->id.'/edit" class="btn btn-primary btn-sm">Edit</a>&nbsp;<a href="#" class="btn btn-danger btn-sm" onclick="sweet('.$data->id.')">Hapus</a>';
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
        $barang = Barang::all();
        $pemesanan = Po::all();

        return view('app.transaksi.returOut.create', compact('barang', 'pemesanan'));
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
            'po_id' => 'required|exists:pemesanans,id',
            'tanggal_pengembalian' => 'required|date',
            'keterangan' => 'required|string|max:65534'
            // 'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        }

        ReturOut::create($request->only('barang_kode', 'po_id', 'tanggal_pengembalian', 'keterangan'));
        $log = LogTransaksi::create([
            'tanggal' => now(),
            'jam' => now(),
            'Aktifitas_transaksi' => 'Retur Barang Keluar'
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
        $barang = Barang::all();
        $pemesanan = Po::all();
        $data = ReturOut::findOrFail($id);

        return view('app.transaksi.returOut.edit', compact('barang', 'pemesanan', 'data'));
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
            'po_id' => 'required|exists:pemesanans,id',
            'tanggal_pengembalian' => 'required|date',
            'keterangan' => 'required|string|max:65534'
            // 'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        }

        ReturOut::findOrFail($id)->update($request->only('barang_kode', 'po_id', 'tanggal_pengembalian', 'keterangan'));

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
        ReturOut::findOrFail($id)->delete();

        return redirect(route('returOut.index'))->with('success', __( 'Retur Deleted!' ));
    }
}
