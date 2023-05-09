<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tasks = [
            [
                'name' => 'Home Page',
                'desk' => 'Using flutter',
                'project_id' => 1,
                'user_id' => 1
            ],
            [
                'name' => 'Profile Page',
                'desk' => 'Using flutter',
                'project_id' => 2,
                'user_id' => 1
            ],
            [
                'name' => 'Home UI',
                'desk' => 'Using figma',
                'project_id' => 1,
                'user_id' => 2
            ],
            [
                'name' => 'Profile UI',
                'desk' => 'Using figma',
                'project_id' => 2,
                'user_id' => 2
            ],
        ];

        foreach ($tasks as $task) {
            Task::create($task);
        }
    }
}
