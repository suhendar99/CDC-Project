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


Route::group(['prefix' => 'v1', 'namespace' => 'v1'], function () {
  	Route::get('detailBarang/{id}','BarangController@detail');
  	Route::get('detailGudang/{id}','TransaksiPemasokController@selectedGudang');
});

Route::get('citiesLoad/{id}', function($id){
    dd($id);
})->name('citiesLoad');

Route::get('/v1/getBarang/{id}','v1\BarangController@show');
Route::get('/v1/getPoPemasok/{id}','v1\PoController@show');
// Route::get('/v1/getDataGudang/{id}','v1\GudangController@show');
Route::get('/v1/getPemesananPelanggan/{id}','v1\PemesananController@show');
Route::get('/v1/getFotoKtp/{id}','v1\UserController@show');
Route::get('/v1/getGudang/{id}','v1\GudangController@show');
Route::get('/v1/getGudang/{id}/bulky','v1\GudangBulkyController@show');
Route::get('/v1/getPemasok/{id}','v1\PemasokController@show');
Route::get('/v1/getPelanggan/{id}','v1\PelangganController@show');
Route::get('/v1/getKabupaten/{id}','v1\DashboardController@getKabupaten');
Route::get('/v1/getKecamatan/{id}','v1\DashboardController@getKecamatan');
Route::get('/v1/getDesa/{id}','v1\DashboardController@getDesa');
Route::get('/v1/getDataPemesanan/{id}','v1\PemesananController@getPemesanan');
Route::get('/v1/storage/barang/{kode}', 'v1\StorageInController@checkBarang');
Route::get('/v1/check/barang/{kode}', 'v1\StorageController@check');
Route::get('/v1/storage/out/gudang/{kode}/barang', 'v1\StorageOutController@findBarang');
Route::get('/v1/detail/storage/in/{id}', 'v1\StorageInController@detail');
Route::get('/v1/detail/bulky/storage/in/{id}', 'v1\StorageMasukBulkyController@detail');
Route::get('/v1/detail/storage/out/{id}', 'v1\StorageOutController@detail');
Route::get('/v1/detail/bank/{id}', 'v1\BankController@detail');
Route::get('/v1/geocode', 'v1\GudangController@geocode');
Route::get('/v1/storage/rak/{id}', 'v1\StorageController@tingkatRak');
Route::get('/v1/bulky/storage/rak/{id}', 'v1\StorageBulkyController@tingkatRak');
Route::get('/v1/rak/{id}/barang', 'v1\GudangController@detailBarang');
Route::get('/v1/bulky/rak/{id}/barang', 'v1\GudangBulkyController@detailBarang');
Route::get('/v1/barang/pesanan/{id}', 'v1\ReturController@barangPesanan');
Route::get('/v1/detail/penyimpanan/stock', 'v1\StorageController@detail');
Route::get('/v1/detail/bulky/penyimpanan/stock/{id}', 'v1\StorageBulkyController@detail');
Route::get('/v1/gudang/{id}/status', 'v1\GudangController@changeStatus');
Route::get('/v1/bulky/{id}/status', 'v1\GudangBulkyController@changeStatus');
Route::get('/v1/rak/{id}/status', 'v1\RakController@changeStatus');
Route::get('/v1/bulky/rak/{id}/status', 'v1\RakBulkyController@changeStatus');
Route::get('/v1/getGudang/{id}/user', function($id){
	$data = App\Models\Gudang::where('user_id', $id)->get();

	return response()->json([
		'data' => $data
	],200);
});
Route::get('/v1/getPesanan/{id}', 'v1\PemesananController@getPesanan');
Route::get('/v1/bulky/getPesanan/{id}', 'v1\PemesananBulkyController@getPesanan');
Route::get('/v1/bulky/detail/pemesanan/{id}', 'v1\PemesananBulkyController@detail');
