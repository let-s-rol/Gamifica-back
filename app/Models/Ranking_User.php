<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ranking_User extends Model
{
    use HasFactory;

    public $table = "ranking_user";
    //protected $primaryKey = "id_user";
    protected $primaryKey = ['id_ranking', 'id_user'];
    //protected $primaryKey = array('id_user', 'id_ranking');
    //protected $primaryKey = 'id_ranking,id_user';

   // protected $primaryKey = 'id_user:id_ranking';
    //protected $primaryKey = "id_user";
    public $incrementing = false;

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_user',
        'id_ranking',
        'user_name',
        'points',
        'validar'
    ];


}
