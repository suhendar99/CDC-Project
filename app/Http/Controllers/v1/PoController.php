<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Validation\Rule;
use App\Models\Po;
use App\Models\PoItem;
use App\Models\Bank;
use App\User;
use Auth;
use PDF;

class PoController extends Controller
{
    public function __construct()
    {
        $this->indexPath = 'app.transaksi.gudang.po.';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Po $po)
    {
        $user = User::where('id',Auth::user()->id)->with('gudang')->first();
        $arrayGudang = [];
        foreach ($user->gudang as $key => $value) {
            $arrayGudang[] = $value->id;
        }
        $data = $po->whereIn('gudang_id',$arrayGudang)->with('po_item')->get();
        return view($this->indexPath.'index',compact('data'));
    }

    public function print($id)
    {
        set_time_limit(120);
        $date = date('d-m-Y');
        $data = Po::where('id',$id)->with('po_item')->first();
        // PDF::;
        $pdf = PDF::loadview('app.transaksi.gudang.po.print', compact('data','date'))->setOptions(['defaultFont' => 'poppins']);
        return $pdf->stream();
        // return view($this->indexPath.'print', compact('data','date'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Bank $bank)
    {
        $user = User::where('id',Auth::user()->id)->with('gudang')->first();
        $count = $user->gudang->count();
        if($count < 1){
            return back()->with('error','Anda Belum Memiliki Gudang!');
        } else {
            // $bank = $bank->all();
            return view($this->indexPath.'create');
        }
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
            // 'pengirim_po' => 'required|string|max:50',
            // 'nama_pengirim' => 'required|string|max:50',
            // 'telepon_pengirim' => 'required|numeric',
            // 'email_pengirim' => 'required|email',
            'gudang_id' => 'required',
            'bank_id' => 'nullable',
            'penerima_po' => 'required|string|max:50',
            'nama_penerima' => 'required|string|max:50',
            'telepon_penerima' => 'required|numeric',
            'email_penerima' => 'required|email',
            'alamat_penerima' => 'required',
            'pembayaran' => 'required',
            'metode_pembayaran' => 'required_if:pembayaran,now',

            'nama_barang.*' => 'required|string|max:100',
            'satuan.*' => 'required|string|max:10',
            'jumlah.*' => 'required|numeric|min:1',
            'harga.*' => 'required|numeric',
            'diskon.*' => 'nullable|numeric',
            'pajak.*' => 'nullable|numeric',
        ]);
        // dd($request->all());

        if ($v->fails()) {
            dd($v->errors()->all());
            // return back()->withErrors($v)->withInput();
            return back()->with('error','Pastikan Formulir diisi dengan lengkap!');
        }

        $date = date('ymd');
        $latest = Po::orderBy('id','desc')->first();
        if ($latest == null) {
            $counter = 1;
        } else {
            $counter = $latest->id+1;
        }
        $kode = 'PO'.$date.sprintf("%'.02d", (String)$counter);

        if ($request->pembayaran == 'kredit') {
            $po = Po::create(array_merge($request->only('gudang_id','bank_id','penerima_po','nama_penerima','telepon_penerima','email_penerima','alamat_penerima','metode_pembayaran'),[
                'kode_po' => $kode
            ]));
        } else {
            $po = Po::create(array_merge($request->only('gudang_id','penerima_po','nama_penerima','telepon_penerima','email_penerima','alamat_penerima','metode_pembayaran'),[
                'kode_po' => $kode
            ]));
        }


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

        $data = Po::where('id',$po->id)->with('po_item','gudang.user')->first();
        $date = date_format($data->created_at,'d-m-Y');
        // dd($data);
        return view($this->indexPath.'konfirmasiPo',compact('data','date'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function preview($id)
    {
        $data = Po::where('id',$id)->with('po_item','gudang.user')->first();
        $date = date_format($data->created_at,'d-m-Y');
        return view($this->indexPath.'konfirmasiPo',compact('data','date'));
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
