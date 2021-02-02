<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangWarungsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang_warungs', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->string('storage_out_kode');
            $table->foreign('storage_out_kode')->references('kode')->on('storage_outs')->onDelete('cascade');
            $table->foreignId('pelanggan_id')->nullable()->constrained('pelanggans')->onDelete('cascade');
            $table->bigInteger('harga_barang')->nullable();
            $table->bigInteger('jumlah');
            $table->string('satuan', 20);
            $table->dateTime('waktu');
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
        Schema::dropIfExists('barang_warungs');
    }
}
