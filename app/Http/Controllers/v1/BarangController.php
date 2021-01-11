<?php

namespace App\Http\Controllers\v1;

use App\City;
use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\FotoBarang;
use App\Models\Kategori;
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
        $barang = Barang::where('pemasok_id',Auth::user()->pemasok_id)->with('foto')->paginate(24);
        $foto = FotoBarang::all();
        // if($request->ajax()){
        //     $data = $this->Data->getData();
        //     return DataTables::of($data)
        //         ->addIndexColumn()
        //         ->addColumn('action', function($data){
        //             return '<a href="/v1/barang/'.$data->id.'/edit" class="btn btn-primary btn-sm">Edit</a>&nbsp;<a href="#" class="btn btn-danger btn-sm" onclick="sweet('.$data->id.')">Hapus</a>';
        //         })
        //         ->addColumn('foto', function($data){
        //             return '<a class="btn btn-info btn-sm" data-toggle="modal" data-target="#exampleModal" onclick="detail('.$data->id.')" data-id="'.$data->id.'" style="cursor: pointer;" title="Detail">Show</a>';
        //         })
        //         ->addColumn('barcode', function($data){
        //             return '<img src="data:image/png;base64,'.\DNS1D::getBarcodePNG($data->kode_barang, 'C39E',1,55,array(0,0,0), true).'" alt="barcode" />';
        //         })
        //         ->addColumn('jumsat', function($data){
        //             return $data->jumlah.' '.$data->satuan;
        //         })
        //         ->rawColumns(['barcode','action','jumsat','foto'])
        //         ->make(true);
        // }
        return view($this->path.'index',compact('barang','foto'));
    }
    public function getBarangByPelanggan(Request $request)
    {
        if ($request->has('search') && $request->search !== '') {
            $search = trim($request->search);
            if($search == ''){
               $barang = Barang::with('pemasok','kategori')->orderBy('id','desc')->paginate(8);
            }else{
           $barang = Barang::with('pemasok','kategori')->orderBy('id','desc')
                ->where('nama_barang','LIKE',"%".$search."%")
                ->orWhere('harga_barang','LIKE',"%".$search."%")
                // ->orWhere('','LIKE',"%".$search."%")
                ->paginate(8);
            }
        } else {
           $barang = Barang::with('pemasok','kategori')->orderBy('id','desc')->paginate(8);
        }
        $else = $request->search;
        //$barang = Barang::where('sarpras_id',$id)->get();
        // $data = SaranaPrasaranaUptd::find($id);
        return view($this->path.'pelanggan.index',compact('barang','else'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kategori = Kategori::all();
        $provinces = Province::pluck('name', 'province_id');
        return view($this->path.'create',compact('kategori','provinces'));
    }
    public function getCities($id)
    {
        $city = City::where('province_id', $id)->pluck('name', 'city_id');
        return response()->json($city);
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
            'harga_total' => 'required|numeric',
            'kategori_id' => 'required|exists:kategoris,id',
            'foto.*' => 'required|mimes:png,jpg|max:2048'
        ]);
        if ($v->fails()) {
            dd($v->errors()->all());
            return back()->withErrors($v)->withInput();
        } else {
            // $pin = mt_rand(100, 999)
            //         .mt_rand(100, 999);
            // $date = date("Y");
            // $kode = "BG".$date.$pin;
            $faker = \Faker\Factory::create('id_ID');

            $kode = $faker->unique()->ean13;
            $barang = Barang::create(array_merge($request->only('nama_barang','harga_barang','satuan','jumlah','harga_total','deskripsi'),[
                'kode_barang' => $kode,
                'pemasok_id' => Auth::user()->pemasok_id,
                'kategori_id' => $request->kategori_id
            ]));

            if($request->hasfile('foto'))
            {
                foreach($request->file('foto') as $image)
                {
                    $name = rand(). '.' . $image->getClientOriginalExtension();
                    $image->move(public_path("upload/foto/barang"), $name);

                    FotoBarang::create([
                        'barang_id' => $barang->id,
                        'foto' => 'upload/foto/barang/'.$name,
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
        $barang = Barang::find($id);
        // dd($barang);
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
            $request->foto->move(public_path("upload/foto/barang"), $foto);

            FotoBarang::create([
                'barang_id' => $barang->id,
                'foto' => 'upload/foto/barang/'.$foto,
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
            $request->foto->move(public_path("upload/foto/barang"), $foto);

            $data->update([
                // 'barang_id' => $barang->id,
                'foto' => 'upload/foto/barang/'.$foto,
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
