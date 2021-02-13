<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Rak;
use App\Models\RakBulky;
use App\Models\Bank;
use App\Models\RekeningBulky;
use App\Models\Gudang;
use App\Models\GudangBulky;
use Illuminate\Support\Facades\DB;
use Auth;

class GudangBulkyController extends Controller
{
    public function __construct()
    {
        $this->path = 'app.data-master.gudangBulky.';
        $this->alert = 'Data berhasil ';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = GudangBulky::withCount('rak')
        ->whereHas('akunGudangBulky', function($query){
            $query->where('pengurus_bulky_id', auth()->user()->pengurus_gudang_bulky_id);
        })
        ->paginate(6);

        if ($request->query('search') !== null) {
        	$data = GudangBulky::where('nama', 'like', '%'.$request->query('search').'%')->whereHas('akunGudangBulky', function($query){
	            $query->where('pengurus_bulky_id', auth()->user()->pengurus_gudang_bulky_id);
	        })
	        ->paginate(6);
        }

        return view('app.data-master.gudangBulky.index', compact('data'));
    }

    public function detailBarang($id)
    {
        $data = RakBulky::with('tingkat.storage.storageMasukBulky.barang')->find($id);

        return response()->json([
            'data' => $data
        ], 200);
    }

    public function search(Request $request)
    {
        $data = Gudang::where('nama', 'like', '%'.$request->nama.'%')->paginate(6);

        return view($this->path.'index', compact('data'));
    }

    public function geocode(Request $request)
    {
        if ($request->query('kecamatan')) {
            $kecamatan = Kecamatan::with('kabupaten.provinsi')->where('nama', 'like', '%'.$request->query('kecamatan').'%')->get();
            if (count($kecamatan) > 0) {
                $data = $kecamatan[0];
                $index = 'kecamatan';
            }
        }elseif ($request->query('kabupaten')) {
            $kabupaten = Kabupaten::with('provinsi')->where('nama', 'like', '%'.$request->query('kabupaten').'%')->get();
            if (count($kabupaten) > 0) {
                $data = $kabupaten[0];
                $index = 'kabupaten';
            }
        }elseif ($request->query('provinsi')) {
            $provinsi = Provinsi::where('nama', 'like', '%'.$request->query('provinsi').'%')->get();
            if (count($provinsi) > 0) {
                $data = $provinsi[0];
                $index = 'provinsi';
            }
        }

        return response()->json([
            $index => $data
        ], 200);
    }

    public function changeStatus($id)
    {
        $data = GudangBulky::find($id);

        if ($data != null) {
            $status = ($data->status == 0) ? 1 : 0;

            $data->update([
                'status' => $status
            ]);

            return response()->json([
                'data' => $data
            ],200);
        } else {
            return response()->json([
                'message' => __( 'Data tidak ditemukan.' )
            ],400);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $provinsi = Provinsi::all();
        $dataBank = Bank::all();
        return view('app.data-master.gudangBulky.create', compact('provinsi','dataBank'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $user_id = Auth::user()->id;
        $v = Validator::make($request->all(),[
            'lat' => 'required',
            'long' => 'required',
            'nama' => 'required|string|max:50',
            'kontak' => 'required|string|regex:/(628)[0-9]{9}/',
            'hari' => 'required|',
            'jam_buka' => 'required|',
            'jam_tutup' => 'required|',
            'alamat' => 'required|string|max:200',
            'kapasitas_meter' => 'required|numeric|min:0',
            'kapasitas_berat' => 'required|numeric|min:0',
            'desa_id' => 'required',
            'pemilik' => 'required|string',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'no_rek' => 'required|numeric',
            'atas_nama' => 'required',
            'bank_id' => 'required'
        ]);
        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        } else {
            date_default_timezone_set('Asia/Jakarta');

            $faker = \Faker\Factory::create('id_ID');

            $kode = $faker->unique()->regexify('[0-9]{9}');

            $date = date("Ymd");

            if ($request->file('foto')) {
                $name = $request->file('foto');
                $foto = time()."_".$name->getClientOriginalName();
                $request->foto->move("upload/foto/bulky", $foto);
                $createGudang = GudangBulky::create(array_merge($request->only('nama','lat','long','alamat','kontak','kapasitas_meter','kapasitas_berat','jam_buka','jam_tutup','hari', 'desa_id', 'pemilik'),[
                    'status' => 1,
                    'foto' => '/upload/foto/bulky/'.$foto,
                    'user_id' => $user_id,
                    'nomor_gudang' => "GUD/BKY/".$date.'/'.$kode
                ]));

                $gudang_id = $createGudang->id;
                RekeningBulky::create(array_merge($request->only('bank_id','atas_nama','no_rek'),[
                    'bulky_id' => $gudang_id
                ]));
            } else {
                $createGudang = GudangBulky::create(array_merge($request->only('nama','lat','long','alamat','kontak','kapasitas_meter','kapasitas_berat','jam_buka','jam_tutup','hari', 'desa_id', 'pemilik'),[
                    'status' => 1,
                    'user_id' => $user_id,
                    'nomor_gudang' => "GUD/BKY/".$date.'/'.$kode
                ]));

                $gudang_id = $createGudang->id;
                RekeningBulky::create(array_merge($request->only('bank_id','atas_nama','no_rek'),[
                    'bulky_id' => $gudang_id
                ]));
            }

            DB::table('akun_gudang_bulkys')->insert([
                'bulky_id' => $gudang_id,
                'pengurus_bulky_id' => auth()->user()->pengurus_gudang_bulky_id,
                'created_at' => now('Asia/Jakarta')
            ]);
        }
        return redirect(route('rak.bulky.create', $gudang_id))->with('success',$this->alert.'Disimpan !');
        // return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = GudangBulky::with('desa.kecamatan.kabupaten.provinsi', 'rak')->where('id',$id)->get();

        return response()->json([
            'data' => $data
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
        $data = GudangBulky::find($id);
        $provinsi = Provinsi::all();
        return view('app.data-master.gudangBulky.edit',compact('data', 'provinsi'));
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
            'nama' => 'required|string|max:50',
            'lat' => 'required',
            'long' => 'required',
            'alamat' => 'required|string|max:200',
            'kontak' => 'required|string|regex:/(08)[0-9]{9}/',
            'kapasitas_meter' => 'required|numeric|min:0',
            'kapasitas_berat' => 'required|numeric|min:0',
            'jam_buka' => 'required|',
            'jam_tutup' => 'required|',
            'hari' => 'required|',
            'desa_id' => 'required|exists:desas,id',
            'pemilik' => 'required|string',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);
        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        } else {
            $data = GudangBulky::findOrFail($id);
            if ($request->file('foto')) {
                File::delete($data->foto);

                $name = $request->file('foto');
                $foto = time()."_".$name->getClientOriginalName();
                $request->foto->move("upload/foto/bulky", $foto);

                $data->update(array_merge($request->only('nama','lat','long','alamat','kontak','kapasitas_meter','kapasitas_berat','jam_buka','jam_tutup','hari','desa_id','pemilik'),[
                    'foto' => '/upload/foto/bulky/'.$foto
                ]));

            } else {
                $data->update(array_merge($request->only('nama','lat','long','alamat','kontak','kapasitas_meter','kapasitas_berat','jam_buka','jam_tutup','hari','desa_id','pemilik')));
            }
        }
        return back()->with('success','Diedit !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = GudangBulky::findOrFail($id);
        File::delete($data->foto);
        $data->delete();

        return back();
    }
}
