<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\Keranjang;
use App\Models\KeranjangItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KeranjangController extends Controller
{
    public function saveKeranjang(Request $request, $id)
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
        $latest = Keranjang::orderBy('id','desc')->first();
        if ($latest == null) {
            $counter = 1;
        } else {
            $counter = $latest->id+1;
        }

        $faker = \Faker\Factory::create('id_ID');

        $kode_faker = $faker->unique()->regexify('[0-9]{9}');

        // $kode = 'PSN'.$date.sprintf("%'.02d", (String)$counter);
        $kode = 'PEM/'.$tanggal.'/'.$tahunRomawi.'/'.$bulanRomawi.'/'.$kode_faker;

        $keranjang = Keranjang::create(array_merge($request->only('pelanggan_id','pengurus_gudang_id','penerima_po','telepon','alamat_pemesan','metode_pembayaran'),[
            'kode' => $kode_faker,
            'nomor_pemesanan' => $kode,
            'nama_pemesan' => $request->nama_pemesan,
            'tanggal_pemesanan' => now('Asia/Jakarta')
        ]));
        // dd($request->barang);
        $kodes = 'BP'.rand(10000,99999);
        KeranjangItem::create([
            'kode' => $kodes,
            'barang_kode' => $request->barangKode,
            'keranjang_id' => $keranjang->id,
            'nama_barang' => $request->nama_barang,
            'satuan' => $request->satuan,
            'jumlah_barang' => $request->jumlah,
            'harga' => $request->harga,
        ]);
        // if ($request->pembayaran == 'later') {
        //     $keranjangItem = KeranjangItem::where('pemesanan_id',$keranjang->id)->get();
        //     // dd($hutang);
        //     Piutang::create([
        //         'barang_id' => $keranjang->id,
        //         'tanggal'=> Carbon::now(),
        //         'nama_pembeli' => Auth::user()->pelanggan->nama,
        //         'hutang' => $keranjangItem->harga * $keranjangItem->jumlah_barang,
        //     ]);
        // }
        return redirect('/')->with('sukses','Pesanan Telah dimasukan ke keranjang !');
    }
}
