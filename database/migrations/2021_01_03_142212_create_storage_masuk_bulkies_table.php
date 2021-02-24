<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStorageMasukBulkiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('storage_masuk_bulkies', function (Blueprint $table) {
            $table->id();
            $table->string('barang_kode');
            $table->foreign('barang_kode')->references('kode_barang')->on('barangs')->onDelete('cascade');
            // $table->foreignId('barang_kode')->nullable()->constrained('kategoris')->onDelete('cascade');
            $table->foreignId('bulky_id')->constrained('gudang_bulkies')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('kode')->unique();
            $table->bigInteger('harga_beli');
            $table->float('jumlah', 11, 2);
            $table->string('satuan');
            $table->dateTime('waktu');
            $table->string('nomor_kwitansi');
            $table->string('foto_kwitansi')->nullable();
            $table->string('foto_surat_piutang')->nullable();
            $table->string('nomor_surat_jalan');
            $table->string('foto_surat_jalan');
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
        Schema::dropIfExists('storage_masuk_bulkies');
    }
}
