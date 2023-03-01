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
            $table->unsignedBigInteger('id_ranking');
            $table->unsignedBigInteger('id_user');
            $table->string('user_name');
            $table->integer('points'); 

            $table->foreign('id_ranking')->references('id_ranking')->on('ranking');
            $table->foreign('id_user')->references('id')->on('user');
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
