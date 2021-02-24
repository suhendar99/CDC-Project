<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStorageInsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('storage_ins', function (Blueprint $table) {
            $table->id();
            $table->dateTime('waktu');
            // $table->string('barang_kode');
            // $table->foreign('barang_kode')->references('kode_barang')->on('barangs')->onDelete('cascade');
            // $table->foreignId('storage_keluar_bulky_id')->constrained('storage_keluar_bulkies')->onDelete('cascade');
            $table->foreignId('barang_bulky_id')->constrained('stock_barang_bulkies')->onDelete('cascade');
            $table->foreignId('pemesanan_bulky_id')->constrained('pemesanan_bulkies')->onDelete('cascade');
            // $table->foreignId('storage_bulky_id')->constrained('storage_bulkies')->onDelete('cascade');
            // $table->foreignId('barang_kode')->nullable()->constrained('kategoris')->onDelete('cascade');
            $table->foreignId('gudang_id')->constrained('gudangs')->onDelete('cascade');
            $table->foreignId('tingkat_id')->nullable()->constrained('tingkatan_raks')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->bigInteger('harga_beli');
            $table->string('kode')->unique();
            $table->string('nama_barang', 50);
            $table->float('jumlah', 11, 2);
            $table->foreignId('satuan_id')->constrained('satuans')->onDelete('cascade');
            $table->string('nomor_kwitansi', 50);
            $table->text('foto_kwitansi')->nullable();
            $table->text('foto_surat_piutang')->nullable();
            $table->string('nomor_surat_jalan', 50);
            $table->text('foto_surat_jalan');
            $table->timestamps();

            // Nama Penjual Diambil dari storage_keluar_bulky
            // Nama Penerima diambil dari user_id
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('storage_ins');
    }
}
