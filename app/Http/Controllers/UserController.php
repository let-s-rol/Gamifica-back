<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;

class UserController extends Controller
{

    private $jwtSecret;

    public function __construct()
    {
        $this->jwtSecret = env('JWT_SECRET');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'lastname' => 'required',
            'nick' => 'required | unique:User',
            'email' => 'required | email | unique:User',
            'password' => 'required',
            'school' => 'nullable',
            'date' => 'nullable',
            'img' => 'nullable|image'
        ]);

        $user = new User();
        $user->nick = $request->nick;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->name = $request->name;
        $user->lastname = $request->lastname;
        $user->school = $request->school;
        $user->date = $request->date;

         if ($request->hasFile('img')) {
             $imagePath = $request->file('img')->getRealPath();
             $image = file_get_contents($imagePath);
             $user->img = base64_encode($image);
         } else {
            $defaultImage = file_get_contents(public_path('images/default.png'));
             $user->img = base64_encode($defaultImage);
         }

        if (isset($user->school)) {
            $user->rol = "teacher";
        } else {
            $user->rol = "student";
        }

        $user->save();

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

                $token = $user->createToken("auth_token")->plainTextToken;

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

    /*ESTA ES LA FUNCIÓN GENERAL PARA PILLAR EL JSON DE USUARIO */
    public function userprofile(Request $request)
    {
        $user = $request->user();
        return response()->json($user);
    }
    public function updateProfilePicture(Request $request)
    {
        $request->validate([
            'img' => 'required|image'
        ]);

        $user = $request->user();

        if ($request->hasFile('img')) {
            $imagePath = $request->file('img')->getRealPath();
            $image = file_get_contents($imagePath);
            $user->img = $image;
            $user->save();

            return response()->json([
                'status' => 1,
                'msg' => 'Imagen de perfil actualizada exitosamente'
            ]);
        } else {
            return response()->json([
                'status' => 0,
                'msg' => 'No se ha seleccionado ninguna imagen'
            ], 400);
        }
    }

    public function editUser(Request $request)
    {
        $oldUser = $request->user();
    
        $request->validate([
            'name' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:User,email,'.$oldUser->id,
            'password' => 'required',
        ]);
    
        $user = User::find($oldUser->id);
    
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->name = $request->name;
        $user->lastname = $request->lastname;
        $user->save();
    
        return response()->json([
            'status' => 1,
            'msg' => 'Usuario actualizado exitosamente'
        ]);
    }
    
}
