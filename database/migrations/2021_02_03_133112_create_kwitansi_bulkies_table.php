<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKwitansiBulkiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kwitansi_bulkies', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->string('terima_dari', 50);
            $table->bigInteger('jumlah_uang_digits');
            $table->text('jumlah_uang_word');
            $table->foreignId('pemesanan_bulky_id')->constrained('pemesanan_bulkies')->onDelete('cascade');
            $table->text('keterangan');
            $table->date('tanggal');
            $table->text('tempat');
            $table->foreignId('bulky_id')->constrained('gudang_bulkies')->onDelete('cascade');
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
        Schema::dropIfExists('kwitansi_bulkies');
    }
}
