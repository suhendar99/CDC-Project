<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Models\StorageOut;
use App\Models\StorageIn;
use App\Models\Storage;
use App\Models\Gudang;
use App\Models\Barang;
use App\Models\BarangPesanan;
use App\Models\Pemesanan;
use App\Models\Kwitansi;
use App\Models\RekapitulasiPenjualan;
use App\Models\SuratJalan;
use PDF;

class StorageOutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = StorageOut::with('barang', 'gudang', 'pemesanan')
            ->orderBy('id', 'desc')
            ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    // return '<a href="/v1/storage/out/'.$data->id.'/edit" class="btn btn-primary btn-sm">Edit</a>&nbsp;<a href="#" class="btn btn-danger btn-sm" onclick="sweet(\'/v1/storage/out/'.$data->id.'\')">Hapus</a>';
                    return '<a href="#" class="btn btn-danger btn-sm" onclick="sweet(\'/v1/storage/out/'.$data->id.'\')">Hapus</a>';
                })
                ->make(true);
        }
        return view('app.data-master.storage.index');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function printKwitansi(Request $request)
    {
        set_time_limit(120);
        $date = date('d-m-Y');
        $data = Kwitansi::with('pemesanan','gudang','user')->first();
        // PDF::;
        $counter = $data->count();
        $kode = sprintf("%'.04d", (String)$counter);
        $pdf = PDF::loadview('app.transaksi.kwitansi.print', compact('data','date','kode'));
        return $pdf->stream();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function printSuratJalan(Request $request)
    {
        return view('app.transaksi.surat-jalan.print');
    }

    public function findBarang($id)
    {
        $barang = Barang::with('storageIn.storage')->whereHas('storageIn', function($query)use($id){
            $query->where('gudang_id', $id);
        })->get();

        return response()->json([
            'data' => $barang
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $gudang = Gudang::all();
        $pemesanan = Pemesanan::all();

        return view('app.data-master.storage.out.create', compact('gudang', 'pemesanan'));
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
            // 'barang_kode' => 'required|numeric|exists:barangs,kode_barang',
            'gudang_id' => 'required|exists:gudangs,id',
            'pemesanan_id' => 'required|exists:pemesanans,id',
            'pengirim' => 'required|string|max:50',
            'terima_dari' => 'required|string|max:50',
            'jumlah_uang_digits' => 'required|integer',
            'jumlah_uang_word' => 'required|string',
            'keterangan' => 'required|string',
            'tempat' => 'required|string'
            // 'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        if ($v->fails()) {
            dd($v);
            return back()->withErrors($v)->withInput();
        }

        $pesanan = Pemesanan::with('barangPesanan')->findOrFail($request->pemesanan_id);

        foreach ($pesanan->barangPesanan as $barang) {
            $kode_barang = $barang->barang_kode;

            $stok = Storage::whereHas('storageIn', function($query)use($kode_barang){
                $query->where('barang_kode', $kode_barang);
            })
            ->orderBy('waktu', 'asc')
            ->get();

            $jumlahBarang = count($stok) - 1;
            $now = 0;



            $jumlah = $barang->jumlah_barang;

            $hasil = 0;

            for ($i=0; $i < count($stok); $i++) {
                # code...
                $jumlahStok = $stok[$i]->jumlah;

                if ($jumlahStok != 0) {
                    $jumlahStok = $jumlahStok - $jumlah;
                    if ($jumlahStok >= 0) {
                        $stok[$i]->update([
                            'jumlah' => $jumlahStok
                        ]);

                        break;
                    }elseif($jumlahStok < 0){
                        $stok[$i]->update([
                            'jumlah' => 0
                        ]);

                        $jumlah = abs($jumlahStok);
                    }
                    // dd($jumlah);
                }
            }

            // while ( $jumlah != 0 ) {
            //     if ($now <= $jumlahBarang) {
            //         $jumlahStok = $stok[$now]->jumlah;

            //         if ($jumlahStok != 0) {
            //             $jumlahStok = $jumlahStok - $jumlah;
            //             if ($jumlahStok >= 0) {
            //                 $stok[$now]->update([
            //                     'jumlah' => $jumlahStok
            //                 ]);

            //                 break;
            //             }elseif($jumlahStok < 0){
            //                 $stok[$now]->update([
            //                     'jumlah' => 0
            //                 ]);

            //                 $jumlah = abs($jumlahStok);
            //                 $now++;
            //             }
            //             // dd($jumlah);
            //         }else{
            //             $now++;
            //         }
            //     }
            // }

            $faker = \Faker\Factory::create('id_ID');

            $kode_out = $faker->unique()->ean13;

            $out = StorageOut::create($request->only('gudang_id', 'pemesanan_id')+[
                'barang_kode' => $kode_barang,
                'jumlah' => $barang->jumlah_barang,
                'satuan' => $barang->satuan,
                'kode' => $kode_out,
                'user_id' => auth()->user()->id,
                'waktu' => now('Asia/Jakarta')
            ]);

        }


        $kode_kwi = $faker->unique()->ean13;
        $kode_surat = $faker->unique()->ean13;

        $kwitansi = Kwitansi::create($request->only('terima_dari', 'jumlah_uang_digits', 'jumlah_uang_word', 'pemesanan_id', 'tempat', 'gudang_id', 'keterangan')+[
            'user_id' => auth()->user()->id,
            'kode' => $kode_kwi,
            'tanggal' => now('Asia/Jakarta')
        ]);

        $surat = SuratJalan::create($request->only('tempat', 'pengirim', 'pemesanan_id')+[
            'penerima' => $pesanan->nama_pemesan,
            'kode' => $kode_surat,
            'user_id' => auth()->user()->id,
            'tanggal' => now('Asia/Jakarta')
        ]);
        $bp = BarangPesanan::where('pemesanan_id',$out->pemesanan->id)->get();
        $jumlah = 0;
        $total = 0;
        $satuan = [];
        foreach ($bp as $key => $value) {
            $jumlah += $value->jumlah_barang;
            $total += $value->harga;
            $harga_total = $jumlah * $total;
            $satuan = $value->satuan;
        }
        RekapitulasiPenjualan::create([
            'storage_out_id' => $out->id,
            'tanggal_penjualan' => $out->waktu,
            'no_penjualan' => $out->kode,
            'no_kwitansi' => $kwitansi->kode,
            'no_surat_jalan' => $surat->kode,
            'nama_pembeli' => $out->pemesanan->nama_pemesan,
            'barang' => $out->pemesanan->barangPesanan[0]->barang->nama_barang,
            'jumlah' => $jumlah,
            'satuan' => $satuan,
            'harga' => $total,
            'total' => $harga_total
        ]);

        return back()->with('success', __( 'Storage Out!' ));
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

    public function detail($id)
    {
        try {
            $data = StorageOut::with('barang', 'gudang', 'user.pengurusGudang')->where('id', $id)->first();

            return response()->json([
                'data' => $data
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = StorageOut::find($id);
        $gudang = Gudang::all();
        return view('app.data-master.storage.out.edit', compact('gudang', 'data'));
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
            'barang_kode' => 'required|numeric|exists:barangs,kode_barang',
            'gudang_id' => 'required|exists:barangs,id',
            'jumlah' => 'required|numeric',
            'satuan' => 'required|string'
            // 'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        }

        // $faker = \Faker\Factory::create('id_ID');

        // $kode = $faker->unique()->ean13;

        StorageOut::findOrFail($id)->update($request->only('barang_kode', 'gudang_id', 'jumlah', 'satuan'));

        return back()->with('success', __( 'Storage Out Updated!' ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        StorageOut::findOrFail($id)->delete();

        return back()->with('success', __( 'Storage In Deleted!' ));
    }
}
