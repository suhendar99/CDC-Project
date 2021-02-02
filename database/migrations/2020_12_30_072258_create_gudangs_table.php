<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGudangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gudangs', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_gudang')->unique();
            $table->string('nama', 50);
            $table->string('lat')->nullable();
            $table->string('long')->nullable();
            $table->string('kontak', 30);
            $table->string('pemilik', 50);
            $table->integer('kapasitas_meter');
            $table->float('kapasitas_berat', 11, 2);
            $table->time('jam_buka');
            $table->time('jam_tutup');
            $table->string('hari', 50);
            $table->text('foto')->nullable();
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
        Schema::dropIfExists('gudangs');
    }
}
