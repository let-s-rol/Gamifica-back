<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task_user;
use App\Models\User;

class Task_userController extends Controller

{

    public function insertTask(Request $request)
    {
        $request->validate([
            'file' => 'required|file',
            'id_task' => 'required'
        ]);

        $user = $request->user();

        $task = new Task_user();
        $task->id_task = $request->id_task;
        $task->id_user = $user->id;
        $task->file = $request->file;
        $file = $request->file('file');
        $contents = file_get_contents($file->path());
        $task->file = $contents;

        if ($task->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Tarea enviada correctamente',
                'data' => $task
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No se pudo enviar la tarea',
        ]);
    }



    public function upload(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'file' => 'required|file'
        ]);

        $task = Task_user::find($request->id_task);

        if ($request->user()->rol != 'alumno') {
            return response()->json([
                'success' => false,
                'message' => 'Solo los alumnos pueden subir archivos a esta tarea'
            ]);
        }

        $file = $request->file('file');
        $contents = file_get_contents($file->path());

        $task->file = $contents;
        if ($task->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Archivo subido correctamente',
                'data' => $task
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No se pudo subir el archivo a la tarea',
        ]);
    }

    public function download(Request $request)
    {
        $request->validate([
            'id' => 'required'
        ]);
        $task = Task_user::findOrFail($request->id);
        $file = $task->file;
        $headers = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $task->file_name . '"',
        ];
        return response($file, 200, $headers);
    }
    public function showTaskByUser(Request $request)
    {
        $user = $request->user();
        $tasks = Task_user::where('id_user', $user->id)->get();

        return response()->json([
            'success' => true,
            'message' => 'Tareas del usuario',
            'data' => $tasks
        ]);
    }
    public function Correct(Request $request)
    {

        $request->validate([
            'id_alumno' => 'required',
            'id_task' => 'required',
            'id_' => 'required',
            'points' => 'required'
        ]);

        $user = $request->user();

        $student = User::where('id', $request->id_alumno)->first();
        $ranking_student = Ranking_User::where('id_ranking', $request->id_ranking)->where('id_user', $student->id)->first();
        $ranking_student->points = $request->points;

        $ranking_student->update();
    }
}
