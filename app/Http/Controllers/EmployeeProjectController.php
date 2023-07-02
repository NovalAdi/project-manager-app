<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Manager;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EmployeeProjectController extends Controller
{
    public function create(Request $req)
    {
        $input = $req->all();
        $validator = Validator::make($input, [
            'project_id' => 'required',
            'employee_id' => 'required',
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

        $project = Project::find($input['project_id']);
        if (!$project) {
            return response()->json([
                'status' => false,
                'message' => 'project not found'
            ], 404);
        }

        $manager = Manager::where('user_id', '=', $project->manager_id)->first();
        if (!$manager) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'manager not found'
                ],404);
        }

        $employee_ids = [];
        foreach ($input['employee_id'] as $value) {
            $employee = Employee::find($value);
            if (!$employee) {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'employee not found'
                    ],
                    404
                );
            } else {
                $employee_ids[] = $value;
            }
        }

        $manager->employees()->attach($employee_ids);

        $project->participants()->attach($employee_ids);

        $data = DB::table('employee_project')->where('project_id', '=', $project->id)->get();

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
        $project = Project::with(['participants'])->find($id);
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
                'status' => true,
                'data' => $project

            ]
        );
    }
}
