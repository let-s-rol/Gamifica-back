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
        Schema::create('ranking_user', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_ranking');
            $table->unsignedBigInteger('id_user');
            $table->string('user_name');
            $table->integer('points');
            $table->boolean('validar');
            $table->integer('puntosSemanales')->default(0);
            
            $table->foreign('id_ranking')->references('id')->on('ranking')->onDelete('cascade');
            $table->foreign('id_user')->references('id')->on('user');
            $table->unique(['id_ranking', 'id_user']); // Restricción de clave única mixta

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ranking_user');
    }
};
