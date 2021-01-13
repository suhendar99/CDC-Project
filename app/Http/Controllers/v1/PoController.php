<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Po;
use App\Models\PoItem;
use PDF;

class PoController extends Controller
{
    public function __construct()
    {
        $this->indexPath = 'app.transaksi.admin.po.';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Po $po)
    {
        $data = $po->with('po_item')->all();
        return view($this->indexPath.'index',compact($data));
    }

    public function print()
    {
        set_time_limit(120);
        $date = date('d-m-Y');
        $pajak = 5;
        $data = array(
            [
                'nama' => 'Beras Super Nganu',
                'jumlah' => 170,
                'harga' => 11500,
                'diskon' => 10,
                'satuan' => 'Kg'
            ],
            [
                'nama' => 'Mangga Super Nganu',
                'jumlah' => 230,
                'harga' => 12000,
                'diskon' => 20,
                'satuan' => 'Kg'
            ]
        );
        // PDF::;
        $pdf = PDF::loadview('app.transaksi.admin.po.print', compact('data','date','pajak'))->setOptions(['defaultFont' => 'poppins']);
        return $pdf->stream();
        return view($this->indexPath.'print', compact('data','date','pajak'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view($this->indexPath.'create');
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
            'pengirim_po' => 'required|string|max:50',
            'nama_pengirim' => 'required|string|max:50',
            'telepon_pengirim' => 'required|numeric',
            'email_pengirim' => 'required|email',

            'penerima_po' => 'required|string|max:50',
            'nama_penerima' => 'required|string|max:50',
            'telepon_penerima' => 'required|numeric',
            'email_penerima' => 'required|email',
            'alamat_penerima' => 'required',

            'nama_barang.*' => 'required|string|max:100',
            'satuan.*' => 'required|string|max:10',
            'jumlah.*' => 'required|numeric|min:1',
            'harga.*' => 'required|numeric',
            'diskon.*' => 'nullable|numeric',
            'pajak.*' => 'nullable|numeric',
        ]);
        // dd($request->all());

        if ($v->fails()) {
            // dd($v->errors()->all());
            // return back()->withErrors($v)->withInput();
            return back()->with('error','Pastikan Formulir diisi dengan lengkap!');
        }
        $date = date('Ymdhis');
        $kode = 'PO'.$date;

        $po = Po::create(array_merge($request->only('pengirim_po','nama_pengirim','telepon_pengirim','email_pengirim','penerima_po','nama_penerima','telepon_penerima','email_penerima','alamat_penerima'),[
            'kode_po' => $kode
        ]));

        $arrayLength = count($request->nama_barang);
        for ($i=0; $i < $arrayLength; $i++) { 
            PoItem::create([
                'po_id' => $po->id,
                'nama_barang' => $request->nama_barang[$i],
                'satuan' => $request->satuan[$i],
                'jumlah' => $request->jumlah[$i],
                'harga' => $request->harga[$i],
                'diskon' => $request->diskon[$i],
                'pajak' => $request->pajak[$i],
            ]);
        }

        // dd($po);
        return view($this->indexPath.'konfirmasiPo',compact($po->id));
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
