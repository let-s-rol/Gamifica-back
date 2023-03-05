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

Route::group(['middleware' => ["auth:sanctum"]], function () {

    Route::get('logout', [UserController::class, 'logout']);

    //RANKING
    Route::get('create_ranking', [RankingController::class, 'create']);
    Route::delete('delete_ranking', [RankingController::class, 'delete']);

    //RANKING_USER
    Route::post('access_ranking', [Ranking_UserController::class, 'insert']);
    Route::delete('kick_student', [Ranking_UserController::class, 'kickoff']);
    Route::post('update_points', [Ranking_UserController::class, 'update_points']);
    Route::get('show_students', [Ranking_UserController::class, 'show_students']);
});

//GET http://127.0.0.1:8000/api/user postman, devuelve el usuario logeado actual
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
