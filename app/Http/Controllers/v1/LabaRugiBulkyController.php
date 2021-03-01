<?php

namespace App\Http\Controllers\v1;

use App\Exports\ExportLabaRugiBulky;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;
use App\Models\LabaRugiBulky;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Auth;
use PDF;

class LabaRugiBulkyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = LabaRugiBulky::orderBy('bulan', 'asc')
            ->where('bulky_id',Auth::user()->pengurus_gudang_bulky_id)
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

        return view('app.transaksi.rekapitulasi.laba-rugi-bulky.index');
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
                $data = LabaRugiBulky::orderBy('bulan', 'asc')
                ->where('bulan',$bulan)
                ->where('bulky_id',Auth::user()->pengurus_gudang_bulky_id)
                ->get();
                if ($data->count() < 1) {
                    return back()->with('error','Data Kosong !');
                }
                $pdf = PDF::loadview('app.transaksi.rekapitulasi.laba-rugi-bulky.export.pdf',compact('data','sumber','month'))->setPaper('DEFAULT_PDF_PAPER_SIZE', 'landscape')->setWarnings(false);
                set_time_limit('99999');
                return $pdf->stream('Laporan-Piutang'.$dateObj->format('F').'.pdf');
                return view('app.transaksi.rekapitulasi.laba-rugi-bulky.export.pdf',compact('data','sumber','month'));

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
        $data = LabaRugiBulky::orderBy('bulan', 'asc')
        ->where('bulan',$bulan)
        ->where('bulky_id',Auth::user()->pengurus_gudang_bulky_id)
        ->get();
        if($data->count() < 1){
            return back()->with('failed','Data Kosong!');
        }
        set_time_limit(99999);
        return (new ExportLabaRugiBulky($data))->download('Rekapitulasi-Piutang-'.Carbon::now().'.xlsx');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = LabaRugiBulky::all();
        return view('app.transaksi.rekapitulasi.laba-rugi-bulky.create',compact('data'));
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
            'bulan' => 'required|integer|min:1|max:12',
            'laba_kotor' => 'required|integer|min:1',
            'penjualan' => 'required|integer|min:1',
            'pembelian' => 'required|integer|min:1',
            'biaya_operasional' => 'required|integer|min:1'
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        }

        $laba_bersih = $request->penjualan - ($request->pembelian + $request->biaya_operasional);

        LabaRugiBulky::create($request->only('bulan', 'laba_kotor', 'penjualan', 'pembelian', 'biaya_operasional')+[
            'laba_bersih' => $laba_bersih,
            'bulky_id' => Auth::user()->pengurus_gudang_bulky_id
        ]);

        return redirect(route('bulky.laba-rugi.index'))->with('success', __( 'Data Berhasil Dibuat' ));
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
        $data = LabaRugiBulky::findOrFail($id);

        return view('app.transaksi.rekapitulasi.laba-rugi-bulky.edit', compact('data'));
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
            'bulan' => 'required|integer|min:1|max:12',
            'laba_kotor' => 'required|integer|min:1',
            'penjualan' => 'required|integer|min:1',
            'pembelian' => 'required|integer|min:1',
            'biaya_operasional' => 'required|integer|min:1'
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        }

        $laba_bersih = $request->penjualan - ($request->pembelian + $request->biaya_operasional);

        LabaRugiBulky::findOrFail($id)->update($request->only('bulan', 'laba_kotor', 'penjualan', 'pembelian', 'biaya_operasional')+[
            'laba_bersih' => $laba_bersih
        ]);

        return redirect(route('bulky.laba-rugi.index'))->with('success', __( 'Data Berhasil Diedit' ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        LabaRugiBulky::findOrFail($id)->delete();

        return redirect(route('bulky.laba-rugi.index'))->with('success', __( 'Data Berhasil Dihapus' ));
    }
}
