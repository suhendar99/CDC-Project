<?php

namespace App\Http\Controllers\v1;

use App\Exports\ExportLabaRugiPemasok;
use App\Http\Controllers\Controller;
use App\Models\LabaRugiPemasok;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use PDF;

class LabaRugiPemasokController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = LabaRugiPemasok::orderBy('bulan', 'asc')
            ->where('pemasok_id',Auth::user()->pemasok_id)
            ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    return '<a href="/v1/bulky/laba-rugi-pemasok/'.$data->id.'/edit" class="btn btn-primary btn-sm">Edit</a>&nbsp;<a href="#" class="btn btn-danger btn-sm" onclick="sweet('.$data->id.')">Hapus</a>';
                })
                ->addColumn('laba_kotor', function($data){
                    return 'Rp. '.number_format($data->laba_kotor,0,',','.');
                })
                ->addColumn('penjualan', function($data){
                    return 'Rp. '.number_format($data->penjualan,0,',','.');
                })
                ->addColumn('pembelian', function($data){
                    return 'Rp. '.number_format($data->pembelian,0,',','.');
                })
                ->addColumn('biaya_operasional', function($data){
                    return 'Rp. '.number_format($data->biaya_operasional,0,',','.');
                })
                ->addColumn('laba_bersih', function($data){
                    return 'Rp. '.number_format($data->laba_bersih,0,',','.');return ;
                })
                ->addColumn('bulan', function($data){
                    if ($data->bulan == 1) {
                        return "Januari";
                    } elseif ($data->bulan == 2) {
                        return "Februari";
                    } elseif ($data->bulan == 3) {
                        return "maret";
                    } elseif ($data->bulan == 4) {
                        return "Aprili";
                    } elseif ($data->bulan == 5) {
                        return "Mei";
                    } elseif ($data->bulan == 6) {
                        return "Juni";
                    } elseif ($data->bulan == 7) {
                        return "Juli";
                    } elseif ($data->bulan == 8) {
                        return "Agustus";
                    } elseif ($data->bulan == 9) {
                        return "September";
                    } elseif ($data->bulan == 10) {
                        return "Oktober";
                    } elseif ($data->bulan == 11) {
                        return "November";
                    } elseif ($data->bulan == 12) {
                        return "Desember";
                    }
                })
                ->editColumn('created_at',function($data){
                    return date('d-m-Y H:i:s', strtotime($data->created_at));
                })
                ->rawColumns(['action','bulan','laba_kotor','penjualan','pembelian','biaya_operasional','laba_bersih'])
                ->make(true);
        }

        return view('app.transaksi.rekapitulasi.laba-rugi-pemasok.index');
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
                $data = LabaRugiPemasok::where('pemasok_id',Auth::user()->pemasok_id)
                ->where('bulan',$bulan)
                ->orderBy('id','desc')
                ->get();
                if ($data->count() < 1) {
                    return back()->with('error','Data Kosong !');
                }
                $pdf = PDF::loadview('app.transaksi.rekapitulasi.laba-rugi-pemasok.export.pdf',compact('data','sumber','month'))->setPaper('DEFAULT_PDF_PAPER_SIZE', 'landscape')->setWarnings(false);
                set_time_limit('99999');
                return $pdf->stream('Laporan-Piutang'.$dateObj->format('F').'.pdf');
                return view('app.transaksi.rekapitulasi.laba-rugi-pemasok.export.pdf',compact('data','sumber','month'));

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
        $data = LabaRugiPemasok::where('pemasok_id',Auth::user()->pemasok_id)
        ->where('bulan',$bulan)
        ->orderBy('id','desc')
        ->get();
        if($data->count() < 1){
            return back()->with('failed','Data Kosong!');
        }
        set_time_limit(99999);
        return (new ExportLabaRugiPemasok($data))->download('Rekapitulasi-Piutang-'.Carbon::now().'.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = LabaRugiPemasok::all();
        return view('app.transaksi.rekapitulasi.laba-rugi-pemasok.create',compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $v = Validator::make($request->all(),[
            'bulan' => 'required',
            'laba_kotor' => 'required|numeric',
            'penjualan' => 'required|numeric',
            'pembelian' => 'required|numeric',
            'biaya_operasional' => 'required|numeric',
            'laba_bersih' => 'required|numeric',
        ]);
        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        } else {
            if ($request->bulan == 0) {
                return back()->with('error','Mohon Pilih Bulan !');
            }
            $laba = LabaRugiPemasok::create($request->only('bulan','laba_kotor','penjualan','pembelian','biaya_operasional','laba_bersih')+['pemasok_id' => Auth::user()->pemasok_id]);
        }
        return redirect()->route('laba-rugi-pemasok.index')->with('success','Data Berhasil Di Tambahkan !');
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
        $data = LabaRugiPemasok::find($id);
        return view('app.transaksi.rekapitulasi.laba-rugi-pemasok.edit',compact('data'));
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
        $v = Validator::make($request->all(),[
            'bulan' => 'required',
            'laba_kotor' => 'required|numeric',
            'penjualan' => 'required|numeric',
            'pembelian' => 'required|numeric',
            'biaya_operasional' => 'required|numeric',
            'laba_bersih' => 'required|numeric',
        ]);
        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        } else {
            if ($request->bulan == 0) {
                return back()->with('error','Mohon Pilih Bulan !');
            }
            $laba = LabaRugiPemasok::find($id);

            $laba->update($request->only('bulan','laba_kotor','penjualan','pembelian','biaya_operasional','laba_bersih'));
        }
        return redirect()->route('laba-rugi-pemasok.index')->with('success','Data Berhasil Di Edit !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $laba = LabaRugiPemasok::find($id);
        $laba->delete();
    }
}
