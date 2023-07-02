<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Invitation;
use App\Models\Manager;
use App\Models\Notif;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProjectWebContoller extends Controller
{
    public function index()
    {
        $manager = Manager::where('user_id', '=', auth()->user()->id)->first();
        $projects = Project::where('manager_id', '=', $manager->id)->get();

        // return dd(count($projects));

        return view('project.index', compact('projects'));
    }

    public function show($id)
    {
        $project = Project::with('tasks', 'invitation')->find($id);
        if (!$project) {
            return view('layout.404');
        }

        // $invitation =

        $participants = [];

        foreach ($project->invitation as $key => $value) {
            if ($value->status == 'accepted') {
                $participants[] = Employee::where('id', '=', $value->employee_id)->first();
            }
        }

        $deadline = $project->deadline;

        $dateNow = Carbon::now();

        $dayLeft = $dateNow->diffInDays($deadline);

        $tasks = Task::where('project_id', '=', $project->id)->get();

        // return dd($project);

        return view('project.detail', compact('project', 'participants', 'dayLeft', 'tasks'));
    }

    public function updateView($id)
    {
        $project = Project::find($id);
        return view('project.edit', compact('project'));
    }

    public function update(Request $req, $id)
    {
        $input = $req->all();
        $validator = Validator::make($input, [
            'deadline' => 'date_format:Y-m-d'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ]);
        }

        $project = Project::find($id);
        if (!$project) {
            return response()->json([
                'status' => false,
                'message' => 'project not found'
            ]);
        }

        $project->update($input);
        return redirect()->route('project.index');
    }

    public function createView()
    {
        return view('project.create');
    }

    public function create(Request $req)
    {
        $manager = Manager::where('user_id', '=', auth()->user()->id)->first();
        $input = $req->all();

        Project::create([
            'name' => $input['name'],
            'desk' => $input['desk'],
            'deadline' => $input['deadline'],
            'manager_id' => $manager->id,
            'token' => random_int(100000, 999999),
        ]);
        return redirect()->route('project.index');
    }

    public function addInvitationView($id)
    {
        $project = Project::find($id);
        return view('project.add', compact('project'));
    }

    public function addInvitation(Request $req, $id)
    {
        $user = User::where('email', '=', $req['email'])->first();
        if (!$user) {
            return view('layout.404');
        }
        $employee = Employee::where('user_id', '=', $user->id)->first();
        $project = Project::find($id);
        $manager = Manager::find($project->manager_id);
        $userManager = User::find($manager->user_id);

        $invitation = Invitation::create([
            'project_id' => $id,
            'employee_id' => $employee->id
        ]);

        Notif::create([
            'message' => "$userManager->username invites you to join '$project->name' project",
            'invitation_id' => $invitation->id,
            'type' => 'invitation',
            'from' => $manager->user_id,
            'to' => $employee->user_id,
        ]);

        return redirect()->route('project.show', $id);

    }

    public function kickParticipant($idEmployee, $idProject)
    {
        $invitation = Invitation::where('employee_id', '=', $idEmployee)->where('project_id', '=', $idProject)->first();
        $invitation->delete();
        $manager = Manager::find(auth()->user()->manager->id);
        $manager->employees()->detach($idEmployee);
        return redirect()->route('project.show', $idProject);
    }

    public function createTaskView($id)
    {
        $project = Project::find($id);
        $participants = [];

        foreach ($project->invitation as $key => $value) {
            if ($value->status == 'accepted') {
                $participants[] = Employee::where('id', '=', $value->employee_id)->first();
            }
        }

        return view('project.create_task', compact('project', 'participants'));
    }

    public function createTask(Request $req, $id)
    {
        $input = $req->all();
        Task::create([
            'name' => $input['name'],
            'desk' => $input['desk'],
            'employee_id' => $input['employee_id'],
            'project_id' => $id
        ]);

        return redirect()->route('project.show', $id);
    }

    public function returnTaskView($idProject, $idTask)
    {
        $task = Task::find($idTask);
        $project = Project::find($idProject);
        if (!$project) {
            return dd('project not found');
        }
        return view('project.return_task', compact('task', 'project'));
    }

    public function returnTask(Request $req, $idProject, $idTask)
    {
        $input = $req->all();
        $task = Task::find($idTask);
        $project = Project::find($idProject);
        $manager = Manager::find($project->manager_id);
        $employee = Employee::find($task->employee_id);
        Notif::create([
            'message' => $input['message'],
            'task_id' => $idTask,
            'type' => 'task_return',
            'from' => $manager->user_id,
            'to' => $employee->user_id,
        ]);

        $task->update([
            'status' => 'pending'
        ]);

        return redirect()->route('project.show', $idProject);
    }

    public function returnDetail($idProject, $idTask)
    {
        $task = Task::find($idTask);
        $notif = Notif::where('task_id' ,'=', $task->id)->first();
        $project = Project::find($idProject);

        return view('project.detail_return', compact('task', 'notif', 'project'));
    }

    public function cancelReturn($idProject, $idTask)
    {
        $notif = Notif::where('task_id', '=', $idTask)->first();
        $notif->delete();
        $task = Task::find($idTask);
        $task->update([
            'status' => 'done'
        ]);
        return redirect()->route('project.show', $idProject);
    }
}
