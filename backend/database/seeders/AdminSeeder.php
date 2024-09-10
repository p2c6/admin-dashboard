<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'username' => 'admin1',
                'name' => 'John Doe',
                'email' => 'jdoe@gmail.com',
                'password' => bcrypt('admin123'),
                'created_at' => now(),
            ],
            [
                'username' => 'admin2',
                'name' => 'Dan Ross',
                'email' => 'dross@gmail.com',
                'password' => bcrypt('admin123'),
                'created_at' => now(),
            ],
            [
                'username' => 'admin3',
                'name' => 'Max Lee',
                'email' => 'mlee@gmail.com',
                'password' => bcrypt('admin123'),
                'created_at' => now(),
            ],
        ];

        User::insert($users);

    }
}
