<?php

use App\Http\Controllers\Auth\WebAuthController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\WEB\EmployeeWebContoller;
use App\Http\Controllers\WEB\MasterWebController;
use App\Http\Controllers\WEB\ProjectWebContoller;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('login');
});
Route::get('/login', [WebAuthController::class, 'loginView'])->name('login.view');
Route::post('/login', [WebAuthController::class, 'login'])->name('login.post');
Route::get('/404', [WebAuthController::class, 'dataNotFound'])->name('404');

// ! Authenticated
Route::group(['middleware' => ['auth']], function () {

    Route::post('/logout', [WebAuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('invitation')->group(function () {
        Route::post('/accept/{id}', [MasterWebController::class, 'acccept'])->name('invitation.accept');
        Route::post('/decline/{id}', [MasterWebController::class, 'decline'])->name('invitation.decline');
    });

    Route::prefix('project')->group(function () {
        Route::get('/', [ProjectWebContoller::class, 'index'])->name('project.index');
        Route::get('/create', [ProjectWebContoller::class, 'createView'])->name('project.create.view');
        Route::post('/create', [ProjectWebContoller::class, 'create'])->name('project.create');

        Route::get('/{id}', [ProjectWebContoller::class, 'show'])->name('project.show');

        Route::delete('/kick-participant/{idEmployee}/{idProject}', [ProjectWebContoller::class, 'kickParticipant'])->name('project.delete.participant');

        Route::get('/{id}/add-participant', [ProjectWebContoller::class, 'addInvitationView'])->name('project.add.view');
        Route::post('/{id}/add-participant', [ProjectWebContoller::class, 'addInvitation'])->name('project.add');

        Route::get('/edit/{id}', [ProjectWebContoller::class, 'updateView'])->name('project.edit');
        Route::post('/edit/{id}', [ProjectWebContoller::class, 'update'])->name('project.update');

        Route::get('/{id}/create-task', [ProjectWebContoller::class, 'createTaskView'])->name('project.create.task.view');
        Route::post('/{id}/create-task', [ProjectWebContoller::class, 'createTask'])->name('project.create.task');

        Route::get('/{idProject}/return-task/{idTask}', [ProjectWebContoller::class, 'returnTaskview'])->name('project.return.task.view');
        Route::post('/{idProject}/return-task/{idTask}', [ProjectWebContoller::class, 'returnTask'])->name('project.return.task');

        Route::get('/{idProject}/detail-return-task/{idTask}', [ProjectWebContoller::class, 'returnDetail'])->name('project.return.task.detail');
        Route::delete('/{idProject}/detail-return-task/{idTask}', [ProjectWebContoller::class, 'cancelReturn'])->name('project.return.task.delete');
    });

    Route::get('/employee', [EmployeeWebContoller::class, 'index'])->name('employee.index');
    Route::get('/employee/{id}', [EmployeeWebContoller::class, 'show'])->name('employee.show');
});
