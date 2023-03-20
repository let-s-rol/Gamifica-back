<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    // Schema::create('task', function (Blueprint $table) {
    //     $table->id('');
    //     $table->unsignedBigInteger('id_ranking');
    //     $table->string('ranking_name');

    //     $table->foreign('id_ranking')->references('id_ranking')->on('ranking')->onDelete('cascade');
    //     $table->timestamps();
    // });

    public function createTaskByRanking(){
        
    }
}
