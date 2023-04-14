<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{

    public function createTask(Request $request, $id_ranking, $ranking_name)
    {
        $request->validate([
            'name' => 'required',
            'sentence' => 'required'
        ]);
        $task = new Task();
        $task->id_ranking = $id_ranking;
        $task->ranking_name = $ranking_name;
        $task->name = $request->name;
        $task->sentence = $request->sentece;
        $task->save();

        return response()->json([
            "status" => 1,
            "msg" => "¡Tarea añadida con éxito!",
        ]);
    }

    public function deleteTaskByRanking($id_ranking)
    {
        Task::where('id_ranking', $id_ranking)->delete();
    }

    public function pickTaskByRanking(Request $request, $id_ranking)
    {
        Task::where('id_ranking', $id_ranking)->get();
    }
}
