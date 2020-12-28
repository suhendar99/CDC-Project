<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKaryawansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('karyawans', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('jabatan');
            $table->text('alamat')->nullable();
            $table->string('telepon',20)->nullable();
            $table->enum('gol_darah',['A','B','AB','O','Lainnya']);
            $table->enum('jenis_kelamin',['Pria','Wanita']);
            $table->enum('status_perkawinan',['Belum Kawin','Sudah']);
            $table->string('kewarganegaraan');
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
        Schema::dropIfExists('karyawans');
    }
}
