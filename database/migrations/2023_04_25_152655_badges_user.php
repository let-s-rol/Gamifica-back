<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('badges_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_badge');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_ranking');
            $table->integer('experience')->default(0);

            $table->foreign('id_badge')->references('id')->on('badges');
            $table->foreign('id_ranking')->references('id')->on('ranking')->onDelete('cascade');
            $table->foreign('id_user')->references('id')->on('user')->onDelete('cascade');
            $table->unique(['id_badge','id_ranking', 'id_user']); // Restricción de clave única mixta
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('badges_user');
    }
};
