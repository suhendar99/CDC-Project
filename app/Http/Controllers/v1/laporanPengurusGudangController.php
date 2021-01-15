<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\Gudang;
use App\Models\StorageIn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PDF;

class laporanPengurusGudangController extends Controller
{
    public function __construct()
    {
        $this->path = 'app.laporan.pengurus-gudang.barang-masuk.';
    }
    public function showLaporanBarangMasuk()
    {
        return view($this->path.'index');
    }
    public function LaporanBarangMasukPdf(Request $request)
    {
        $v = Validator::make($request->all(),[
            'awal' => 'required',
            'akhir' => 'required',
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        } else {
            $awal = $request->awal;
            $akhir = $request->akhir;
            if ($akhir < $awal) {
                return back()->with('failed','Mohon Perikas Tanggal Anda !');
            }
            $data = StorageIn::with('user','gudang','barang')->whereBetween('waktu',[$awal, $akhir])->latest()->get();
            // $barang = Gudang::where('');
            if ($data === null) {
                return back()->with('error','Tidak ada data pada tanggal  '.$awal.' sampai '.$akhir);
            } else {
                $sumber = "Semua UPTD";
                $pdf = PDF::loadview($this->path.'pdf',compact('data','awal','akhir','sumber'))->setPaper('DEFAULT_PDF_PAPER_SIZE', 'potrait')->setWarnings(false);
                set_time_limit('99999');
                return $pdf->stream('Laporan'.$sumber.$akhir.'.pdf');
                return view($this->path.'pdf',compact('data','awal','akhir','sumber'));
            }
        }
    }
}
