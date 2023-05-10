<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = [
            [
                'name' => 'Home App',
                'desk' => 'A simple home app',
                'deadline' => '2024-01-13',
                'user_id' => 1,
                'token' => random_int(100000, 999999)
            ],
            [
                'name' => 'Toilet App',
                'desk' => 'An app about Toilet',
                'deadline' => '2023-12-24',
                'user_id' => 1,
                'token' => random_int(100000, 999999)
            ],
        ];

        foreach ($projects as $project) {
            Project::create($project);
        }
    }
}
