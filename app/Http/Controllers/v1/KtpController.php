<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\Pelanggan;
use App\Models\Pemasok;
use App\Models\PengurusGudang;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class KtpController extends Controller
{
    public function fotoKtp(Request $request,$id)
    {
        $auth = Auth::user();
        $data = User::find($id);
        $v = Validator::make($request->all(),[
            'foto_ktp' => 'required'
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        } else {
            if ($auth->pemasok_id != null) {
                $dateNow = Carbon::now()->format('Ymdhis');
                $image = $request->foto_ktp;  // your base64 encoded
                $image = str_replace('data:image/png;base64,', '', $image);
                $image = str_replace(' ', '+', $image);
                $imageName = 'Foto-KTP-Pemasok-'.$dateNow.'.jpeg';
                File::put(public_path(). '/upload/foto/Foto-KTP/' . $imageName, base64_decode($image));

                $info = getimagesize(public_path().'/upload/foto/Foto-KTP/'.$imageName);

                $foto = imagecreatefrompng(public_path().'/upload/foto/Foto-KTP/'.$imageName);
                imagejpeg($foto,public_path().'/upload/foto/Foto-KTP/'.$imageName, 70);

                $set = Pemasok::find($data->pemasok_id);

                $set->update([
                    'foto_ktp' => '/upload/foto/Foto-KTP/'.$imageName
                ]);
                $data->update([
                    'status' => 3
                ]);
            } elseif ($auth->pelanggan_id != null) {
                $dateNow = Carbon::now()->format('Ymdhis');
                $image = $request->foto_ktp;  // your base64 encoded
                $image = str_replace('data:image/png;base64,', '', $image);
                $image = str_replace(' ', '+', $image);
                $imageName = 'Foto-KTP-Pelanggan-'.$dateNow.'.jpeg';
                File::put(public_path(). '/upload/foto/Foto-KTP/' . $imageName, base64_decode($image));

                $info = getimagesize(public_path().'/upload/foto/Foto-KTP/'.$imageName);

                $foto = imagecreatefrompng(public_path().'/upload/foto/Foto-KTP/'.$imageName);
                imagejpeg($foto,public_path().'/upload/foto/Foto-KTP/'.$imageName, 70);

                $set = Pelanggan::find($data->pelanggan_id);

                $set->update([
                    'foto_ktp' => '/upload/foto/Foto-KTP/'.$imageName
                ]);
                $data->update([
                    'status' => 3
                ]);
            } elseif ($auth->pengurus_gudang_id != null) {
                $dateNow = Carbon::now()->format('Ymdhis');
                $image = $request->foto_ktp;  // your base64 encoded
                $image = str_replace('data:image/png;base64,', '', $image);
                $image = str_replace(' ', '+', $image);
                $imageName = 'Foto-KTP-PengurusGudang-'.$dateNow.'.jpeg';
                File::put(public_path(). '/upload/foto/Foto-KTP/' . $imageName, base64_decode($image));

                $info = getimagesize(public_path().'/upload/foto/Foto-KTP/'.$imageName);

                $foto = imagecreatefrompng(public_path().'/upload/foto/Foto-KTP/'.$imageName);
                imagejpeg($foto,public_path().'/upload/foto/Foto-KTP/'.$imageName, 70);

                $set = PengurusGudang::find($data->pengurus_gudang_id);

                $set->update([
                    'foto_ktp' => '/upload/foto/Foto-KTP/'.$imageName
                ]);
                $data->update([
                    'status' => 3
                ]);
            } elseif ($auth->bank_id != null) {
                $dateNow = Carbon::now()->format('Ymdhis');
                $image = $request->foto_ktp;  // your base64 encoded
                $image = str_replace('data:image/png;base64,', '', $image);
                $image = str_replace(' ', '+', $image);
                $imageName = 'Foto-KTP-Bank-'.$dateNow.'.jpeg';
                File::put(public_path(). '/upload/foto/Foto-KTP/' . $imageName, base64_decode($image));

                $info = getimagesize(public_path().'/upload/foto/Foto-KTP/'.$imageName);

                $foto = imagecreatefrompng(public_path().'/upload/foto/Foto-KTP/'.$imageName);
                imagejpeg($foto,public_path().'/upload/foto/Foto-KTP/'.$imageName, 70);

                $set = Bank::find($data->bank_id);

                $set->update([
                    'foto_ktp' => '/upload/foto/Foto-KTP/'.$imageName
                ]);
                $data->update([
                    'status' => 3
                ]);
            }
            if ($set = true) {
                return redirect('v1/dashboard')->with('success',  __('Foto KTP Sudah Diambil, Terima Kasih.'));
            } else {
                return redirect('v1/dashboard')->with('failed',  __('Update Data Gagal.'));
            }
        }
    }
    public function fotoKtpSelfie(Request $request,$id)
    {
        $auth = Auth::user();
        $data = User::find($id);
        $v = Validator::make($request->all(),[
            'foto_ktp_selfie' => 'required'
        ]);

        if ($v->fails()) {
            return back()->withErrors($v)->withInput();
        } else {
            if ($auth->pemasok_id != null) {
                $dateNow = Carbon::now()->format('Ymdhis');
                $image = $request->foto_ktp_selfie;  // your base64 encoded
                $image = str_replace('data:image/png;base64,', '', $image);
                $image = str_replace(' ', '+', $image);
                $imageName = 'Foto-KTP-Selfie-Pemasok-'.$dateNow.'.jpeg';
                File::put(public_path(). '/upload/foto/Foto-KTP-Selfie/' . $imageName, base64_decode($image));

                $info = getimagesize(public_path().'/upload/foto/Foto-KTP-Selfie/'.$imageName);

                $foto = imagecreatefrompng(public_path().'/upload/foto/Foto-KTP-Selfie/'.$imageName);
                imagejpeg($foto,public_path().'/upload/foto/Foto-KTP-Selfie/'.$imageName, 70);

                $set = Pemasok::find($data->pemasok_id);

                $set->update([
                    'foto_ktp_selfie' => '/upload/foto/Foto-KTP-Selfie/'.$imageName
                ]);
                $data->update([
                    'status' => 0
                ]);
            } elseif ($auth->pelanggan_id != null) {
                $dateNow = Carbon::now()->format('Ymdhis');
                $image = $request->foto_ktp_selfie;  // your base64 encoded
                $image = str_replace('data:image/png;base64,', '', $image);
                $image = str_replace(' ', '+', $image);
                $imageName = 'Foto-KTP-Selfie-Pelanggan-'.$dateNow.'.jpeg';
                File::put(public_path(). '/upload/foto/Foto-KTP-Selfie/' . $imageName, base64_decode($image));

                $info = getimagesize(public_path().'/upload/foto/Foto-KTP-Selfie/'.$imageName);

                $foto = imagecreatefrompng(public_path().'/upload/foto/Foto-KTP-Selfie/'.$imageName);
                imagejpeg($foto,public_path().'/upload/foto/Foto-KTP-Selfie/'.$imageName, 70);

                $set = Pelanggan::find($data->pelanggan_id);

                $set->update([
                    'foto_ktp_selfie' => '/upload/foto/Foto-KTP-Selfie/'.$imageName
                ]);
                $data->update([
                    'status' => 0
                ]);
            } elseif ($auth->pengurus_gudang_id != null) {
                $dateNow = Carbon::now()->format('Ymdhis');
                $image = $request->foto_ktp_selfie;  // your base64 encoded
                $image = str_replace('data:image/png;base64,', '', $image);
                $image = str_replace(' ', '+', $image);
                $imageName = 'Foto-KTP-Selfie-PengurusGudang-'.$dateNow.'.jpeg';
                File::put(public_path(). '/upload/foto/Foto-KTP-Selfie/' . $imageName, base64_decode($image));

                $info = getimagesize(public_path().'/upload/foto/Foto-KTP-Selfie/'.$imageName);

                $foto = imagecreatefrompng(public_path().'/upload/foto/Foto-KTP-Selfie/'.$imageName);
                imagejpeg($foto,public_path().'/upload/foto/Foto-KTP-Selfie/'.$imageName, 70);

                $set = PengurusGudang::find($data->pengurus_gudang_id);

                $set->update([
                    'foto_ktp_selfie' => '/upload/foto/Foto-KTP-Selfie/'.$imageName
                ]);
                $data->update([
                    'status' => 0
                ]);
            } elseif ($auth->bank_id != null) {
                $dateNow = Carbon::now()->format('Ymdhis');
                $image = $request->foto_ktp_selfie;  // your base64 encoded
                $image = str_replace('data:image/png;base64,', '', $image);
                $image = str_replace(' ', '+', $image);
                $imageName = 'Foto-KTP-Selfie-Bank-'.$dateNow.'.jpeg';
                File::put(public_path(). '/upload/foto/Foto-KTP-Selfie/' . $imageName, base64_decode($image));

                $info = getimagesize(public_path().'/upload/foto/Foto-KTP-Selfie/'.$imageName);

                $foto = imagecreatefrompng(public_path().'/upload/foto/Foto-KTP-Selfie/'.$imageName);
                imagejpeg($foto,public_path().'/upload/foto/Foto-KTP-Selfie/'.$imageName, 70);

                $set = Bank::find($data->bank_id);

                $set->update([
                    'foto_ktp_selfie' => '/upload/foto/Foto-KTP-Selfie/'.$imageName
                ]);
                $data->update([
                    'status' => 0
                ]);
            }
            if ($set = true) {
                return redirect('v1/dashboard')->with('success',  __('Foto Selfie KTP Sudah Diambil, Terima Kasih.'));
            } else {
                return redirect('v1/dashboard')->with('failed',  __('Update Data Gagal.'));
            }
        }
    }

}
