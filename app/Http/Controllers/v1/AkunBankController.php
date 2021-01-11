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
use App\User;

class AkunBankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = User::with('bank')
            ->whereNotNull('bank_id')
            ->orderBy('id', 'desc')
            ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    return '<div class="text-center" style="width: 100%"><a href="/v1/akun-bank/'.$data->id.'/edit" class="btn btn-outline-primary btn-sm" style="border-width: 3px;border-radius: 5px;">Edit</a>&nbsp;<a href="#" class="btn btn-outline-danger btn-sm" onclick="sweet('.$data->id.')" style="border-width: 3px;border-radius: 5px;">Hapus</a></div>';
                })
                ->make(true);
        }

        return view('app.data-master.bank.akun.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bank = Bank::all();
        return view('app.data-master.bank.akun.create', compact('bank'));
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
            'email' => 'required|email|unique:users,email',
            'bank_id' => 'required|exists:banks,id'
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        }

        $faker = \Faker\Factory::create('id_ID');

        $password = $faker->unique()->regexify('([A-Za-z0-9]{10})');

        Mail::to($request->email)->send(new SendPasswordMail($password));

        User::create($request->only('name', 'username', 'email', 'bank_id')+[
            'password' => Hash::make($password),
            'status' => 1
        ]);

        return redirect(route('akun-bank.index'))->with('success', __( 'Bank Account Created' ));
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
        $bank = Bank::all();
        $akun = User::where('id', $id)->whereNotNull('bank_id')->first();
        return view('app.data-master.bank.akun.edit', compact('bank', 'akun'));
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
            'email' => 'required|email|unique:users,email,'.$id,
            'bank_id' => 'required|exists:banks,id'
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        }

        $user = User::whereNotNull('bank_id')->findOrFail($id);

        $user->update($request->only('name', 'username', 'email', 'bank_id'));

        return redirect(route('akun-bank.index'))->with('success', __( 'Bank Account Updated' ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::whereNotNull('bank_id')->findOrfail($id)->delete();

        return back()->with('success', __( 'Bank Account Deleted' ));
    }
}
