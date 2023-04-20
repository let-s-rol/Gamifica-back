<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{

    public function createTask(Request $request)
    {
        $request->validate([
            'id_ranking' => 'required',
            'ranking_name'=>'required',
            'name' => 'required',
            'sentence' => 'required'
        ]);
        $task = new Task();
        $task->id_ranking = $request->id_ranking;
        $task->ranking_name = $request->ranking_name;
        $task->name = $request->name;
        $task->sentence = $request->sentence;
        $task->save();

        return response()->json([
            "status" => 1,
            "msg" => "¡Tarea añadida con éxito!",
        ]);
    }

    public function deleteTaskByRanking(Request $request)
    {
        $request->validate([
            'id_ranking' => 'required'
        ]);
        Task::where('id_ranking', $request->id_ranking)->delete();
    }

    public function pickTaskByRanking(Request $request)
    {
        $request->validate([
            'id_ranking' => 'required'
        ]);
        Task::where('id_ranking', $request->id_ranking)->get();
    }
}
