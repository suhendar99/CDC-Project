<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePembeliansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pembelians', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pembelian');
            $table->integer('jumlah');
            $table->date('tanggal_pembelian');
            $table->date('tanggal_penerimaan')->nullable();
            $table->boolean('status_pengiriman')->nullable();
            $table->foreignId('pelanggan_id')->nullable()->constrained('pelanggans')->onDelete('cascade');
            $table->foreignId('barang_id')->nullable()->constrained('barangs')->onDelete('cascade');
            $table->foreignId('pemasok_id')->nullable()->constrained('pemasoks')->onDelete('cascade');
            $table->foreignId('city_id')->nullable()->constrained('cities')->onDelete('set null');
            $table->foreignId('province_id')->nullable()->constrained('provinsis')->onDelete('set null');
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
        Schema::dropIfExists('pembelians');
    }
}
