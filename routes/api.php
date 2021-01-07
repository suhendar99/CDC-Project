<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/v1/getBarang/{id}','v1\BarangController@show');
Route::get('/v1/getGudang/{id}','v1\GudangController@show');
Route::get('/v1/getPemasok/{id}','v1\PemasokController@show');
Route::get('/v1/getPelanggan/{id}','v1\PelangganController@show');
Route::get('/v1/getKabupaten/{id}','v1\DashboardController@getKabupaten');
Route::get('/v1/getKecamatan/{id}','v1\DashboardController@getKecamatan');
Route::get('/v1/getDesa/{id}','v1\DashboardController@getDesa');
Route::get('/v1/storage/barang/{kode}', 'v1\StorageInController@checkBarang');
Route::get('/v1/detail/storage/in/{id}', 'v1\StorageInController@detail');
Route::get('/v1/detail/storage/out/{id}', 'v1\StorageOutController@detail');
