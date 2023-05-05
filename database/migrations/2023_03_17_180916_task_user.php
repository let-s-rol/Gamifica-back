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
            $table->id();
            $table->unsignedBigInteger('id_task');
            $table->unsignedBigInteger('id_user');
            $table->binary('file');
            $table->boolean('corrected')->default(false);
            $table->decimal('note', 2, 2)->nullable();
            
            $table->foreign('id_task')->references('id')->on('task')->onDelete('cascade');
            $table->foreign('id_user')->references('id')->on('user')->onDelete('cascade');
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
