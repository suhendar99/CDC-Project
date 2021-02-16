<?php

namespace App\Http\Controllers\v1;

use App\Exports\ExportLaporanPenjualanPemasok;
use App\Exports\ExportLaporanStokPemasok;
use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\StorageKeluarPemasok;
use DateTime;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LaporanPemasokController extends Controller
{
    public function __construct()
    {
        $this->pathPenjualan = 'app.laporan.pemasok.penjualan.';
        $this->pathStok = 'app.laporan.pemasok.stok.';
    }
    public function showLaporanPenjualan()
    {
        return view($this->pathPenjualan.'index');
    }
    public function LaporanPenjualanPdf(Request $request)
    {
        if ($request->month != null && $request->has('month')) {
            $v = Validator::make($request->all(),[
                'month' => 'required'
            ]);
        } elseif ($request->awal != null && $request->akhir != null) {
            $v = Validator::make($request->all(),[
                'awal' => 'required',
                'akhir' => 'required'
            ]);
        }

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        } else {
            $awal = $request->awal;
            $akhir = $request->akhir;
            $month = $request->month;
            if ($request->month != null && $request->has('month')) {
                if ($request->month == null) {
                    return back()->with('error','Mohon Pilih Bulan !');
                }
                $dateObj = DateTime::createFromFormat('!m',$month);
                $sumber = 'Bulan '.$dateObj->format('F');
                $bulan = $request->input('month');
                $data = StorageKeluarPemasok::with('user','pemasok','barang')->whereRaw('MONTH(waktu) = '.$bulan)->get();

                $pdf = PDF::loadview($this->pathPenjualan.'pdf',compact('data','awal','akhir','sumber','month'))->setPaper('DEFAULT_PDF_PAPER_SIZE', 'landscape')->setWarnings(false);
                set_time_limit('99999');
                return $pdf->stream('Laporan'.$sumber.$akhir.'.pdf');
                return view($this->pathPenjualan.'pdf',compact('data','awal','akhir','sumber','month'));

            } elseif ($awal != null && $akhir != null) {
                if ($akhir < $awal) {
                    return back()->with('failed','Mohon Periksa Tanggal Anda !');
                }
                $data = StorageKeluarPemasok::with('user','pemasok','barang')->whereBetween('waktu',[$awal, $akhir])->latest()->get();

                $pdf = PDF::loadview($this->pathPenjualan.'pdf',compact('data','awal','akhir','month'))->setPaper('DEFAULT_PDF_PAPER_SIZE', 'landscape')->setWarnings(false);
                set_time_limit('99999');
                return $pdf->stream('Laporan'.$akhir.'.pdf');
                return view($this->pathPenjualan.'pdf',compact('data','awal','akhir','month'));
            }
            $null  = StorageKeluarPemasok::all();
            if ($null == null) {
                return back()->with('error','Tidak ada data !');
            }
        }
    }
    public function LaporanPenjualanExcel(Request $request)
    {
        if ($request->month != null && $request->has('month')) {
            $v = Validator::make($request->all(),[
                'month' => 'required'
            ]);
        } elseif ($request->awal != null && $request->akhir != null) {
            $v = Validator::make($request->all(),[
                'awal' => 'required',
                'akhir' => 'required'
            ]);
        }

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        } else {
            $awal = $request->awal;
            $akhir = $request->akhir;
            $bulan = $request->month;
            $month = $request->has('month');
            $hii = $request->input('month');
            $data = StorageKeluarPemasok::all();
            if($data->count() < 1){
                return back()->with('failed','Data Kosong!');
            }
                $input = $request->all();
                set_time_limit(99999);
                return (new ExportLaporanPenjualanPemasok($awal, $akhir,$bulan,$month,$hii))->download('Laporan-'.$akhir.'.xlsx');
        }
    }
    public function showLaporanStok()
    {
        return view($this->pathStok.'index');
    }
    public function LaporanStokPdf(Request $request)
    {
        if ($request->month != null && $request->has('month')) {
            $v = Validator::make($request->all(),[
                'month' => 'required'
            ]);
        } elseif ($request->awal != null && $request->akhir != null) {
            $v = Validator::make($request->all(),[
                'awal' => 'required',
                'akhir' => 'required'
            ]);
        }

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        } else {
            $awal = $request->awal;
            $akhir = $request->akhir;
            $month = $request->month;
            if ($request->month != null && $request->has('month')) {
                if ($request->month == null) {
                    return back()->with('error','Mohon Pilih Bulan !');
                }
                $dateObj = DateTime::createFromFormat('!m',$month);
                $sumber = 'Bulan '.$dateObj->format('F');
                $bulan = $request->input('month');
                $data = Barang::with('pemasok')->whereRaw('MONTH(created_at) = '.$bulan)->get();

                $pdf = PDF::loadview($this->pathStok.'pdf',compact('data','awal','akhir','sumber','month'))->setPaper('DEFAULT_PDF_PAPER_SIZE', 'landscape')->setWarnings(false);
                set_time_limit('99999');
                return $pdf->stream('Laporan'.$sumber.$akhir.'.pdf');
                return view($this->pathStok.'pdf',compact('data','awal','akhir','sumber','month'));

            } elseif ($awal != null && $akhir != null) {
                if ($akhir < $awal) {
                    return back()->with('failed','Mohon Periksa Tanggal Anda !');
                }
                $data = Barang::with('pemasok')->whereBetween('created_at',[$awal, $akhir])->latest()->get();

                $pdf = PDF::loadview($this->pathStok.'pdf',compact('data','awal','akhir','month'))->setPaper('DEFAULT_PDF_PAPER_SIZE', 'landscape')->setWarnings(false);
                set_time_limit('99999');
                return $pdf->stream('Laporan'.$akhir.'.pdf');
                return view($this->pathStok.'pdf',compact('data','awal','akhir','month'));
            }
            $null  = Barang::all();
            if ($null == null) {
                return back()->with('error','Tidak ada data !');
            }
        }
    }
    public function LaporanStokExcel(Request $request)
    {
        if ($request->month != null && $request->has('month')) {
            $v = Validator::make($request->all(),[
                'month' => 'required'
            ]);
        } elseif ($request->awal != null && $request->akhir != null) {
            $v = Validator::make($request->all(),[
                'awal' => 'required',
                'akhir' => 'required'
            ]);
        }

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        } else {
            $awal = $request->awal;
            $akhir = $request->akhir;
            $bulan = $request->month;
            $month = $request->has('month');
            $hii = $request->input('month');
            $data = Barang::all();
            if($data->count() < 1){
                return back()->with('failed','Data Kosong!');
            }
                $input = $request->all();
                set_time_limit(99999);
                return (new ExportLaporanStokPemasok($awal, $akhir,$bulan,$month,$hii))->download('Laporan-'.$akhir.'.xlsx');
        }
    }
}
