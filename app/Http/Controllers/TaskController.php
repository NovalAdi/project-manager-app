<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function index()
    {
        $task = Task::all();
        return response()->json(
            [
                'stastus' => true,
                'data' => $task
            ]
        );
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
            'user_id' => 'required',
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
        $task = Task::find($id);
        if (!$task) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'task not found'
                ]

            );
        }

        $task->update($req->all());
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
