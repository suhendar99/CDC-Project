<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePiutangRetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('piutang_retails', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pemesanan_keluar_id')->constrained('pemesanan_bulkies')->onDelete('cascade');
            $table->date('tanggal');
            $table->string('nama_pembeli', 50);
            $table->date('jatuh_tempo');
            $table->integer('hutang');
            $table->integer('jumlah_terbayar')->nullable();
            $table->boolean('status')->default(0);
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
        Schema::dropIfExists('piutang_retails');
    }
}
