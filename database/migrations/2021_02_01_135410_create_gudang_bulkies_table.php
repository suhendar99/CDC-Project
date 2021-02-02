<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGudangBulkiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gudang_bulkies', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_gudang')->unique();
            $table->string('nama');
            $table->string('lat')->nullable();
            $table->string('long')->nullable();
            $table->string('kontak');
            $table->string('pemilik');
            $table->integer('kapasitas_meter');
            $table->float('kapasitas_berat', 11, 2);
            $table->time('jam_buka');
            $table->time('jam_tutup');
            $table->string('hari');
            $table->string('foto')->nullable();
            $table->text('alamat');
            $table->foreignId('desa_id')->nullable()->constrained('desas')->onDelete('set null');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->integer('status')->default(0);
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
        Schema::dropIfExists('gudang_bulkies');
    }
}
