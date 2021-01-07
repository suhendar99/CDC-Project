<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Kategori;
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
            $data = $this->Data->getData();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    return '<a href="/v1/barang/'.$data->id.'/edit" class="btn btn-primary btn-sm">Edit</a>&nbsp;<a href="#" class="btn btn-danger btn-sm" onclick="sweet('.$data->id.')">Hapus</a>';
                })
                ->addColumn('barcode', function($data){
                    return '<img src="data:image/png;base64,'.\DNS1D::getBarcodePNG($data->kode_barang, 'C39E',1,65,array(0,0,0), true).'" alt="barcode" />';
                })
                ->addColumn('jumsat', function($data){
                    return $data->jumlah.' '.$data->satuan;
                })
                ->rawColumns(['barcode','action','jumsat'])
                ->make(true);
        }
        return view($this->path.'index');
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
        return view($this->path.'create',compact('kategori'));
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
            'nama_barang' => 'required|string|max:20',
            'harga_barang' => 'required|string|max:20',
            // 'kode_barang' => 'required|string|max:100',
            'satuan' => 'required|string|max:10',
            'jumlah' => 'required|numeric',
            'harga_satuan' => 'required|numeric',
            'harga_total' => 'required|numeric',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'kategori_id' => 'required|exists:kategoris,id'
        ]);
        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        } else {
            // $pin = mt_rand(100, 999)
            //         .mt_rand(100, 999);
            // $date = date("Y");
            // $kode = "BG".$date.$pin;
            $faker = \Faker\Factory::create('id_ID');

            $kode = $faker->unique()->ean13;
            if ($request->file('foto')) {
                $name = $request->file('foto');
                $foto = time()."_".$name->getClientOriginalName();
                $request->foto->move(public_path("upload/foto/barang"), $foto);
                Barang::create(array_merge($request->only('nama_barang','harga_barang','satuan','jumlah','harga_total'),[
                    'foto' => 'upload/foto/barang/'.$foto,
                    'kode_barang' => $kode,
                    'pemasok_id' => Auth::user()->pemasok_id,
                    'kategori_id' => $request->kategori_id
                ]));
            } else {
                Barang::create(array_merge($request->only('nama_barang','harga_barang','satuan','jumlah','harga_total'),[
                    'kode_barang' => $kode,
                    'pemasok_id' => Auth::user()->pemasok_id,
                    'kategori_id' => $request->kategori_id
                ]));
            }
        }
        return back()->with('success',$this->alert.'Disimpan !');
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $kategori = Kategori::all();
        $data = Barang::find($id);
        return view($this->path.'edit',compact('kategori','data'));
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
            'jumlah' => 'required|numeric',
            'harga_satuan' => 'required|numeric',
            'harga_total' => 'required|numeric',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
            'kategori_id' => 'required|exists:kategoris,id'
        ]);
        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        } else {
            $barang = Barang::find($id);
            if ($request->file('foto')) {
                File::delete($barang->foto);
                $name = $request->file('foto');
                $foto = time()."_".$name->getClientOriginalName();
                $request->foto->move(public_path("upload/foto/barang"), $foto);
                $barang->update(array_merge($request->only('nama_barang','harga_barang','satuan','jumlah','harga_total'),[
                    'foto' => 'upload/foto/barang/'.$foto,
                    // 'kode_barang' => $request->kode_barang,
                    'kategori_id' => $request->kategori_id
                ]));
            } else {
                $barang->update(array_merge($request->only('nama_barang','harga_barang','satuan','jumlah','harga_total'),[
                    'kategori_id' => $request->kategori_id,
                    // 'kode_barang' => $request->kode_barang,
                ]));
            }
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
