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
use Auth;
use Yajra\DataTables\Facades\DataTables;

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
                $data = StorageKeluarPemasok::where('pemasok_id',Auth::user()->pemasok_id)->with('user','pemasok','barang')->whereRaw('MONTH(waktu) = '.$bulan)->get();
                if ($data->count() < 1) {
                    return back()->with('error','Data Kosong !');
                }

                $pdf = PDF::loadview($this->pathPenjualan.'pdf',compact('data','awal','akhir','sumber','month'))->setPaper('DEFAULT_PDF_PAPER_SIZE', 'landscape')->setWarnings(false);
                set_time_limit('99999');
                return $pdf->stream('Laporan'.$sumber.$akhir.'.pdf');
                return view($this->pathPenjualan.'pdf',compact('data','awal','akhir','sumber','month'));

            } elseif ($awal != null && $akhir != null) {
                if ($akhir < $awal) {
                    return back()->with('failed','Mohon Periksa Tanggal Anda !');
                }
                $data = StorageKeluarPemasok::where('pemasok_id',Auth::user()->pemasok->id)->with('user','pemasok','barang')->whereBetween('waktu',[$awal, $akhir])->latest()->get();
                if ($data->count() < 1) {
                    return back()->with('error','Data Kosong !');
                }

                $pdf = PDF::loadview($this->pathPenjualan.'pdf',compact('data','awal','akhir','month'))->setPaper('DEFAULT_PDF_PAPER_SIZE', 'landscape')->setWarnings(false);
                set_time_limit('99999');
                return $pdf->stream('Laporan'.$akhir.'.pdf');
                return view($this->pathPenjualan.'pdf',compact('data','awal','akhir','month'));
            }
            $null  = StorageKeluarPemasok::where('pemasok_id',Auth::user()->pemasok->id)->get();
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
            if ($bulan != null && $month) {
                $data = StorageKeluarPemasok::where('pemasok_id',Auth::user()->pemasok_id)->with('user','pemasok','barang')->whereRaw('MONTH(waktu) = '.$hii)->get();
            } elseif ($awal != null && $akhir != null) {
                $data = StorageKeluarPemasok::where('pemasok_id',Auth::user()->pemasok_id)->whereBetween('waktu',[$awal, $akhir])->get();
            }
            if($data->count() < 1){
                return back()->with('failed','Data Kosong!');
            }
            $input = $request->all();
            set_time_limit(99999);
            return (new ExportLaporanPenjualanPemasok($data))->download('Laporan-'.$akhir.'.xlsx');
        }
    }
    public function showLaporanStok(Request $request)
    {
        if($request->ajax()){
            $data = Barang::orderBy('id', 'desc')
            ->where('pemasok_id',Auth::user()->pemasok_id)
            ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    return '<a href="/v1/bulky/laba-rugi/'.$data->id.'/edit" class="btn btn-primary btn-sm">Edit</a>&nbsp;<a href="#" class="btn btn-danger btn-sm" onclick="sweet('.$data->id.')">Hapus</a>';
                })
                ->editColumn('created_at',function($data){
                    return date('d-m-Y H:i:s', strtotime($data->created_at));
                })
                ->make(true);
        }
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
                $data = Barang::where('pemasok_id',Auth::user()->pemasok->id)->with('pemasok')->whereRaw('MONTH(created_at) = '.$bulan)->get();
                if ($data->count() < 1) {
                    return back()->with('error','Data Kosong !');
                }
                $pdf = PDF::loadview($this->pathStok.'pdf',compact('data','awal','akhir','sumber','month'))->setPaper('DEFAULT_PDF_PAPER_SIZE', 'landscape')->setWarnings(false);
                set_time_limit('99999');
                return $pdf->stream('Laporan'.$sumber.$akhir.'.pdf');
                return view($this->pathStok.'pdf',compact('data','awal','akhir','sumber','month'));

            } elseif ($awal != null && $akhir != null) {
                if ($akhir < $awal) {
                    return back()->with('failed','Mohon Periksa Tanggal Anda !');
                }
                $data = Barang::where('pemasok_id',Auth::user()->pemasok->id)->with('pemasok')->whereBetween('created_at',[$awal, $akhir])->latest()->get();
                if ($data->count() < 1) {
                    return back()->with('error','Data Kosong !');
                }
                $pdf = PDF::loadview($this->pathStok.'pdf',compact('data','awal','akhir','month'))->setPaper('DEFAULT_PDF_PAPER_SIZE', 'landscape')->setWarnings(false);
                set_time_limit('99999');
                return $pdf->stream('Laporan'.$akhir.'.pdf');
                return view($this->pathStok.'pdf',compact('data','awal','akhir','month'));
            }
            $null  = Barang::where('pemasok_id',Auth::user()->pemasok->id)->get();
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
            if ($bulan != null && $month) {
                $data = Barang::where('pemasok_id',Auth::user()->pemasok->id)->with('pemasok')->whereRaw('MONTH(created_at) = '.$hii)->get();
            } elseif ($awal != null && $akhir != null) {
                $data = Barang::where('pemasok_id',Auth::user()->pemasok->id)->whereBetween('created_at',[$awal, $akhir])->get();
            }
            if($data->count() < 1){
                return back()->with('failed','Data Kosong!');
            }
            $input = $request->all();
            set_time_limit(99999);
            return (new ExportLaporanStokPemasok($data))->download('Laporan-'.$akhir.'.xlsx');
        }
    }
}
