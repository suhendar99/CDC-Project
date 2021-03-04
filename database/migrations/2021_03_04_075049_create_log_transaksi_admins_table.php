<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogTransaksiAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_transaksi_admins', function (Blueprint $table) {
            $table->id();
            $table->dateTime('time', 0);
            $table->string('transaksi');
            $table->string('penjual');
            $table->string('pembeli');
            $table->string('barang');
            $table->bigInteger('jumlah');
            $table->string('satuan');
            $table->bigInteger('harga');
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
        Schema::dropIfExists('log_transaksi_admins');
    }
}
