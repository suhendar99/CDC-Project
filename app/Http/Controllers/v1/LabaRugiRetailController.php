<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;
use App\Models\LabaRugiRetail;
use Illuminate\Support\Facades\Auth;

class LabaRugiRetailController extends Controller
{
    function __construct(LabaRugiRetail $labarugiretail)
    {
        $this->model = $labarugiretail;

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $data = $this->model::orderBy('bulan', 'asc')
            ->where('retail_id',Auth::user()->pengurus_gudang_id)
            ->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    return '<a href="/v1/retail/laba-rugi/'.$data->id.'/edit" class="btn btn-primary btn-sm">Edit</a>&nbsp;<a href="#" class="btn btn-danger btn-sm" onclick="sweet('.$data->id.')">Hapus</a>';
                })
                ->editColumn('created_at',function($data){
                    return date('d-m-Y H:i:s', strtotime($data->created_at));
                })
                ->make(true);
        }

        return view('app.transaksi.rekapitulasi.laba-rugi-retail.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = $this->model::all();
        return view('app.transaksi.rekapitulasi.laba-rugi-retail.create',compact('data'));
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
            'bulan' => 'required|integer|min:1|max:12',
            'laba_kotor' => 'required|integer|min:1',
            'penjualan' => 'required|integer|min:1',
            'pembelian' => 'required|integer|min:1',
            'biaya_operasional' => 'required|integer|min:1'
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        }

        $laba_bersih = $request->penjualan - ($request->pembelian + $request->biaya_operasional);

        $this->model::create($request->only('bulan', 'laba_kotor', 'penjualan', 'pembelian', 'biaya_operasional')+[
            'laba_bersih' => $laba_bersih,
            'retail_id' => Auth::user()->pengurus_gudang_id
        ]);

        return redirect(route('retail.laba-rugi.index'))->with('success', __( 'Data Berhasil Dibuat' ));
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
        $data = $this->model::findOrFail($id);

        return view('app.transaksi.rekapitulasi.laba-rugi-retail.edit', compact('data'));
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
            'bulan' => 'required|integer|min:1|max:12',
            'laba_kotor' => 'required|integer|min:1',
            'penjualan' => 'required|integer|min:1',
            'pembelian' => 'required|integer|min:1',
            'biaya_operasional' => 'required|integer|min:1'
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        }

        $laba_bersih = $request->penjualan - ($request->pembelian + $request->biaya_operasional);

        $this->model::findOrFail($id)->update($request->only('bulan', 'laba_kotor', 'penjualan', 'pembelian', 'biaya_operasional')+[
            'laba_bersih' => $laba_bersih
        ]);

        return redirect(route('retail.laba-rugi.index'))->with('success', __( 'Data Berhasil Diedit' ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = $this->model::findOrFail($id);
        $data->delete();
        return redirect(route('retail.laba-rugi.index'))->with('success', __( 'Data Berhasil Dihapus' ));
    }
}
