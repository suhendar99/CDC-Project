<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\Piutang;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PiutangController extends Controller
{
    public function __construct()
    {
        $this->Data = new Piutang;

        $this->path = 'app.data-master.piutang.';
        $this->alert = 'Data Berhasil ';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // foreach ($data as $key => $value) {
        //     foreach ($value->user as $u) {
        //         dd($u->email);
        //     }
        // }
        if($request->ajax()){
            $data = $this->Data->getData();
            return DataTables::of($data)
                ->addIndexColumn()
                // ->addColumn('action', function($data){
                //     return '<a href="/v1/piutang/'.$data->id.'/edit" class="btn btn-primary btn-sm">Edit</a>&nbsp;<a href="#" class="btn btn-danger btn-sm" onclick="sweet('.$data->id.')">Hapus</a>';
                // })
                ->addColumn('user', function($data){
                    if ($data->user->pengurus_gudang_id != null) {
                        return $data->user->pengurusGudang->nama;
                    } elseif ($data->user->pelanggan_id != null) {
                        return $data->user->pelanggan->nama;
                    }
                })
                ->addColumn('jumlah', function($data){
                    $totalPajak = 0;
					$totalDiskon = 0;
					$subtotalHarga = 0;
                    foreach ($data->po->po_item as $key => $value) {
                        $harga = $value->harga;
                        $jumlah = $value->jumlah;
                        $subtotal = $harga*$jumlah;
                        $diskon = $subtotal*$value->diskon/100;
                        $pajak = $subtotal*$value->pajak/100;

                        $totalPajak = $totalPajak + $pajak;
                        $totalDiskon = $totalDiskon + $diskon;
                        $subtotalHarga = $subtotalHarga + $subtotal;
                    }
                    $totHar = $subtotalHarga+$totalPajak;
                    $totalHarga = $totHar-$totalDiskon;
                    return 'Rp '.$totalHarga;
                })
                ->rawColumns(['user','jumlah'])
                ->make(true);
        }
        return view($this->path.'index');
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
