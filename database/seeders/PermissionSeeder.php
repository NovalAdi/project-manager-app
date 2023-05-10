<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'create-task',
            'read-task',
            'update-task',
            'delete-task',
            'create-project',
            'read-project',
            'update-project',
            'delete-project',
            'show-manager',
            'show-employee',
        ];
        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission
            ]);
        }

        $manager = Role::where('name', 'manager')->first();
        $manager->syncPermissions($permissions);

        $employee = Role::where('name', 'employee')->first();
        $employee->syncPermissions([
            'read-task',
            'update-task',
            'read-project',
            'show-employee'
        ]);
    }
}
