<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PemesananKeluarPembeliController extends Controller
{
    public function __construct(Pemesanan $pemesanan)
    {
        $this->model = $pemesanan;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->model::with('storageOut.user.pengurusGudang.kabupaten','pelanggan.kabupaten','barangPesanan')->where('pelanggan_id',Auth::user()->pelanggan_id)->orderBy('id','desc')->paginate(4);
        // dd($data->toArray());
        return view('app.transaksi.pemesanan-keluar-warung.index',compact('data'));
    }

    public function konfirmasi($id)
    {
        $data = $this->model::findOrFail($id);
        // dd($data);
        $data->update(['status'=>'5']);

        return back()->with('success','Penerimaan Pesanan Telah Dikonfirmasi!');
    }

    public function validasi($id)
    {
        $data = $this->model::findOrFail($id);
        $data->update(['status'=>'2']);
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
