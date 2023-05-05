<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    use HasFactory;
    protected $table = 'badges';

    protected $fillable = [
        'name',
        'level',
        'max_points',
        'img_url'
    ];

    public function rankingUsers()
{
    return $this->belongsToMany(Ranking_User::class);
}
}
