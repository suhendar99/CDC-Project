<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\RekeningPemasok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class RekeningPemasokController extends Controller
{
    public function __construct()
    {
        $this->Data = new RekeningPemasok;

        $this->path = 'app.data-master.rekening-pemasok.';
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
            $data = RekeningPemasok::orderBy('id','desc')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    return '<a href="/v1/pemasok/'.$data->id.'/edit" class="btn btn-primary btn-sm">Edit</a>&nbsp;<a class="btn btn-info btn-sm" data-toggle="modal" data-target="#exampleModal" onclick="detail('.$data->id.')" data-id="'.$data->id.'" style="cursor: pointer;" title="Detail">Detail</a>&nbsp;<a href="#" class="btn btn-danger btn-sm" onclick="sweet('.$data->id.')">Hapus</a>';
                })
                ->editColumn('created_at',function($data){
                    return date('d-m-Y H:i:s', strtotime($data->created_at));
                })
                ->make(true);
        }
        return view($this->path.'index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = RekeningPemasok::where('pemasok_id',Auth::user()->pemasok_id)->get();
        $bank = Bank::all();

        return view($this->path.'create',compact('data','bank'));
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
            'bank_id' => 'required|exists:banks,id',
            'pemilik' => 'required|string|max:50',
            'no_rek' => 'required|digits_between:1,16',
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        } else {
            RekeningPemasok::create(array_merge($request->only('bank_id','pemilik','no_rek'),['pemasok_id' => Auth::user()->pemasok_id]));
        }
        return back()->with('success',$this->alert.'ditambah !');
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
        $data = RekeningPemasok::find($id);
        $bank = Bank::all();

        return view($this->path.'edit',compact('data','bank'));
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
            'bank_id' => 'required|exists:banks,id',
            'pemilik' => 'required|string|max:50',
            'no_rek' => 'required|digits_between:1,16',
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        } else {
            $data = RekeningPemasok::find($id);
            $data->update(array_merge($request->only('bank_id','pemilik','no_rek')));
        }
        return back()->with('success',$this->alert.'diedit !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = RekeningPemasok::find($id);
        $data->delete();
        return back()->with('success',$this->alert.'dihapus !');
    }
}
