<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes(['verify' => true]);

Route::get('/home', function (){
	return redirect('v1/dashboard');
})->name('home');

Route::group(['prefix' => 'v1', 'namespace' => 'v1','middleware' => 'auth'], function () {
    //Dashboard
    Route::get('dashboard','DashboardController@index')->name('dashboard');
    // Complete Akun
    Route::post('completeAkun/{id}','DashboardController@complete')->name('complete.akun');
    //Approval
    Route::get('approval', 'DashboardController@approval')->name('approval');

    Route::group(['middleware' => ['admin']], function () {
        // User
        Route::resource('user', 'UserController');
        Route::get('/user/{id}/approve', 'UserController@approve')->name('admin.users.approve');
        Route::get('/user/{id}/unapprove', 'UserController@unapprove')->name('admin.users.unapprove');
        // Pemasok
        Route::resource('pemasok', 'PemasokController');
        // Pembeli
        Route::resource('pelanggan', 'PelangganController');
        // Gudang
        Route::resource('gudang', 'GudangController');
    });
    Route::group(['middleware' => ['pemasok']], function () {
        // Barang
        Route::resource('barang', 'BarangController');
    });
    Route::group(['middleware' => ['bank']], function () {

    });
    Route::group(['middleware' => ['pelanggan']], function () {
        // Barang funtuk pembeli
        Route::get('barangs','BarangController@getBarangByPelanggan')->name('get-barang');
    });
    Route::group(['middleware' => ['karyawan']], function () {

    });
});
