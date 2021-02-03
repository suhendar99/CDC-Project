<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Rak;
use App\Models\TingkatanRak;
use App\Models\Gudang;

class RakController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $gudang)
    {
        if($request->ajax()){
            $data = Rak::with('gudang', 'tingkat')
            ->where('gudang_id', $gudang)
            ->withCount('tingkat')
            ->orderBy('id', 'desc')
            ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data)use($gudang){
                    if ($data->status == 0) {
                        return '<a href="/v1/gudang/'.$gudang.'/rak/'.$data->id.'/edit" class="btn btn-primary btn-sm">Edit</a>&nbsp;<a class="btn btn-info btn-sm" data-toggle="modal" data-target="#exampleModal" onclick="detail('.$data->id.')" data-id="'.$data->id.'" style="cursor: pointer;" title="Detail">Barang</a>&nbsp;<a href="#" class="btn btn-danger btn-sm" onclick="sweet('.$data->id.')">Hapus</a>&nbsp;<button type="button" href="#" class="btn btn-outline-dark btn-sm" id="status-rak-'.$data->id.'" onclick="change('.$data->id.','.$gudang.')" title="Klik untuk ubah status rak">Rak Tidak Penuh</button>';
                    } else {
                        return '<a href="/v1/gudang/'.$gudang.'/rak/'.$data->id.'/edit" class="btn btn-primary btn-sm">Edit</a>&nbsp;<a class="btn btn-info btn-sm" data-toggle="modal" data-target="#exampleModal" onclick="detail('.$data->id.')" data-id="'.$data->id.'" style="cursor: pointer;" title="Detail">Barang</a>&nbsp;<a href="#" class="btn btn-danger btn-sm" onclick="sweet('.$data->id.')">Hapus</a>&nbsp;<button type="button" class="btn btn-success btn-sm" id="status-rak-'.$data->id.'" onclick="change('.$data->id.','.$gudang.')" title="Klik untuk ubah status rak">Rak Penuh</button>';
                    }
                    
                })
                ->make(true);
        }
        $gudang = Gudang::findOrFail($gudang);

        return view('app.data-master.gudang.rak.index', compact('gudang'));
    }

    public function changeStatus($id)
    {
        $data = Rak::find($id);

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
    public function create($gudang)
    {
        $gudang = Gudang::findOrFail($gudang);

        return view('app.data-master.gudang.rak.create', compact('gudang'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $gudang)
    {
        $v = Validator::make($request->all(),[
            'nama' => [
                'required',
                'string',
                Rule::unique('raks')->where(function($query)use($gudang){
                    return $query->where('gudang_id', $gudang);
                })
            ],
            'panjang' => 'required|numeric|min:0',
            'lebar' => 'required|numeric|min:0',
            'tinggi' => 'required|numeric|min:0',
            'tingkat' => 'required|numeric|min:0',
            'kapasitas_berat' => 'required|numeric|min:0'
            // 'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        }

        $faker = \Faker\Factory::create('id_ID');

        $rak = Rak::create($request->only('nama', 'lebar', 'panjang', 'tinggi', 'kapasitas_berat')+[
            'gudang_id' => $gudang,
            'kode' => $faker->unique()->regexify('([A-Z]{3})+([0-9]{7})')
        ]);

        for ($i=1; $i <= (integer)$request->tingkat; $i++) { 
            TingkatanRak::create([
                'nama' => 'tingkat '.$i,
                'rak_id' => $rak->id
            ]);
        }

        return redirect(route('rak.index', ['gudang' => $gudang]))->with('success', __( 'Rak Created!' ));
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
    public function edit($gudang, $id)
    {
        $data = Rak::withCount('tingkat')->findOrFail($id);
        $gudang = Gudang::findOrFail($gudang);

        return view('app.data-master.gudang.rak.edit', compact('gudang', 'data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $gudang, $id)
    {
        $v = Validator::make($request->all(),[
            'nama' => [
                'required',
                'string',
                Rule::unique('raks')->where(function($query)use($gudang, $id){
                    return $query->where('gudang_id', $gudang);
                })->ignore($id)
            ],
            'panjang' => 'required|numeric|min:0',
            'lebar' => 'required|numeric|min:0',
            'tinggi' => 'required|numeric|min:0',
            'tingkat' => 'required|numeric|min:0',
            'kapasitas_berat' => 'required|numeric|min:0'
            // 'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        }

        // $faker = \Faker\Factory::create('id_ID');

        $rak = Rak::withCount('tingkat')->findOrFail($id);

        $rak->update($request->only('nama', 'lebar', 'panjang', 'tinggi', 'kapasitas_berat'));

        if ($request->tingkat > $rak->tingkat_count) {
            for ($i=((integer)$rak->tingkat_count + 1); $i <= (integer)$request->tingkat; $i++) { 
                TingkatanRak::create([
                    'nama' => 'tingkat '.$i,
                    'rak_id' => $id
                ]);
            }
        } elseif ($request->tingkat < $rak->tingkat_count) {
            for ($i=((integer)$rak->tingkat_count - 1); $i >= (integer)$request->tingkat; $i--) { 
                TingkatanRak::orderBy('id', 'desc')->first()->delete();
            }
        }

        return redirect(route('rak.index', ['gudang' => $gudang]))->with('success', __( 'Rak Updated!' ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($gudang, $id)
    {
        Rak::whereHas('gudang', function($query)use($gudang){
            $query->where('id', $gudang);
        })->findOrFail($id)->delete();

        return back()->with('success', __( 'Rak Deleted!' ));
    }
}
