<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Validation\Rule;
use App\Models\Po;
use App\Models\PoItem;
use App\Models\PemesananBulky;
use App\Models\BarangPemesananBulky;
use App\Models\Bank;
use App\Models\Barang;
use App\Models\BarangPesanan;
use App\Models\BatasPiutang;
use App\Models\LogTransaksi;
use App\Models\Pemasok;
use App\Models\PengaturanTransaksi;
use App\Models\PiutangOut;
use App\Models\Gudang;
use App\User;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use PDF;

class PoController extends Controller
{
    public function __construct()
    {
        $this->indexPath = 'app.transaksi.gudang.po.';
        $this->indexPathPemasok = 'app.transaksi.pemasok.po.';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getDataMasukPemasok(Po $po)
    {
        $user = User::where('pengurus_gudang_id','!=',null)->orderBy('id','desc')->with('pengurusGudang.gudang')->first();
        $arrayGudang = [];
        foreach ($user->pengurusGudang->gudang as $key => $value) {
            $arrayGudang[] = $value->id;
        }
        $data = $po->whereIn('gudang_id',$arrayGudang)->with('po_item')->get();
        return view($this->indexPathPemasok.'index',compact('data'));
    }
    
    public function index()
    {
        $gudang = Gudang::select('id')->where('user_id', auth()->user()->id)->get();
        $data = PemesananBulky::with('storageKeluarBulky.user.pengurusGudangBulky.kabupaten','retail.akunGudang.kabupaten','barangPesananBulky')->whereIn('gudang_retail_id',$gudang)->orderBy('id','desc')->paginate(4);
        // dd($data[0]->barangPesananBulky->nama_barang);
        return view($this->indexPath.'index',compact('data'));
    }

    public function preview($id)
    {
        $data = Po::where('id',$id)->with('po_item')->first();
        dd($data);
        $date = date_format($data->created_at,'d-m-Y');
        return view($this->indexPath.'konfirmasiPo',compact('data','date'));
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
    public function acceptGudang(Request $request, $id)
    {
        $po = Po::find($id);
        $batasPiutang = BatasPiutang::find(1);
        $tempo = $batasPiutang->jumlah_hari;
        if ($po->metode_pembayaran == null) {
            $po->update([
                'status' => 1
            ]);
            PiutangOut::where('barang_id',$po->id)->update([
                'status' => 1,
                'jatuh_tempo' => date('Y-m-d', strtotime($po->created_at.' +'.$tempo.' days'))
            ]);
            return back()->with('success','Po telah disetujui');
        } else {
            $po->update([
                'status' => 1
            ]);
            return back()->with('success','Po telah disetujui');
        }

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Bank $bank)
    {
        // dd(Auth::user()->pengurusGudang->gudang);
        $user = User::where('id',Auth::user()->id)->with('pengurusGudang.gudang')->first();
        // dd($user);
        $pmsk = Pemasok::all();
        $count = $user->pengurusGudang->gudang->count();
        if($count < 1){
            return back()->with('error','Anda Belum Memiliki Gudang!');
        } else {
            // $bank = $bank->all();
            return view($this->indexPath.'create',compact('pmsk'));
        }
    }
    public function show($id)
    {
        $data = Pemasok::with('user')->where('id',$id)->get();
        $ser = User::where('pemasok_id',$id)->get();
        foreach ($ser as $key => $value) {
            $user = $value;
        }
        return response()->json([
            'data' => $data,
            'user' => $user
        ]);
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
            'nama_penerima' => 'nullable|string|max:50',
            'telepon_penerima' => 'required|numeric',
            'email_penerima' => 'required|email',
            'alamat_penerima' => 'required',
            'pembayaran' => 'required',
            'metode_pembayaran' => 'nullable',

            'nama_barang.*' => 'required|string|max:100',
            'satuan.*' => 'required|string|max:10',
            'jumlah.*' => 'required|numeric|min:1',
            'harga.*' => 'required|numeric',
            'diskon.*' => 'nullable|numeric',
            'pajak.*' => 'nullable|numeric',
        ]);
        // dd($request->all());
        if ($v->fails()) {
            // return back()->withErrors($v)->withInput();
            return back()->with('error','Pastikan Formulir diisi dengan lengkap!');
        }
        $pemasok = $request->pemasok_id;
        $search = Pemasok::find($pemasok);
        $nama = $search->nama;

        $date = date('ymd');
        $latest = Po::orderBy('id','desc')->first();
        if ($latest == null) {
            $counter = 1;
        } else {
            $counter = $latest->id+1;
        }
        $kode = 'PO'.$date.sprintf("%'.02d", (String)$counter);

        $po = Po::create(array_merge($request->only('gudang_id','pemasok_id','penerima_po','telepon_penerima','email_penerima','alamat_penerima','metode_pembayaran'),[
            'kode_po' => $kode,
            'nama_penerima' => $nama
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
        if ($request->pembayaran == 'later') {
            $poItem = PoItem::where('po_id',$po->id)->get();
            $totalPajak = 0;
            $totalDiskon = 0;
            $subtotalHarga = 0;
            // $harga = 0;
            // $jumlah = 0;
            // $disc =0;
            // $paj = 0;
            foreach ($poItem as $key => $value) {
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
            PiutangOut::create([
                'barang_id' => $po->id,
                'tanggal'=> Carbon::now(),
                'nama_pembeli' => FacadesAuth::user()->pengurusGudang->nama,
                'hutang' => $hutang,
            ]);
        }
        // } else {
        //     $po = Po::create(array_merge($request->only('gudang_id','pemasok_id','penerima_po','telepon_penerima','email_penerima','alamat_penerima','metode_pembayaran'),[
        //         'kode_po' => $kode,
        //         'nama_penerima' => $nama
        //     ]));
        // }
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


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Barang::find($id);
        $biaya = PengaturanTransaksi::find(1);
        return view($this->indexPath.'pesanan',compact('id','data','biaya'));
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
            'alamat_pemesan' => 'required',
            'pembayaran' => 'required',
            'telepon' => 'required',
            'metode_pembayaran' => 'nullable',
            'jumlah' => 'required|numeric|min:1',
        ]);
        if ($v->fails()) {
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
        $date = date('ymd');
        $latest = Po::orderBy('id','desc')->first();
        if ($latest == null) {
            $counter = 1;
        } else {
            $counter = $latest->id+1;
        }

        $faker = \Faker\Factory::create('id_ID');

        $kode_faker = $faker->unique()->regexify('[0-9]{9}');

        // $kode = 'PSN'.$date.sprintf("%'.02d", (String)$counter);
        $kode = 'PEM/'.$tanggal.'/'.$tahunRomawi.'/'.$bulanRomawi.'/'.$kode_faker;

        $store = Barang::find($id);
        $harga = $request->harga * $request->jumlah;

        $po = Po::create(array_merge($request->only('pengurus_gudang_id','pemasok_id','gudang_id','penerima_po','telepon','alamat_pemesan','metode_pembayaran'),[
            'kode' => $kode_faker,
            'nomor_pemesanan' => $kode,
            'nama_pemesan' => $request->nama_pemesan,
            'tanggal_pemesanan' => now('Asia/Jakarta')
        ]));
        // dd($request->barang);
        $kodes = 'BP'.rand(10000,99999);
        PoItem::create([
            'kode' => $kodes,
            'barang_kode' => $request->barangKode,
            'po_id' => $po->id,
            'nama_barang' => $request->nama_barang,
            'satuan' => $request->satuan,
            'jumlah_barang' => $request->jumlah,
            'pajak' => $request->pajak,
            'biaya_admin' => $request->biaya_admin,
            'harga' => $request->harga
        ]);
        $log = LogTransaksi::create([
            'tanggal' => now(),
            'jam' => now(),
            'Aktifitas_transaksi' => 'Pemesanan Barang Keluar'
        ]);

        if ($request->pembayaran == 'later') {
            $poItem = PoItem::where('po_id',$po->id)->get();
            // dd($hutang);
            PiutangOut::create([
                'barang_id' => $po->id,
                'tanggal'=> Carbon::now(),
                'nama_pembeli' => Auth::user()->pengurusGudang->nama,
                'hutang' => $harga,
            ]);
        }
        return redirect('/shop')->with('sukses','Pesanan Telah dibuat !');
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
