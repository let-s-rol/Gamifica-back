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

        switch ($badges) {
            case $badges['Responsabilidad']:
                $badge1 = new Badges_User();
                $badge1->id_user=$user->id;
                $badge1->id_ranking = $badges['id_ranking'];
                break;
            case $badges['Cooperacion']:
                $badge2 = new Badges_User();
                $badge2->id_user=$user->id;
                $badge2->id_ranking = $badges['id_ranking'];
                break;
            case $badges['Iniciativa']:
                $badge3 = new Badges_User();
                $badge3->id_user=$user->id;
                $badge3->id_ranking = $badges['id_ranking'];
                break;
            case $badges['Emocional']:
                $badge4 = new Badges_User();
                $badge4->id_user=$user->id;
                $badge4->id_ranking = $badges['id_ranking'];
                break;
            case $badges['Pensamiento']:
                $badge5 = new Badges_User();
                $badge5->id_user=$user->id;
                $badge5->id_ranking = $badges['id_ranking'];

                break;
        }
    }
}


// Responsabilidad: 1 (nivel 0)
// Cooperacion: 6 (nivel 0)
// Iniciativa: 11 (nivel 0)
// Emocional: 16 (nivel 0)
// Pensamiento: 21 (nivel 0)

// Schema::create('badges_user', function (Blueprint $table) {
//     $table->id();
//     $table->unsignedBigInteger('id_badge');
//     $table->unsignedBigInteger('id_user');
//     $table->unsignedBigInteger('id_ranking');
//     $table->integer('experience')->default(0);

//     $table->foreign('id_badge')->references('id')->on('badges');
//     $table->foreign('id_ranking')->references('id')->on('ranking')->onDelete('cascade');
//     $table->foreign('id_user')->references('id')->on('user')->onDelete('cascade');
//     $table->unique(['id_badge','id_ranking', 'id_user']); // Restricción de clave única mixta
// });
