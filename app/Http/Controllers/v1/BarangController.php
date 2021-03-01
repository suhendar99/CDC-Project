<?php

namespace App\Http\Controllers\v1;

use App\City;
use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\FotoBarang;
use App\Models\Kategori;
use App\Models\LogTransaksi;
use App\Models\Satuan;
use App\Models\Storage;
use App\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class BarangController extends Controller
{
    public function __construct()
    {
        $this->Data = new Barang();

        $this->path = 'app.data-master.barang.';
        $this->alert = 'Data Berhasil ';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = Barang::where('pemasok_id',Auth::user()->pemasok_id)->with('foto')->orderBy('id','desc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    // <a href="/v1/barang/'.$data->id.'/edit" class="btn btn-primary btn-sm">Edit</a>&nbsp;
                    return '<a href="#" class="btn btn-danger btn-sm" onclick="sweet('.$data->id.')">Hapus</a>';
                })
                ->addColumn('foto', function($data){
                    // <a href="/v1/barang/'.$data->id.'/edit" class="btn btn-primary btn-sm">Edit</a>&nbsp;
                    return '<a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalFotoBarang" onclick="foto('.$data->id.')" data-id="'.$data->id.'" style="cursor: pointer;" title="Foto Stock Barang">Foto Stock Barang</a>';
                })
                ->editColumn('created_at',function($data){
                    return date('d-m-Y H:i', strtotime($data->created_at)).' WIB';
                })
                ->rawColumns(['action','foto'])
                ->make(true);
        }
        return view($this->path.'index');
    }
    public function getBarangByPelanggan(Request $request)
    {
        if ($request->has('search') && $request->search !== '') {
            $search = trim($request->search);
            if($search == ''){
                $barang = Storage::with('storageIn.barang')->orderBy('id','desc')->paginate(8);

                // dd($barang->storageIn->barang);
            }else{
           $barang = Storage::with('storageIn.barang')->orderBy('id','desc')
                ->whereHas('storageIn.barang',function($q) use ($search){
                    $q->where('nama_barang','LIKE',"%".$search."%")
                    ->orWhere('harga_barang','LIKE',"%".$search."%");
                })
                ->paginate(8);
            }
        } else {
            $barang = Storage::with('storageIn.barang')->orderBy('id','desc')->paginate(8);

            // dd($barang->storageIn->barang);
        }
        $else = $request->search;
        //$barang = Barang::where('sarpras_id',$id)->get();
        // $data = SaranaPrasaranaUptd::find($id);
        return view($this->path.'pelanggan.index',compact('barang','else'));
    }
    public function uploadFoto(Request $request, $id)
    {
        $v = Validator::make($request->all(),[
            'foto' => 'required|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        }

        $foto_barang = $request->file('foto');
        $nama_barang = "PMSK".time()."_".$foto_barang->getClientOriginalName();
        $foto_barang->move("upload/foto/barang/pemasok", $nama_barang);
        $foto = FotoBarang::where('barang_id',$id)->get();
        if ($foto->count() < 1) {
            FotoBarang::create([
                'barang_id' => $id,
                'foto' => 'upload/foto/barang/pemasok/'.$nama_barang
            ]);
        } else {
            FotoBarang::where('barang_id',$id)->update([
                'foto' => 'upload/foto/barang/pemasok/'.$nama_barang
            ]);
        }


        return back()->with('success', __( 'Foto telah diunggah.' ));
    }
    public function getFoto($id)
    {
        try {
            $data = FotoBarang::where('barang_id',$id)
            ->get();

            return response()->json([
                'data' => $data
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
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
        $kategori = Kategori::all();
        $satuan = Satuan::all();
        $provinces = Province::pluck('name', 'province_id');
        return view($this->path.'create',compact('kategori','provinces','satuan'));
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
            'nama_barang' => 'required|string|max:50',
            'harga_barang' => 'required|string|max:20',
            // 'kode_barang' => 'required|string|max:100',
            'satuan' => 'required|string|max:10',
            'deskripsi' => 'required|string',
            'jumlah' => 'required|numeric',
            'keuntungan' => 'required|numeric',
            'harga_total' => 'required|numeric',
            'kategori_id' => 'required|exists:kategoris,id',
            'foto.*' => 'required|mimes:png,jpg|max:2048'
        ]);
        if ($v->fails()) {
            dd($v->errors()->all());
            return back()->withErrors($v)->withInput();
        } else {
            if ($request->satuan == null) {
                return back()->with('error','Mohon Pilih !');
            }
            // $pin = mt_rand(100, 999)
            //         .mt_rand(100, 999);
            // $date = date("Y");
            // $kode = "BG".$date.$pin;
            $faker = \Faker\Factory::create('id_ID');

            $kode = $faker->unique()->ean13;
            $barang = Barang::create(array_merge($request->only('nama_barang','harga_barang','satuan','jumlah','keuntungan','harga_total','deskripsi'),[
                'kode_barang' => $kode,
                'pemasok_id' => Auth::user()->pemasok_id,
                'kategori_id' => $request->kategori_id
            ]));

            LogTransaksi::create([
                'user_id' => Auth::user()->id,
                'tanggal' => now('Asia/Jakarta'),
                'jam' => now('Asia/Jakarta'),
                'aktifitas_transaksi' => 'Barang Masuk',
                'role' => 'Pemasok'
            ]);

            if($request->hasfile('foto'))
            {
                foreach($request->file('foto') as $image)
                {
                    $name = "PMSK".time()."_".$image->getClientOriginalName();
                    $image->move("upload/foto/barang/pemasok", $name);

                    FotoBarang::create([
                        'barang_id' => $barang->id,
                        'foto' => 'upload/foto/barang/pemasok/'.$name,
                    ]);
                }
            }
        }
        return back()->with('success',$this->alert.'disimpan !');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Barang::with('pemasok','kategori')->where('id',$id)->get();

        return response()->json([
            'data' => $data
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function detail($id)
    {
        $data = Barang::with('foto','pemasok','kategori')->find($id);
        $foto = [];
        foreach ($data->foto as $key => $value) {
            $foto[] = $value->foto;
        }

        // dd($foto);
        return response()->json([
            'data' => $data,
            'foto' => $foto
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        // dd($barang);
        $barang = Barang::find($id);
        if($request->ajax()){
            $data = FotoBarang::where('barang_id',$barang->id)->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    return '<a href="/v1/edit-foto-barang/'.$data->id.'" class="btn btn-success btn-sm">Edit</a>
                    <button class="btn btn-danger btn-sm" onclick="sweet('.$data->id.')" data-id="'.$data->id.'">Hapus</button>';
                })
                ->make(true);
        }
        $kategori = Kategori::all();
        $foto = FotoBarang::where('barang_id',$barang->id)->get();
        $data = Barang::find($id);
        if (!$data) {
            return redirect(route('barang.index'));
        }
        return view($this->path.'edit',compact('kategori','data','foto'));
    }
    public function createFotoBarang($id)
    {
        return view($this->path.'foto-barang.create',compact('id'));
    }
    public function storeFotoBarang(Request $request)
    {
        $v = Validator::make($request->all(),[
            'foto' => 'required|image|mimes:png,jpg|max:2048'
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        } else {
            $barang = Barang::find($request->id);
            // dd($barang);
            $name = $request->file('foto');
            $foto = time()."_".$name->getClientOriginalName();
            $request->foto->move("upload/foto/barang", $foto);

            FotoBarang::create([
                'barang_id' => $barang->id,
                'foto' => '/upload/foto/barang/'.$foto,
            ]);
            return back()->with('success',$this->alert.'ditambahkan !');
        }
    }
    public function editFotoBarang($id)
    {
        $data = Barang::find($id);
        $fotoBarang = FotoBarang::find($id);
        return view($this->path.'foto-barang.edit',compact('data','fotoBarang'));
    }
    public function updateFotoBarang(Request $request,$id)
    {
        $v = Validator::make($request->all(),[
            'foto' => 'required|image|mimes:png,jpg|max:2048'
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        } else {
            $data = FotoBarang::find($id);
            File::delete($data->foto);
            $name = $request->file('foto');
            $foto = time()."_".$name->getClientOriginalName();
            $request->foto->move("upload/foto/barang", $foto);

            $data->update([
                // 'barang_id' => $barang->id,
                'foto' => '/upload/foto/barang/'.$foto,
            ]);
            return back()->with('success',$this->alert.'diedit !');
        }
    }
    public function deleteFotoBarang($id)
    {
        $data = FotoBarang::find($id);
        File::delete($data->foto);
        $data->delete();
        return back();
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
            'nama_barang' => 'required|string|max:20',
            'harga_barang' => 'required|string|max:20',
            // 'kode_barang' => 'required|string|max:100',
            'satuan' => 'required|string|max:10',
            'deskripsi' => 'required|string',
            'jumlah' => 'required|numeric',
            'harga_total' => 'required|numeric',
            'kategori_id' => 'required|exists:kategoris,id',
        ]);
        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        } else {
            $barang = Barang::find($id);
            $barang->update(array_merge($request->only('nama_barang','harga_barang','satuan','jumlah','harga_total','deskripsi'),[
                'kategori_id' => $request->kategori_id,
                // 'kode_barang' => $request->kode_barang
            ]));
        }
        return back()->with('success',$this->alert.'Diedit !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = $this->Data->find($id);
        File::delete($data->foto);
        $data->delete();

        return back();
    }
}
