<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['namespace' => 'v1'], function () {
    Route::get('shop', 'ShopController@index')->name('shop');
    Route::get('/', function(){
        return redirect('login');
    });
    Route::get('detail/{id}','ShopController@detail')->name('shop.detail');
    Route::get('citiesShop/{id}', 'ShopController@getCities');
    Route::post('ongkirShop', 'PembelianController@check_ongkir');
    Route::post('searchBarang', 'SearchController@barang')->name('search.barang');
});

Route::get('/verification','Auth\RegisterController@verify');

Auth::routes(['verify' => true]);

Route::get('/home', function (){
	return redirect('v1/dashboard');
})->name('home');

Route::group(['prefix' => 'v1', 'namespace' => 'v1','middleware' => 'auth'], function () {
    // Complete Foto KTP
    Route::post('KTP/{id}','KtpController@fotoKtp')->name('foto.ktp');
    // End Complete Foto KTP
    // Complete Foto Selfie KTP
    Route::post('KTP-Selfie/{id}','KtpController@fotoKtpSelfie')->name('foto.ktp.selfie');
    // End Complete Foto Selfie KTP
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
    Route::group(['middleware' => ['admin']], function () {
        // User
        Route::resource('user', 'UserController');
        Route::get('/user/{id}/approve', 'UserController@approve')->name('admin.users.approve');
        Route::get('/user/{id}/unapprove', 'UserController@unapprove')->name('admin.users.unapprove');
        // Koperasi
        Route::resource('koperasi', 'KoperasiController');
        // Pemasok
        Route::resource('pemasok', 'PemasokController');
        // Pembeli
        Route::resource('pelanggan', 'PelangganController');

        // Pengaturan Aplikasi
        Route::resource('setApp', 'PengaturanAplikasiController');
        // Kategori Barang Induk
        Route::resource('kategoriBarang', 'KategoriBarangController');

        Route::resource('pemilik-gudang', 'PemilikGudangController');
        // Batas Piutang
        Route::resource('batasPiutang', 'BatasPiutangController');
        // Bank
        Route::resource('bank', 'BankController');
        Route::resource('akun-bank', 'AkunBankController');
    });
    Route::group(['middleware' => ['pemasok']], function () {
        // Brang Po Masuk
        Route::get('po-masuk-pemasok','PoController@getDataMasukPemasok')->name('po.masuk.pemasok');
        Route::get('accept-po-gudang/{id}','PoController@acceptGudang')->name('accept.po.gudang');
        Route::get('previewPemasok/{id}', 'PoController@preview')->name('po.previewPemasok');
        // Barang
        Route::resource('barang', 'BarangController');
        Route::get('edit-foto-barang/{id}','BarangController@editFotoBarang')->name('edit.barang');
        Route::put('update-foto-barang/{id}','BarangController@updateFotoBarang')->name('update.barang');
        Route::get('create-foto-barang/{id}','BarangController@createFotoBarang')->name('create.barang');
        Route::post('store-foto-barang','BarangController@storeFotoBarang')->name('store.barang');
        Route::delete('delete-foto-barang/{id}','BarangController@deleteFotoBarang')->name('delete.barang');
        Route::get('detailBarang/{id}','BarangController@detail');
        // Rekening Pemasok
        Route::resource('rekeningPemasok', 'RekeningPemasokController');
        Route::resource('transaksiPemasok', 'TransaksiPemasokController');
        Route::get('transaksiPemasok/createDetail/{id}', 'TransaksiPemasokController@createDetail')->name('create.detail');
        Route::get('selectGudang', 'TransaksiPemasokController@selectGudang')->name('select.gudang');
        Route::get('suratJalan', 'TransaksiPemasokController@suratJalan')->name('transaksiPemasok.surat');
    });
    Route::get('/getKota/{id}', 'BarangConptroller@getCities');
    Route::group(['middleware' => ['bank']], function () {
        // Bunga Bank
        Route::resource('bungaBank', 'BungaBankController');
    });
    Route::group(['middleware' => ['pelanggan']], function () {
        // Barang funtuk pembeli
        Route::get('barangs','BarangController@getBarangByPelanggan')->name('get-barang');
        // Pemesanan
        Route::get('prints/{id}', 'PemesananController@print')->name('print');
        Route::resource('pesanan', 'PemesananController');
        Route::get('previews/{id}', 'PemesananController@preview')->name('preview');
        // // pemesanan
        // Route::get('pemesanan/{id}','pemesananController@showFormPemesanan')->name('pemesanan');
        // Route::post('pemesanan/store/{id}','pemesananController@store')->name('pemesanan.store');
    });
    Route::get('print/{id}', 'PoController@print')->name('po.print');
    Route::group(['middleware' => ['karyawan']], function () {
        // Purchase Order
        Route::get('print/{id}', 'PoController@print')->name('po.print');
        Route::resource('po', 'PoController');
        Route::get('preview/{id}', 'PoController@preview')->name('po.preview');
        // Storage
        // Route::resource('storage', 'StorageController');
        // Route::resource('storage-in', 'StorageInController');
        Route::get('storage/in', 'StorageInController@index')->name('storage.in.index');
        Route::get('storage/out', 'StorageOutController@index')->name('storage.out.index');
        Route::get('storage/in/create', 'StorageInController@create')->name('storage.in.create');
        Route::post('storage/in/store', 'StorageInController@store')->name('storage.in.store');
        Route::get('storage/in/{id}/edit', 'StorageInController@edit')->name('storage.in.edit');
        Route::put('storage/in/{id}', 'StorageInController@update')->name('storage.in.update');
        Route::delete('storage/in/{id}', 'StorageInController@destroy')->name('storage.in.delete');

        Route::get('storage/out/create', 'StorageOutController@create')->name('storage.out.create');
        Route::post('storage/out/store', 'StorageOutController@store')->name('storage.out.store');
        Route::get('storage/out/{id}/edit', 'StorageOutController@edit')->name('storage.out.edit');
        Route::put('storage/out/{id}', 'StorageOutController@update')->name('storage.out.update');
        Route::delete('storage/out/{id}', 'StorageOutController@destroy')->name('storage.out.delete');
        // Route::resource('storage-out', 'StorageOutController');
        Route::get('storage', 'StorageController@index')->name('storage.index');
        Route::get('storage/penyimpanan/{id}', 'StorageController@edit')->name('storage.rak');
        Route::post('storage/penyimpanan/{id}/simpan', 'StorageController@update')->name('storage.rak.simpan');

        Route::group(['middleware' => 'pemilik'], function() {
            // Gudang
            Route::post('gudang/search', 'GudangController@search')->name('gudang.search');
            Route::resource('gudang', 'GudangController');

            Route::resource('pengurus-gudang', 'PengurusGudangController');
        });

        Route::resource('retur', 'ReturController');
        Route::resource('returOut', 'ReturOutController');

        // Kwitansi
        Route::get('kwitansi', 'KwitansiController@index')->name('kwitansi.index');

        // Surat Jalan
        Route::get('surat-jalan', 'SuratJalanController@index')->name('surat-jalan.index');

        Route::get('pemesanan', 'PemesananController@index')->name('pemesanan.index');

        Route::get('kwitansi/print', 'StorageOutController@printKwitansi')->name('kwitansi.print');
        Route::get('surat-jalan/print', 'StorageOutController@printSuratJalan')->name('surat-jalan.print');

        // Rak
        Route::resource('gudang/{gudang}/rak', 'RakController');
        // Laporan
        Route::get('laporan-barang-masuk','LaporanPengurusGudangController@showLaporanBarangMasuk')->name('laporan.barang.masuk');
        Route::post('laporan-barang-masuk-pdf','LaporanPengurusGudangController@LaporanBarangMasukPdf')->name('laporan.barang.masuk.pdf');
        Route::post('laporan-barang-masuk-excel','LaporanPengurusGudangController@LaporanBarangMasukExcel')->name('laporan.barang.masuk.excel');

        Route::get('laporan-barang-keluar','LaporanPengurusGudangController@showLaporanBarangKeluar')->name('laporan.barang.keluar');
        Route::post('laporan-barang-keluar-pdf','LaporanPengurusGudangController@LaporanBarangKeluarPdf')->name('laporan.barang.keluar.pdf');
        Route::post('laporan-barang-keluar-excel','LaporanPengurusGudangController@LaporanBarangKeluarExcel')->name('laporan.barang.keluar.excel');

        Route::get('laporan-po','LaporanPengurusGudangController@showLaporanPo')->name('laporan.po');
        Route::post('laporan-po-pdf','LaporanPengurusGudangController@LaporanPoPdf')->name('laporan.po.pdf');
        Route::post('laporan-po-excel','LaporanPengurusGudangController@LaporanPoExcel')->name('laporan.po.excel');
        // End Laporan
        // Piutang
        Route::resource('piutang', 'PiutangController');
        Route::resource('piutangOut', 'PiutangOutController');
        // Rekapitulasi
        Route::resource('rekapitulasiPembelian', 'RekapitulasiPembelianController');
        Route::resource('rekapitulasiPenjualan', 'RekapitulasiPenjualanController');
    });
});
