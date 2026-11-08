<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('t013_roles', function (Blueprint $table) {
            $table->id('t013_role_id');
            $table->string('t013_role_name');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('t013_roles');
    }
};