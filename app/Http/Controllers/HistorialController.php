<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Historial;

class HistorialController extends Controller
{
    public function showHistorial(Request $request, $id_ranking)
    {

        $historial = Historial::where('id_ranking', $id_ranking)->get();
        return response()->json([$historial]);
    }
}
