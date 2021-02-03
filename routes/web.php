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
    Route::get('/shop', 'ShopController@index')->name('shop');
    Route::get('/', function(){
        return redirect('login');
    });
    Route::get('detail/{id}','ShopController@detail')->name('shop.detail');
    Route::get('cari-kategori/{id}','ShopController@cariKategori')->name('cari.kategori');
    Route::get('shop/pesanan/{id}','ShopController@showPemesanan')->name('shop.pesanan')->middleware('auth');
    Route::post('shop/pemesanan/{id}','ShopController@pemesanan')->name('shop.pesanan.action');
    Route::get('citiesShop/{id}', 'ShopController@getCities');
    Route::post('ongkirShop', 'PembelianController@check_ongkir');
    Route::get('search', 'ShopController@index')->name('home.search.barang');
    Route::post('searchBarang', 'SearchController@barang')->name('search.barang');
});

Route::get('/verification','Auth\RegisterController@verify');

Auth::routes(['verify' => true]);

Route::get('/home', function (){
    if (Auth::user()->name != null) {
        return redirect('/v1/dashboard');
    } else {
        return redirect('shop');
    }
})->name('home');

Route::group(['prefix' => 'v1', 'namespace' => 'v1','middleware' => 'auth'], function () {
    // Keranjang
    Route::post('keranjang/{id}','KeranjangController@saveKeranjang')->name('keranjang.store');
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

    // Pembeli
    Route::get('pengaturan-akun-pembeli','PengaturanAkunController@showFormUpdateAkunPembeli')->name('setPembeli.show');
    Route::post('pengaturan-akun-pembeli','PengaturanAkunController@updateAkunPembeli')->name('setPembeli.action');
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
        // Pengaturan Transaksi
        Route::resource('pengaturanTransaksi', 'PengaturanTransaksiController');
        // Pemasok
        Route::resource('pemasok', 'PemasokController');
        // Armada Pengiriman
        Route::resource('armada', 'ArmadaPengirimanController');
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
        // Untuk Konfirmasi Penerimaan Barang
        Route::get('transaksi/warung/riwayat/konfirmasi/{id}','PemesananKeluarPembeliController@konfirmasi')->name('konfirmasi.terima.warung');

        // Barang funtuk pembeli
        Route::resource('barangWarung', 'BarangWarungController');
        //Retur Masuk
        Route::resource('returMasukPembeli', 'ReturMasukPembeliController');
        // Retur Keluar
        Route::resource('returKeluarPelanggan', 'ReturKeluarPelangganController');
        // Piutang
        Route::resource('piutangPelanggan', 'PiutangPelangganController');
        Route::get('pelangganPiutang/excel', 'PiutangPelangganController@exportExcel')->name('pelangganPiutang.excel');
        Route::get('pelangganPiutang/pdf', 'PiutangPelangganController@exportPdf')->name('pelangganPiutang.pdf');
        // Pemesanan
        Route::get('pemesananMasukWarung','PemesananController@pemesananMasukPembeli')->name('pemesananMasukWarung.index');
        Route::resource('pemesananKeluarWarung', 'PemesananKeluarPembeliController');
        Route::resource('pesanan', 'PemesananController')->middleware('auth');
        Route::get('prints/{id}', 'PemesananController@print')->name('print');
        Route::get('previews/{id}', 'PemesananController@preview')->name('preview');

        Route::post('upload/bukti/warung/{id}','PemesananController@bukti');
        // Barang Masuk
        Route::resource('barangMasukPelanggan', 'BarangMasukPelangganController');
        Route::resource('barangKeluarPelanggan', 'BarangKeluarPelangganController');
        // Rekapitulasi Penjualan
        Route::resource('rekapitulasiPenjualanPelanggan', 'RekapitulasiPenjualanPelangganController');
        // // pemesanan
        // Route::get('pemesanan/{id}','pemesananController@showFormPemesanan')->name('pemesanan');
        // Route::post('pemesanan/store/{id}','pemesananController@store')->name('pemesanan.store');
    });
    Route::get('print/{id}', 'PoController@print')->name('po.print');

    // Gudang Bulky
    Route::group(['middleware' => ['pembeli']], function() {
        Route::get('transaksi/pembeli/riwayat','TransaksiPembeliController@index')->name('transaksi.pembeli.riwayat');

        Route::get('transaksi/pembeli/riwayat/konfirmasi/{id}','TransaksiPembeliController@konfirmasi')->name('konfirmasi.terima.pembeli');

        // Untuk Upload Bukti Pembayaran
        Route::post('upload/bukti/pembeli/{id}','TransaksiPembeliController@bukti');
    });
    Route::group(['middleware' => ['bulky']], function() {
        Route::group(['middleware' => 'pemilikBulky'], function() {
            // Gudang
            // Route::post('gudang/search', 'GudangController@search')->name('gudang.search');
            Route::resource('gudang-bulky', 'GudangBulkyController');

            // Route::resource('pengurus-gudang-bulky', 'PengurusGudangController');
        });

        Route::resource('gudang-bulky/{gudang}/rak', 'RakBulkyController', [
                'names' => [
                    'index' => 'rak.bulky.index',
                    'create' => 'rak.bulky.create',
                    'store' => 'rak.bulky.store',
                    'edit' => 'rak.bulky.edit',
                    'update' => 'rak.bulky.update',
                    'destroy' => 'rak.bulky.destroy'
                ]
        ]);

        Route::resource('bulky/storage/masuk', 'StorageMasukBulkyController', [
            'names' => [
                'index' => 'bulky.storage.masuk.index',
                'create' => 'bulky.storage.masuk.create',
                'store' => 'bulky.storage.masuk.store',
                'edit' => 'bulky.storage.masuk.edit',
                'update' => 'bulky.storage.masuk.update',
                'destroy' => 'bulky.storage.masuk.destroy'
            ]
        ]);

        Route::resource('bulky/storage/keluar', 'StorageKeluarBulkyController', [
            'names' => [
                'index' => 'bulky.storage.keluar.index',
                'create' => 'bulky.storage.keluar.create',
                'store' => 'bulky.storage.keluar.store',
                'edit' => 'bulky.storage.keluar.edit',
                'update' => 'bulky.storage.keluar.update',
                'destroy' => 'bulky.storage.keluar.destroy'
            ]
        ]);

        Route::get('bulky/storage/penyimpanan/{id}', 'StorageBulkyController@edit')->name('bulky.storage.rak');
        Route::post('bulky/storage/penyimpanan/{id}/simpan', 'StorageBulkyController@update')->name('bulky.storage.rak.simpan');

        Route::resource('bulky/storage', 'StorageBulkyController', [
            'names' => [
                'index' => 'bulky.storage.index',
                'create' => 'bulky.storage.create',
                'store' => 'bulky.storage.store',
                'edit' => 'bulky.storage.edit',
                'update' => 'bulky.storage.update',
                'destroy' => 'bulky.storage.destroy'
            ]
        ]);

        // Ubah Harga Barang
        Route::get('bulky/barang/stock/{id}', 'StockBarangBulkyController@editHarga')->name('bulky.harga.edit');
        Route::put('bulky/barang/stock/{id}/simpan', 'StockBarangBulkyController@simpanHarga')->name('bulky.harga.simpan');

        // Kwitansi
        Route::get('bulky/kwitansi', 'KwitansiBulkiController@index')->name('bulky.kwitansi.index');

        // Surat Jalan
        Route::get('bulky/surat-jalan', 'SuratJalanBulkyController@index')->name('bulky.surat-jalan.index');

        Route::get('bulky/kwitansi/print', 'StorageKeluarBulkyController@printKwitansi')->name('bulky.kwitansi.print');
        Route::get('bulky/surat-jalan/print', 'StorageKeluarBulkyController@printSuratJalan')->name('bulky.surat-jalan.print');

        Route::get('bulky/pemesanan', 'PemesananBulkyController@index')->name('bulky.pemesanan.index');

        Route::put('bulky/validate/bukti/{id}', 'PemesananBulkyController@validateBukti')->name('bulky.validate.bukti');
    });

    // Gudang Retail
    Route::group(['middleware' => ['karyawan']], function () {
        // Menolak Pesanan Dari Warung
        Route::get('tolak/pesanan/warung/{id}','PemesananController@tolak');
        // Mengalihkan ke halaman storage out dengan membawa variabel
        // Route::get('kirim/pesanan/warung','StorageOutController@create');
        // Untuk Validasi Butki Pembayaran
        Route::get('validasi/bukti/warung/{id}','PemesananKeluarPembeliController@validasi')->name('validasi.bukti.warung');

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

        // Ubah Harga Barang
        Route::get('barang/stock/{id}', 'StockBarangController@editHarga')->name('harga.edit');
        Route::put('barang/stock/{id}/simpan', 'StockBarangController@simpanHarga')->name('harga.simpan');

        Route::group(['middleware' => 'pemilik'], function() {
            // Gudang
            Route::post('gudang/search', 'GudangController@search')->name('gudang.search');
            Route::resource('gudang-retail', 'GudangController', [
                'names' => [
                    'index' => 'gudang.index',
                    'create' => 'gudang.create',
                    'store' => 'gudang.store',
                    'edit' => 'gudang.edit',
                    'update' => 'gudang.update',
                    'destroy' => 'gudang.destroy'
                ]
            ]);

            Route::resource('pengurus-gudang', 'PengurusGudangController');
        });

        Route::resource('returIn', 'ReturController');
        Route::resource('returOut', 'ReturOutController');

        // Kwitansi
        Route::get('kwitansi', 'KwitansiController@index')->name('kwitansi.index');

        // Surat Jalan
        Route::get('surat-jalan', 'SuratJalanController@index')->name('surat-jalan.index');

        Route::get('pemesanan', 'PemesananController@index')->name('pemesanan.index');
        Route::delete('pemesanan/{id}', 'PemesananController@destroy')->name('pemesanan.destroy');

        Route::get('kwitansi/print', 'StorageOutController@printKwitansi')->name('kwitansi.print');
        Route::get('surat-jalan/print', 'StorageOutController@printSuratJalan')->name('surat-jalan.print');

        // Rak
        Route::resource('gudang/{gudang}/rak', 'RakController');
        Route::get('/v1/rak/{id}/status', 'RakController@changeStatus');
        // Laporan
        Route::get('laporan-barang-masuk','laporanPengurusGudangController@showLaporanBarangMasuk')->name('laporan.barang.masuk');
        Route::post('laporan-barang-masuk-pdf','laporanPengurusGudangController@LaporanBarangMasukPdf')->name('laporan.barang.masuk.pdf');
        Route::post('laporan-barang-masuk-excel','laporanPengurusGudangController@LaporanBarangMasukExcel')->name('laporan.barang.masuk.excel');

        Route::get('laporan-barang-keluar','laporanPengurusGudangController@showLaporanBarangKeluar')->name('laporan.barang.keluar');
        Route::post('laporan-barang-keluar-pdf','laporanPengurusGudangController@LaporanBarangKeluarPdf')->name('laporan.barang.keluar.pdf');
        Route::post('laporan-barang-keluar-excel','laporanPengurusGudangController@LaporanBarangKeluarExcel')->name('laporan.barang.keluar.excel');

        Route::get('laporan-barang','laporanPengurusGudangController@showLaporanBarang')->name('laporan.barang');
        Route::post('laporan-barang-pdf','laporanPengurusGudangController@LaporanBarangPdf')->name('laporan.barang.pdf');
        Route::post('laporan-barang-excel','laporanPengurusGudangController@LaporanBarangExcel')->name('laporan.barang.excel');

        Route::get('laporan-po','laporanPengurusGudangController@showLaporanPo')->name('laporan.po');
        Route::post('laporan-po-pdf','laporanPengurusGudangController@LaporanPoPdf')->name('laporan.po.pdf');
        Route::post('laporan-po-excel','laporanPengurusGudangController@LaporanPoExcel')->name('laporan.po.excel');
        // End Laporan
        // Piutang
        Route::resource('piutangIn', 'PiutangController');
        Route::resource('piutangOut', 'PiutangOutController');
        // PDF & EXCEL Piutang In
        Route::get('RetailPiutangMasuk/pdf','PiutangController@exportPdf')->name('RetailPiutangMasuk.pdf');
        Route::get('RetailPiutangMasuk/excel','PiutangController@exportExcel')->name('RetailPiutangMasuk.excel');
        // PDF & EXCEL Piutang Out
        Route::get('piutangOut/pdf','PiutangOutController@exportPdf')->name('piutangOut.pdf');
        Route::get('piutangOut/excel','PiutangOutController@exportExcel')->name('piutangOut.excel');
        // Rekapitulasi
        Route::resource('rekapitulasiPembelian', 'RekapitulasiPembelianController');
        Route::resource('rekapitulasiPenjualan', 'RekapitulasiPenjualanController');

        Route::get('rekapPenjualan/downloadPdf', 'RekapitulasiPenjualanController@downloadRekapitulasiPenjualanPdf')->name('rekapPenjualan.download.pdf');
        Route::get('rekapPenjualan/downloadExcel', 'RekapitulasiPenjualanController@downloadRekapitulasiPenjualanExcel')->name('rekapPenjualan.download.excel');

        Route::get('rekapPembelian/downloadPdf', 'RekapitulasiPembelianController@downloadRekapitulasiPembelianPdf')->name('rekapPembelian.download.pdf');
        Route::get('rekapPembelian/downloadExcel', 'RekapitulasiPembelianController@downloadRekapitulasiPembelianExcel')->name('rekapPembelian.download.excel');
    });
});
