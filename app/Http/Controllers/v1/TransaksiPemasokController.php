<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Gudang;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Models\Barang;
use Auth;

class TransaksiPemasokController extends Controller
{
    public function __construct()
    {
        $this->indexPath = 'app.transaksi.pemasok.';
        $this->gudang = new Gudang;
        $this->barang = new Barang;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view($this->indexPath.'index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $barang = $this->barang->where('pemasok_id',Auth::user()->pemasok_id)->with('foto')->paginate(24);
        return view($this->indexPath.'create',compact('barang'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createDetail($id)
    {
        $gudang = $this->gudang->all();
        $barang = $this->barang->where('pemasok_id',Auth::user()->pemasok_id)->where('id',$id)->with('foto')->first();
        return view($this->indexPath.'createDetail',compact('barang','gudang'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function selectGudang(Request $request)
    {
        $data = $this->gudang->with('desa.kecamatan.kabupaten.provinsi');
        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($data){
                return '<button type="button" class="btn btn-danger btn-sm" onclick="select('.$data->id.')">Pilih</button>';
            })
            ->make(true);
    }

    public function selectedGudang($id)
    {
        $data = Gudang::where('id',$id)->with('desa.kecamatan.kabupaten.provinsi')->first();

        return response()->json([
            'data' => $data
        ]);
    }

    public function suratJalan(Request $request)
    {
        // dd($request->all());
        $barang = $this->barang->where('pemasok_id',Auth::user()->pemasok_id)->where('id',$request->barang_id)->with('foto')->first();
        $gudang = $this->gudang->where('id',$request->gudang_id)->first();

        $v = Validator::make($request->all(),[
            'barang_id' => 'required',
            'max' => 'required|numeric',
            'jumlah' => 'required|numeric|digits_between:1,'.$request->max,
            'gudang_id' => 'required',
            'satuan' => 'required|string|max:10'
        ]);
        if ($v->fails()) {
            // dd($v->errors()->all());
            return back()->withErrors($v)->withInput();
        } else {
            return view($this->indexPath.'suratJalan', compact('barang','gudang'));
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
        // dd($request->all());
        $v = Validator::make($request->all(),[
            'max' => 'required|numeric',
            'jumlah' => 'required|numeric|digits_between:1,'.$request->max,
            'gudang_id' => 'required',
            'satuan' => 'required|string|max:10'
        ]);
        if ($v->fails()) {
            // dd($v->errors()->all());
            return back()->withErrors($v)->withInput();
        } else {
            $faker = \Faker\Factory::create('id_ID');

            $kode = $faker->unique()->ean13;
            $barang = Barang::create(array_merge($request->only('nama_barang','harga_barang','satuan','jumlah','harga_beli','deskripsi'),[
                'kode_barang' => $kode,
                'pemasok_id' => Auth::user()->pemasok_id,
                'kategori_id' => $request->kategori_id
            ]));

            if($request->hasfile('foto'))
            {
                foreach($request->file('foto') as $image)
                {
                    $name = rand(). '.' . $image->getClientOriginalExtension();
                    $image->move("upload/foto/barang", $name);

                    FotoBarang::create([
                        'barang_id' => $barang->id,
                        'foto' => 'upload/foto/barang/'.$name,
                    ]);
                }
            }
        }
        return back()->with('success',$this->alert.'disimpan !');
        dd($request->all());
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
