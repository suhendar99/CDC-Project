<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\BarangPesanan;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Pemesanan;
use App\Models\PemesananPembeli;
use App\Models\PengurusGudang;
use App\Models\Piutang;
use App\Models\Storage;
use App\User;
use Carbon\Carbon;
use PDF;

class PemesananController extends Controller
{
    public function __construct(Pemesanan $pemesanan)
    {
        $this->model = $pemesanan;
        $this->indexPath = 'app.transaksi.pemesanan-barang.';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function pemesananMasukPembeli()
    {
        $data = PemesananPembeli::where('pelanggan_id',Auth::user()->pelanggan_id)->orderBy('id','desc')->paginate(4);
        return view('app.transaksi.pemesanan-masuk-warung.index',compact('data'));
    }
    public function index(Request $request)
    {
        $data = BarangPesanan::with('pesanan.storageOut', 'barang')
        ->orderBy('id', 'desc')
        ->get();
        if($request->ajax()){
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    return '<a class="btn btn-info btn-sm" data-toggle="modal" data-target="#exampleModal" onclick="detail('.$data->id.')" data-id="'.$data->id.'" style="cursor: pointer;" title="Detail">Detail</a> <a href="#" class="btn btn-danger btn-sm" onclick="sweet('.$data->id.')">Hapus</a>';
                })
                ->addColumn('status_pemesanan', function($data){
                    if($data->pesanan->status == 0){
                        return '<a class="btn btn-danger btn-sm">Pesanan Ditolak</a>';
                    }elseif ($data->pesanan->status == 1 && $data->pesanan->foto_bukti != null) {
                        return '<a class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalBukti" onclick="bukti('.$data->pesanan->id.')" data-id="'.$data->pesanan->id.'" style="cursor: pointer;" title="Lihat Bukti Pembayaran">Lihat Bukti Pembayaran</a>';
                    } elseif ($data->pesanan->status == 1){
                        return '<a class="btn btn-info btn-sm" >Bukti Pembayaran Belum Dikirim</a> <a href="/v1/tolak/pesanan/warung/'.$data->pesanan->id.'" class="btn btn-danger btn-sm" >Tolak Pesanan</a>';
                    }elseif ($data->pesanan->status == 2) {
                        return '<a href="/v1/storage/out/create?id='.$data->pesanan->id.'" class="btn btn-success btn-sm">Kirim</a>';
                    } elseif ($data->pesanan->status == 4) {
                        return 'Menunggu Pesanan Sampai .....';
                    } elseif ($data->pesanan->status == 5) {
                        return 'Sudah Diterima';
                    }
                })
                ->addColumn('jumlah_barang', function($data){
                    return $data->jumlah_barang.' '.$data->satuan;
                })
                ->addColumn('status_pembayaran', function($data){
                    if ($data->pesanan->metode_pembayaran == null) {
                        return "Hutang";
                    } else{
                        return $data->pesanan->metode_pembayaran;
                    }
                })
                ->rawColumns(['action','jumlah_barang','status_pembayaran','status_pemesanan'])
                ->make(true);
        }
        return view('app.data-master.pemesanan.index');
    }

    public function tolak($id)
    {
        $data = $this->model::findOrFail($id);
        $data->update(['status'=>'0']);

        return back()->with('success','Pesanan Berhasil Ditolak!');
    }

    public function kirim($id)
    {
        return redirect('/v1/storage/out/create',['data'=>'data']);
    }

    function getPesanan($id){
        $data = $this->model::whereId($id)->with('barangPesanan')->first();
        $barang = $data->barangPesanan;
        $harga = $barang->sum('harga');
        return response()->JSON([
            'data' => $data,
            'barang' => $barang,
            'harga' => $harga,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pGudang = PengurusGudang::all();
        $barang = Barang::all();

        return view($this->indexPath.'create',compact('pGudang','barang'));
    }
    public function print($id)
    {
        set_time_limit(120);
        $date = date('d-m-Y');
        $data = Pemesanan::where('id',$id)->with('barangPesanan')->first();
        $email = User::where('pengurus_gudang_id',$data->pengurusGudang->id)->get();
        foreach ($email as $key => $value) {
            $user = $value;
        }
        // PDF::;
        $pdf = PDF::loadview($this->indexPath.'print', compact('data','date','user'))->setOptions(['defaultFont' => 'poppins']);
        return $pdf->stream();
        // return view($this->indexPath.'print', compact('data','date'));
    }
    public function preview($id)
    {
        $data = Pemesanan::where('id',$id)->with('barangPesanan')->first();
        $date = date_format($data->created_at,'d-m-Y');
        return view($this->indexPath.'konfirmasiPo',compact('data','date'));
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
            'penerima_po' => 'required|string|max:50',
            'nama_pemesan' => 'nullable|string|max:50',
            'telepon' => 'required|numeric',
            'email_penerima' => 'nullable|email',
            'alamat_pemesan' => 'required',
            'pembayaran' => 'required',
            'metode_pembayaran' => 'nullable',

            'nama_barang.*' => 'required|string|max:100',
            'satuan.*' => 'required|string|max:10',
            'jumlah.*' => 'required|numeric|min:1',
            'harga.*' => 'required|numeric',
            'diskon.*' => 'nullable|numeric',
            'pajak.*' => 'nullable|numeric',
        ]);
        if ($v->fails()) {
            dd($v->errors()->all());
            // return back()->withErrors($v)->withInput();
            return back()->with('error','Pastikan Formulir diisi dengan lengkap!');
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

        $pengurus_gudang = $request->pengurus_gudang_id;
        $search = PengurusGudang::find($pengurus_gudang);
        $nama = $search->nama;

        $date = date('ymd');
        $latest = Pemesanan::orderBy('id','desc')->first();
        if ($latest == null) {
            $counter = 1;
        } else {
            $counter = $latest->id+1;
        }

        $faker = \Faker\Factory::create('id_ID');

        $kode_faker = $faker->unique()->regexify('[0-9]{9}');

        // $kode = 'PSN'.$date.sprintf("%'.02d", (String)$counter);
        $kode = 'PEM/'.$tanggal.'/'.$tahunRomawi.'/'.$bulanRomawi.'/'.$kode_faker;

        $pemesanan = Pemesanan::create(array_merge($request->only('pelanggan_id','pengurus_gudang_id','penerima_po','telepon','email_penerima','alamat_pemesan','metode_pembayaran'),[
            'kode' => $kode_faker,
            'nomor_pemesanan' => $kode,
            'nama_pemesan' => $nama,
            'tanggal_pemesanan' => now('Asia/Jakarta')
        ]));
        $arrayLength = count($request->barang);
        // dd($request->barang);
        for ($i=0; $i < $arrayLength; $i++) {
            $kodes = 'PM'.rand(10000,99999);
            list($v, $n) = explode('-', $request->barang[$i]);
            if ($v == null || $n == null) {
                return back()->with('error','Isikan dengan benar !');
            }
            BarangPesanan::create([
                'kode' => $kodes,
                'pemesanan_id' => $pemesanan->id,
                'nama_barang' => $n,
                'satuan' => $request->satuan[$i],
                'barang_kode' => $v,
                'jumlah_barang' => $request->jumlah[$i],
                'harga' => $request->harga[$i],
                'diskon' => $request->diskon[$i],
                'pajak' => $request->pajak[$i],
            ]);
        }
        if ($request->pembayaran == 'later') {
            $BarangPesanan = BarangPesanan::where('pemesanan_id',$pemesanan->id)->get();
            $totalPajak = 0;
            $totalDiskon = 0;
            $subtotalHarga = 0;
            // $harga = 0;
            // $jumlah = 0;
            // $disc =0;
            // $paj = 0;
            foreach ($BarangPesanan as $key => $value) {
                $harga = $value->harga;
                $jumlah = $value->jumlah;
                $disc = $value->diskon;
                $paj = $value->pajak;
                $subtotal = $harga*$jumlah;
                $diskon = $subtotal*$disc/100;
                $pajak = $subtotal*$paj/100;

                $totalPajak = $totalPajak + $pajak;
                $totalDiskon = $totalDiskon + $diskon;
                $subtotalHarga = $subtotalHarga + $subtotal;
            }
            $totHar = $subtotalHarga+$totalPajak;
            $hutang = $totHar-$totalDiskon;
            // dd($hutang);
            Piutang::create([
                'barang_id' => $pemesanan->id,
                'tanggal'=> Carbon::now(),
                'nama_pembeli' => Auth::user()->pelanggan->nama,
                'hutang' => $hutang,
            ]);
        }
        $data = Pemesanan::where('id',$pemesanan->id)->with('barangPesanan','pengurusGudang')->first();
        $date = date_format($data->created_at,'d-m-Y');
        $email = User::where('pengurus_gudang_id',$request->pengurus_gudang_id)->get();
        foreach ($email as $key => $value) {
            $user = $value;
        }
        return view($this->indexPath.'konfirmasi',compact('data','date','user'));
    }

    public function bukti(Request $request, $id)
    {
        // dd($request->file('foto_bukti'));
        $data = Pemesanan::findOrFail($id);
        $foto_bukti = $request->file('foto_bukti');
        $nama_bukti = time()."_".$foto_bukti->getClientOriginalName();
        $foto_bukti->move(public_path("/upload/foto/bukti"), $nama_bukti);

        $data->update([
            'foto_bukti' => '/upload/foto/bukti/'.$nama_bukti
        ]);

        return back()->with('success','Bukti Pembayaran Berhasil Diupload!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getPemesanan($id)
    {
        $data = BarangPesanan::with('pesanan.storageOut', 'barang')->where('id',$id)->get();
        return response()->json([
            'data' => $data
        ]);
    }
    public function show($id)
    {
        $data = Pelanggan::with('user')->where('id',$id)->get();
        $ser = User::where('pengurus_gudang_id',$id)->get();
        foreach ($ser as $key => $value) {
            $user = $value;
        }
        return response()->json([
            'data' => $data,
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Pemesanan::findOrFail($id);
        return view('app.data-master.pemesanan.edit', compact('data'));
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
            'barang_kode' => 'required|string|exists:barangs,kode_barang',
            'jumlah_barang' => 'required|integer',
            'nama_pemesan' => 'required|string|max:50',
            'tanggal_pemesanan' => 'required|date',
            'alamat_pemesan' => 'required|string|max:255',
            'metode_pembayaran' => 'required|integer',
            'total_harga' => 'required|integer|min:0',
            'satuan' => 'required'
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        }

        $arrayName = ["kg", "ons", "gram", "ml", "m3", "m2", "m", "gram"];

        if (!in_array($request->satuan, $arrayName)) {
            return back()->with('failed', __( 'Masukan inputan satuan yang benar' ))->withInput();
        }

        Pemesanan::findOrFail($id)
        ->update($request->only('barang_kode', 'jumlah_barang', 'nama_pemesan', 'tanggal_pemesanan', 'alamat_pemesan', 'metode_pembayaran', 'total_harga', 'satuan'));

        return redirect(route('pemesanan.index'))->with('success', __( 'Pemesanan telah diedit' ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = BarangPesanan::findOrFail($id);
        $pesanan = Pemesanan::findOrFail($data->pesanan->id);
        $pesanan->delete();

        return back()->with('success', __( 'Pemesanan masuk telah dihapus' ));
    }
}
