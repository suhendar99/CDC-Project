<?php

namespace App\Http\Controllers\v1;

use App\City;
use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Pembelian;
use App\Models\Provinsi;
use App\Province;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Kavist\RajaOngkir\Facades\RajaOngkir;

class PembelianController extends Controller
{
    public function __construct()
    {
        $this->path = 'app.transaksi.pembelian-barang.pelanggan.';
        $this->alert = 'Data Berhasil ';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $data = Barang::find($id);
        // dd($data->city_id);
        $provinces = Province::pluck('name', 'province_id');
        return view($this->path.'beli', compact('provinces','data'));
    }

    public function getCities($id)
    {
        $city = City::where('province_id', $id)->pluck('name', 'city_id');
        return response()->json($city);
    }

    public function check_ongkir(Request $request)
    {
        $cost = RajaOngkir::ongkosKirim([
            'origin'        => $request->city_origin, // ID kota/kabupaten asal
            'destination'   => $request->city_destination, // ID kota/kabupaten tujuan
            'weight'        => $request->weight, // berat barang dalam gram
            'courier'       => $request->courier // kode kurir pengiriman: ['jne', 'tiki', 'pos'] untuk starter
        ])->get();


        return response()->json($cost);
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
            'jumlah' => 'required|numeric',
            'alamat' => 'required|string|max:20',
            'province_destination' => 'required',
            'city_destination' => 'required',
            // 'courier' => 'required',
        ]);
        if ($v->fails()) {
            // dd($v->errors()->all());
            return back()->with('error','Mohon Periksa kembali inputan anda !');
        } else {
            $id = $request->id;
            $data = Barang::find($id);
            $jumlah = $request->jumlah;
            $jumtot = $data->jumlah;
            $sisa = $jumtot - $jumlah;
            $hargaTotal = $data->harga_barang + $request->hargaOngkir;
            $total = $hargaTotal * $jumlah;
            $date = date('Ymd');
            $kode = 'PB'.$date;
            $data->update([
                'jumlah' => $sisa
            ]);
            Pembelian::create([
                'kode_pembelian' => $kode,
                'jumlah' => $jumlah,
                'tanggal_pembelian' => Carbon::now(),
                'pelanggan_id' => Auth::user()->pelanggan_id,
                'barang_id' => $data->id,
                'city_id' => $request->province_destination,
                'province_id' => $request->city_destination,
                'kurir' => $request->courier,
                'harga_total' => $total,
                'alamat' => $request->alamat,
            ]);

            return redirect('v1/barangs')->with('success','Barang'.$data->nama_barang.'berhasil dibeli !');
        }
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
