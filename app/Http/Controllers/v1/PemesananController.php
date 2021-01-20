<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Pemesanan;

class PemesananController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Pemesanan::with('barangPesanan.barang')
        ->orderBy('id', 'desc')
        ->get();
        dd($data);
        if($request->ajax()){
            $data = Pemesanan::with('barangPesanan.barang')
            ->orderBy('id', 'desc')
            ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    return '<div class="text-center" style="width: 100%"><a href="/v1/pemesanan/'.$data->id.'/edit" class="btn btn-primary btn-sm">Edit</a>&nbsp;<a href="#" class="btn btn-danger btn-sm" onclick="sweet('.$data->id.')">Hapus</a></div>';
                })
                ->make(true);
        }

            $data = Pemesanan::with('barangPesanan.barang')
            ->orderBy('id', 'desc')
            ->get();
            dd($data);

        return view('app.data-master.pemesanan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('app.data-master.pemesanan.create');
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

        Pemesanan::create($request->only('barang_kode', 'jumlah_barang', 'nama_pemesan', 'tanggal_pemesanan', 'alamat_pemesan', 'metode_pembayaran', 'total_harga', 'satuan'));

        return redirect(route('pemesanan.index'))->with('success', __( 'Pemesanan Created' ));
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
