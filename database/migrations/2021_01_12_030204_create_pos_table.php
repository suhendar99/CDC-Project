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
            $table->string('kode_po',50)->unique();
            // $table->string('pengirim_po',50);
            // $table->string('nama_pengirim',50);
            // $table->string('telepon_pengirim',50);
            // $table->string('email_pengirim',50);
            $table->foreignId('gudang_id')->nullable()->constrained('gudangs')->onDelete('cascade');
            $table->foreignId('bank_id')->nullable()->constrained('banks')->onDelete('cascade');
            $table->string('penerima_po',50);
            $table->string('nama_penerima',50);
            $table->string('telepon_penerima',50);
            $table->string('email_penerima',50);
            $table->string('alamat_penerima',50);
            $table->string('metode_pembayaran',50);
            $table->boolean('status')->default(0); 
            // Jika 1 Maka Peminjaman PO Diterima Oleh Bank
            // Jika 2 Maka PO diseujui oleh bulky dan oleh bank(jika meminjam)
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
