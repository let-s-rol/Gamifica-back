<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task_user;

class Task_userController extends Controller

{
    public function insert(Request $request, $id_task)
    {
        $request->validate([
            'file' => 'required|file'
        ]);

        $user = $request->user();

        $task = new Task_user();
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

    public function download(Request $request, $id)
    {
        $task = Task_user::findOrFail($id);
        $file = $task->file;
        $headers = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="' . $task->file_name . '"',
        ];
        return response($file, 200, $headers);
    }
    public function showTaskByUser(){

    }
    public function deleteTask(){
        
    }
}
