<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangMasukPelanggansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang_masuk_pelanggans', function (Blueprint $table) {
            $table->id();
            $table->string('storage_out_kode');
            $table->foreign('storage_out_kode')->references('kode')->on('storage_outs')->onDelete('cascade');
            // $table->foreignId('gudang_id')->constrained('gudangs')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->bigInteger('harga_beli');
            $table->string('kode')->unique();
            $table->bigInteger('jumlah');
            $table->string('satuan', 50);
            $table->dateTime('waktu');
            $table->string('nomor_kwitansi', 50);
            $table->text('foto_kwitansi')->nullable();
            $table->text('foto_surat_piutang')->nullable();
            $table->string('nomor_surat_jalan', 50);
            $table->text('foto_surat_jalan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('barang_masuk_pelanggans');
    }
}
