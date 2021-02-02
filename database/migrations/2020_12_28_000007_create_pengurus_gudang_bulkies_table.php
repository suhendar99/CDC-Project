<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengurusGudangBulkiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengurus_gudang_bulkies', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->text('alamat')->nullable();
            $table->string('telepon',20)->nullable();
            $table->string('nik')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->bigInteger('no_rek')->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->string('agama')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->enum('jenis_kelamin',['Pria','Wanita'])->nullable();
            $table->enum('status_perkawinan',['Belum Kawin','Sudah'])->nullable();
            $table->string('kewarganegaraan')->nullable();
            $table->string('foto')->nullable();
            $table->string('foto_ktp')->nullable();
            $table->string('foto_ktp_selfie')->nullable();
            $table->integer('status')->default(0);
            $table->foreignId('bank_id')->nullable()->constrained('banks')->onDelete('cascade');
            $table->foreignId('desa_id')->nullable()->constrained('desas')->onDelete('set null');
            $table->foreignId('kecamatan_id')->nullable()->constrained('kecamatans')->onDelete('set null');
            $table->foreignId('kabupaten_id')->nullable()->constrained('kabupatens')->onDelete('set null');
            $table->foreignId('provinsi_id')->nullable()->constrained('provinsis')->onDelete('set null');
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
        Schema::dropIfExists('pengurus_gudang_bulkies');
    }
}
