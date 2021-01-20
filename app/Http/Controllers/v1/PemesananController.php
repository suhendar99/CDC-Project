<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\Pemesanan;
use App\Models\Storage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PemesananController extends Controller
{
    public function __construct()
    {
        $this->path = 'app.transaksi.pemesanan-barang.';
    }
    public function showFormPemesanan($id)
    {
        $storage = Storage::with('storageIn.barang')->where('id',$id)->get();

        return view($this->path.'index', compact('storage','id'));
    }
    public function store(Request $request,$id)
    {
        $v = Validator::make($request->all(),[
            'jumlah_barang' => 'required',
            'metode_pembayaran' => 'required'
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        } else {
            $pembayaran = $request->pembayaran;
            $kode_barang = Storage::with('storageIn')->whereId($id)->get();;
            if ($pembayaran == 'sekarang') {
                Pemesanan::create([
                    'jumlah_barang' => $request->jumlah_barang,
                    'metode_pembayaran' => $request->metode_pembayaran,
                    'nama_pemesan' => Auth::user()->pelanggan->nama,
                    'alamat_pemesan' => Auth::user()->pelanggan->alamat,
                    'tanggal_pemesanan' => Carbon::now(),
                    'barang_kode' => $kode_barang->storageIn->kode
                ]);
            } elseif ($pembayaran == 'nanti') {
                Pemesanan::create([
                    'jumlah_barang' => $request->jumlah_barang,
                    'metode_pembayaran' => $request->metode_pembayaran,
                    'nama_pemesan' => Auth::user()->pelanggan->nama,
                    'alamat_pemesan' => Auth::user()->pelanggan->alamat,
                    'tanggal_pemesanan' => Carbon::now(),
                    'barang_kode' => $kode_barang->storageIn->kode
                ]);
                
            }
        }
    }
}
