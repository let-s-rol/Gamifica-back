<?php

use App\Http\Controllers\RankingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Ranking_UserController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);

Route::group( ['middleware' => ["auth:sanctum"]], function(){
    //insert ranking
    //Route::get('user-profile', [UserController::class, 'userProfile']);
    Route::get('create', [RankingController::class, 'create']);
    Route::get('logout', [UserController::class, 'logout']);
});

//GET http://127.0.0.1:8000/api/user postman, devuelve el usuario logeado actual
Route::middleware('auth:sanctum')->get('/user', function (Request 
$request) {
    return $request->user();
});
