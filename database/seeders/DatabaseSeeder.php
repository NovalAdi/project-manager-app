<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Invitation;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
            UserSeeder::class,
            ManagerSeeder::class,
            EmployeeSeeder::class,
            // ProjectSeeder::class,
            // TaskSeeder::class,
            // InvitationSeeder::class
        ]);
    }
}
