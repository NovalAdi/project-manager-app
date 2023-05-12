<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $Employee = [
            [
                'user_id' => 2
            ],
            [
                'user_id' => 3
            ]
        ];

        foreach ($Employee as $employee) {
            Employee::create($employee);
        }
    }
}
