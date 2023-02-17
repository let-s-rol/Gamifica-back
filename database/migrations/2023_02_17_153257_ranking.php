<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
    {
        Schema::create('ranking', function (Blueprint $table) {
            $table->string('ranking_name');
            $table->string('nick');
            $table->integer('points');
            $table->timestamps();

            $table->primary('ranking_name');
            $table->foreign('nick')->references('nick')->on('users');
        });
    }

    
    public function down()
    {
        Schema::dropIfExists('ranking');
    }
};
