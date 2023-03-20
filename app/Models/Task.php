<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

// Schema::create('task', function (Blueprint $table) {
    //     $table->id('');
    //     $table->unsignedBigInteger('id_ranking');
    //     $table->string('ranking_name');

    //     $table->foreign('id_ranking')->references('id_ranking')->on('ranking')->onDelete('cascade');
    //     $table->timestamps();
    // });
    
    public $table = "task";


    
}
