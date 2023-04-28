<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task_user extends Model
{
    use HasFactory;

    protected $table="task_user";
    
    protected $fillable = [
        'id_task',
        'id_user',
        'file',
        'points'
    ];
}
