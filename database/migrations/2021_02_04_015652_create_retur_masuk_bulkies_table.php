<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturMasukBulkiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retur_masuk_bulkies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kwitansi_bulky_id')->constrained('kwitansi_bulkies')->onDelete('cascade');
            $table->date('tanggal_pengembalian');
            $table->text('keterangan');
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
        Schema::dropIfExists('retur_masuk_bulkies');
    }
}
