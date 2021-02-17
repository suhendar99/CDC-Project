<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\ReturKeluarBulky;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ReturBulkyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = ReturKeluarBulky::with('barang')
            ->whereHas('barang',function($q){
                $q->where('pemasok_id',Auth::user()->pemasok_id);
            })
            ->orderBy('id', 'desc')
            ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    return '<a href="#" class="btn btn-danger btn-sm" onclick="sweet('.$data->id.')">Hapus</a>';
                })
                ->addColumn('status', function($data){
                    if ($data->status == 2) {
                        return "<span class='text-danger'>Retur telah ditolak</span>";
                    } elseif ($data->status == 1) {
                        return "<span class='text-success'>Retur telah diterima</span>";
                    } elseif ($data->status == null) {
                        return '<a href="'.route('retur-status-tolak',$data->id).'" class="btn btn-danger btn-sm">Tolak</a>&emsp;<a href="'.route('retur-status-terima',$data->id).'" class="btn btn-success btn-sm">Terima</a>';
                    }
                })
                ->editColumn('created_at',function($data){
                    return date('d-m-Y H:i:s', strtotime($data->created_at));
                })
                ->rawColumns(['status','action'])
                ->make(true);
        }

        return view('app.transaksi.retur-masuk-pemasok.index');
    }

    public function terima($id)
    {
        $data = ReturKeluarBulky::find($id);
        $data->update([
            'status' => 1
        ]);
        return back()->with('success','Retur Diterima');
    }
    public function tolak($id)
    {
        $data = ReturKeluarBulky::find($id);
        $data->update([
            'status' => 2
        ]);
        return back()->with('error','Retur Ditolak');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
