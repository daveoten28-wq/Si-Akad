<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('t013_matakuliah', function (Blueprint $table) {
            $table->id('t013_mk_id');
            $table->string('t013_kode_mk')->unique();
            $table->string('t013_nama_mk');
            $table->integer('t013_sks');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('t013_matakuliah');
    }
};