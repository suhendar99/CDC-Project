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
    // return view('auth.login');
    return view('app.shop.index');
});

Route::get('test', function () {
    return view('app.transaksi.pembelian-barang.pelanggan.stepper');
});

Route::get('/verification','Auth\RegisterController@verify');

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
    // Pengaturan Akun User
        // Admin
    Route::get('pengaturan-akun-admin','PengaturanAkunController@showFormUpdateAkunAdmin')->name('setAdmin.show');
    Route::post('pengaturan-akun-admins','PengaturanAkunController@updateAkunAdmin')->name('setAdmin.action');
        // Pelanggan
    Route::get('pengaturan-akun-pelanggan','PengaturanAkunController@showFormUpdateAkunPelanggan')->name('setPelanggan.show');
    Route::post('pengaturan-akun-pelanggans','PengaturanAkunController@updateAkunPelanggan')->name('setPelanggan.action');
        // Pemasok
    Route::get('pengaturan-akun-pemasok','PengaturanAkunController@showFormUpdateAkunPemasok')->name('setPemasok.show');
    Route::post('pengaturan-akun-pemasoks','PengaturanAkunController@updateAkunPemasok')->name('setPemasok.action');
        // Pengurus Gudang
    Route::get('pengaturan-akun-pengurusGudang','PengaturanAkunController@showFormUpdateAkunPengurusGudang')->name('setPengurusGudang.show');
    Route::post('pengaturan-akun-pengurusGudangs','PengaturanAkunController@updateAkunPengurusGudang')->name('setPengurusGudang.action');
        // Karyawan
    Route::get('pengaturan-akun-karyawan','PengaturanAkunController@showFormUpdateAkunKaryawan')->name('setKaryawan.show');
    Route::post('pengaturan-akun-karyawans','PengaturanAkunController@updateAkunKaryawan')->name('setKaryawan.action');
        // Bank
    Route::get('pengaturan-akun-bank','PengaturanAkunController@showFormUpdateAkunBank')->name('setBank.show');
    Route::post('pengaturan-akun-banks','PengaturanAkunController@updateAkunBank')->name('setBank.action');
        // Update Password
    Route::get('pengaturan-password-akun','PengaturanAkunController@updatePassword')->name('setPass.show');
    Route::post('pengaturan-passwords-akun','PengaturanAkunController@actionUpdatePassword')->name('setPass.action');
    // End Pengaturan Akun User

    // Penerimaan Barang Pada Pelanggan
    Route::resource('penerimaan', 'PenerimaanController');
    // Pembelian Barang
    Route::get('pembelian/{id}','PembelianController@create')->name('pembelian');
    Route::post('/ongkir', 'PembelianController@check_ongkir');
    Route::get('/cities/{id}', 'PembelianController@getCities');
    // Route::resource('pembelian', 'PembelianController');

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
        // Pengaturan Aplikasi
        Route::resource('setApp', 'PengaturanAplikasiController');
    });
    Route::group(['middleware' => ['pemasok']], function () {
        // Barang
    });
    Route::get('/getKota/{id}', 'BarangController@getCities');
    Route::resource('barang', 'BarangController');
    Route::group(['middleware' => ['bank']], function () {

    });
    Route::group(['middleware' => ['pelanggan']], function () {
        // Barang funtuk pembeli
        Route::get('barangs','BarangController@getBarangByPelanggan')->name('get-barang');
    });
    Route::group(['middleware' => ['karyawan']], function () {
        // Storage
        Route::resource('storage/in', 'StorageInController');
        Route::resource('storage/out', 'StorageOutController');
    });
});
