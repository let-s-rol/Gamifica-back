<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ranking_User;
use App\Models\Ranking;
use App\Models\User;


class Ranking_UserController extends Controller
{

    /* FUNCIÓN INSERT: El proposito de esta función es insertar un Usuario en un Ranking.
       Para ello primero comprueba si quien quiere insertar el alumno es un profesor, después
       define las propiedades del Ranking_User con los datos recibidos del User que se quiere insertar.
       Por último comprueba si se han guardado estos cambios y te lanza varios mensajes para ver
       si la operación ha sido exitosa, si ha fallado, y algunos de los motivos de fallo.*/

    public function insert(Request $request)
    {
        $user = $request->user();

        $ranking_user = new Ranking_User();
        $ranking_user->id_user = $user->id;
        $ranking_user->user_name = $user->nick;
        $ranking_user->points = 0;

        if ($ranking_user->save()) {
            return response()->json(['success' => true, 'message' => 'Alumno agregado correctamente']);
        }
        return response()->json(['success' => false, 'message' => 'No se pudo agregar el alumno al ranking']);

    }


    /* FUNCIÓN KICKOFF: Está función sirve para eliminar a un alumno de un ranking. Para ello
       comprobará si el Usuario intentándolo es un profesor, después rellena el objeto Student
       con los datos del alumno...*/
    public function kickoff(Request $request, $id_alumno, $id_ranking)
    {
        $user = $request->user();

        if (isset($user->rol) && $user->rol == "profesor") {

            $student = User::where('id', $id_alumno)->first();
            $ranking_student = Ranking_User::where('id_ranking',$id_ranking)->where('id_user',$student->id);

            $ranking_student->delete();


        }
    }

    /* */
    public function update_points(Request $request, $id_alumno, $id_ranking)
    {
        $user = $request->user();

        if (isset($user->rol) && $user->rol == "profesor") {

            $request->validate([
                'points' => 'required'
            ]);
            $student = User::where('id', $id_alumno)->first();
            $ranking_student = Ranking_User::where('id_ranking',$id_ranking)->where('id_user',$student->id);
            $ranking_student->points=$request->points;
            $ranking_student->update();

        }
    }

    /* */
    public function show_students(Request $request)
    {
        $students = User::where('rol', 'student')->orderBy('points', 'desc')->get();
        return response()->json($students);
    }
}
