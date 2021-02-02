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
            $table->string('barang_kode');
            $table->foreign('barang_kode')->references('kode_barang')->on('barangs')->onDelete('cascade');
            // $table->foreignId('barang_kode')->nullable()->constrained('kategoris')->onDelete('cascade');
            $table->foreignId('gudang_id')->constrained('gudangs')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('kode')->unique();
            $table->bigInteger('jumlah');
            $table->string('satuan', 50);
            $table->dateTime('waktu');
            $table->string('nomor_kwitansi', 50);
            $table->text('foto_kwitansi');
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
        Schema::dropIfExists('storage_ins');
    }
}
