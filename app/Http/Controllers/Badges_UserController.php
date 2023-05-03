<?php

namespace App\Http\Controllers;

use App\Models\Ranking_User;
use App\Models\Ranking;
use App\Models\User;
use App\Models\Badges_User;
use Illuminate\Http\Request;

class Badges_UserController extends Controller
{
    public function insertSkillsPoints(Request $request)
    {
        $user = $request->user();

        $badges = $request->validate([
            'id_ranking' => 'required',
            'Responsabilidad' => 'nullable',
            'Puntos_Responsabilidad' => 'nullable',
            'Cooperacion' => 'nullable',
            'Puntos_Cooperacion' => 'nullable',
            'Iniciativa' => 'nullable',
            'Puntos_Iniciativa' => 'nullable',
            'Emocional' => 'nullable',
            'Puntos_Emocional' => 'nullable',
            'Pensamiento' => 'nullable',
            'Puntos_Pensamiento' => 'nullable'
        ]);

        $badges_user = Badges_User::where('id_user', $user->id)
            ->where('id_ranking', $request->input('id_ranking'))
            ->get();

        if ($badges_user->isNotEmpty()) {

            foreach ($badges_user as $badge) {
                $new_badge_id = $badge->max_experience($badge->id_badge, $badge->experience);
                if ($new_badge_id != $badge->id_badge) {
                    $badge->id_badge = $new_badge_id;
                    $badge->update();
                }
            }
        }

        if (isset($badges['Responsabilidad'])) {
            $badge1 = new Badges_User();
            $badge1->id_user = $user->id;
            $badge1->id_ranking = $badges['id_ranking'];
            $badge1->id_badge = $badge1->max_experience(1, $badges['Puntos_Responsabilidad']);
            $badge1->experience = $badges['Puntos_Responsabilidad'];
            $badge1->save();
        }

        if (isset($badges['Cooperacion'])) {
            $badge2 = new Badges_User();
            $badge2->id_user = $user->id;
            $badge2->id_ranking = $badges['id_ranking'];
            $badge2->id_badge = $badge2->max_experience(6, $badges['Puntos_Cooperacion']);
            $badge2->experience = $badges['Puntos_Cooperacion'];
            $badge2->save();
        }
        if (isset($badges['Iniciativa'])) {
            $badge3 = new Badges_User();
            $badge3->id_user = $user->id;
            $badge3->id_ranking = $badges['id_ranking'];
            $badge3->id_badge = $badge3->max_experience(11, $badges['Puntos_Iniciativa']);
            $badge3->experience = $badges['Puntos_Iniciativa'];
            $badge3->save();
        }
        if (isset($badges['Emocional'])) {
            $badge4 = new Badges_User();
            $badge4->id_user = $user->id;
            $badge4->id_ranking = $badges['id_ranking'];
            $badge4->id_badge = $badge4->max_experience(16, $badges['Puntos_Emocional']);
            $badge4->experience = $badges['Puntos_Emocional'];
            $badge4->save();
        }
        if (isset($badges['Pensamiento'])) {
            $badge5 = new Badges_User();
            $badge5->id_user = $user->id;
            $badge5->id_ranking = $badges['id_ranking'];
            $badge5->id_badge = $badge5->max_experience(21, $badges['Puntos_Pensamiento']);
            $badge5->experience = $badges['Puntos_Pensamiento'];
            $badge5->save();
        }
    }
}
