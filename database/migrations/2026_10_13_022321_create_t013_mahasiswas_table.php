<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('t013_mahasiswas', function (Blueprint $table) {
            $table->id('t013_mahasiswa_id');
            $table->string('t013_nim')->unique();
            $table->string('t013_nama');
            $table->string('t013_prodi');
            $table->unsignedBigInteger('t013_user_id')->nullable();
            $table->timestamps();

            $table->foreign('t013_user_id')->references('t013_user_id')->on('t013_users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('t013_mahasiswas');
    }
};