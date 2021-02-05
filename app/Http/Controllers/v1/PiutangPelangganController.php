<?php

namespace App\Http\Controllers\v1;

use App\Exports\ExportPiutang;
use App\Http\Controllers\Controller;
use App\Models\Piutang;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use PDF;

class PiutangPelangganController extends Controller
{
    public function __construct()
    {
        $this->Data = new Piutang;

        $this->path = 'app.data-master.piutang-pelanggan.';
        $this->alert = 'Data Berhasil ';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = Piutang::with('pemesanan')->where('status','=',1)->orderBy('id','desc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('hutang', function($data){
                    return 'Rp '.number_format($data->hutang);
                })
                ->rawColumns(['hutang'])
                ->make(true);
        }
        return view($this->path.'index');
    }
    public function exportPdf()
    {
        $data = Piutang::where('status',1)->orderBy('jatuh_tempo','desc')->get();
        if ($data->isEmpty()) {
            return back()->with('failed','Data Kosong !');
        } else {
            $pdf = PDF::loadview('app.data-master.piutang.pdf',compact('data'))->setPaper('DEFAULT_PDF_PAPER_SIZE', 'landscape')->setWarnings(false);
            set_time_limit(300);
            return $pdf->stream('Data-Piutang-'.Carbon::now());
            return view('app.data-master.piutang.pdf',compact('data'));
        }
    }

    public function exportExcel()
    {
        $data = Piutang::where('status',1)->orderBy('jatuh_tempo','desc')->get();
        if($data->count() < 1){
            return back()->with('failed','Data Kosong!');
        }
        set_time_limit(99999);
        return (new ExportPiutang($data))->download('Data-Piutang-'.Carbon::now().'.xlsx');
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
