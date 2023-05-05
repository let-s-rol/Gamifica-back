<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('ranking', function (Blueprint $table) {
            $table->id();
            $table->string('ranking_name')->unique();
            $table->string('owner');
            $table->binary('img')->nullable();
            $table->string('code')->unique();
            
            $table->foreign('owner')->references('nick')->on('user')->onDelete('cascade');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('ranking');
    }
};
