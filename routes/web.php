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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::group(['prefix' => 'v1', 'namespace' => 'v1','middleware' => 'auth'], function () {
	//Dashboard
	Route::get('dashboard','DashboardController@index')->name('dashboard');

    // User
    Route::resource('user', 'UserController');
    Route::group(['middleware' => ['admin']], function () {
        // User
        Route::resource('user', 'UserController');
        // Pemasok
        Route::resource('pemasok', 'PemasokController');
        // Pembeli
        Route::resource('pelanggan', 'PelangganController');
    });
    Route::group(['middleware' => ['pemasok']], function () {
        // Barang
        Route::resource('barang', 'BarangController');
    });
    Route::group(['middleware' => ['bank']], function () {

    });
    Route::group(['middleware' => ['pelanggan']], function () {
        Route::get('barangs','BarangController@getBarangByPelanggan')->name('get-barang');
    });
    Route::group(['middleware' => ['karyawan']], function () {

    });
});
