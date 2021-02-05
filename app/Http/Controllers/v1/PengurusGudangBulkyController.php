<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Models\Bank;
use App\Mail\SendPasswordMail;
use App\Models\GudangBulky;
use App\Models\PengurusGudangBulky;
use App\User;

class PengurusGudangBulkyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $gudang = [];
            foreach (auth()->user()->pengurusGudangBulky->bulky as $value) {
                $gudang[] = $value->id;
            }

            $data = User::with('pengurusGudangBulky.bulky')->whereHas('pengurusGudangBulky.bulky', function($query)use($gudang){
                $query->whereIn('bulky_id', $gudang);
            })->whereHas('pengurusGudangBulky', function($query){
                $query->where('status', 0);
            })
            ->orderBy('id', 'desc')
            ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    return '<div class="text-center" style="width: 100%"><a href="/v1/bulky/pengurus/'.$data->id.'/edit" class="btn btn-primary btn-sm">Edit</a>&nbsp;<a href="#" class="btn btn-danger btn-sm" onclick="sweet('.$data->id.')">Hapus</a></div>';
                })
                ->make(true);
        }

        // dd(User::has('pengurusGudang')->get());

        return view('app.data-master.gudangBulky.akun.pengurus.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $gudang = auth()->user()->pengurusGudangBulky->bulky;
        return view('app.data-master.gudangBulky.akun.pengurus.create', compact('gudang'));
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
            'name' => 'required|string|max:50',
            'username' => 'required|string|max:50',
            'telepon' => 'required|numeric',
            'email' => 'required|email|unique:users,email',
            'bulky_id' => 'required|exists:gudang_bulkies,id'
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        }

        $faker = \Faker\Factory::create('id_ID');

        $password = $faker->unique()->regexify('([A-Za-z0-9]{10})');

        Mail::to($request->email)->send(new SendPasswordMail($password));

        $pengurus = PengurusGudangBulky::create([
            'nama' => $request->name,
            'telepon' => $request->telepon,
        ]);

        User::create($request->only('name', 'username', 'email')+[
            'password' => Hash::make($password),
            'pengurus_gudang_bulky_id' => $pengurus->id,
            'status' => 1
        ]);

        DB::table('akun_gudang_bulkys')->insert([
            'bulky_id' => $request->bulky_id,
            'pengurus_bulky_id' => $pengurus->id,
            'created_at' => now('Asia/Jakarta')
        ]);



        return redirect(route('bulky.pengurus.index'))->with('success', __( 'Akun pengurus telah dibuat !' ));
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
        $gudang = auth()->user()->pengurusGudangBulky->bulky;

        $arr = [];

        foreach (auth()->user()->pengurusGudangBulky->bulky as $value) {
            $arr[] = $value->id;
        }

        $data = User::with('pengurusGudangBulky.bulky')->whereHas('pengurusGudangBulky.bulky', function($query)use($arr){
                $query->whereIn('bulky_id', $arr);
        })->whereHas('pengurusGudangBulky', function($query){
            $query->where('status', 0);
        })
        ->findOrFail($id);

        return view('app.data-master.gudangBulky.akun.pengurus.edit', compact('gudang', 'data'));
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
            'name' => 'required|string|max:50',
            'username' => 'required|string|max:50',
            'telepon' => 'required|numeric',
            'email' => 'required|email|unique:users,email,'.$id,
            'bulky_id' => 'required|exists:gudangs,id'
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        }
        $user = User::with('pengurusGudangBulky')->findOrFail($id);

        PengurusGudangBulky::find($user->pengurusGudangBulky->id)->update([
            'nama' => $request->name,
            'telepon' => $request->telepon,
        ]);
        $user->update($request->only('username', 'email'));

        DB::table('akun_gudang_bulkys')->where('pengurus_bulky_id', $user->pengurus_gudang_bulky_id)->update([
            'bulky_id' => $request->bulky_id,
        ]);

        return redirect(route('bulky.pengurus.index'))->with('success', __( 'Pengurus akun telah di edit' ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $arr = [];

        foreach (auth()->user()->pengurusGudangBulky->bulky as $value) {
            $arr[] = $value->id;
        }

        $user = User::with('pengurusGudangBulky.bulky')->whereHas('pengurusGudangBulky.bulky', function($query)use($arr){
                $query->whereIn('bulky_id', $arr);
        })->whereHas('pengurusGudangBulky', function($query){
            $query->where('status', 0);
        })
        ->findOrFail($id);

        PengurusGudangBulky::where('id', $user->pengurus_gudang_bulky_id)->first()->delete();

        $user->delete();

        return back()->with('success', __( 'Akun pengurus dihapus !' ));
    }
}
