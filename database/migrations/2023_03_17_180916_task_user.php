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

        Schema::create('task_user', function (Blueprint $table) {
            $table->id('');
            $table->unsignedBigInteger('task_ranking_id');
            $table->unsignedBigInteger('id_user');
            $table->binary('file');

            $table->foreign('task_ranking_id')->references('id')->on('task')->onDelete('cascade');
            $table->foreign('id_user')->references('id')->on('user');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_user');
    }
};
