<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Manager;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeWebContoller extends Controller
{
    public function index()
    {
        $manager = Manager::where('user_id', '=', auth()->user()->id)->with('employees')->first();
        $employees = $manager['employees'];

        return view('employee.index', compact('employees'));
    }

    public function show($id)
    {
        $manager = Manager::where('user_id', '=', auth()->user()->id)->first();
        $employee = Employee::with('user', 'invitations', 'tasks')->find($id);
        if (!$employee) {
            return view('layout.404');
        }

        $user = $employee['user'];

        $arrayEmployee = $employee->toArray();
        $invitations = $arrayEmployee['invitations'];
        $projects = [];
        $projectNames = [];

        foreach ($invitations as $value) {
            $project = Project::where('id', '=', $value['project_id'])->first()->toArray();
            $projects[] = $project;
            $projectNames[] = $project['name'];

        }

        $tasks = $arrayEmployee['tasks'];

        // return dd($projectName);

        return view('employee.profile', compact('user', 'projects', 'tasks', 'projectNames'));
    }
}
