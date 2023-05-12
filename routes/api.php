<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\EmployeeProjectController;
use App\Http\Controllers\ManagerEmployeeController;
use App\Http\Controllers\PermissionRoleController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('/role', [RoleController::class, 'index']);
Route::get('/role/{id}', [RoleController::class, 'show']);
Route::post('/role', [RoleController::class, 'create']);
Route::post('/role/{id}', [RoleController::class, 'update']);
Route::delete('/role/{id}', [RoleController::class, 'delete']);

Route::get('/permission', [PermissionRoleController::class, 'index']);
Route::get('/permission/{id}', [PermissionRoleController::class, 'show']);
Route::post('/permission', [PermissionRoleController::class, 'create']);
Route::post('/permission/{id}', [PermissionRoleController::class, 'update']);
Route::delete('/permission/{id}', [PermissionRoleController::class, 'delete']);

// Auth
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// ! Authenticated
Route::group(['middleware' => ['auth:sanctum',]], function () {

    Route::post('logout', [AuthController::class, 'logout']);

    // task
    Route::get('/task', [TaskController::class, 'index']);
    Route::get('/task/{id}', [TaskController::class, 'show']);
    Route::post('/task', [TaskController::class, 'create']);
    Route::post('/task/{id}', [TaskController::class, 'update']);
    Route::delete('/task/{id}', [TaskController::class, 'delete']);

    // project
    Route::get('/project', [ProjectController::class, 'index']);
    Route::get('/project/{id}', [ProjectController::class, 'show']);
    Route::post('/project', [ProjectController::class, 'create']);
    Route::post('/project/{id}', [ProjectController::class, 'update']);
    Route::delete('/project/{id}', [ProjectController::class, 'delete']);

    // user
    Route::get('/user', [UserController::class, 'index']);
    Route::get('/user/{id}', [UserController::class, 'show']);
    Route::post('/user/{id}', [UserController::class, 'update']);
    Route::delete('/user/{id}', [UserController::class, 'delete']);

    //employee-project
    Route::get('/employee-project/{id}', [EmployeeProjectController::class, 'show']);
    Route::post('/employee-project', [EmployeeProjectController::class, 'create']);

    //managerEmployee
    Route::get('/managerEmployee', [ManagerEmployeeController::class, 'index']);
    Route::get('/managerEmployee/{id}', [ManagerEmployeeController::class, 'show']);
    Route::post('/managerEmployee', [ManagerEmployeeController::class, 'create']);
});

