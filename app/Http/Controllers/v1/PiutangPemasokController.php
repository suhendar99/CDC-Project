<?php

namespace App\Http\Controllers\v1;

use App\Exports\ExportPiutangBulky;
use App\Http\Controllers\Controller;
use App\Models\PiutangBulky;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use PDF;

class PiutangPemasokController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = PiutangBulky::with('pemesananKeluarBulky.bulky')
            ->whereHas('pemesananKeluarBulky.bulky',function($q){
                $q->where('user_id',Auth::user()->id);
            })
            ->where('status','=',0)
            ->orderBy('id','desc')
            ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('hutang', function($data){
                    return 'Rp '.number_format($data->hutang);
                })
                ->editColumn('tanggal',function($data){
                    return date('d-m-Y', strtotime($data->tanggal));
                })
                ->addColumn('status', function($data){
                    if ($data->status == 1) {
                        return '<span class="badge badge-success">Sudah Dibayar</span>';
                    } else {
                        return '<span class="badge badge-danger">Belum Dibayar</span>';
                    }
                })
                ->editColumn('jatuh_tempo',function($data){
                    return date('d-m-Y', strtotime($data->jatuh_tempo));
                })
                ->rawColumns(['hutang','status'])
                ->make(true);
        }
        return view('app.data-master.piutang-bulky.keluar-pemasok.index');
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
                $data = PiutangBulky::with('pemesananKeluarBulky.bulky')
                ->whereHas('pemesananKeluarBulky.bulky',function($q){
                    $q->where('user_id',Auth::user()->id);
                })
                ->whereRaw('MONTH(tanggal) = '.$bulan)
                ->where('status','=',0)
                ->orderBy('id','desc')
                ->get();
                if ($data->count() < 1) {
                    return back()->with('error','Data Kosong !');
                }
                $pdf = PDF::loadview('app.data-master.piutang-bulky.keluar-pemasok.pdf',compact('data','sumber','month'))->setPaper('DEFAULT_PDF_PAPER_SIZE', 'landscape')->setWarnings(false);
                set_time_limit('99999');
                return $pdf->stream('Laporan-Piutang'.$dateObj->format('F').'.pdf');
                return view('app.data-master.piutang-bulky.keluar-pemasok.pdf',compact('data','sumber','month'));

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
        $data = PiutangBulky::with('pemesananKeluarBulky.bulky')
        ->whereHas('pemesananKeluarBulky.bulky',function($q){
            $q->where('user_id',Auth::user()->id);
        })
        ->whereRaw('MONTH(tanggal) = '.$bulan)
        ->where('status','=',0)
        ->orderBy('id','desc')
        ->get();
        if($data->count() < 1){
            return back()->with('failed','Data Kosong!');
        }
        set_time_limit(99999);
        return (new ExportPiutangBulky($data))->download('Rekapitulasi-Piutang-'.Carbon::now().'.xlsx');
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
