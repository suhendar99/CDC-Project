<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePiutangOutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('piutang_outs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id')->constrained('pos')->onDelete('cascade');
            $table->date('tanggal');
            $table->string('nama_pembeli', 50);
            $table->date('jatuh_tempo')->nullable();
            $table->integer('hutang');
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
        Schema::dropIfExists('piutang_outs');
    }
}
