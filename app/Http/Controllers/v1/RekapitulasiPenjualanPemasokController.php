<?php

namespace App\Http\Controllers\v1;

use App\Exports\ExportRekapitulasiPenjualanPemasok;
use App\Http\Controllers\Controller;
use App\Models\RekapitulasiPenjualanPemasok;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $data = RekapitulasiPenjualanPemasok::with('storageKeluar')
        ->whereHas('storageKeluar',function($q){
            $q->where('pemasok_id',Auth::user()->pemasok_id);
        })
        ->orderBy('id','desc')->get();
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
                ->rawColumns(['action','jumlah'])
                ->make(true);
        }
        return view('app.transaksi.rekapitulasi.penjualan-pemasok.index',compact('total'));
    }

    public function printPdf()
    {
        $data = RekapitulasiPenjualanPemasok::all();
        if ($data->isEmpty()) {
            return back()->with('failed','Data Kosong !');
        } else {
            $pdf = PDF::loadview('app.transaksi.rekapitulasi.penjualan-pemasok.pdf',compact('data'))->setPaper('DEFAULT_PDF_PAPER_SIZE', 'landscape')->setWarnings(false);
            set_time_limit(300);
            return $pdf->stream('Rekapitulasi-Penjualan-'.Carbon::now());
            return view('app.transaksi.rekapitulasi.penjualan-pemasok.pdf',compact('data'));
        }
    }

    public function printExcel()
    {
        $data = RekapitulasiPenjualanPemasok::all();
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
