<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{

    public function createTaskByRanking($id_ranking, $ranking_name){
        $task = new Task();
        $task->id_ranking = $id_ranking;
        $task->ranking_name = $ranking_name;
        $task->save();
    }

    public function deleteTaskByRanking($id_ranking){
        Task::where('id_ranking', $id_ranking)->delete();
    }

    public function pickTaskByRanking(Request $request, $id_ranking){
        Task::where('id_ranking', $id_ranking)->get();
    }
}
