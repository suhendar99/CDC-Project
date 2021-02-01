<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('username')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('keanggotaan')->nullable();
            $table->tinyInteger('status')->comment('0 = nonaktif, 1 = data diri, 2 = KTP, 3 = foto selfie KTP')->default(0);
            $table->tinyInteger('jenis')->comment('0 = Perorangan, 1 = Instansi')->nullable();
            $table->foreignId('koperasi_id')->nullable()->constrained('koperasis')->onDelete('cascade');
            $table->foreignId('pelanggan_id')->nullable()->constrained('pelanggans')->onDelete('cascade');
            $table->foreignId('bulky_id')->nullable()->constrained('bulkies')->onDelete('cascade');
            $table->foreignId('pembeli_id')->nullable()->constrained('pembelis')->onDelete('cascade');
            $table->foreignId('pemasok_id')->nullable()->constrained('pemasoks')->onDelete('cascade');
            $table->foreignId('pengurus_gudang_id')->nullable()->constrained('pengurus_gudangs')->onDelete('cascade');
            $table->timestamp('approved_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
