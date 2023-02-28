<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function register(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'lastname' => 'required',
            'nick' => 'required | unique:User',
            'email' => 'required | email | unique:User',
            'password' => 'required | confirmed',
            'school' => 'nullable',
            'date' => 'nullable'
        ]);

        $user = new User();
        $user->nick = $request->nick;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->name = $request->name;
        $user->lastname = $request->lastname;
        $user->school = $request->school;
        $user->date = $request->date;

        if (isset($user->school)) {
            $user->rol = "teacher";
        } else {
            $user->rol = "student";
        }

        $user->save();
        //autologin
        $token = $user->createToken("auth_token")->plainTextToken;
        return response()->json([
            "status" => 1,
            "msg" => "Registro de usuario exitoso",
            "access_token" => $token
        ]);
    }

    public function login(Request $request)
    {
        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);

        $user = User::where("email", "=", $request->email)->first();

        if (isset($user->id)) {
            if (Hash::check($request->password, $user->password)) {
                //creamos el token
                $token = $user->createToken("auth_token")->plainTextToken;
                //si está todo ok
                return response()->json([
                    "status" => 1,
                    "msg" => "¡Usuario logueado exitosamente!",
                    "access_token" => $token
                ]);
            } else {
                return response()->json([
                    "status" => 0,
                    "msg" => "La password es incorrecta",
                ], 404);
            }
        } else {
            return response()->json([
                "status" => 0,
                "msg" => "Usuario no registrado",
            ], 404);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            "status" => 1,
            "msg" => "Cierre de Sesión",
        ]);
    }
}
