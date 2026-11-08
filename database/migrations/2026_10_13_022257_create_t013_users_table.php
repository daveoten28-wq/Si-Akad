<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('t013_users', function (Blueprint $table) {
            $table->id('t013_user_id');
            $table->string('t013_username')->unique();
            $table->string('t013_password');
            $table->unsignedBigInteger('t013_role_id');
            $table->timestamps();

            $table->foreign('t013_role_id')->references('t013_role_id')->on('t013_roles')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('t013_users');
    }
};