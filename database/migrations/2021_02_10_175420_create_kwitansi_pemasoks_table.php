<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKwitansiPemasoksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kwitansi_pemasoks', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique()->nullable();
            $table->string('terima_dari', 50)->nullable();
            $table->bigInteger('jumlah_uang_digits')->nullable();
            $table->text('jumlah_uang_word')->nullable();
            $table->foreignId('pemesanan_keluar_bulky_id')->nullable()->constrained('pemesanan_keluar_bulky')->onDelete('cascade');
            $table->foreignId('storage_keluar_pemasok_id')->nullable()->constrained('storage_keluar_pemasoks')->onDelete('cascade');
            $table->text('keterangan')->nullable();
            $table->date('tanggal')->nullable();
            $table->text('tempat')->nullable();
            $table->foreignId('pemasok_id')->nullable()->constrained('pemasoks')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
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
        Schema::dropIfExists('kwitansi_pemasoks');
    }
}
