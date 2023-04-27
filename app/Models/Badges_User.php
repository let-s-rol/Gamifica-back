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

    public function getImageUrl(): string
    {
        $level = $this->level > 0 ? $this->level : 1; // si el nivel es 0, la imagen es la de nivel 1
        return "/assets/medals/{$this->name}{$level}.png";
    }

    function max_experience2($badge, $experience) {
        $points_per_level = [0, 1000, 2000, 4000, 7000, 10000];
        $level = $badge->level;
        $max_points = $badge->max_points;
    
        while ($experience >= $max_points && $level < 5) {
            $level++;
            $max_points = $points_per_level[$level];
            $badge->update(['level' => $level, 'max_points' => $max_points]);
        }
    
        return $max_points;
    }

    public function max_experience($experience) {
        $max_experience = $this->max_points;
        if ($experience >= $max_experience) {
            $this->experience = $max_experience;
            $current_image = $this->img_url;
            $new_experience = $this->experience;
            $new_level = $this->getLevelFromExperience($new_experience);
            if ($new_level !== $this->level) {
                $this->level = $new_level;
                $this->img_url = "/assets/medals/{$this->name}{$new_level}.png";
            }
        } else {
            $this->experience = $experience;
        }
    }
    
}
