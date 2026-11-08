<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('t013_nilais', function (Blueprint $table) {
            $table->id('t013_nilai_id');
            $table->unsignedBigInteger('t013_mahasiswa_id');
            $table->unsignedBigInteger('t013_mk_id');
            $table->decimal('t013_nilai_angka', 5, 2);
            $table->char('t013_nilai_huruf', 2);
            $table->timestamps();

            $table->foreign('t013_mahasiswa_id')->references('t013_mahasiswa_id')->on('t013_mahasiswas')->onDelete('cascade');
            $table->foreign('t013_mk_id')->references('t013_mk_id')->on('t013_matakuliah')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('t013_nilais');
    }
};