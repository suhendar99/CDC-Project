<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Bank;
use App\User;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = Bank::orderBy('id', 'desc')
            ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    return '<a href="/v1/bank/'.$data->id.'/edit" class="btn btn-primary btn-sm">Edit</a>&nbsp;<a class="btn btn-info btn-sm" data-toggle="modal" data-target="#exampleModal" onclick="detail('.$data->id.')" data-id="'.$data->id.'" style="cursor: pointer;" title="Detail">Detail</a>&nbsp;<a href="#" class="btn btn-danger btn-sm" onclick="sweet('.$data->id.')">Hapus</a>';
                })
                ->make(true);
        }

        return view('app.data-master.bank.index');
    }

    public function detail($id)
    {
        $bank = Bank::with('user')->find($id);

        return response()->json([
            'data' => $bank
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('app.data-master.bank.create');
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
            'nama_akun' => 'required|string|max:50',
            'nama_bank' => 'required|string|max:50',
            'tahun_berdiri' => 'required|integer|max:2022',
            'username' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email',
            'telepon' => 'required|string|regex:/(08)[0-9]{9}/',
            'alamat' => 'required|string|max:65534',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        }

        $bank = Bank::create($request->only('tahun_berdiri', 'alamat', 'telepon')+[
            'nama' => $request->nama_bank
        ]);

        User::create([
            'name' => $request->nama_akun,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make('12341234'),
            'bank_id' => $bank->id
        ]);

        if ($request->file('foto')) {
            $foto = $request->file('foto');
            $nama = time()."_".$foto->getClientOriginalName();
            $foto->move(public_path("upload/foto/bank"), $nama);

            $bank->update([
                'foto' => 'upload/foto/bank/'.$nama
            ]);
        }
        
        return redirect(route('bank.index'))->with('success', __( 'Bank Created' ));
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
        $data = Bank::with('user')->findOrFail($id);
        return view('app.data-master.bank.edit', compact('data'));
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
            'nama_bank' => 'required|string|max:50',
            'tahun_berdiri' => 'required|integer|max:2022',
            'telepon' => 'required|string|regex:/(08)[0-9]{9}/',
            'alamat' => 'required|string|max:65534',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        }

        $bank = Bank::findOrFail($id);

        $bank->update($request->only('tahun_berdiri', 'alamat', 'telepon')+[
            'nama' => $request->nama_bank
        ]);

        if ($request->file('foto')) {

            File::delete($bank->foto);

            $foto = $request->file('foto');
            $nama = time()."_".$foto->getClientOriginalName();
            $foto->move(public_path("upload/foto/bank"), $nama);

            $bank->update([
                'foto' => 'upload/foto/bank/'.$nama
            ]);
        }
        
        return redirect(route('bank.index'))->with('success', __( 'Bank Updated' ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bank = Bank::findOrFail($id);

        File::delete($bank->foto);

        $bank->delete();

        return back()->with('success', __( 'Bank Deleted' ));
    }
}
