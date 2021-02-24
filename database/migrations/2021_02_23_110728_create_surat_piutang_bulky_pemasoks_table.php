<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuratPiutangBulkyPemasoksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surat_piutang_bulky_pemasoks', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->string('pihak_pertama');
            $table->string('pihak_kedua');
            $table->bigInteger('jumlah_uang_digits');
            $table->text('jumlah_uang_word');
            $table->foreignId('pemesanan_keluar_bulky_id')->constrained('pemesanan_keluar_bulky')->onDelete('cascade');
            $table->foreignId('storage_keluar_pemasok_id')->constrained('storage_keluar_pemasoks')->onDelete('cascade');
            $table->text('keterangan');
            $table->date('tanggal');
            $table->text('tempat');
            $table->foreignId('pemasok_id')->constrained('pemasoks')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
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
        Schema::dropIfExists('surat_piutang_bulky_pemasoks');
    }
}
