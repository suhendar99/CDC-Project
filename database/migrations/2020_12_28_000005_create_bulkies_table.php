<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBulkiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bulkies', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 50);
            $table->string('jabatan', 50)->nullable();
            $table->text('alamat')->nullable();
            $table->string('telepon',20)->nullable();
            $table->string('nik', 30)->nullable();
            $table->string('tempat_lahir', 50)->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->string('agama', 30)->nullable();
            $table->enum('jenis_kelamin',['Pria','Wanita'])->nullable();
            $table->enum('status_perkawinan',['Belum Kawin','Sudah'])->nullable();
            $table->string('kewarganegaraan', 50)->nullable();
            $table->text('foto')->nullable();
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
        Schema::dropIfExists('bulkies');
    }
}
