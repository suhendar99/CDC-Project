<?php

namespace App\Http\Controllers\v1;

use App\Exports\ExportRekapitulasiPembelianPelanggan;
use App\Http\Controllers\Controller;
use App\Models\RekapitulasiPembelianPelanggan;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use PDF;

class RekapitulasiPembelianPelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = RekapitulasiPembelianPelanggan::with('barangMasuk')
        ->whereHas('barangMasuk',function($q){
            $q->where('user_id',Auth::user()->id);
        })
        ->orderBy('id','desc')
        ->get();
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
                ->addColumn('hargas', function($data){
                    return 'Rp. '.number_format($data->harga,0,',','.');
                })
                ->addColumn('totals', function($data){
                    return 'Rp. '.number_format($data->total,0,',','.');
                })
                ->editColumn('created_at',function($data){
                    return date('d-m-Y H:i:s', strtotime($data->created_at));
                })
                ->rawColumns(['action','jumlah','hargas','totals'])
                ->make(true);
        }
        return view('app.transaksi.rekapitulasi.pembelianPelanggan.index',compact('total'));
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
                $data = RekapitulasiPembelianPelanggan::with('barangMasuk')
                ->whereHas('barangMasuk',function($q){
                    $q->where('user_id',Auth::user()->id);
                })
                ->whereRaw('MONTH(tanggal_pembelian) = '.$bulan)
                ->orderBy('id','desc')
                ->get();
                if ($data->count() < 1) {
                    return back()->with('error','Data Kosong !');
                }

                $pdf = PDF::loadview('app.transaksi.rekapitulasi.pembelianPelanggan.pdf',compact('data','sumber','month'))->setPaper('DEFAULT_PDF_PAPER_SIZE', 'landscape')->setWarnings(false);
                set_time_limit('99999');
                return $pdf->stream('Laporan-rekapitulasi.pdf');
                return view('app.transaksi.rekapitulasi.pembelianPelanggan.pdf',compact('data','sumber','month'));

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
        $data = RekapitulasiPembelianPelanggan::with('barangMasuk')
                ->whereHas('barangMasuk',function($q){
                    $q->where('user_id',Auth::user()->id);
                })
                ->whereRaw('MONTH(tanggal_pembelian) = '.$bulan)
                ->orderBy('id','desc')
                ->get();
        if($data->count() < 1){
            return back()->with('failed','Data Kosong!');
        }
        set_time_limit(99999);
        return (new ExportRekapitulasiPembelianPelanggan($data))->download('Rekapitulasi-pembelian-'.Carbon::now().'.xlsx');
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
