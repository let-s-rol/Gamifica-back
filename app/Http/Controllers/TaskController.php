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
            'ranking_name' => 'required',
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
            'id' => 'required',
            //'id_ranking' => 'required'
        ]);
        if (Task:://where('id_ranking', $request->id_ranking)
            where('id', $request->id)
            ->delete()
        ) {

            return response()->json(['message' => 'Tarea eliminada correctamente.']);
        }

        return response()->json(['message' => 'No se encontró ninguna tarea para eliminar.']);
    }

    public function pickTaskByRanking(Request $request)
    {
        $request->validate([
            'id_ranking' => 'required'
        ]);
        Task::where('id_ranking', $request->id_ranking)->get();
    }

    public function show_tasks(Request $request)
    {

        $request->validate([
            'id' => 'required'
        ]);
        $task = Task::where('id_ranking', $request->id); //se obtiene task deseado
        $task = $task
            ->get();

        return response()->json($task);
    }
}
