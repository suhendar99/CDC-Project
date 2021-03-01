<?php

namespace App\Http\Controllers\v1;

use App\Exports\ExportRekapitulasiPenjualanPemasok;
use App\Http\Controllers\Controller;
use App\Models\RekapitulasiPenjualanPemasok;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use PDF;

class RekapitulasiPenjualanPemasokController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = RekapitulasiPenjualanPemasok::with('storageKeluar.suratPiutangBulkyPemasok')
        ->whereHas('storageKeluar',function($q){
            $q->where('pemasok_id',Auth::user()->pemasok_id);
        })
        ->orderBy('id','desc')->get();
        // dd($data[0]->storageKeluar->suratPiutangBulkyPemasok[0]->kode);
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
                ->addColumn('no_kwitansi', function($data){
                    if ($data->no_kwitansi != null) {
                        return $data->no_kwitansi;
                    } else {
                        return $data->storageKeluar->suratPiutangBulkyPemasok[0]->kode;
                    }
                })
                ->editColumn('created_at',function($data){
                    return date('d-m-Y H:i:s', strtotime($data->created_at));
                })
                ->rawColumns(['action','jumlah'])
                ->make(true);
        }
        return view('app.transaksi.rekapitulasi.penjualan-pemasok.index',compact('total'));
    }

    public function printPdf(Request $request)
    {
        $v = Validator::make($request->all(),[
            'month' => 'required'
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        } else{
            $month = $request->month;
            if ($request->month != null && $request->has('month')) {
                if ($request->month == null) {
                    return back()->with('error','Mohon Pilih Bulan !');
                }
                $dateObj = DateTime::createFromFormat('!m',$month);
                $sumber = 'Bulan '.$dateObj->format('F');
                $bulan = $request->input('month');
                $data = RekapitulasiPenjualanPemasok::with('storageKeluar')
                ->whereHas('storageKeluar',function($q){
                    $q->where('pemasok_id',Auth::user()->pemasok_id);
                })
                ->whereRaw('MONTH(tanggal_penjualan) = '.$bulan)
                ->orderBy('id','desc')->get();

                $pdf = PDF::loadview('app.transaksi.rekapitulasi.penjualan-pemasok.pdf',compact('data','sumber','month'))->setPaper('DEFAULT_PDF_PAPER_SIZE', 'landscape')->setWarnings(false);
                set_time_limit('99999');
                return $pdf->stream('Laporan-rekapitulasi.pdf');
                return view('app.transaksi.rekapitulasi.penjualan-pemasok.pdf',compact('data','sumber','month'));

            }
        }
    }

    public function printExcel(Request $request)
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
        $data = RekapitulasiPenjualanPemasok::with('storageKeluar')
                ->whereHas('storageKeluar',function($q){
                    $q->where('pemasok_id',Auth::user()->pemasok_id);
                })
                ->whereRaw('MONTH(tanggal_penjualan) = '.$bulan)
                ->orderBy('id','desc')->get();
        if($data->count() < 1){
            return back()->with('failed','Data Kosong!');
        }
        set_time_limit(99999);
        return (new ExportRekapitulasiPenjualanPemasok($data))->download('Rekapitulasi-Penjualan-'.Carbon::now().'.xlsx');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
