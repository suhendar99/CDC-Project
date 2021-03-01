<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\BatasPiutang;
use App\Models\PengurusGudang;
use App\Models\StorageKeluarBulky;
use App\Models\SuratPiutangRetailBulky;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use PDF;

class SuratPiutangRetailBulkyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = SuratPiutangRetailBulky::with('pemesananBulky')
            ->where('user_id',Auth::user()->id)
            ->orderBy('id', 'desc')
            ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    return '<a href="/v1/piutang-retail-bulky/print?id='.$data->id.'" target="_blank" class="btn btn-primary btn-sm">Cetak PDF</a>';
                })
                ->addColumn('invoice', function($data){
                    return $data->pemesananBulky->nomor_pemesanan;
                })
                ->editColumn('created_at',function($data){
                    return date('d-m-Y H:i:s', strtotime($data->created_at));
                })
                ->rawColumns(['action','invoice'])
                ->make(true);
        }

        return view('app.data-master.storageBulky.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $id = $request->query('id');
        $data = StorageKeluarBulky::with('pemesananBulky.barangPesananBulky')->find($id);
        // dd($data->pemesananBulky->nama_pemesan);
        return view('app.data-master.storageBulky.piutang.index',compact('data','id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id = $request->id;
        $v = Validator::make($request->all(),[
            'pihak_pertama' => 'required|string|max:100',
            'pihak_kedua' => 'required|string|max:100',
            'tempat' => 'required|string|max:30',
            'keterangan' => 'nullable',
        ]);
        if ($v->fails()) {
            dd($v->errors()->all());
            return back()->withErrors($v)->withInput();
        } else {
            $storageKeluar = StorageKeluarBulky::with('pemesananBulky.barangPesananBulky')->find($id);
            SuratPiutangRetailBulky::create(array_merge($request->only('pihak_pertama','pihak_kedua','tempat','keterangan','jumlah_uang_digits','jumlah_uang_word'),[
                'kode' => rand(100000,999999),
                'pemesanan_bulky_id' => $storageKeluar->pemesananBulky->id,
                'storage_keluar_bulky_id' => $storageKeluar->id,
                'tanggal' => $storageKeluar->pemesananBulky->tanggal_pemesanan,
                'bulky_id' => Auth::user()->pengurusGudangBulky->id,
                'user_id' => Auth::user()->id,
            ]));
        }
        return redirect('/v1/bulky/storage')->with('success','Data Berhasil disimpan !');
    }

    public function printPdf(Request $request)
    {
        $day = BatasPiutang::find(1);
        $jatuhTempo = date('d-m-Y',strtotime('+'.$day->jumlah_hari.' day'));
        set_time_limit(120);
        $date = date('d F Y');
        $data = SuratPiutangRetailBulky::whereId($request->query('id'))->with('pemesananBulky.barangPesananBulky','pemesananBulky.piutangRetail','bulky')->first();
        $pengurus = PengurusGudang::where('nama',$data->pihak_kedua)->first();
        $counter = $data->count();
        $kode = sprintf("%'.04d", (String)$counter);
        $pdf = PDF::loadview('app.transaksi.surat-piutang.print_bulky', compact('data','date','kode','pengurus','day'));
        return $pdf->stream();

        // return view('app.transaksi.surat-jalan.print');
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
