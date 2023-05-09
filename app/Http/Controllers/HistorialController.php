<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Historial;

class HistorialController extends Controller
{
    public function showHistorial(Request $request)
    {

        $request->validate([
            'id_ranking' => 'required'
        ]);
        
        $historial = Historial::where('id_ranking', $request->id_ranking)->get();
        return response()->json([$historial]);
    }
}
