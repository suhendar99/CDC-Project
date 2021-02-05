<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pos', function (Blueprint $table) {
            $table->id();
            $table->string('kode',50)->unique();
            $table->string('nomor_pemesanan')->unique();
            $table->foreignId('gudang_id')->nullable()->constrained('gudangs')->onDelete('cascade');
            $table->foreignId('pemasok_id')->nullable()->constrained('pemasoks')->onDelete('cascade');
            $table->foreignId('pengurus_gudang_id')->nullable()->constrained('pengurus_gudangs')->onDelete('cascade');
            $table->string('penerima_po', 50);
            $table->string('nama_pemesan', 50);
            $table->string('telepon', 30);
            $table->text('alamat_pemesan');
            $table->dateTime('tanggal_pemesanan', 0);
            $table->string('metode_pembayaran', 50)->nullable();
            $table->boolean('status')->default(1);
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
        Schema::dropIfExists('pos');
    }
}
