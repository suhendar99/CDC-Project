<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\PengaturanAplikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class PengaturanAplikasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = PengaturanAplikasi::find(1);
        return view('app.pengaturanAplikasi.index',compact('data'));
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
        $v = Validator::make($request->all(),[
            'logo_app' => 'nullable|image|mimes:png,jpg,jpeg,svg',
            'logo_pemasok' => 'nullable|image|mimes:png,jpg,jpeg,svg',
            'logo_bulky' => 'nullable|image|mimes:png,jpg,jpeg,svg',
            'logo_retail' => 'nullable|image|mimes:png,jpg,jpeg,svg',
            'logo_warung' => 'nullable|image|mimes:png,jpg,jpeg,svg',
            'logo_pembeli' => 'nullable|image|mimes:png,jpg,jpeg,svg',
            'logo_tab' => 'nullable|image|mimes:jpg,png,jpeg,svg',
            'nama_app' => 'nullable|string|max:50',
            'nama_tab' => 'required|string|max:90',
            'copyright_text' => 'required',
            'copyright_link' => 'nullable',
        ]);
        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        } else {
            $data = PengaturanAplikasi::findOrFail($request->id)->update($request->only('nama_app','nama_tab','copyright_text','copyright_link'));

            if ($request->file('logo_app')) {
                // Delete
                $foto_public = PengaturanAplikasi::find($request->id);
                File::delete($foto_public->logo_app);

                // Update foto
                $foto = $request->file('logo_app');
                $name = time().'_'.$foto->getClientOriginalName();
                $foto->move('upload/PengaturanAplikasi/logo_app', $name);

                PengaturanAplikasi::find($request->id)->update(
                    array_merge($request->only('nama_app','nama_tab','copyright_text','copyright_link'),
                        ['logo_app'=> 'upload/PengaturanAplikasi/logo_app/'.$name],
                    )
                );
            }
            if ($request->file('logo_pemasok')) {
                // Delete
                $foto_public = PengaturanAplikasi::find($request->id);
                File::delete($foto_public->logo_pemasok);

                // Update foto
                $foto = $request->file('logo_pemasok');
                $name = time().'_'.$foto->getClientOriginalName();
                $foto->move('upload/PengaturanAplikasi/logo_pemasok', $name);

                PengaturanAplikasi::find($request->id)->update(
                    array_merge($request->only('nama_app','nama_tab','copyright_text','copyright_link'),
                        ['logo_pemasok'=> 'upload/PengaturanAplikasi/logo_pemasok/'.$name],
                    )
                );
            }
            if ($request->file('logo_bulky')) {
                // Delete
                $foto_public = PengaturanAplikasi::find($request->id);
                File::delete($foto_public->logo_bulky);

                // Update foto
                $foto = $request->file('logo_bulky');
                $name = time().'_'.$foto->getClientOriginalName();
                $foto->move('upload/PengaturanAplikasi/logo_bulky', $name);

                PengaturanAplikasi::find($request->id)->update(
                    array_merge($request->only('nama_app','nama_tab','copyright_text','copyright_link'),
                        ['logo_bulky'=> 'upload/PengaturanAplikasi/logo_bulky/'.$name],
                    )
                );
            }
            if ($request->file('logo_retail')) {
                // Delete
                $foto_public = PengaturanAplikasi::find($request->id);
                File::delete($foto_public->logo_retail);

                // Update foto
                $foto = $request->file('logo_retail');
                $name = time().'_'.$foto->getClientOriginalName();
                $foto->move('upload/PengaturanAplikasi/logo_retail', $name);

                PengaturanAplikasi::find($request->id)->update(
                    array_merge($request->only('nama_app','nama_tab','copyright_text','copyright_link'),
                        ['logo_retail'=> 'upload/PengaturanAplikasi/logo_retail/'.$name],
                    )
                );
            }
            if ($request->file('logo_warung')) {
                // Delete
                $foto_public = PengaturanAplikasi::find($request->id);
                File::delete($foto_public->logo_warung);

                // Update foto
                $foto = $request->file('logo_warung');
                $name = time().'_'.$foto->getClientOriginalName();
                $foto->move('upload/PengaturanAplikasi/logo_warung', $name);

                PengaturanAplikasi::find($request->id)->update(
                    array_merge($request->only('nama_app','nama_tab','copyright_text','copyright_link'),
                        ['logo_warung'=> 'upload/PengaturanAplikasi/logo_warung/'.$name],
                    )
                );
            }
            if ($request->file('logo_pembeli')) {
                // Delete
                $foto_public = PengaturanAplikasi::find($request->id);
                File::delete($foto_public->logo_pembeli);

                // Update foto
                $foto = $request->file('logo_pembeli');
                $name = time().'_'.$foto->getClientOriginalName();
                $foto->move('upload/PengaturanAplikasi/logo_pembeli', $name);

                PengaturanAplikasi::find($request->id)->update(
                    array_merge($request->only('nama_app','nama_tab','copyright_text','copyright_link'),
                        ['logo_pembeli'=> 'upload/PengaturanAplikasi/logo_pembeli/'.$name],
                    )
                );
            }
            if ($request->file('logo_tab')) {
                // Delete
                $foto_public = PengaturanAplikasi::find($request->id);
                File::delete($foto_public->logo_tab);

                // Update foto
                $foto = $request->file('logo_tab');
                $name = time().'_'.$foto->getClientOriginalName();
                $foto->move('upload/PengaturanAplikasi/logo_tab', $name);

                PengaturanAplikasi::find($request->id)->update(
                    array_merge($request->only('nama_app','nama_tab','copyright'),
                        ['logo_tab'=> 'upload/PengaturanAplikasi/logo_tab/'.$name],
                    )
                );
            }
            return back()->with('success','Data Updated !');

        }
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
