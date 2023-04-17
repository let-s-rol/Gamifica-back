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

        $request -> validate([
            'code' => 'required'
        ]);

        $code = $request -> code;
    

            // Log the value of $code
            

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

    public function validar(Request $request, $id, $validador)
    {
        $ranking_student = Ranking_User::where('id_user', $id)->first();
        if (!$ranking_student) {
            return response()->json(['success' => false, 'message' => 'No se encontró el alumno en el ranking']);
        }
        if ($validador == 0) {
            if ($ranking_student->delete()) {
                return response()->json(['success' => true, 'message' => 'Alumno eliminado correctamente']);
            } else {
                return response()->json(['success' => false, 'message' => 'No se pudo eliminar el alumno del ranking']);
            }
        } else {
            $ranking_student->validar = true;
            if ($ranking_student->update()) {
                return response()->json(['success' => true, 'message' => 'Alumno validado correctamente']);
            } else {
                return response()->json(['success' => false, 'message' => 'No se pudo validar al alumno']);
            }
        }
    }


    /* FUNCIÓN KICKOFF: Está función sirve para eliminar a un alumno de un ranking. Para ello
       comprobará si el Usuario intentándolo es un profesor, después rellena el objeto Student
       con los datos del alumno...*/
    public function kickoff(Request $request, $id_alumno, $id_ranking)
    {
        $user = $request->user();

        if (isset($user->rol) && $user->rol == "profesor") {

            $student = User::where('id', $id_alumno)->first();
            $ranking_student = Ranking_User::where('id_ranking', $id_ranking)->where('id_user', $student->id)->first();

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
            $ranking_student = Ranking_User::where('id_ranking', $id_ranking)->where('id_user', $student->id)->first();
            $ranking_student->points = $request->points;

            $ranking_student->update();
        }
    }

    /* */
    public function show_students(Request $request, $id_ranking)
    {
        $ranking = Ranking_User::find($id_ranking); //se obtiene ranking deseado
        $students = $ranking->users()
            ->where('rol', 'student')
            ->orderBy('ranking_user.points', 'desc')
            ->get();

        return response()->json($students);
    }
}
