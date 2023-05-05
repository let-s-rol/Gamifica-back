<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Historial extends Model
{
    use HasFactory;

    protected $table = 'historial';

    protected $fillable = [
        'id_ranking',
        'id_giver',
        'id_receiver',
        'experience',
        'giver_name',
        'receiver_name',
        'Responsabilidad',
        'Cooperacion',
        'Iniciativa',
        'Emocional',
        'Pensamiento',

    ];


}
