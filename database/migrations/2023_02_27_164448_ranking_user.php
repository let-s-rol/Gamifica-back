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
            $table->unsignedBigInteger('ranking_id'); 
            $table->string('user');
            $table->integer('points'); 

            $table->foreign('ranking_id')->references('ranking_id')->on('ranking');
            //$table->timestamps();
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
