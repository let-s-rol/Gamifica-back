<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Historial;

class HistorialController extends Controller
{
    public function showHistorial(Request $request){
        $historial = Historial::all();
        return response()->json([$historial]);
    }
}
