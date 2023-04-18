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
        //$code = $request->query('code');

        $request->validate([
            'code' => 'required'
        ]);

        $code = $request->code;
        // Log the value of $code

        $request->validate([
            'code' => 'required'
        ]);
        $code = $request->code;

        // Buscamos el ranking correspondiente al código proporcionado
        $ranking = Ranking::where('code', $code)->first();

        if (!$ranking) {
            return response()->json(['success' => false, 'message' => 'No se encontró el ranking correspondiente']);
        }

        // Validamos el código proporcionado con el código del ranking
        if ($ranking->code != $code) {
            return response()->json(['success' => false, 'message' => 'El código proporcionado no coincide con el código del ranking']);
        }
        $ranking_user = new Ranking_User();
        $ranking_user->id_ranking = $ranking->id;
        $ranking_user->id_user = $user->id;
        $ranking_user->user_name = $user->nick;
        $ranking_user->points = 0;
        $ranking_user->validar = false;

        if ($ranking_user->save()) {

            return response()->json(['success' => true, 'message' => 'Has sido agregado, espera a que el profesor te valide dentro del ranking']);
        }

        return response()->json(['success' => false, 'message' => 'No se pudo agregar el alumno al ranking']);
    }

    public function validate_user(Request $request)
    {

        $request->validate([
            'id_alumno' => 'required',
            'id_ranking' => 'required'
        ]);

        $student = User::where('id', $request->id_alumno)->first();
        $ranking_student = Ranking_User::where('id_ranking', $request->id_ranking)->where('id_user', $student->id)->first();
        $ranking_student->validar = true;
        if ($ranking_student->update()) {
            return response()->json(['success' => true, 'message' => 'Alumno validado correctamente']);
        } else {
            return response()->json(['success' => false, 'message' => 'No se pudo validar al alumno']);
        }
        if (!$ranking_student) {
            return response()->json(['success' => false, 'message' => 'No se encontró el alumno en el ranking']);
        }
    }


    /* FUNCIÓN KICKOFF: Está función sirve para eliminar a un alumno de un ranking. Para ello
       comprobará si el Usuario intentándolo es un profesor, después rellena el objeto Student
       con los datos del alumno...*/
    public function kickoff(Request $request)
    {
        $request->validate([
            'id_alumno' => 'required',
            'id_ranking' => 'required'
        ]);
        $user = $request->user();

        if (isset($user->rol) && $user->rol == "profesor") {

            $student = User::where('id', $request->id_alumno)->first();
            $ranking_student = Ranking_User::where('id_ranking', $request->id_ranking)->where('id_user', $student->id)->first();

            if ($ranking_student->delete()) {
                return response()->json(['success' => true, 'message' => 'Alumno borrado correctamente']);
            } else {
                return response()->json(['success' => false, 'message' => 'No se pudo borrar al alumno']);
            }
            if (!$ranking_student) {
                return response()->json(['success' => false, 'message' => 'No se encontró el alumno en el ranking']);
            }
        }
    }

    /* */
    public function update_points(Request $request)
    {

        $request->validate([
            'id_alumno' => 'required',
            'id_ranking' => 'required'
        ]);

        $user = $request->user();

        if (isset($user->rol) && $user->rol == "profesor") {

            $request->validate([
                'points' => 'required'
            ]);
            $student = User::where('id', $request->id_alumno)->first();
            $ranking_student = Ranking_User::where('id_ranking', $request->id_ranking)->where('id_user', $student->id)->first();
            $ranking_student->points = $request->points;

            $ranking_student->update();
        }
    }

    /* */
    public function show_students(Request $request)
    {

        $request->validate([
            'id_ranking' => 'required'
        ]);
        $ranking = Ranking_User::find($request->id_ranking); //se obtiene ranking deseado
        $students = $ranking->users()
            ->where('rol', 'student')
            ->orderBy('ranking_user.points', 'desc')
            ->get();

        return response()->json($students);
    }

    public function show_pending_users()
    {
        $pending_users = Ranking_User::where('validar', false)->get();
        return response()->json($pending_users);
    }
}
