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
    Route::group(['middleware' => ['admin']], function () {

    });
    Route::group(['middleware' => ['pemasok']], function () {
        Route::resource('barang', 'BarangController');
    });
    Route::group(['middleware' => ['bank']], function () {

    });
    Route::group(['middleware' => ['pelanggan']], function () {

    });
    Route::group(['middleware' => ['karyawan']], function () {

    });
    // User
    Route::resource('user', 'UserController');
    // Pemasok
    Route::resource('pemasok', 'PemasokController');
    // Barang
});
