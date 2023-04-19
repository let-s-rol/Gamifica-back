<?php

use App\Http\Controllers\RankingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Ranking_UserController;
use App\Http\Controllers\Task_userController;
use App\Http\Controllers\TaskController;

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

    Route::delete('logout', [UserController::class, 'logout']);

    //RANKING
    Route::post('create_ranking', [RankingController::class, 'create']);
    Route::delete('delete_ranking', [RankingController::class, 'delete']);
    Route::get('show_rankings', [RankingController::class, 'show_rankings']);
    Route::post('regenerate_code', [RankingController::class, 'regenerateCode']);

    //RANKING_USER
    Route::post('access_ranking/', [Ranking_UserController::class, 'insert']);
    Route::post('update_points', [Ranking_UserController::class, 'update_points']);
    Route::get('show_students', [Ranking_UserController::class, 'show_students']);
    Route::get('show_pending_users', [Ranking_UserController::class, 'show_pending_users']);
    Route::put('validate_student', [Ranking_UserController::class, 'validate_user']);
    Route::delete('kick_student', [Ranking_UserController::class, 'kickoff']);

    //TASKS
    Route::post('createTask', [TaskController::class, 'createTask']);
    Route::get('pickTask', [TaskController::class, 'pickTaskByRanking']);
    Route::delete('deleteTask', [TaskController::class, 'deleteTaskByRanking']);

    //TASK_USER
    Route::post('tasks/{id_task}/insert', [Task_userController::class, 'insertTask']);
    Route::post('tasks/{id_task}/upload', [Task_userController::class, 'upload']);
    Route::get('tasks/{id_task}/download', [Task_userController::class, 'download']);
    Route::get('tasks', [Task_userController::class, 'showTaskByUser']);
    Route::delete('tasks/{id_task}/delete', [Task_userController::class, 'delete']);
});

//GET http://127.0.0.1:8000/api/user postman, devuelve el usuario logeado actual
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
