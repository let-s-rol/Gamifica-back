<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Badge;

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

    function max_experience($badge_name, $experience)
    {
        
        $badge = Badge::where('name', $badge_name)->first();
        
        $points_per_level = [0, 1000, 2000, 4000, 7000, 10000];

        $current_level = 0;
        foreach ($points_per_level as $level => $points) {
            if ($experience <= $points) {
                break;
            }
            $current_level = $level;
        }

        return $badge->id + $current_level;
    }
}
