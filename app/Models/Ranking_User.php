<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ranking_User extends Model
{
    use HasFactory;

    protected $table = 'ranking_user';

    protected $primaryKey = ['id_ranking', 'id_user'];

    protected $fillable = [
        'id_user',
        'id_ranking',
        'user_name',
        'points',
        'validar',
    ];

    public $incrementing = false;

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function ranking()
    {
        return $this->belongsTo(Ranking::class, 'id_ranking');
    }
}
