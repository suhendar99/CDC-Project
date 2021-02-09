<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Mail;
use App\Models\Bank;
use App\Mail\SendPasswordMail;
use App\Models\Gudang;
use App\Models\PengurusGudang;
use App\User;

class PemilikGudangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = PengurusGudang::orderBy('id', 'desc')
            ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    return '<div class="text-center" style="width: 100%"><a href="/v1/pemilik-gudang-retail/'.$data->id.'/edit" class="btn btn-primary btn-sm">Edit</a>&nbsp;<a href="#" class="btn btn-danger btn-sm" onclick="sweet('.$data->id.')">Hapus</a></div>';
                })
                ->addColumn('ttl',function($data){
                    if ($data->tgl_lahir != null && $data->tempat_lahir != null) {
                        return $data->tempat_lahir.', '.date('d-F-Y', strtotime($data->tgl_lahir));
                    } else {
                        return "";
                    }
                })
                ->editColumn('created_at',function($data){
                    if ($data->tgl_lahir != null && $data->tempat_lahir != null) {
                        return date('d-m-Y H:i:s', strtotime($data->created_at));
                    } else {
                        return "";
                    }
                })
                ->rawColumns(['action','ttl'])
                ->make(true);
        }

        return view('app.data-master.gudang.akun.pemilik.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('app.data-master.gudang.akun.pemilik.create');
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
            'nama' => 'required|string|max:50',
            'alamat' => 'required|string|max:200',
            'telepon' => 'required|string|regex:/(08)[0-9]{9}/',
            'nik' => 'required|numeric',
            'tempat_lahir' => 'required|string|max:30',
            'no_rek' => 'required',
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        }
        return redirect(route('pemilik-gudang.index'))->with('success', __( 'Pemilik Account Created' ));
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
        $data = User::whereHas('pengurusGudang', function($query){
                $query->where('status', 1);
            })->findOrFail($id);
        return view('app.data-master.gudang.akun.pemilik.edit', compact('data'));
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
            'email' => 'required|email|unique:users,email,'.$id
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        }

        User::findOrFail($id)->update($request->only('name', 'username', 'email'));

        return redirect(route('pemilik-gudang.index'))->with('success', __( 'Pemilik Account Updated' ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::whereHas('pengurusGudang', function($query){
                $query->where('status', 1);
            })
            ->findOrFail($id);

        PengurusGudang::where('id', $user->pengurus_gudang_id)->first()->delete();

        $user->delete();

        return back()->with('success', __( 'Pemilik Account Deleted' ));
    }
}
