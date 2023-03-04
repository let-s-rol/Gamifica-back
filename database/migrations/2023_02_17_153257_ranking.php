<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('ranking', function (Blueprint $table) {
            $table->id('id_ranking');
            $table->string('ranking_name');
            $table->string('owner');
            $table->string('img')->nullable();

            $table->foreign('owner')->references('nick')->on('user');

            //$table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('ranking');
    }
};
