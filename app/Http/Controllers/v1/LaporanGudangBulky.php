<?php

namespace App\Http\Controllers\v1;


use App\Exports\ExportLaporanBarangBulky;
use App\Exports\ExportLaporanBarangKeluarBulky;
use App\Exports\ExportLaporanBarangMasukBulky;
use App\Exports\ExportLaporanPo;
use App\Http\Controllers\Controller;
use App\Models\GudangBulky;
use App\Models\Po;
use App\Models\PoItem;
use App\Models\StockBarangBulky;
use App\Models\StorageBulky;
use App\Models\StorageMasukBulky;
use App\Models\StorageKeluarBulky;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PDF;
use Auth;
use Yajra\DataTables\Facades\DataTables;

class LaporanGudangBulky extends Controller
{
    public function showLaporanBarangKeluar()
    {
        return view('app.laporan.gudang-bulky.barang-keluar.index');
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
                $data = StorageKeluarBulky::with('user','bulky','barangBulky')
                ->where('user_id',Auth::user()->id)
                ->whereRaw('MONTH(waktu) = '.$bulan)->get();

                if ($data->count() < 1) {
                    return back()->with('error','Tidak ada data !');
                }

                $pdf = PDF::loadview('app.laporan.gudang-bulky.barang-keluar.pdf',compact('data','awal','akhir','sumber','month'))->setPaper('DEFAULT_PDF_PAPER_SIZE', 'landscape')->setWarnings(false);
                set_time_limit('99999');
                return $pdf->stream('Laporan'.$sumber.$akhir.'.pdf');
                return view('app.laporan.gudang-bulky.barang-keluar.pdf',compact('data','awal','akhir','sumber','month'));
            } elseif ($awal != null && $akhir != null) {
                if ($akhir < $awal) {
                    return back()->with('failed','Mohon Periksa Tanggal Anda !');
                }

                $data = StorageKeluarBulky::with('user','bulky','barangBulky')
                ->where('user_id',Auth::user()->id)
                ->whereBetween('waktu',[$awal.' 00:00:00', $akhir.' 23:59:59'])
                ->latest()
                ->get();

                if ($data->count() < 1) {
                    return back()->with('error','Tidak ada data !');
                }

                $pdf = PDF::loadview('app.laporan.gudang-bulky.barang-keluar.pdf',compact('data','awal','akhir','month'))->setPaper('DEFAULT_PDF_PAPER_SIZE', 'landscape')->setWarnings(false);
                set_time_limit('99999');
                return $pdf->stream('Laporan'.$akhir.'.pdf');
                return view('app.laporan.gudang-bulky.barang-keluar.pdf',compact('data','awal','akhir','month'));
            }
            $null = StorageKeluarBulky::all();
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
            foreach(Auth::user()->pengurusGudangBulky->bulky as $gudang){
                $gudang_saya[] = $gudang->id;
            }
            if ($bulan != null && $month) {
                $data = StorageKeluarBulky::whereIn('bulky_id',$gudang_saya)->with('user','bulky','barangBulky')->whereRaw('MONTH(waktu) = '.$hii)->get();
            } elseif ($awal != null && $akhir != null) {
                $data = StorageKeluarBulky::whereIn('bulky_id',$gudang_saya)->with('user','bulky','barangBulky')->whereBetween('waktu',[$awal.' 00:00:00', $akhir.' 23:59:59'])->get();
            }
            if($data->count() < 1){
                return back()->with('failed','Data Kosong!');
            }
                $input = $request->all();
                set_time_limit(99999);
                return (new ExportLaporanBarangKeluarBulky($data))->download('Laporan-'.$akhir.'.xlsx');
        }
    }

    public function showLaporanBarangMasuk()
    {
        return view('app.laporan.gudang-bulky.barang-masuk.index');
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
            $awal = $request->awal;
            $akhir = $request->akhir;
            $month = $request->month;

            $null  = StorageMasukBulky::all();

            // if ($null->count() < 1) {
            //     return back()->with('error','Tidak ada data !');
            // }
            $gudang_saya = [];
            foreach(Auth::user()->pengurusGudangBulky->bulky as $gudang){
                $gudang_saya[] = $gudang->id;
            }

            // dd($gudang_saya);
            if ($request->month != null && $request->has('month')) {
                if ($request->month == null) {
                    return back()->with('error','Mohon Pilih Bulan !');
                }

                $dateObj = DateTime::createFromFormat('!m',$month);
                $sumber = 'Bulan '.$dateObj->format('F');
                $bulan = $request->input('month');
                $data = StorageMasukBulky::whereIn('bulky_id',$gudang_saya)->with('user','bulky','barang')->whereRaw('MONTH(waktu) = '.$bulan)->get();
                // dd($data, Auth::user()->pengurusGudangBulky->bulky);

                if ($data->count() < 1) {
                    return back()->with('error','Tidak ada data !');
                }

                $pdf = PDF::loadview('app.laporan.gudang-bulky.barang-masuk.pdf',compact('data','awal','akhir','sumber','month'))->setPaper('DEFAULT_PDF_PAPER_SIZE', 'landscape')->setWarnings(false);
                set_time_limit('99999');
                return $pdf->stream('Laporan'.$sumber.$akhir.'.pdf');
                return view('app.laporan.gudang-bulky.barang-masuk.pdf',compact('data','awal','akhir','sumber','month'));

            } elseif ($awal != null && $akhir != null) {
                if ($akhir < $awal) {
                    return back()->with('failed','Mohon Periksa Tanggal Anda !');
                }
                $data = StorageMasukBulky::whereIn('bulky_id',$gudang_saya)->with('user','bulky','barang')->whereBetween('waktu',[$awal.' 00:00:00', $akhir.' 23:59:59'])->latest()->get();
                // dd($data, Auth::user()->pengurusGudangBulky->bulky);

                if ($data->count() < 1) {
                    return back()->with('error','Tidak ada data !');
                }

                $pdf = PDF::loadview('app.laporan.gudang-bulky.barang-masuk.pdf',compact('data','awal','akhir','month'))->setPaper('DEFAULT_PDF_PAPER_SIZE', 'landscape')->setWarnings(false);
                set_time_limit('99999');
                return $pdf->stream('Laporan'.$akhir.'.pdf');
                return view('app.laporan.gudang-bulky.barang-masuk.pdf',compact('data','awal','akhir','month'));
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
            foreach(Auth::user()->pengurusGudangBulky->bulky as $gudang){
                $gudang_saya[] = $gudang->id;
            }
            if ($bulan != null && $month) {
                $data = StorageMasukBulky::whereIn('bulky_id',$gudang_saya)->with('user','bulky','barang')->whereRaw('MONTH(waktu) = '.$hii)->get();
            } elseif ($awal != null && $akhir != null) {
                $data = StorageMasukBulky::whereIn('bulky_id',$gudang_saya)->with('user','bulky','barang')->whereBetween('waktu',[$awal.' 00:00:00', $akhir.' 23:59:59'])->get();
            }

            if($data->count() < 1){
                return back()->with('failed','Data Kosong!');
            }

            $input = $request->all();
            set_time_limit(99999);
            return (new ExportLaporanBarangMasukBulky($data))->download('Laporan-'.$akhir.'.xlsx');
        }
    }

    // Laporan Barang
    public function showLaporanBarang(Request $request)
    {
        if($request->ajax()){
            $data = StockBarangBulky::with('barang.storageMasukBulky.storageBulky.tingkat.rak', 'bulky')
            ->whereHas('bulky.akunGudangBulky', function($query){
                $query->where('pengurus_bulky_id', auth()->user()->pengurus_gudang_bulky_id);
            })
            ->orderBy('id', 'desc')
            ->get();
            return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('created_at',function($data){
                return date('d-m-Y H:i:s', strtotime($data->created_at));
            })
            ->editColumn('gudang',function($data){
                return $data->bulky->nama;
            })
            ->editColumn('nama',function($data){
                return $data->barang->nama_barang;
            })
            ->make(true);
        }
        return view('app.laporan.gudang-bulky.barang.index');
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
        } else {
            return redirect()->back()->with('failed','Mohon Isi Bulan / Tanggal Terlebih Dahulu!');
        }

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        } else {

            $gudang_saya = [];
            foreach(Auth::user()->pengurusGudangBulky->bulky as $gudang){
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
                $data = StockBarangBulky::with('barang.storageMasukBulky.storageBulky.tingkat.rak', 'bulky')
                ->whereHas('bulky.akunGudangBulky', function($query){
                    $query->where('pengurus_bulky_id', auth()->user()->pengurus_gudang_bulky_id);
                })
                ->whereRaw('MONTH(created_at) = '.$bulan)
                ->orderBy('id', 'desc')
                ->get();

                if ($data->count() < 1) {
                    return back()->with('error','Tidak ada data !');
                }

                $pdf = PDF::loadview('app.laporan.gudang-bulky.barang.pdf',compact('data','awal','akhir','sumber','month'))->setPaper('DEFAULT_PDF_PAPER_SIZE', 'landscape')->setWarnings(false);
                set_time_limit('99999');
                return $pdf->stream('Laporan'.$sumber.$akhir.'.pdf');
                return view('app.laporan.gudang-bulky.barang.pdf',compact('data','awal','akhir','sumber','month'));
            } elseif ($awal != null && $akhir != null) {
                if ($akhir < $awal) {
                    return back()->with('failed','Mohon Periksa Tanggal Anda !');
                }

                $data = StorageBulky::whereHas('storageMasukBulky', function($q)use($gudang_saya){
                        $q->whereIn('bulky_id',$gudang_saya);
                    })->with('storageMasukBulky')->whereBetween('waktu',[$awal.' 00:00:00', $akhir.' 23:59:59'])->latest()->get();
                // dd($data);

                if ($data->count() < 1) {
                    return back()->with('error','Tidak ada data !');
                }

                $pdf = PDF::loadview('app.laporan.gudang-bulky.barang.pdf',compact('data','awal','akhir','month'))->setPaper('DEFAULT_PDF_PAPER_SIZE', 'landscape')->setWarnings(false);
                set_time_limit('99999');
                return $pdf->stream('Laporan'.$akhir.'.pdf');
                return view('app.laporan.gudang-bulky.barang.pdf',compact('data','awal','akhir','month'));
            }
            $null = StorageBulky::all();
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
            foreach(Auth::user()->pengurusGudangBulky->bulky as $gudang){
                $gudang_saya[] = $gudang->id;
            }
            if ($bulan != null && $month) {
                $data = StockBarangBulky::with('barang.storageMasukBulky.storageBulky.tingkat.rak', 'bulky')
                ->whereHas('bulky.akunGudangBulky', function($query){
                    $query->where('pengurus_bulky_id', auth()->user()->pengurus_gudang_bulky_id);
                })
                ->whereRaw('MONTH(created_at) = '.$bulan)
                ->orderBy('id', 'desc')
                ->get();
            } elseif ($awal != null && $akhir != null) {
                $data = StorageBulky::whereHas('storageMasukBulky', function($q)use($gudang_saya){
                        $q->whereIn('bulky_id', $gudang_saya);
                    })->whereBetween('waktu',[$awal.' 00:00:00', $akhir.' 23:59:59'])->get();
            }

            if($data->count() < 1){
                return back()->with('failed','Data Kosong!');
            }
                $input = $request->all();
                set_time_limit(99999);
                return (new ExportLaporanBarangBulky($data))->download('Laporan-'.$akhir.'.xlsx');
        }
    }
}
