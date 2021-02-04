<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PemesananBulky;
use App\Models\Barang;
use App\Models\GudangBulky;
use App\Models\BarangPemesananBulky;
use App\Models\PemesananKeluarBulky;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\File;

class PemesananKeluarBulkyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = PemesananKeluarBulky::with('bulky', 'barang.pemasok')
        ->orderBy('id', 'desc')
        ->get();
        if($request->ajax()){
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    return '<a class="btn btn-info btn-sm" href="/v1/bulky/pemesanan/keluar/'.$data->id.'/edit" title="Edit data">Edit</a> <a href="#" class="btn btn-danger btn-sm" onclick="sweet('.$data->id.')">Hapus</a>';
                })
                ->make(true);
        }
        return view('app.transaksi.pemesanan-keluar-bulky.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bulky = GudangBulky::whereHas('akunGudangBulky', function($query){
                $query->where('pengurus_bulky_id', auth()->user()->pengurus_gudang_bulky_id);
            })->get();
        $barangs = Barang::all();
        return view('app.transaksi.pemesanan-keluar-bulky.create', compact('barangs', 'bulky'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (isset($request->bulky_id)) {
            $v = Validator::make($request->all(),[
                'alamat_pemesan' => 'required',
                'barang_kode' => 'required',
                'bulky_id' => 'required',
                // 'pembayaran' => 'required',
                'telepon' => 'required',
                'metode_pembayaran' => 'nullable',
                'jumlah' => 'required|numeric|min:1'
            ]);
        } else {
            $v = Validator::make($request->all(),[
                'alamat_pemesan' => 'required',
                'barang_kode' => 'required',
                // 'pembayaran' => 'required',
                'telepon' => 'required',
                'metode_pembayaran' => 'nullable',
                'jumlah' => 'required|numeric|min:1'
            ]);
        }
        

        if ($v->fails()) {
            dd($v);
            return back()->withErrors($v)->withInput();
            // return back()->with('error','Pastikan Formulir diisi dengan lengkap!');
        }

        date_default_timezone_set('Asia/Jakarta');

        $tanggal = date("Ymd");
        $tahun = date("y");
        $bulan = date("m");

        // Number To Romawi
        $map = array(
            'M' => 1000,
            'CM' => 900,
            'D' => 500,
            'CD' => 400,
            'C' => 100,
            'XC' => 90,
            'L' => 50,
            'XL' => 40,
            'X' => 10,
            'IX' => 9,
            'V' => 5,
            'IV' => 4,
            'I' => 1
        );

        $tahunRomawi = '';
        $bulanRomawi = '';

        while ($tahun > 0) {
            foreach ($map as $romawi => $int) {
                if ($tahun >= $int) {
                    $tahun -= $int;
                    $tahunRomawi .= $romawi;
                    break;
                }
            }
        }

        while ($bulan > 0) {
            foreach ($map as $roman => $num) {
                if ($bulan >= $num) {
                    $bulan -= $num;
                    $bulanRomawi .= $roman;
                    break;
                }
            }
        }

        $date = date('ymd');
        $latest = PemesananKeluarBulky::orderBy('id','desc')->first();

        if ($latest == null) {
            $counter = 1;
        } else {
            $counter = $latest->id+1;
        }

        $faker = \Faker\Factory::create('id_ID');

        $kode_faker = $faker->unique()->regexify('[0-9]{9}');

        // $kode = 'PSN'.$date.sprintf("%'.02d", (String)$counter);
        $kode = 'PEM/BKY/'.$tanggal.'/'.$tahunRomawi.'/'.$bulanRomawi.'/'.$kode_faker;

        $barang = Barang::where('kode_barang', $request->barang_kode)->first();

        if ($barang->satuan == 'Kg') {
            $jumlah = $request->jumlah * 1000;
        } else {
            $jumlah = $request->jumlah;
        }
        

        $bulky = (isset($request->bulky_id)) ? $request->bulky_id : auth()->user()->pengurusGudangBulky->akunGudangBulky[0]->bulky_id ;

        $pemesanan = PemesananKeluarBulky::create(array_merge($request->only('bulky_id','telepon','alamat_pemesan','metode_pembayaran', 'barang_kode'),[
            'jumlah' => $jumlah,
            'penerima_po' => $barang->pemasok->nama,
            'bulky_id' => $request->bulky_id,
            'satuan' => $barang->satuan,
            'kode' => $kode_faker,
            'nomor_pemesanan' => $kode,
            'nama_pemesan' => auth()->user()->pengurusGudangBulky->nama,
            'tanggal_pemesanan' => now('Asia/Jakarta')
        ]));
        // dd($request->barang);

        // if ($request->pembayaran == 'later') {
        //     $BarangPesanan = BarangPemesananBulky::where('pemesanan_bulky_id',$pemesanan->id)->get();
        //     // dd($hutang);
        //     Piutang::create([
        //         'barang_id' => $pemesanan->id,
        //         'tanggal'=> Carbon::now(),
        //         'nama_pembeli' => Auth::user()->pelanggan->nama,
        //         'hutang' => $BarangPesanan->harga * $BarangPesanan->jumlah_barang,
        //     ]);
        // }

        return redirect(route('bulky.pemesanan.keluar.index'))->with('success', __( 'Pesanan berhasil dibuat.' ));
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
        $bulky = GudangBulky::whereHas('akunGudangBulky', function($query){
                $query->where('pengurus_bulky_id', auth()->user()->pengurus_gudang_bulky_id);
            })->get();
        $barangs = Barang::all();
        $data = PemesananKeluarBulky::findOrFail($id);

        return view('app.transaksi.pemesanan-keluar-bulky.edit', compact('barangs', 'bulky', 'data'));
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
        if (isset($request->bulky_id)) {
            $v = Validator::make($request->all(),[
                'alamat_pemesan' => 'required',
                'barang_kode' => 'required',
                'bulky_id' => 'required',
                // 'pembayaran' => 'required',
                'telepon' => 'required',
                'metode_pembayaran' => 'nullable',
                'jumlah' => 'required|integer|min:1'
            ]);
        } else {
            $v = Validator::make($request->all(),[
                'alamat_pemesan' => 'required',
                'barang_kode' => 'required',
                // 'pembayaran' => 'required',
                'telepon' => 'required',
                'metode_pembayaran' => 'nullable',
                'jumlah' => 'required|integer|min:1'
            ]);
        }
        

        if ($v->fails()) {
            dd($v);
            return back()->withErrors($v)->withInput();
            // return back()->with('error','Pastikan Formulir diisi dengan lengkap!');
        }

        date_default_timezone_set('Asia/Jakarta');

        $barang = Barang::where('kode_barang', $request->barang_kode)->first();

        $bulky = (isset($request->bulky_id)) ? $request->bulky_id : auth()->user()->pengurusGudangBulky->akunGudangBulky[0]->bulky_id ;

        $pemesanan = PemesananKeluarBulky::findOrFail($id)->update(array_merge($request->only('bulky_id','telepon','alamat_pemesan','metode_pembayaran', 'barang_kode', 'jumlah'),[
            'penerima_po' => $barang->pemasok->nama,
            'bulky_id' => $request->bulky_id,
            'satuan' => $barang->satuan,
            'nama_pemesan' => auth()->user()->pengurusGudangBulky->nama,
        ]));
        // dd($request->barang);

        // if ($request->pembayaran == 'later') {
        //     $BarangPesanan = BarangPemesananBulky::where('pemesanan_bulky_id',$pemesanan->id)->get();
        //     // dd($hutang);
        //     Piutang::create([
        //         'barang_id' => $pemesanan->id,
        //         'tanggal'=> Carbon::now(),
        //         'nama_pembeli' => Auth::user()->pelanggan->nama,
        //         'hutang' => $BarangPesanan->harga * $BarangPesanan->jumlah_barang,
        //     ]);
        // }

        return redirect(route('bulky.pemesanan.keluar.index'))->with('success', __( 'Pesanan berhasil diubah.' ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        PemesananKeluarBulky::findOrFail($id)->delete();

        return redirect(route('bulky.pemesanan.keluar.index'))->with('success', __( 'Pesanan berhasil dihapus.' ));
    }
}
