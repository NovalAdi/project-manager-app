<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Manager;
use App\Models\Project;
use App\Models\Task;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class DashboardController extends Controller
{
    public function index()
    {
        $manager = Manager::where('user_id', '=', auth()->user()->id)->first();
        $totalEmployee = $manager->employees()->count();

        $totalProject = $manager->projects()->count();

        $listProject = Project::where('manager_id', '=', $manager->id)->oldest()->get();

        $project = Project::where('manager_id', '=', $manager->id)->with('tasks')->get()->toArray();

        $tasks = [];

        foreach ($project as $key => $value) {
            foreach ($value['tasks'] as $key2 => $value2) {
                $tasks[] = $value2;
            }
        }

        $totalTask = count($tasks);

        $taskStatus = [];
        foreach ($tasks as $key => $value) {
            $taskStatus[] = $value['status'];
        }

        $done = [];
        $pending = [];
        $undone = [];

        foreach ($tasks as $key => $value) {
            if ($value['status'] == 'done') {
                $done[] = $value;
            } elseif ($value['status'] == 'undone') {
                $undone[] = $value;
            } else {
                $pending[] = $value;
            }
        }

        $topFraction = 0;
        $percentage = [0];

        if ($tasks != null) {

            $percentage = [];
            foreach ($project as $value) {
                $projectsTask = $value['tasks'];
                foreach ($projectsTask as $key => $value) {
                    if ($value['status'] == 'done') {
                        $topFraction += 1;
                    } elseif ($value['status'] == 'pending') {
                        $topFraction += 0.5;
                    }
                }

                if (count($projectsTask) == 0) {
                    $percentage[] = 0;
                } else {
                    $percentage[] = $topFraction / count($projectsTask) * 100;
                    $topFraction = 0;
                }
            }
        }

        // return dd($percentage);

        return view('dashboard', compact('totalEmployee', 'totalProject', 'totalTask', 'listProject', 'done', 'pending', 'undone', 'percentage'));
    }
}
