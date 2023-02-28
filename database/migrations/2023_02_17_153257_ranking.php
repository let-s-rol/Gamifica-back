<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
    {
        Schema::create('ranking', function (Blueprint $table) {
            $table->id('ranking_id');
            $table->string('ranking_name'); 
            $table->string('owner'); 
            
            $table->foreign('owner')->references('nick')->on('user');

            //$table->timestamps();
        });
    }

    
    public function down()
    {
        Schema::dropIfExists('ranking');
    }
};
