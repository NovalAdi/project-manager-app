<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Invitation;
use App\Models\Manager;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function index($id)
    {
        $manager = Manager::where('user_id', '=', $id)->first();
        $project = Project::where('manager_id', '=', $manager->id)->get();
        return response()->json(
            [
                'status' => true,
                'data' => $project
            ]
        );
    }


    public function getMainProject($id)
    {
        $employee = Employee::where('user_id', '=', $id)->first();
        $invitations = Invitation::where('employee_id', '=', $employee->id)->where('status', '=', 'accepted')->get();

        $projects = [];

        foreach ($invitations as $key => $value) {
            $projects[] = $value->project;
        }

        $projectCollections = collect($projects);
        $projectCollectionsSorted = $projectCollections->sortBy('deadline')->values()->all();

        $customProject = [];

        foreach ($projectCollectionsSorted as $key => $project) {
            $project = Project::find($project->id);
            if (!$project) {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'project not found'
                    ]

                );
            }

            $taskTotal = $project->taskTotal();
            $taskDone = $project->taskDone();
            $taskPending = $project->taskPending();
            $taskUndone = $project->taskUndone();
            $now = Carbon::now();
            $dayLeft = $now->diffInDays($project->deadline);
            $projectArr = $project->toArray();
            $projectArr['done'] = $taskDone;
            $projectArr['pending'] = $taskPending;
            $projectArr['undone'] = $taskUndone;
            $projectArr['total_task'] = $taskTotal;
            $projectArr['percentage'] = $this->percentage($taskDone, $taskPending, $taskTotal);
            $projectArr['day_left'] = $dayLeft;

            $customProject[] = $projectArr;
        }

        return response()->json([
            'status' => true,
            'data' => $customProject
        ]);
    }

    public function projectParticipants($id)
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

        foreach ($project->invitation as $key => $value) {
            $employee1 = Employee::find($value->employee_id);
            $participant[] = User::find($employee1->user_id);
        }
        $parMap = array_map(function ($part) {
            $part['image'] = url('uploads/users/' . $part['image']);
            return $part;
        }, $participant);

        return response()->json([
            'status' => true,
            'data' => $parMap,
        ]);
    }



    public function show($id)
    {
        $project = Project::with(['tasks', 'invitation', 'manager'])->latest()->find($id);
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
            'manager_id' => 'required',
            'deadline' => 'required|date_format:Y-m-d'
        ];

        $manager = Manager::find($input['manager_id']);
        if (!$manager) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'manager not found'
                ],
                404
            );
        }

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

    private function percentage(int $done, int $pending, int $total)
    {
        if ($total == 0) {
            return 0;
        }

        $pendingValue = $pending - 0.5;

        if ($pending == 0) {
            $pendingValue = 0;
        }
        $topFraction = $done + $pendingValue;
        $divide = $topFraction / $total;
        $value = $divide * 100;
        return $value;
    }
}
