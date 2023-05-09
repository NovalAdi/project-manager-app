<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function index()
    {
        $project = Project::all();
        return response()->json(
            [
                'stastus' => true,
                'data' => $project
            ]
        );
    }

    public function show($id)
    {
        $project = Project::with(['tasks','users'])->latest()->find($id);
        if (!$project) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'project not found'
                ],
                404
            );
        }

        return response()->json(
            [
                'stastus' => true,
                'data' => $project
            ]
        );
    }

    public function create(Request $req)
    {
        $input = $req->all();
        $rules = [
            'name' => 'required',
            'desk' => 'required',
            'token' => 'unique:projects,token',
            'deadline' => 'required|date_format:Y-m-d'
        ];

        $validator = Validator::make($input, $rules);
        $input['token'] = random_int(100000, 999999);
        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => false,
                    'message' => $validator->errors()
                ],
                400
            );
        }

        $project = Project::create($input);
        return response()->json(
            [
                'status' => true,
                'data' => $project
            ]
        );
    }

    public function update(Request $req, $id)
    {
        $project = Project::find($id);
        if (!$project) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'project not found'
                ]

            );
        }

        $project->update($req->all());
        return response()->json(
            [
                'status' => true,
                'data' => $project
            ]
        );
    }

    public function delete($id)
    {
        $project = Project::find($id);
        if (!$project) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'project not found'
                ],
                400
            );
        }

        $project->delete($id);
        return response()->json(
            [
                'status' => true,
                'message' => 'data succcessfully deleted'
            ]
        );
    }
}
