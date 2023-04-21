<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task_user extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_task',
        'id_user',
        'file',
        'file_name',
        'points'
    ];
}
