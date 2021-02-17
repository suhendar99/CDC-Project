<?php

namespace App\Http\Controllers\v1;

use App\Exports\ExportRekapitulasiPembelian;
use App\Http\Controllers\Controller;
use App\Models\Po;
use App\Models\RekapitulasiPembelian;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use PDF;

class RekapitulasiPembelianController extends Controller
{
    public function __construct()
    {
        $this->path = 'app.transaksi.rekapitulasi.pembelian.';
        $this->alert = 'Data berhasil ';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = RekapitulasiPembelian::with('storageIn')
        ->whereHas('storageIn',function($q){
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
                ->editColumn('created_at',function($data){
                    return date('d-m-Y H:i:s', strtotime($data->created_at));
                })
                ->rawColumns(['action','jumlah'])
                ->make(true);
        }

        return view($this->path.'index', compact('total'));
    }
    public function downloadRekapitulasiPembelianPdf()
    {
        $data = RekapitulasiPembelian::all();
        if ($data->isEmpty()) {
            return back()->with('failed','Data Kosong !');
        } else {
            $pdf = PDF::loadview($this->path.'pdf',compact('data'))->setPaper('DEFAULT_PDF_PAPER_SIZE', 'landscape')->setWarnings(false);
            set_time_limit(300);
            return $pdf->stream('Rekapitulasi-Pembelian-'.Carbon::now());
            return view($this->path.'pdf',compact('data'));
        }
    }

    public function downloadRekapitulasiPembelianExcel()
    {
        $data = RekapitulasiPembelian::all();
        if($data->count() < 1){
            return back()->with('failed','Data Kosong!');
        }
        set_time_limit(99999);
        return (new ExportRekapitulasiPembelian($data))->download('Rekapitulasi-Pembelian-'.Carbon::now().'.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $po = Po::all();
        return view($this->path.'create',compact('po'));
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
