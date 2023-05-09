<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserProjectController extends Controller
{
    public function create(Request $req)
    {
        $input = $req->all();
        $validator = Validator::make($input, [
            'project_id' => 'required',
            'user_id' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => false,
                    'message' => $validator->errors()
                ],
                400
            );
        }

        $user_ids = [];

        foreach ($input['user_id'] as $value) {
            $user = User::find($value);
            if (!$user) {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'user not found'
                    ],
                    404
                );
            } else {
                $user_ids = $value;
            }
        }

        $project = Project::find($input['project_id']);
        if (!$project) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'project not found'
                ],
                404
            );
        }

        $project->users()->attach($user_ids);

        $data = DB::table('user_projects')->where('project_id', '=', $project->id)->get();

        return response()->json(
            [
                'status' => true,
                'message' => 'data succeesfully created',
                'data' => $data
            ]
        );
    }

    public function show($id)
    {
        $project = Project::find($id);
        if (!$project) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'project not found'
                ],
                404
            );
        }

        $user_name = [];
        foreach ($project->users as $user) {
            $user_name[] = $user->name;
        }

        return response()->json(
            [
                'status' => true,
                'project_name' => $project->name,
                'participants' => $user_name
            ]
        );
    }
}