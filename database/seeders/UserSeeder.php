<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::whereIn('email', ['staff@campus.local', 'ops@campus.local'])->delete();

        $users = [
            ['name' => 'Quản trị viên sân thể thao', 'email' => 'admin@campus.local', 'password' => Hash::make('password'), 'role' => 'admin'],
            ['name' => 'Nguyen Van A', 'email' => 'student1@campus.local', 'password' => Hash::make('password'), 'role' => 'student'],
            ['name' => 'Tran Thi B', 'email' => 'student2@campus.local', 'password' => Hash::make('password'), 'role' => 'student'],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(['email' => $user['email']], $user);
        }
    }
}
