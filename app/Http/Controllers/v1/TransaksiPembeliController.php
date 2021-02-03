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
		$data->update(['status'=>4]);
		// dd($data);
		return back()->with('success','Penerimaan Pesanan Telah Dikonfirmasi!');
	}
}
