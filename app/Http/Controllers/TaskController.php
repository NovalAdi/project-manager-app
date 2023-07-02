<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Notif;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function index($id)
    {
        $employee = Employee::where('user_id', '=', $id)->first();
        $task = Task::where('employee_id', '=', $employee->id)->with(['project'])->get();
        return response()->json(
            [
                'status' => true,
                'data' => $task
            ]
        );
    }

    public function getTask($idProject, $idUser)
    {
        $employee = Employee::where('user_id', '=', $idUser)->first();
        $tasks = Task::where('project_id', '=', $idProject)->where('employee_id', '=', $employee->id)->get();

        return response()->json([
            'status' => true,
            'data' => $tasks
        ]);
    }

    public function show($id)
    {
        $task = Task::with(['project', 'employee'])->find($id);
        if (!$task) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'task not found'
                ]

            );
        }

        return response()->json(
            [
                'stastus' => true,
                'data' => $task
            ]
        );
    }

    public function create(Request $req)
    {
        $input = $req->all();
        $rules = [
            'name' => 'required',
            'desk' => 'required',
            'project_id' => 'required',
            'employee_id' => 'required',
            'status' => 'in:done,pending,undone'
        ];

        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => false,
                    'message' => $validator->errors()
                ],
                400
            );
        }

        $task = Task::create($input);
        return response()->json(
            [
                'status' => true,
                'data' => $task
            ]
        );
    }

    public function update(Request $req, $id)
    {
        $input = $req->all();
        $task = Task::find($id);
        if (!$task) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'task not found'
                ]

            );
        }

        if ($task->status == 'pending') {
            $notif = Notif::where('task_id', '=', $task->id)->first();
            $notif->delete();
        }

        $task->update($input);
        return response()->json(
            [
                'status' => true,
                'data' => $task
            ]
        );
    }

    public function delete($id)
    {
        $task = Task::find($id);
        if (!$task) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'task not found'
                ],
                400
            );
        }

        $task->delete($id);
        return response()->json(
            [
                'status' => true,
                'message' => 'data succcessfully deleted'
            ]
        );
    }
}
