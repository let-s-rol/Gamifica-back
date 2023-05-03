<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Badges_User extends Model
{
    use HasFactory;

    protected $table = "badges_user";

    protected $fillable = [
        'id_badge',
        'id_user',
        'id_ranking',
        'experience'
    ];

    // Obtener la entrada específica de la badge de la tabla badges
    public function badge()
    {
        return $this->belongsTo(Badge::class, 'id_badge');
    }

    // Obtener el usuario de la tabla users
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function ranking()
    {
        return $this->belongsTo(Ranking::class, 'id_ranking');
    }

    public function getImageUrl(): string
    {
        $level = $this->level > 0 ? $this->level : 1; // si el nivel es 0, la imagen es la de nivel 1
        return "/assets/medals/{$this->name}{$level}.png";
    }

    function max_experience($id_badge, $experience)
    {
        $points_per_level = [0, 1000, 2000, 4000, 7000, 10000];
        $level = 0;
        $max_points = $points_per_level[$level];

        while ($experience >= $max_points && $level < 5) {
            $level++;
            $max_points = $points_per_level[$level];
        }

        $id_badge = $id_badge + $level - 1;

        return $id_badge;
    }
}
