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

        Schema::create('historial', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_ranking');
            $table->unsignedBigInteger('id_giver');
            $table->unsignedBigInteger('id_receiver');
            $table->string('giver_name');
            $table->string('receiver_name');
            $table->integer('Responsabilidad');
            $table->integer('Cooperacion');
            $table->integer('Iniciativa');
            $table->integer('Emocional');
            $table->integer('Pensamiento');
            $table->timestamps();

            $table->foreign('id_ranking')->references('id')->on('ranking')->onDelete('cascade');
            $table->foreign('id_giver')->references('id')->on('user')->onDelete('cascade');
            $table->foreign('id_receiver')->references('id')->on('user')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial');
    }
};
