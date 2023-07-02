<?php

namespace Database\Seeders;

use App\Models\Invitation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InvitationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $invitaions = [
            [
                'status' => 'accepted',
                'project_id' => 1,
                'employee_id' => 1
            ],
            [
                'status' => 'accepted',
                'project_id' => 2,
                'employee_id' => 1
            ],
            [
                'status' => 'accepted',
                'project_id' => 1,
                'employee_id' => 2
            ],
            [
                'status' => 'accepted',
                'project_id' => 2,
                'employee_id' => 2
            ],
        ];

        foreach ($invitaions as $invitaion) {
            Invitation::create($invitaion);
        }
    }
}
