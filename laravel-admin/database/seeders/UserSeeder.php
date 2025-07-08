<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => '山田太郎',
                'email' => 'yamada@example.com',
                'password' => \Illuminate\Support\Facades\Hash::make('password123'),
                'project_id' => 1,
                'status' => 'active',
            ],
            [
                'name' => '佐藤花子',
                'email' => 'sato@example.com',
                'password' => \Illuminate\Support\Facades\Hash::make('password123'),
                'project_id' => 2,
                'status' => 'active',
            ],
            [
                'name' => '鈴木一郎',
                'email' => 'suzuki@example.com',
                'password' => \Illuminate\Support\Facades\Hash::make('password123'),
                'project_id' => 3,
                'status' => 'inactive',
            ],
        ];

        foreach ($users as $user) {
            \App\Models\User::create($user);
        }
    }
}
