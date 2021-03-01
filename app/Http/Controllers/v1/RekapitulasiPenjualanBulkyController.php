<?php

namespace App\Http\Controllers\v1;

use App\Exports\ExportRekapitulasiPenjualanBulky;
use App\Http\Controllers\Controller;
use App\Models\RekapitulasiPenjualanBulky;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use PDF;

class RekapitulasiPenjualanBulkyController extends Controller
{
    public function __construct()
    {
        $this->path = 'app.transaksi.rekapitulasi.penjualan-bulky.';
        $this->alert = 'Data berhasil ';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = RekapitulasiPenjualanBulky::with('storageKeluarBulky.suratPiutangRetail')
        ->whereHas('storageKeluarBulky.bulky.akunGudangBulky', function($query){
            $query->where('pengurus_bulky_id', auth()->user()->pengurus_gudang_bulky_id);
        })
        ->orderBy('id','desc')
        ->get();
        // dd($data);
        $total = $data->sum('total');
        if($request->ajax()){
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    return '<a href="/v1/rekapitulasiPembelian/'.$data->id.'/edit" class="btn btn-primary btn-sm">Edit</a>&nbsp;<a href="#" class="btn btn-danger btn-sm" onclick="sweet('.$data->id.')">Hapus</a>';
                })
                ->addColumn('jumlah', function($data){
                    return $data->jumlah.' '.$data->satuan;
                })
                ->editColumn('created_at',function($data){
                    return date('d-m-Y H:i:s', strtotime($data->created_at));
                })
                ->editColumn('no_kwitansi',function($data){
                    if ($data->no_kwitansi != null) {
                        return $data->no_kwitansi;
                    } else {
                        return $data->storageKeluarBulky->suratPiutangRetail[0]->kode;
                    }

                })
                ->rawColumns(['action','jumlah'])
                ->make(true);
        }
        return view('app.transaksi.rekapitulasi.penjualan-bulky.index', compact('total'));
    }

    public function downloadRekapitulasiPenjualanPdf(Request $request)
    {
        $v = Validator::make($request->all(),[
            'month' => 'required'
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        } else {
            $month = $request->month;
            if ($request->month != null && $request->has('month')) {
                if ($request->month == null) {
                    return back()->with('error','Mohon Pilih Bulan !');
                }
                $dateObj = DateTime::createFromFormat('!m',$month);
                $sumber = 'Bulan '.$dateObj->format('F');
                $bulan = $request->input('month');
                $data = RekapitulasiPenjualanBulky::with('storageKeluarBulky')
                        ->whereHas('storageKeluarBulky.bulky.akunGudangBulky', function($query){
                            $query->where('pengurus_bulky_id', auth()->user()->pengurus_gudang_bulky_id);
                        })
                        ->whereRaw('MONTH(tanggal_penjualan) = '.$bulan)
                        ->orderBy('id','desc')
                        ->get();
                if ($data->isEmpty()) {
                    return back()->with('failed','Data Kosong !');
                } else {
                    $pdf = PDF::loadview($this->path.'pdf',compact('data'))->setPaper('DEFAULT_PDF_PAPER_SIZE', 'landscape')->setWarnings(false);
                    set_time_limit(300);
                    return $pdf->stream('Rekapitulasi-Penjualan-'.Carbon::now());
                    return view($this->path.'pdf',compact('data'));
                }

            }
        }

    }

    public function downloadRekapitulasiPenjualanExcel(Request $request)
    {
        $v = Validator::make($request->all(),[
            'month' => 'required'
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        }
        if ($request->month == null) {
            return back()->with('error','Mohon Pilih Bulan !');
        }
        $bulan = $request->input('month');
        $data = RekapitulasiPenjualanBulky::with('storageKeluarBulky')
                ->whereHas('storageKeluarBulky.bulky.akunGudangBulky', function($query){
                    $query->where('pengurus_bulky_id', auth()->user()->pengurus_gudang_bulky_id);
                })
                ->whereRaw('MONTH(tanggal_penjualan) = '.$bulan)
                ->orderBy('id','desc')
                ->get();
        if($data->count() < 1){
            return back()->with('failed','Data Kosong!');
        }
        set_time_limit(99999);
        return (new ExportRekapitulasiPenjualanBulky($data))->download('Rekapitulasi-Penjualan-'.Carbon::now().'.xlsx');
    }
}
