<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Ranking;
use App\Models\User;


class RankingController extends Controller
{

    public function getAuthUser(Request $request)
    {
        $user = $request->user();
        return $user;
    }

    public function create(Request $request)
    {
        $user = $request->user();

        if (isset($user->rol) == "profesor") {

            $request->validate([
                'ranking_name' => 'required | unique:ranking',
                'img' => 'nullable'
            ]);

            $ranking = new Ranking();
            $ranking->ranking_name = $request->ranking_name;
            $ranking->owner = $user->nick;
            if (isset($request->img)) {
                $ranking->img = $request->img;
            } else {
                $ranking->img = 'public/images/default.png';
            }

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

    public function delete(Request $request, $ranking_id)
    {
        $user = $request->user();
        $ranking = Ranking::find($ranking_id);

        if (isset($ranking->owner) === $user->nick) {

            $ranking->delete();

            return response()->json([
                "status" => 1,
                "msg" => "Ranking eliminado con éxito",
            ]);
        }
        return response()->json([
            "status" => 0,
            "msg" => "Han habido un error",
        ]);

    }
}
