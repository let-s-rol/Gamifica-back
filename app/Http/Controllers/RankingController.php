<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Ranking;
use App\Models\User;
use Illuminate\Support\Str;
use App\Http\Controllers\TaskController;


class RankingController extends Controller
{

    public function create(Request $request)
    {
        $user = $request->user();

        if (isset($user->rol) == "profesor") {

            $request->validate([
                'ranking_name' => 'required | unique:ranking',
                'img' => 'nullable| image'
            ]);

            $ranking = new Ranking();
            $ranking->ranking_name = $request->ranking_name;
            $ranking->owner = $user->nick;
            $ranking->code = Str::random(10);

            $ranking->save();

            return response()->json([
                "status" => 1,
                "msg" => "¡Ranking creado con éxito!",
            ]);
        } else {
            return response()->json([
                "status" => 0,
                "msg" => "Han habido daddy issues",
            ]);
        }
    }

    public function delete(Request $request)
    {

        $request->validate([
            'id' => 'required'
        ]);
        $user = $request->user();

        $ranking = Ranking::find($request->id);
        $ranking->delete();

        return response()->json([
            "status" => 1,
            "msg" => "Ranking eliminado con éxito",
        ]);
    }

    public function show_rankings(Request $request)
    {
        $user = $request->user();
        if ($user->rol == "teacher") {
            $rankings = Ranking::where('owner', $user->nick)->get();
            if (isset($rankings)) {
                return response()->json($rankings);
            }
        }
        return null;
    }

    public function show_rankings_students(Request $request)
    {
        $user = $request->user();
        $rankings = $user->rankings()->wherePivot('validar', true)->get();

        return response()->json($rankings);
    }


    public function regenerateCode(Request $request)
    {

        $request->validate([
            'id' => 'required'
        ]);

        $user = $request->user();
        $ranking = Ranking::find($request->id);

        if (isset($ranking->owner) == $user->nick) {

            $new_code = Str::random(10);
            $ranking->code = $new_code;
            $ranking->update();

            return response()->json([
                "status" => 1,
                "msg" => "Código generado con éxito",
                "new_code" => $new_code,
            ]);
        }
        return response()->json([
            "status" => 0,
            "msg" => "No tiene permisos para realizar esta acción", $ranking->owner, $user->nick
        ]);
    }
}
