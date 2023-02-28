<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Ranking;
use App\Models\User;


class RankingController extends Controller
{

    public function getAuthUser(Request $request){
        $user = $request->user();
        return $user;
    }

    public function create(Request $request)
    {
        $user = $request->user();
        
        if (isset($user->rol)=="profesor") {
            
            $request->validate([
                'ranking_name' => 'required | unique:ranking',
            ]);
            
            $ranking = new Ranking();
            $ranking->ranking_name=$request->ranking_name;
            $ranking->owner=$user->nick;
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
        
        if (isset($user->rol)=="profesor") {
            
            $ranking = Ranking::find($ranking_id);
            $ranking->delete();

        } else {
            return response()->json([
                "status" => 0,
                "msg" => "Han habido daddy issues",
            ]);
        } 
    }
}
