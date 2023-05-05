<?php

namespace App\Http\Controllers;

use App\Models\Ranking_User;
use App\Models\Ranking;
use App\Models\User;
use App\Models\Badges_User;
use App\Models\Badge;
use App\Models\Historial;
use Illuminate\Http\Request;

class Badges_UserController extends Controller
{
    public function createBaseBadgesByUser($id_ranking, $id_user)
    {
        $badge1 = new Badges_User();
        $badge1->id_user = $id_user;
        $badge1->id_ranking = $id_ranking;
        $badge1->id_badge = 1;
        $badge1->experience = 0;
        $badge1->save();

        $badge2 = new Badges_User();
        $badge2->id_user = $id_user;
        $badge2->id_ranking = $id_ranking;
        $badge2->id_badge = 7;
        $badge2->experience = 0;
        $badge2->save();

        $badge3 = new Badges_User();
        $badge3->id_user = $id_user;
        $badge3->id_ranking = $id_ranking;
        $badge3->id_badge = 13;
        $badge3->experience = 0;
        $badge3->save();

        $badge4 = new Badges_User();
        $badge4->id_user = $id_user;
        $badge4->id_ranking = $id_ranking;
        $badge4->id_badge = 19;
        $badge4->experience = 0;
        $badge4->save();

        $badge5 = new Badges_User();
        $badge5->id_user = $id_user;
        $badge5->id_ranking = $id_ranking;
        $badge5->id_badge = 25;
        $badge5->experience = 0;
        $badge5->save();
    }

    public function insertSkillsPoints(Request $request)
    {
        $user = $request->user();
        $badges = $request->validate([
            'id_ranking' => 'required',
            'id_user' => 'required',
            'Responsabilidad' => 'nullable', //badge inicial id 1
            'Cooperacion' => 'nullable', //badge inicial id 7
            'Iniciativa' => 'nullable', //badge inicial id 13
            'Emocional' => 'nullable', //badge inicial id 19
            'Pensamiento' => 'nullable' //badge inicial id 25
        ]);

        if ($user->id == $request->id_user) {
            return response()->json(
                ['success' => false, 'message' => 'No puedes puntuarte a ti mismo']
            );
        }
        
        $user = Ranking_User::where('id_user', $request->id_user)
            ->where('id_ranking', $request->id_ranking)
            ->first();
        

        $badges_experience = [
            $badges['Responsabilidad'] ?? 0,
            $badges['Cooperacion'] ?? 0,
            $badges['Iniciativa'] ?? 0,
            $badges['Emocional'] ?? 0,
            $badges['Pensamiento'] ?? 0
        ];

        $sum_experience = array_sum($badges_experience);

        
        if ($user->puntosSemanales < $sum_experience) {
            return response()->json(
                ['success' => false, 'message' => 'Los puntos que tratas de añadir exceden tu límite de puntos semanales: ' . $user->puntosSemanales]
            );
        } else {
            $user->puntosSemanales -= $sum_experience;
            $user->save();
        }

        $badges_user = Badges_User::where('id_user', $request->id_user)
            ->where('id_ranking', $request->input('id_ranking'))
            ->get();

        $indice = 0;
        // crear una nueva instancia de Historial
        $historial = new Historial();

        // asignar los valores necesarios a las propiedades
        $historial->id_ranking = $request->input('id_ranking');
        $historial->id_giver = $user->id;
        $historial->id_receiver = $request->id_user;
        $historial->giver_name = $user->user_name;
        $historial->receiver_name = User::find($request->id_user)->name;
        $historial->Responsabilidad = $badges_experience[0];
        $historial->Cooperacion = $badges_experience[1];
        $historial->Iniciativa = $badges_experience[2];
        $historial->Emocional = $badges_experience[3];
        $historial->Pensamiento = $badges_experience[4];
       
        // guardar el historial
        $historial->save();
        
        foreach ($badges_user as $badge) { //creación de objeto de las medallas del usuario y usado en el foreach

            $badge_obj = Badge::find($badge->id_badge)->first();
            $badge->experience += $badges_experience[$indice];
            $new_badge_id = $badge->max_experience($badge_obj->name, $badge->experience);

            if ($new_badge_id != $badge_obj->id) {
                $badge->update(['id_badge' => $new_badge_id, 'experience' => $badge->experience]);
            } else {
                $badge->update(['experience' => $badge->experience]);
            }
            $indice++;
        }
    }


    public function showSkillsByUsers(Request $request)
    {
        $request->validate([
            'id_ranking' => 'required',
        ]);

        $badges_user = Badges_User::where('id_ranking', $request->input('id_ranking'))
            ->get();
        return response()->json(['success' => true, 'data' => $badges_user]);
    }
}
