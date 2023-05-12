<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user1 = User::create([
            'username' => 'Noval Adi Prasetya',
            'email' => 'novaladiprasetya@gmail.com',
            'password' => Hash::make('1234567890'),
        ]);
        $user1->assignRole('manager');

        $user2 = User::create([
            'username' => 'Anas Muflih',
            'email' => 'anasmuflih@gmail.com',
            'password' => Hash::make('1234567890'),
        ]);
        $user2->assignRole('employee');

        $user3 = User::create([
            'username' => 'Zaki Hidayat',
            'email' => 'zaki@gmail.com',
            'password' => Hash::make('1234567890'),
        ]);
        $user3->assignRole('employee');
    }
}
