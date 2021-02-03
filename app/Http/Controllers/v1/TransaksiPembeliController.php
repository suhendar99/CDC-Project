<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PemesananPembeli;

class TransaksiPembeliController extends Controller
{
	public function __construct(PemesananPembeli $pemesanan)
	{
		$this->model = $pemesanan;
		$this->path = 'app.transaksi.pembeli.riwayat-transaksi.';
	}

	public function index()
	{
		$data = $this->model::with('pemesananPembeliItem','pembeli','pelanggan.kabupaten')->paginate(6);
		return view($this->path.'index',compact('data'));
	}

	public function konfirmasi($id)
	{
		$data = $this->model::findOrFail($id);
		$data->update(['status'=>5]);
		// dd($data);
		return back()->with('success','Penerimaan Pesanan Telah Dikonfirmasi!');
	}


    public function tolak($id)
    {
        $data = $this->model::findOrFail($id);
        $data->update(['status'=>'0']);

        return back()->with('success','Pesanan Berhasil Ditolak!');
    }

    public function kirim($id)
    {
        return redirect('/v1/storage/out/create',['data'=>'data']);
    }

    public function bukti(Request $request, $id)
    {
        // dd($request->file('foto_bukti'));
        $data = $this->model::findOrFail($id);
        $foto_bukti = $request->file('foto_bukti');
        $nama_bukti = time()."_".$foto_bukti->getClientOriginalName();
        $foto_bukti->move(public_path("/upload/foto/bukti"), $nama_bukti);

        $data->update([
            'foto_bukti' => '/upload/foto/bukti/'.$nama_bukti
        ]);

        return back()->with('success','Bukti Pembayaran Berhasil Diupload!');
    }
}
