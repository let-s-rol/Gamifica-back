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
                'img' => 'nullable| image'
            ]);

            $ranking = new Ranking();
            $ranking->ranking_name = $request->ranking_name;
            $ranking->owner = $user->nick;
            $ranking->code = Str::random(10);

            if (isset($request->img)) {
                $ranking->img = $request->img;
            } else {
                $ranking->img = 'public/images/default.png';
            }

            // Si se ha subido una imagen, se guarda su contenido en la base de datos
        if ($request->hasFile('img')) {
            $imagePath = $request->file('img')->getRealPath();
            $image = file_get_contents($imagePath);
            $ranking->img = $image;
        } else {
            $defaultImage = file_get_contents(public_path('img/default.png'));
            $character->base_character_img = $defaultImage;
        }

            $ranking->save();
            $task = app(TaskController::class);
            $task->createTaskByRanking($ranking->id_ranking, $ranking->ranking_name);

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

    public function regenerateCode(Request $request, $ranking_id)
    {
        $user = $request->user();
        $ranking = Ranking::find($ranking_id);

        if (isset($ranking->owner) === $user->nick) {

            $new_code = Str::random(10);
            $ranking->code = $new_code;
            $ranking->save();

            return response()->json([
                "status" => 1,
                "msg" => "Código generado con éxito",
                "new_code" => $new_code,
            ]);
        }
        return response()->json([
            "status" => 0,
            "msg" => "No tiene permisos para realizar esta acción",
        ]);
    }
}
