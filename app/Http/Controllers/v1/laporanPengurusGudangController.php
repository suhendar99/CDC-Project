<?php

namespace App\Http\Controllers\v1;

use App\Exports\ExportLaporanBarangKeluar;
use App\Exports\ExportLaporanBarangMasuk;
use App\Exports\ExportLaporanPo;
use App\Http\Controllers\Controller;
use App\Models\Gudang;
use App\Models\Po;
use App\Models\PoItem;
use App\Models\StorageIn;
use App\Models\StorageOut;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PDF;

class laporanPengurusGudangController extends Controller
{
    public function __construct()
    {
        $this->path = 'app.laporan.pengurus-gudang.barang-masuk.';
        $this->pathKeluar = 'app.laporan.pengurus-gudang.barang-keluar.';
        $this->pathPo = 'app.laporan.pengurus-gudang.po.';
    }
    public function showLaporanBarangMasuk()
    {
        return view($this->path.'index');
    }
    public function LaporanBarangMasukPdf(Request $request)
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
                $data = StorageIn::with('user','gudang','barang')->whereRaw('MONTH(waktu) = '.$bulan)->get();

                $pdf = PDF::loadview($this->path.'pdf',compact('data','awal','akhir','sumber','month'))->setPaper('DEFAULT_PDF_PAPER_SIZE', 'landscape')->setWarnings(false);
                set_time_limit('99999');
                return $pdf->stream('Laporan'.$sumber.$akhir.'.pdf');
                return view($this->path.'pdf',compact('data','awal','akhir','sumber','month'));

            } elseif ($awal != null && $akhir != null) {
                if ($akhir < $awal) {
                    return back()->with('failed','Mohon Periksa Tanggal Anda !');
                }
                $data = StorageIn::with('user','gudang','barang')->whereBetween('waktu',[$awal, $akhir])->latest()->get();

                $pdf = PDF::loadview($this->path.'pdf',compact('data','awal','akhir','month'))->setPaper('DEFAULT_PDF_PAPER_SIZE', 'landscape')->setWarnings(false);
                set_time_limit('99999');
                return $pdf->stream('Laporan'.$akhir.'.pdf');
                return view($this->path.'pdf',compact('data','awal','akhir','month'));
            }
            $null  = StorageIn::all();
            if ($null == null) {
                return back()->with('error','Tidak ada data !');
            }
        }
    }
    public function LaporanBarangMasukExcel(Request $request)
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
            $data = StorageIn::all();
            if($data->count() < 1){
                return back()->with('failed','Data Kosong!');
            }
                $input = $request->all();
                set_time_limit(99999);
                return (new ExportLaporanBarangMasuk($awal, $akhir,$bulan,$month,$hii))->download('Laporan-'.$akhir.'.xlsx');
        }
    }
    public function showLaporanBarangKeluar()
    {
        return view($this->pathKeluar.'index');
    }
    public function LaporanBarangKeluarPdf(Request $request)
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
                $data = StorageOut::with('user','gudang','barang')->whereRaw('MONTH(waktu) = '.$bulan)->get();

                $pdf = PDF::loadview($this->pathKeluar.'pdf',compact('data','awal','akhir','sumber','month'))->setPaper('DEFAULT_PDF_PAPER_SIZE', 'landscape')->setWarnings(false);
                set_time_limit('99999');
                return $pdf->stream('Laporan'.$sumber.$akhir.'.pdf');
                return view($this->pathKeluar.'pdf',compact('data','awal','akhir','sumber','month'));
            } elseif ($awal != null && $akhir != null) {
                if ($akhir < $awal) {
                    return back()->with('failed','Mohon Periksa Tanggal Anda !');
                }
                $data = StorageOut::with('user','gudang','barang')->whereBetween('waktu',[$awal, $akhir])->latest()->get();

                $pdf = PDF::loadview($this->pathKeluar.'pdf',compact('data','awal','akhir','month'))->setPaper('DEFAULT_PDF_PAPER_SIZE', 'landscape')->setWarnings(false);
                set_time_limit('99999');
                return $pdf->stream('Laporan'.$akhir.'.pdf');
                return view($this->pathKeluar.'pdf',compact('data','awal','akhir','month'));
            }
            $null = StorageOut::all();
            if ($null == null) {
                return back()->with('error','Tidak ada data !');
            }
        }
    }
    public function LaporanBarangKeluarExcel(Request $request)
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
            $data = StorageOut::all();
            if($data->count() < 1){
                return back()->with('failed','Data Kosong!');
            }
                $input = $request->all();
                set_time_limit(99999);
                return (new ExportLaporanBarangKeluar($awal,$akhir,$bulan,$month,$hii))->download('Laporan-'.$akhir.'.xlsx');
        }
    }
    public function showLaporanPo()
    {
        return view($this->pathPo.'index');
    }
    public function LaporanPoPdf(Request $request)
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
                $data = Po::with('po_item','gudang','piutang')->whereRaw('MONTH(created_at) = '.$bulan)->get();

                $pdf = PDF::loadview($this->pathPo.'pdf',compact('data','awal','akhir','sumber','month'))->setPaper('DEFAULT_PDF_PAPER_SIZE', 'landscape')->setWarnings(false);
                set_time_limit('99999');
                return $pdf->stream('Laporan'.$sumber.$akhir.'.pdf');
                return view($this->pathPo.'pdf',compact('data','awal','akhir','sumber','month'));
            } elseif ($awal != null && $akhir != null) {
                if ($akhir < $awal) {
                    return back()->with('failed','Mohon Periksa Tanggal Anda !');
                }
                $data = Po::with('po_item','gudang','piutang')->whereBetween('created_at',[$awal, $akhir])->latest()->get();
                $item = PoItem::with('po')->get();
                $date = date('d-m-Y');
                $barang = Gudang::all();

                $pdf = PDF::loadview($this->pathPo.'pdf',compact('data','date','item','awal','akhir','month'))->setPaper('DEFAULT_PDF_PAPER_SIZE', 'landscape')->setWarnings(false);
                set_time_limit('99999');
                return $pdf->stream('Laporan'.$akhir.'.pdf');
                return view($this->pathPo.'pdf',compact('data','date','item','awal','akhir','month'));
            }
            $null = Po::all();
            if ($null == null) {
                return back()->with('error','Tidak ada data !');
            }
        }
    }

    public function LaporanPoExcel(Request $request)
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
            if ($akhir < $awal) {
                return back()->with('failed','Mohon Perikas Tanggal Anda !');
            }
            $data = Po::all();
            $item = PoItem::with('po')->get();
            $date = date('d-m-Y');
            if($data->count() < 1){
                return back()->with('failed','Data Kosong!');
            }
                $input = $request->all();
                set_time_limit(99999);
                return (new ExportLaporanPo($awal, $akhir,$date,$item,$bulan,$month,$hii))->download('Laporan-'.$akhir.'.xlsx');
        }
    }
}
