<?php

namespace App\Http\Controllers\v1;

use App\Exports\ExportLaporanBarangKeluar;
use App\Exports\ExportLaporanBarangMasuk;
use App\Http\Controllers\Controller;
use App\Models\Gudang;
use App\Models\StorageIn;
use App\Models\StorageOut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PDF;

class laporanPengurusGudangController extends Controller
{
    public function __construct()
    {
        $this->path = 'app.laporan.pengurus-gudang.barang-masuk.';
        $this->pathKeluar = 'app.laporan.pengurus-gudang.barang-keluar.';
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
            // dd($data);
            $barang = Gudang::all();
            if ($data === null) {
                return back()->with('error','Tidak ada data pada tanggal  '.$awal.' sampai '.$akhir);
            } else {
                $sumber = "Semua UPTD";
                $pdf = PDF::loadview($this->path.'pdf',compact('data','awal','akhir','sumber'))->setPaper('DEFAULT_PDF_PAPER_SIZE', 'landscape')->setWarnings(false);
                set_time_limit('99999');
                return $pdf->stream('Laporan'.$sumber.$akhir.'.pdf');
                return view($this->path.'pdf',compact('data','awal','akhir','sumber'));
            }
        }
    }
    public function LaporanBarangMasukExcel(Request $request)
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
            if($data->count() < 1){
                return back()->with('failed','Data Kosong!');
            }
                $input = $request->all();
                set_time_limit(99999);
                return (new ExportLaporanBarangMasuk($awal, $akhir))->download('Laporan-'.$akhir.'.xlsx');
        }
    }
    public function showLaporanBarangKeluar()
    {
        return view($this->pathKeluar.'index');
    }
    public function LaporanBarangKeluarPdf(Request $request)
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
            $data = StorageOut::with('user','gudang','barang')->whereBetween('waktu',[$awal, $akhir])->latest()->get();
            // dd($data);
            $barang = Gudang::all();
            if ($data === null) {
                return back()->with('error','Tidak ada data pada tanggal  '.$awal.' sampai '.$akhir);
            } else {
                $sumber = "Semua UPTD";
                $pdf = PDF::loadview($this->pathKeluar.'pdf',compact('data','awal','akhir','sumber'))->setPaper('DEFAULT_PDF_PAPER_SIZE', 'landscape')->setWarnings(false);
                set_time_limit('99999');
                return $pdf->stream('Laporan'.$sumber.$akhir.'.pdf');
                return view($this->pathKeluar.'pdf',compact('data','awal','akhir','sumber'));
            }
        }
    }
    public function LaporanBarangKeluarExcel(Request $request)
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
            $data = StorageOut::with('user','gudang','barang')->whereBetween('waktu',[$awal, $akhir])->latest()->get();
            if($data->count() < 1){
                return back()->with('failed','Data Kosong!');
            }
                $input = $request->all();
                set_time_limit(99999);
                return (new ExportLaporanBarangKeluar($awal, $akhir))->download('Laporan-'.$akhir.'.xlsx');
        }
    }
}
