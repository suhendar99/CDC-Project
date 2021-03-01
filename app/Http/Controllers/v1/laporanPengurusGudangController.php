<?php

namespace App\Http\Controllers\v1;

use App\Exports\ExportLaporanBarang;
use App\Exports\ExportLaporanBarangKeluar;
use App\Exports\ExportLaporanBarangMasuk;
use App\Exports\ExportLaporanPo;
use App\Http\Controllers\Controller;
use App\Models\Gudang;
use App\Models\Po;
use App\Models\PoItem;
use App\Models\Storage;
use App\Models\StorageIn;
use App\Models\StorageOut;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PDF;
use Auth;

class laporanPengurusGudangController extends Controller
{
    public function __construct()
    {
        $this->path = 'app.laporan.pengurus-gudang.barang-masuk.';
        $this->pathKeluar = 'app.laporan.pengurus-gudang.barang-keluar.';
        $this->pathStorage = 'app.laporan.pengurus-gudang.barang.';
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
        } else {
            return redirect()->back()->with('failed','Mohon Isi Bulan / Tanggal Terlebih Dahulu!');
        }

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        } else {
            $gudang_saya = [];
            foreach(Auth::user()->pengurusGudang->gudang as $gudang){
                $gudang_saya[] = $gudang->id;
            }


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
                $data = StorageIn::whereIn('gudang_id',$gudang_saya)->with('user','gudang','barangBulky')->whereRaw('MONTH(waktu) = '.$bulan)->get();

                if ($data->count() < 1) {
                    return back()->with('error','Data Kosong !');
                }
                $pdf = PDF::loadview($this->path.'pdf',compact('data','awal','akhir','sumber','month'))->setPaper('DEFAULT_PDF_PAPER_SIZE', 'landscape')->setWarnings(false);
                set_time_limit('99999');
                return $pdf->stream('Laporan'.$sumber.$akhir.'.pdf');
                return view($this->path.'pdf',compact('data','awal','akhir','sumber','month'));

            } elseif ($awal != null && $akhir != null) {
                if ($akhir < $awal) {
                    return back()->with('failed','Mohon Periksa Tanggal Anda !');
                }
                $data = StorageIn::whereIn('gudang_id',$gudang_saya)->with('user','gudang','barangBulky')->whereBetween('waktu',[$awal, $akhir])->latest()->get();
                // dd($data);
                if ($data->count() < 1) {
                    return back()->with('error','Data Kosong !');
                }
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
        } else {
            return redirect()->back()->with('failed','Mohon Isi Bulan / Tanggal Terlebih Dahulu!');
        }

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        } else {
            $awal = $request->awal;
            $akhir = $request->akhir;
            $bulan = $request->month;
            $month = $request->has('month');
            $hii = $request->input('month');
            $gudang_saya = [];
            foreach(Auth::user()->pengurusGudang->gudang as $gudang){
                $gudang_saya[] = $gudang->id;
            }
            if ($bulan != null && $month) {
                $data = StorageIn::whereIn('gudang_id',$gudang_saya)->with('user','gudang','barangBulky')->whereRaw('MONTH(waktu) = '.$hii)->get();
            } elseif ($awal != null && $akhir != null) {
                $data = StorageIn::whereIn('gudang_id',$gudang_saya)->whereBetween('waktu',[$awal, $akhir])->get();
            }
            if($data->count() < 1){
                return back()->with('failed','Data Kosong!');
            }
            $input = $request->all();
            set_time_limit(99999);
            return (new ExportLaporanBarangMasuk($data))->download('Laporan-'.$akhir.'.xlsx');
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
        } else {
            return redirect()->back()->with('failed','Mohon Isi Bulan / Tanggal Terlebih Dahulu!');
        }

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        } else {
            // dd(Auth::user()->pengurusGudang->gudang);
            $gudang_saya = [];
            foreach(Auth::user()->pengurusGudang->gudang as $gudang){
                $gudang_saya[] = $gudang->id;
            }

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
                $data = StorageOut::whereIn('gudang_id',$gudang_saya)->with('user','gudang','stockBarangRetail')->whereRaw('MONTH(waktu) = '.$bulan)->get();
                if ($data->count() < 1) {
                    return back()->with('error','Data Kosong !');
                }

                $pdf = PDF::loadview($this->pathKeluar.'pdf',compact('data','awal','akhir','sumber','month'))->setPaper('DEFAULT_PDF_PAPER_SIZE', 'landscape')->setWarnings(false);
                set_time_limit('99999');
                return $pdf->stream('Laporan'.$sumber.$akhir.'.pdf');
                return view($this->pathKeluar.'pdf',compact('data','awal','akhir','sumber','month'));
            } elseif ($awal != null && $akhir != null) {
                if ($akhir < $awal) {
                    return back()->with('failed','Mohon Periksa Tanggal Anda !');
                }
                $data = StorageOut::whereIn('gudang_id',$gudang_saya)->with('user','gudang','stockBarangRetail')->whereBetween('waktu',[$awal, $akhir])->latest()->get();

                if ($data->count() < 1) {
                    return back()->with('error','Data Kosong !');
                }
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
        } else {
            return redirect()->back()->with('failed','Mohon Isi Bulan / Tanggal Terlebih Dahulu!');
        }

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        } else {
            $awal = $request->awal;
            $akhir = $request->akhir;
            $bulan = $request->month;
            $month = $request->has('month');
            $hii = $request->input('month');
            $gudang_saya = [];
            foreach(Auth::user()->pengurusGudang->gudang as $gudang){
                $gudang_saya[] = $gudang->id;
            }
            if ($bulan != null && $month) {
                $data = StorageOut::whereIn('gudang_id',$gudang_saya)->with('user','gudang','barang')->whereRaw('MONTH(waktu) = '.$hii)->get();
            } elseif ($awal != null && $akhir != null) {
                $data = StorageOut::whereIn('gudang_id',$gudang_saya)->whereBetween('waktu',[$awal, $akhir])->get();
            }
            if($data->count() < 1){
                return back()->with('failed','Data Kosong!');
            }
            $input = $request->all();
            set_time_limit(99999);
            return (new ExportLaporanBarangKeluar($data))->download('Laporan-'.$akhir.'.xlsx');
        }
    }
    public function showLaporanBarang()
    {
        return view($this->pathStorage.'index');
    }
    public function LaporanBarangPdf(Request $request)
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
        }  else {
            return redirect()->back()->with('failed','Mohon Pilih Bulan / Tanggal Terlebih Dahulu!');
        }

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        } else {
            $gudang_saya = [];
            foreach(Auth::user()->pengurusGudang->gudang as $gudang){
                $gudang_saya[] = $gudang->id;
            }

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
                $data = Storage::whereHas('storageIn', function($q)use($gudang_saya){
                        $q->whereIn('gudang_id',$gudang_saya);
                    })->with('storageIn.gudang','stockBarangRetail')->whereRaw('MONTH(waktu) = '.$bulan)->get();
                // dd($data);
                if ($data->count() < 1) {
                    return back()->with('error','Data Kosong !');
                }
                $pdf = PDF::loadview($this->pathStorage.'pdf',compact('data','awal','akhir','sumber','month'))->setPaper('DEFAULT_PDF_PAPER_SIZE', 'landscape')->setWarnings(false);
                set_time_limit('99999');
                return $pdf->stream('Laporan'.$sumber.$akhir.'.pdf');
                return view($this->pathStorage.'pdf',compact('data','awal','akhir','sumber','month'));
            } elseif ($awal != null && $akhir != null) {
                if ($akhir < $awal) {
                    return back()->with('failed','Mohon Periksa Tanggal Anda !');
                }
                $data = Storage::whereHas('storageIn', function($q)use($gudang_saya){
                        $q->whereIn('gudang_id',$gudang_saya);
                    })->with('storageIn.gudang','stockBarangRetail')->whereBetween('waktu',[$awal, $akhir])->latest()->get();
                // dd($data);
                if ($data->count() < 1) {
                    return back()->with('error','Data Kosong !');
                }
                $pdf = PDF::loadview($this->pathStorage.'pdf',compact('data','awal','akhir','month'))->setPaper('DEFAULT_PDF_PAPER_SIZE', 'landscape')->setWarnings(false);
                set_time_limit('99999');
                return $pdf->stream('Laporan'.$akhir.'.pdf');
                return view($this->pathStorage.'pdf',compact('data','awal','akhir','month'));
            }
            $null = Storage::all();
            if ($null == null) {
                return back()->with('error','Tidak ada data !');
            }
        }
    }
    public function LaporanBarangExcel(Request $request)
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
        } else {
            return redirect()->back()->with('failed','Mohon Pilih Bulan / Tanggal Terlebih Dahulu!');
        }

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        } else {
            $awal = $request->awal;
            $akhir = $request->akhir;
            $bulan = $request->month;
            $month = $request->has('month');
            $hii = $request->input('month');
            $gudang_saya = [];
            foreach(Auth::user()->pengurusGudang->gudang as $gudang){
                $gudang_saya[] = $gudang->id;
            }
            if ($bulan != null && $month) {
                $data = Storage::whereHas('storageIn', function($q)use($gudang_saya){
                    $q->whereIn('gudang_id',$gudang_saya);
                })->with('storageIn')->whereRaw('MONTH(waktu) = '.$hii)->get();
            } elseif ($awal != null && $akhir != null) {
                $data = Storage::whereHas('storageIn', function($q)use($gudang_saya){
                    $q->whereIn('gudang_id',$gudang_saya);
                })->whereBetween('waktu',[$awal, $akhir])->get();
            }
            if($data->count() < 1){
                return back()->with('failed','Data Kosong!');
            }
                $input = $request->all();
                set_time_limit(99999);
                return (new ExportLaporanBarang($data))->download('Laporan-'.$akhir.'.xlsx');
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
        } else {
            return redirect()->back()->with('failed','Mohon Isi Bulan / Tanggal Terlebih Dahulu!');
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
        } else {
            return redirect()->back()->with('failed','Mohon Isi Bulan / Tanggal Terlebih Dahulu!');
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
